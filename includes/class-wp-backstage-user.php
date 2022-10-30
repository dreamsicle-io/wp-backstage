<?php
/**
 * WP Backstage User
 *
 * @since       0.0.1
 * @since       3.0.0  linted and formatted with phpcs
 * @package     wp-backstage
 * @subpackage  includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage User
 *
 * @since       0.0.1
 * @package     wp-backstage
 * @subpackage  includes
 */
class WP_Backstage_User extends WP_Backstage_Component {

	/**
	 * Default Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'field_groups' => array(),
	);

	/**
	 * Default Field Group Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_field_group_args  The default field group arguments for this instance.
	 */
	protected $default_field_group_args = array(
		'id'          => '',
		'title'       => '',
		'description' => '',
		'fields'      => array(),
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
	 * @return  WP_Backstage_User  A fully constructed instance of `WP_Backstage_User`.
	 */
	public static function modify( $args = array() ) {

		$component = new WP_Backstage_User( $args );
		$component->init();
		return $component;

	}

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	public function __construct( $args = array() ) {

		$this->default_field_args   = array_merge(
			$this->default_field_args,
			array(
				'has_column'    => false,
				'is_sortable'   => false,
				'is_filterable' => false,
			)
		);
		$this->default_address_args = array_merge(
			$this->default_address_args,
			array(
				'max_width' => '50em',
			)
		);
		$this->default_code_args    = array_merge(
			$this->default_code_args,
			array(
				'max_width' => '50em',
			)
		);
		$this->default_editor_args  = array_merge(
			$this->default_editor_args,
			array(
				'max_width' => '50em',
			)
		);
		$this->slug                 = 'user';
		$this->set_args( $args );
		$this->screen_id = array( 'user-edit', 'profile', 'user' );
		$this->nonce_key = '_wp_backstage_user_nonce';
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 *
	 * @since   0.0.1
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {
		$this->args = wp_parse_args( $args, $this->default_args );
	}

	/**
	 * Set Errors
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	protected function set_errors() {

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[ $required_arg ] ) ) {

					$this->errors[] = new WP_Error(
						'required_user_arg',
						sprintf(
							/* translators: 1:required arg key. */
							_x( '[user] The %1$s key is required.', 'user - required arg error', 'wp_backstage' ),
							'<code>' . $required_arg . '</code>'
						)
					);

				}
			}
		}

	}

	/**
	 * Init
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	public function init() {

		global $wp_backstage;

		if ( $wp_backstage->has_errors() ) {
			return;
		}

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		add_action( 'show_user_profile', array( $this, 'render_edit_nonce' ), 10 );
		add_action( 'edit_user_profile', array( $this, 'render_edit_nonce' ), 10 );
		add_action( 'user_new_form', array( $this, 'render_add_nonce' ), 10 );
		add_action( 'user_new_form', array( $this, 'render_field_groups' ), 10 );
		add_action( 'show_user_profile', array( $this, 'render_field_groups' ), 10 );
		add_action( 'edit_user_profile', array( $this, 'render_field_groups' ), 10 );
		add_action( 'personal_options_update', array( $this, 'save' ), 10 );
		add_action( 'edit_user_profile_update', array( $this, 'save' ), 10 );
		add_action( 'user_register', array( $this, 'save' ), 10 );
		add_filter( 'manage_users_columns', array( $this, 'add_field_columns' ), 10 );
		add_filter( 'manage_users_sortable_columns', array( $this, 'manage_sortable_columns' ), 10 );
		add_filter( 'manage_users_custom_column', array( $this, 'manage_admin_column_content' ), 10, 3 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_action( 'pre_get_users', array( $this, 'manage_filtering' ), 10 );
		add_action( 'pre_get_users', array( $this, 'manage_sorting' ), 10 );
		add_filter( 'users_list_table_query_args', array( $this, 'manage_list_table_query_args' ), 10 );
		add_action( 'manage_users_extra_tablenav', array( $this, 'render_table_filter_form' ), 10 );

		parent::init();

	}

	/**
	 * Get Field Groups
	 *
	 * @since   0.0.1
	 * @return  array  An array of field group argument arrays.
	 */
	protected function get_field_groups() {

		$field_groups = array();

		if ( is_array( $this->args['field_groups'] ) && ! empty( $this->args['field_groups'] ) ) {

			foreach ( $this->args['field_groups'] as $field_group ) {

				$field_groups[] = wp_parse_args( $field_group, $this->default_field_group_args );

			}
		}

		return $field_groups;

	}

	/**
	 * Get Fields
	 *
	 * @since   0.0.1
	 * @return  array  An array of field argument arrays.
	 */
	protected function get_fields() {

		$field_groups = $this->get_field_groups();
		$fields       = array();

		if ( is_array( $field_groups ) && ! empty( $field_groups ) ) {

			foreach ( $field_groups as $field_group ) {

				if ( is_array( $field_group['fields'] ) && ! empty( $field_group['fields'] ) ) {

					foreach ( $field_group['fields'] as $field ) {

						$fields[] = wp_parse_args( $field, $this->default_field_args );

					}
				}
			}
		}

		return $fields;

	}

	/**
	 * Render Edit Fields
	 *
	 * @since   0.0.1
	 * @since   3.1.0 Sends null to `render_fields` instead of user instance if this is the new user screen.
	 * @param   WP_User|string $user  An instance of `WP_User` or the string `add-new-user` if on the add new user form.
	 * @return  void
	 */
	public function render_field_groups( $user = null ) {

		$field_groups = $this->get_field_groups();

		if ( is_array( $field_groups ) && ! empty( $field_groups ) ) {

			foreach ( $field_groups as $field_group ) { ?>

				<h2><?php

					echo wp_kses( $field_group['title'], WP_Backstage::$kses_p );

				?></h2>

				<?php if ( ! empty( $field_group['description'] ) ) { ?>

					<p class="description"><?php

						echo wp_kses( $field_group['description'], WP_Backstage::$kses_p );

					?></p>

				<?php } ?>

				<table class="form-table">

					<tbody><?php

						$this->render_fields( $field_group, $user instanceof WP_User ? $user : null );

					?></tbody>

				</table>

			<?php }
		}

	}

	/**
	 * Render Fields
	 *
	 * @since   0.0.1
	 * @since   3.1.0 Checks if there is a user before getting the value as this is also run on the add new user form where there is no user yet.
	 * @param   array        $field_group  An array of field group arguments.
	 * @param   WP_User|null $user  An instance of `WP_User` or null if on the add user form.
	 * @return  void
	 */
	protected function render_fields( $field_group = array(), $user = null ) {

		if ( is_array( $field_group['fields'] ) && ! empty( $field_group['fields'] ) ) {

			foreach ( $field_group['fields'] as $field ) {

				$field['value']      = $user instanceof WP_User ? get_user_meta( $user->ID, $field['name'], true ) : null;
				$field['show_label'] = false;
				$input_class         = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

				if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
					$field['input_attrs']['class'] = sprintf( 'regular-text %1$s', $input_class );
				}

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows                 = ( $field['type'] === 'editor' ) ? 15 : 5;
					$default_cols                 = $this->is_screen( 'id', 'user' ) ? 60 : 30;
					$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $default_cols;
				}

				$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $user ); ?>

				<tr>

					<th>

						<?php if ( ! in_array( $field['type'], $this->remove_label_for_fields ) ) { ?>

							<label for="<?php echo sanitize_key( $field['name'] ); ?>"><?php

								echo wp_kses( $field['label'], WP_Backstage::$kses_label );

							?></label>

						<?php } else { ?>

							<span><?php

								echo wp_kses( $field['label'], WP_Backstage::$kses_label );

							?></span>

						<?php } ?>

					</th>

					<td><?php

						do_action( "wp_backstage_{$this->slug}_field_before", $field, $user );

						$this->render_field_by_type( $field );

						do_action( "wp_backstage_{$this->slug}_field_after", $field, $user );

					?></td>

				</tr>

			<?php }
		}

	}

	/**
	 * Save
	 *
	 * @since   0.0.1
	 * @param   int $user_id  The ID of the user to update.
	 * @return  void
	 */
	public function save( $user_id = null ) {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
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

			$values = array();

			foreach ( $fields as $field ) {

				if ( isset( $post_data[ $field['name'] ] ) ) {

					$value = $this->sanitize_field( $field, $post_data[ $field['name'] ] );

					update_user_meta( $user_id, $field['name'], $value );

				} else {

					delete_user_meta( $user_id, $field['name'] );

				}
			}
		}

	}

	/**
	 * Manage Admin Column Content
	 *
	 * @since   0.0.1
	 * @param   string $content  The original column content.
	 * @param   string $column   The column name.
	 * @param   int    $user_id  The ID of the user to populate the column for.
	 * @return  string  The new formatted column content.
	 */
	public function manage_admin_column_content( $content = '', $column = '', $user_id = null ) {

		$field = $this->get_field_by( 'name', $column );

		if ( ! empty( $field ) ) {

			$value = get_user_meta( $user_id, $column, true );

			/**
			 * Filters the post type custom field's admin column content.
			 *
			 * Returning any value here will short circuit the plugin's
			 * output and render this content instead.
			 *
			 * @since 0.0.1
			 *
			 * @param string $content The current content string.
			 * @param array $field an array of field arguments.
			 * @param mixed $value the field's value.
			 * @param int $user_id The user ID of the current user.
			 */
			$content = apply_filters( "wp_backstage_{$this->slug}_{$column}_column_content", $content, $field, $value, $user_id );

			if ( ! empty( $content ) ) {
				return $content;
			}

			$formatted_value = $this->format_field_value( $value, $field );

			if ( ! empty( $formatted_value ) ) {

				$content = $formatted_value;

			} else {

				$content = '&horbar;';

			}
		}

		return $content;

	}

	/**
	 * Render Table Filter Form
	 *
	 * This method is responsible for rendering the filter form at the top of the admin user list table.
	 * Because the user list table does not have filters, it is necessary to add the filter action submit
	 * button here.
	 *
	 * @since 3.1.0
	 * @param string $which whether the form is displayed at the top or bottom, or both. Possible values are `top`, `bottom`, or an empty string.
	 * @return void
	 */
	public function render_table_filter_form( $which = 'top' ) {

		if ( $which === 'top' ) { ?>

			<div id="wp-backstage-user-table-filters" class="align-left actions">

				<?php $this->render_table_filter_controls(); ?>

				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo get_submit_button(
					_x( 'Filter', 'users table filter - submit', 'wp_backstage' ),
					'',
					'filter_action',
					false,
					array(
						'id' => 'user-query-submit',
					)
				); ?>

			</div>

		<?php }
	}

	/**
	 * Manage Sorting
	 *
	 * The method is responsible for managing sorting on the query. If a field's
	 * name is found in the `orderby` key, then its key is added as the meta key
	 * for the query, and the orderby is reset to either `meta_value` or `meta_value_num`
	 * according to if the value is expected to be numeric or not. If no meta query is set,
	 * this will add a meta query that filters for users that either do or do not have the meta
	 * value set for the field. By default, setting just `meta_key` is not sufficient if the
	 * desire is to show users that don't have a value as well.
	 *
	 * @since   0.0.1
	 * @since   3.1.0  Added a check to see if there is already a meta query before setting the meta query that is added in order to get users both with or without a value set for the field.
	 * @param   WP_User_Query $query  An instance of `WP_User_Query`.
	 * @return  void
	 */
	public function manage_sorting( $query = null ) {

		$field = $this->get_field_by( 'name', $query->get( 'orderby' ) );

		if ( is_array( $field ) && ! empty( $field ) ) {

			if ( $field['is_sortable'] ) {

				$meta_query = $query->get( 'meta_query' );
				if ( empty( $meta_query ) ) {
					$query->set(
						'meta_query',
						array(
							'relation' => 'OR',
							array(
								'key'     => $field['name'],
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => $field['name'],
								'compare' => 'EXISTS',
							),
						)
					);
				} else {

					$query->set( 'meta_key', $field['name'] );

				}

				if ( $field['type'] === 'number' ) {

					$query->set( 'orderby', 'meta_value_num' );

				} else {

					$query->set( 'orderby', 'meta_value' );

				}
			}
		}
	}

	/**
	 * Manage Filtering
	 *
	 * This method is responsible for filtering the query if a query var set to
	 * a field's name is found. The fields are looped over and, if a field is
	 * found with the matching query var, builds an array of meta query filters.
	 * At the end of the loop, if there is a meta query to be set, the "AND" relation
	 * is also added to the meta query, allowing for complex filtering to be accomplished.
	 * See `WP_Backstage_Post_Type::manage_list_table_query_args()` to see how the fields
	 * are made available as public query vars.
	 *
	 * @since   3.1.0
	 * @param   WP_User_Query $query  An instance of `WP_User_Query`.
	 * @return  void
	 */
	public function manage_filtering( $query = null ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			$meta_query = array();

			foreach ( $fields as $field ) {

				$value = $query->get( $field['name'] );

				if ( ! empty( $value ) ) {

					$meta_query[] = array(
						'key'     => $field['name'],
						'value'   => $value,
						'compare' => '=',
					);
				}
			}

			// If we have a non-empty meta query set, add the "AND" relation
			// to the meta query and set it.
			if ( is_array( $meta_query ) && ! empty( $meta_query ) ) {
				$meta_query = array_merge( array( 'relation' => 'AND' ), $meta_query );
				$query->set( 'meta_query', $meta_query );
			}
		}
	}

	/**
	 * Manage List Table Query Args
	 *
	 * This method is responsible for making the URL query fields available to the main `WP User Query`.
	 * This allows for similar behavior to the query vars filter that is only available for posts. This
	 * method loops over the fields, and checks if the field key is a key of the URL query. If it is, it
	 * then adds the key and value to the args array to be passed to the `WP_User_Query` that runs the main
	 * users table.
	 *
	 * @since 3.1.0
	 * @param array $args The incoming array of arguments.
	 * @return array The filtered array of arguments.
	 */
	public function manage_list_table_query_args( $args = array() ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				// phpcs:ignore WordPress.Security.NonceVerification
				$url_params = wp_unslash( $_GET );

				if ( isset( $url_params[ $field['name'] ] ) ) {
					$args[ $field['name'] ] = $url_params[ $field['name'] ];
				}
			}
		}

		return $args;
	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Adds all generated fields to the hidden columns array by default, so as
	 * to not choke up the UI. Note that this will only work if user's
	 * columns UI has never been modified by the user. Hooked to
	 * `default_hidden_columns`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/default_hidden_columns/ Hook: default_hidden_columns
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 *
	 * @since   0.0.1
	 * @param   array     $hidden  An array of hidden columns.
	 * @param   WP_Screen $screen  An instance of `WP_Screen`.
	 * @return  array An array of hidden column keys.
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

}
