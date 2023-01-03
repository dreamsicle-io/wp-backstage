<?php
/**
 * WP Backstage Nav Menu Item
 *
 * @since       2.0.0
 * @since       3.0.0  linted and formatted with phpcs
 * @package     WPBackstage
 * @subpackage  Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Nav Menu Item
 *
 * @since       2.0.0
 */
class WP_Backstage_Nav_Menu_Item extends WP_Backstage_Component {

	/**
	 * Default Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'fields' => array(),
	);

	/**
	 * Required Args
	 *
	 * @since  0.0.1
	 * @var    array  $required_args  The required arguments for this instance. Arguments in this array will throw an error if empty.
	 */
	protected $required_args = array();

	/**
	 * Add
	 *
	 * @since   0.0.1
	 * @param   array $args  An array of arguments for this instance.
	 * @return  WP_Backstage_Nav_Menu_Item  A fully constructed instance of `WP_Backstage_Nav_Menu_Item`.
	 */
	public static function modify( $args = array() ) {

		$component = new WP_Backstage_Nav_Menu_Item( $args );
		$component->init();
		return $component;

	}

	/**
	 * Construct
	 *
	 * @since   2.0.0
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	public function __construct( $args = array() ) {

		$this->slug = 'nav_menu_item';
		$this->set_args( $args );
		$this->screen_id = array( 'nav-menus' );
		$this->nonce_key = '_wp_backstage_nav_menu_item_nonce';
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 *
	 * @since   2.0.0
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {
		$this->args = wp_parse_args( $args, $this->default_args );

		foreach ( $this->args['fields'] as $i => $field ) {
			$this->args['fields'][ $i ] = wp_parse_args( $field, $this->default_field_args );
		}
	}

	/**
	 * Set Errors
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	protected function set_errors() {

		foreach ( $this->required_args as $required_arg ) {

			if ( empty( $this->args[ $required_arg ] ) ) {

				$this->errors[] = new WP_Error(
					'required_nav_menu_item_arg',
					sprintf(
						/* translators: 1: required arg key. */
						_x( '[Nav Menu Item] The %1$s key is required.', 'nav menu item - required arg error', 'wp_backstage' ),
						'<code>' . $required_arg . '</code>'
					)
				);

			}
		}
	}

	/**
	 * Init
	 *
	 * @since   2.0.0
	 * @since   3.5.0 Hooks the `manage_customizer_meta_preview` method at a much later priority.
	 * @since   4.0.0 Removes error checking of the `WP_Backstage` class as it no longer reports errors.
	 * @return  void
	 */
	public function init() {

		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_edit_nonce' ), 10, 5 );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_fields' ), 10, 5 );
		add_action( 'wp_nav_menu_item_custom_fields_customize_template', array( $this, 'render_customizer_fields' ), 10 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'save' ), 10, 3 );
		add_action( 'customize_save_after', array( $this, 'save_customizer' ), 10 );
		add_action( 'wp_setup_nav_menu_item', array( $this, 'setup_nav_menu_item' ), 10 );
		add_filter( 'manage_nav-menus_columns', array( $this, 'add_field_columns' ), 20 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_action( 'customize_register', array( $this, 'manage_customizer_meta_preview' ), 9999 );
		add_action( 'customize_controls_print_styles', array( $this, 'inline_customizer_style' ), 10 );

		parent::init();

	}

	/**
	 * Inline Customizer Style
	 *
	 * This method is responsible for inlint field specific customizer styles.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function inline_customizer_style() {

		$fields = $this->get_fields(); ?>

		<style 
		id="wp_backstage_nav_menu_item_customizer_style"
		type="text/css"><?php

		foreach ( $fields as $field ) {

			$field = wp_parse_args( $field, $this->default_field_args );

			echo esc_html(
				sprintf(
					'.control-section-nav_menu .field-%1$s { display: none; }',
					sanitize_key( $field['name'] )
				)
			);

			echo esc_html(
				sprintf(
					'.control-section-nav_menu.field-%1$s-active .field-%1$s { display: block; }',
					sanitize_key( $field['name'] )
				)
			);

		}

		?></style>

	<?php }

	/**
	 * Get Fields
	 *
	 * @since   2.0.0
	 * @return  array  An array of field argument arrays.
	 */
	protected function get_fields() {
		return $this->args['fields'];
	}

	/**
	 * Setup Nav Menu Item
	 *
	 * Adds all values to the Nav Menu Item object.
	 *
	 * @since   2.0.0
	 * @param object $item The incoming nav menu item object.
	 * @return  object  The nav menu item object with axtra meta hydrated.
	 */
	public function setup_nav_menu_item( $item = null ) {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {
			$field_name        = $field['name'];
			$item->$field_name = get_post_meta( $item->ID, $field_name, true );
		}

		return $item;

	}

	/**
	 * Render Fields
	 *
	 * @since   2.0.0
	 * @param   int     $item_id  The nav menu item ID.
	 * @param   WP_Post $item     The nav menu item post object.
	 * @param   int     $depth    The depth of menu item.
	 * @param   object  $args     An object of menu item arguments.
	 * @param   int     $id       The ID of the nav menu that this item is related to.
	 * @return  void
	 */
	public function render_fields( $item_id = 0, $item = null, $depth = 0, $args = null, $id = 0 ) {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			$field_name     = $field['name'];
			$field['name']  = sprintf( '%1$s[%2$d]', $field_name, $item->ID );
			$field['id']    = sprintf( 'edit-menu-item-%1$s_%2$d', $field_name, $item->ID );
			$field['value'] = get_post_meta( $item->ID, $field_name, true );

			$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $item );

			$field_class = $this->get_field_class( $field['type'] );

			if ( $field_class->has_tag( 'text_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
			}

			if ( $field_class->has_tag( 'textarea_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
				$field = $this->set_field_textarea_dimensions( $field, 3, 20 );
			} ?>

			<p 
			class="<?php echo esc_attr( sprintf( 'field-%1$s', $field_name ) ); ?> description description-wide"
			data-wp-backstage-field-name="<?php echo esc_attr( $field_name ); ?>"><?php

				do_action( "wp_backstage_{$this->slug}_field_before", $field, $item );

				$this->render_field_label( $field );

				$field_class->render( $field );

				$this->render_field_description( $field );

				do_action( "wp_backstage_{$this->slug}_field_after", $field, $item );

			?></p>

		<?php }
	}

	/**
	 * Render Field Description
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	protected function render_field_description( $field = array() ) {

		if ( ! empty( $field['description'] ) ) {

			$field_class = $this->get_field_class( $field['type'] ); ?>

			<span
			class="description" 
			id="<?php printf( '%1$s-description', esc_attr( $field_class->get_id( $field ) ) ); ?>"><?php
				$field_class->description( $field );
			?></span>

		<?php }

	}

	/**
	 * Render Customizer Fields
	 *
	 * Render the customizer template for new menu items. Note that the templating is different
	 * in the customizer for menu items, therefore the `before` and `after` field actions
	 * are different in this case and are passed different values.
	 *
	 * @since   2.0.0
	 * @since   3.5.0 Uses the menu item ID as the dynamic portion of the name/id instead of the instance number.
	 * @return  void
	 */
	public function render_customizer_fields() {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			$field_name     = $field['name'];
			$field['name']  = sprintf( 'menu-item-%1$s[{{ data.menu_item_id }}]', $field_name );
			$field['id']    = sprintf( 'edit-menu-item-%1$s-{{ data.menu_item_id }}', $field_name );
			$field['value'] = sprintf( '{{ data.%1$s }}', $field_name );

			$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field ); ?>

			<p 
			class="<?php echo esc_attr( sprintf( 'field-%1$s', $field_name ) ); ?> description description-thin"
			data-wp-backstage-field-name="<?php echo esc_attr( $field_name ); ?>"
			data-wp-backstage-field-type="<?php echo esc_attr( $field['type'] ); ?>"><?php

				do_action( "wp_backstage_{$this->slug}_field_customizer_before", $field, $field_name );

				$field_class = $this->get_field_class( $field['type'] );
				$field_class->render( $field );

				do_action( "wp_backstage_{$this->slug}_field_customizer_after", $field, $field_name );

			?></p>

		<?php }
	}

	/**
	 * Save
	 *
	 * @since   2.0.0
	 * @param   int   $menu_id  The ID of the menu that the item is in.
	 * @param   int   $item_id  The ID of the menu item.
	 * @param   array $menu_item_data  The menu item data.
	 * @return  void
	 */
	public function save( $menu_id = 0, $item_id = 0, $menu_item_data = array() ) {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( ! current_user_can( 'edit_post', $item_id ) ) {
			return;
		}
		if ( empty( $post_data ) ) {
			return;
		}
		if ( empty( $post_data[ $this->nonce_key ] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $post_data[ $this->nonce_key ], 'add' ) && ! wp_verify_nonce( $post_data[ $this->nonce_key ], 'edit' ) ) {
			return;
		}

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				if ( isset( $post_data[ $field['name'] ][ $item_id ] ) ) {

					$field_class = $this->get_field_class( $field['type'] );
					$value       = $field_class->sanitize( $post_data[ $field['name'] ][ $item_id ] );

					update_post_meta( $item_id, $field['name'], $value );

				} else {

					delete_post_meta( $item_id, $field['name'] );

				}
			}
		}

	}

	/**
	 * Save Customizer
	 *
	 * Save the Nav Menu Item settings after the customizer has finished saving.
	 *
	 * @todo    Though it's probably not needed, try to check nonce here.
	 *
	 * @since   2.0.0
	 * @param   WP_Customize_Manager $wp_customize The current WP Customize instance.
	 * @return  void
	 */
	public function save_customizer( $wp_customize = null ) {

		foreach ( $wp_customize->settings() as $setting ) {

			if ( $setting instanceof WP_Customize_Nav_Menu_Item_Setting && $setting->check_capabilities() ) {

				$item_id       = $setting->post_id;
				$posted_values = $setting->manager->unsanitized_post_values()[ $setting->id ];

				if ( ! current_user_can( 'edit_post', $item_id ) ) {
					return;
				}
				if ( empty( $posted_values ) ) {
					return;
				}

				$fields = $this->get_fields();

				foreach ( $fields as $field ) {

					if ( isset( $posted_values[ $field['name'] ] ) ) {

						$field_class = $this->get_field_class( $field['type'] );
						$value       = $field_class->sanitize( $posted_values[ $field['name'] ] );

						update_post_meta( $item_id, $field['name'], $value );

					} else {

						delete_post_meta( $item_id, $field['name'] );

					}
				}
			}
		}

	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Adds all generated fields to the hidden columns array by default, so as
	 * to not choke up the UI. Note that this will only work if this post type's
	 * columns UI has never been modified by the user. Hooked to
	 * `default_hidden_columns`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/default_hidden_columns/ Hook: default_hidden_columns
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 *
	 * @since   2.0.0
	 * @param   array     $hidden  An array of hidden columns.
	 * @param   WP_Screen $screen  An instance of `WP_Screen`.
	 * @return  array An array of hidden column keys.
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $this->is_screen( 'id', $this->screen_id ) ) {

			$fields = $this->get_fields();

			foreach ( $fields as $field ) {

				$hidden[] = $field['name'];

			}
		}

		return $hidden;

	}

	/**
	 * Manage Customizer Meta Preview
	 *
	 * Preview changes to the nav menu item roles. Note the unimplemented
	 * to-do in the doc block for the setting's preview method. This will only
	 * work for existing menu items. New menu items have a dynamically generated ID
	 * and do not exist in the database yet. Note that this is a "short-circuit" filter,
	 * which means if a non-null value is returned, it will be used instead of the DB or
	 * cache value. This filter always receives `null` as the `$value`. The return value
	 * must always be an array, even if it is a single value.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/get_meta_type_metadata/ Filter: get_{$meta_type}_metadata
	 * @link    https://wordpress.stackexchange.com/questions/372493/add-settings-to-menu-items-in-the-customizer  Stack Overflow Discussion on Nav Menu Items in the Customizer
	 * @link    https://gist.github.com/westonruter/7f2b9c18113f0576a72e0aca3ce3dbcb  Customizer Roles Plugin Example by Weston Ruter
	 *
	 * @since 2.0.0
	 * @since 3.5.0 Always cast value to array, more strict checks of value existence, upped the priority so this always runs last.
	 * @param   WP_Customize_Manager $wp_customize  The WP Customize instance.
	 * @return  void
	 */
	public function manage_customizer_meta_preview( $wp_customize = null ) {

		if ( $wp_customize->settings_previewed() ) {

			foreach ( $wp_customize->settings() as $setting ) {

				if ( $setting instanceof WP_Customize_Nav_Menu_Item_Setting ) {

					add_filter(
						'get_post_metadata',
						function( $value, $object_id, $meta_key, $single ) use ( $setting ) {

							if ( $object_id === $setting->post_id ) {

								$field = $this->get_field_by( 'name', $meta_key );

								if ( ! empty( $field ) ) {

									$unsanitized_values = $setting->manager->unsanitized_post_values();

									if ( ! empty( $unsanitized_values ) && isset( $unsanitized_values[ $setting->id ] ) ) {

										$setting_values = $unsanitized_values[ $setting->id ];

										if ( ! empty( $setting_values ) && isset( $setting_values[ $meta_key ] ) ) {

											$field_class = $this->get_field_class( $field['type'] );
											$value       = $field_class->sanitize( $setting_values[ $meta_key ] );

											// Cast this to an array, or array values will have their first index plucked.
											$value = array( $value );
										}
									}
								}
							}

							return $value;
						},
						9999,
						4
					);
				}
			}
		}
	}

}
