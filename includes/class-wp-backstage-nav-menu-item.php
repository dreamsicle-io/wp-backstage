<?php
/**
 * WP Backstage Nav Menu Item
 *
 * @since       1.1.0
 * @package     wp_backstage
 * @subpackage  includes
 */

/**
 * WP Backstage Nav Menu Item
 *
 * @since       1.1.0
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Nav_Menu_Item extends WP_Backstage {

	/**
	 * Default Args
	 * 
	 * @var  array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'fields' => array(), 
	);

	/**
	 * Required Args
	 * 
	 * @var  array  $required_args  The required arguments for this instance. Arguments in this array will throw an error if empty.
	 */
	protected $required_args = array();

	/**
	 * Add
	 * 
	 * @param   array              $args  An array of arguments for this instance.
	 * @return  WP_Backstage_Nav_Menu_Item  A fully constructed instance of `WP_Backstage_Nav_Menu_Item`. 
	 */
	public static function modify( $args = array() ) {

		$Nav_Menu_Item = new WP_Backstage_Nav_Menu_Item( $args );
		$Nav_Menu_Item->init();
		return $Nav_Menu_Item;

	}

	/**
	 * Construct
	 * 
	 * @since   1.1.0
	 * @param   array  $args  An array of arguments.
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
	 * @since   1.1.0
	 * @param   array  $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {
		$this->args = wp_parse_args( $args, $this->default_args );
	}

	/**
	 * Set Errors
	 * 
	 * @since   1.1.0
	 * @return  void 
	 */
	protected function set_errors() {

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_nav_menu_item_arg', sprintf( 
						/* translators: 1:required arg key. */
						__( '[nav_menu_item] The %1$s key is required.', 'wp-backstage' ), 
						'<code>' . $required_arg . '</code>'
					) );

				}

			}

		}

	}

	/**
	 * Init
	 * 
	 * @since   1.1.0
	 * @return  void 
	 */
	public function init() {
		
		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_edit_nonce' ), 10, 5 );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_fields' ), 10, 5 );
		add_action( 'wp_nav_menu_item_custom_fields_customize_template', array( $this, 'render_customizer_fields' ), 10 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'save' ), 10, 3 );
		add_action( 'customize_save_after', array( $this, 'save_customizer' ), 10 );
		add_action( 'wp_setup_nav_menu_item', array( $this, 'setup_nav_menu_item' ), 10 );
		add_filter( 'manage_nav-menus_columns', array( $this, 'add_field_columns' ), 20 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_action( 'customize_register', array( $this, 'manage_customizer_meta_preview' ), 10 );

		parent::init();

	}

	/**
	 * Get Fields
	 * 
	 * @since   1.1.0
	 * @return  array  An array of field argument arrays.
	 */
	protected function get_fields() {

		$fields = array();

		if ( is_array( $this->args['fields'] ) && ! empty( $this->args['fields'] ) ) {
			
			foreach ( $this->args['fields'] as $field ) {
			
				$fields[] = wp_parse_args( $field, $this->default_field_args );
			
			}
		
		}

		return $fields;

	}
	
	/**
	 * Setup Nav Menu Item
	 * 
	 * Adds all values to the Nav Menu Item object.
	 * 
	 * @since   1.1.0
	 * @return  object  The nav menu item object.
	 */
	public function setup_nav_menu_item( $item = null ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			foreach ( $fields as $field ) {

				$field_name = $field['name'];
				$item->$field_name = get_post_meta( $item->ID, $field_name, true );
			
			}
		
		}

		return $item;

	}

	/**
	 * Render Fields
	 * 
	 * @since   1.1.0
	 * @param   int      $item_id  The nav menu item ID.
	 * @param   WP_Post  $item     The nav menu item post object.
	 * @param   int      $depth    The depth of menu item.
	 * @param   object   $args     An object of menu item arguments.
	 * @param   int      $id       The ID of the nav menu that this item is related to.
	 * @return  void 
	 */
	public function render_fields( $item_id = 0, $item = null, $depth = 0, $args = null, $id = 0 ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			foreach ( $fields as $field ) {
				
				$field_name = $field['name'];
				$field['value'] = get_post_meta( $item->ID, $field_name, true );
				$field['name'] = sprintf( '%1$s[%2$d]', $field_name, $item->ID );
				$field['id'] = sprintf( '%1$s_%2$d', $field_name, $item->ID );
				$input_class = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

				if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows = ($field['type'] === 'textarea') ? 3 : 10;
					$default_cols = 20;
					$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $default_cols;
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( $field['type'] === 'code' ) {
					$field['settings_key'] = $field_name;
				}

				$field = apply_filters( $this->format_field_action( 'args' ), $field, $item ); ?>

				<p 
				class="<?php echo esc_attr( sprintf( 'field-%1$s', $field_name ) ); ?> description-wide"
				data-wp-backstage-field-name="<?php echo esc_attr( $field_name ); ?>"><?php 

					do_action( $this->format_field_action( 'before' ), $field, $item );

					$this->render_field_by_type( $field ); 

					do_action( $this->format_field_action( 'after' ), $field, $item );

				?></p>

			<?php }

		}

	}

	/**
	 * Render Customizer Fields
	 * 
	 * Render the customizer template for new menu items. Note that the templating is different
	 * in the customizer for menu items, therefore the `before` and `after` field actions
	 * are different in this case and are passed different values.
	 * 
	 * @since   1.1.0
	 * @return  void 
	 */
	public function render_customizer_fields() {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			foreach ( $fields as $field ) {
				
				$field_name = $field['name'];
				$field['value'] = sprintf( '{{ data.%1$s }}', $field_name );
				$field['name'] = sprintf( 'menu-item-%1$s', $field_name );
				$field['id'] = sprintf( 'edit-menu-item-%1$s-{{ data.menu_item_id }}', $field_name );

				if ( $field['type'] === 'code' ) {
					$field['settings_key'] = $field_name;
				}

				$field = apply_filters( $this->format_field_action( 'args' ), $field ); ?>

				<p 
				class="<?php echo esc_attr( sprintf( 'field-%1$s', $field_name ) ); ?> description description-thin"
				data-wp-backstage-field-name="<?php echo esc_attr( $field_name ); ?>"
				data-wp-backstage-field-type="<?php echo esc_attr( $field['type'] ); ?>"><?php 

					do_action( $this->format_field_action( 'customizer_before' ), $field, $field_name );

					$this->render_field_by_type( $field ); 

					do_action( $this->format_field_action( 'customizer_after' ), $field, $field_name );

				?></p>

			<?php }

		}

	}

	/**
	 * Save
	 * 
	 * @since   1.1.0
	 * @param   int    $menu_id  The ID of the menu that the item is in.
	 * @param   int    $item_id  The ID of the menu item.
	 * @param   array  $menu_item_data  The menu item data.
	 * @return  void 
	 */
	public function save( $menu_id = 0, $item_id = 0, $menu_item_data = array() ) {

		if ( ! current_user_can( 'edit_post', $item_id ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( empty( $_POST[$this->nonce_key] ) ) { return; }
		if ( ! wp_verify_nonce( $_POST[$this->nonce_key], 'add' ) && ! wp_verify_nonce( $_POST[$this->nonce_key], 'edit' ) ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				if ( isset( $_POST[$field['name']][$item_id] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']][$item_id] );
					
					update_post_meta( $item_id, $field['name'], $value );

				} else {

					delete_post_meta( $item_id, $field['name'] );

				}

			}

		}

	}
	
	/**
	 * Save Customizer.
	 * 
	 * @
	 */
	public function save_customizer( $wp_customize = null ) {

		foreach ( $wp_customize->settings() as $setting ) {
			
			if ( $setting instanceof WP_Customize_Nav_Menu_Item_Setting && $setting->check_capabilities() ) {

				$item_id = $setting->post_id;
				$posted_values = $setting->manager->unsanitized_post_values()[$setting->id];

				if ( ! current_user_can( 'edit_post', $item_id ) ) { return; }
				if ( ! $posted_values || empty( $posted_values ) ) { return; }

				$fields = $this->get_fields();

				if ( is_array( $fields ) && ! empty( $fields ) ) {
					
					$values = array();

					foreach ( $fields as $field ) {

						if ( isset( $posted_values[$field['name']] ) ) {

							$value = $this->sanitize_field( $field, $posted_values[$field['name']] );
							
							update_post_meta( $item_id, $field['name'], $value );

						} else {

							delete_post_meta( $item_id, $field['name'] );

						}

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
	 * @since   1.1.0
	 * @param   array      $hidden  An array of hidden columns.
	 * @param   WP_Screen  $screen  An instance of `WP_Screen`.
	 * @return  void 
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $this->is_screen( 'id', $this->screen_id ) ) {

			$fields = $this->get_fields();

			if ( is_array( $fields ) && ! empty( $fields ) ) {

				foreach ( $fields as $field ) {

					$hidden[] = $field['name'];

				}

			}

		}

		return $hidden;

	}

	/**
	 * Manage Customizer Meta Preview
	 * 
	 * Preview changes to the nav menu item roles. Note the unimplemented 
	 * to-do in the doc block for the setting's preview method.
	 *
	 * @link    https://wordpress.stackexchange.com/questions/372493/add-settings-to-menu-items-in-the-customizer  Stack Overflow Discussion on Nav Menu Items in the Customizer
	 * @link    https://gist.github.com/westonruter/7f2b9c18113f0576a72e0aca3ce3dbcb  Customizer Roles Plugin Example by Weston Ruter
	 *
	 * @param   WP_Customize_Manager  $wp_customize  The WP Customize instance.
	 * @return  void
	 */
	public function manage_customizer_meta_preview( $wp_customize = null ) {

		if ( $wp_customize->settings_previewed() ) {

			foreach ( $wp_customize->settings() as $setting ) {

				if ( $setting instanceof WP_Customize_Nav_Menu_Item_Setting ) {
					
					add_filter( 'get_post_metadata', function( $value, $object_id, $meta_key, $single ) use ( $setting ) {
						
						if ( $object_id === $setting->post_id ) {

							$field = $this->get_field_by( 'name', $meta_key );
							$posted_values = $setting->manager->unsanitized_post_values()[$setting->id];
							$value = $this->sanitize_field( $field, $posted_values[$field['name']] );

						}

						return $value;

					}, 10, 4 );

				}

			}

		}

	}

}
