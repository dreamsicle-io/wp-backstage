<?php
/**
 * WP Backstage User
 * 
 * @version     0.0.1
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_User extends WP_Backstage {

	/**
	 * Default Args
	 * 
	 * @since 0.0.1
	 */
	public $default_args = array(
		'field_groups' => array(), 
	);

	/**
	 * Default Field Group Args
	 * 
	 * @since 0.0.1
	 */
	public $default_field_group_args = array(
		'id'          => '', 
		'title'       => '', 
		'description' => '', 
		'fields'      => array(), 
	);

	/**
	 * Required Args
	 * 
	 * @since 0.0.1
	 */
	public $required_args = array();

	/**
	 * Add
	 * 
	 * @since   0.0.1
	 * @param   array   $args 
	 * @return  void 
	 */
	public static function modify( $args = array() ) {

		$User = new WP_Backstage_User( $args );

		$User->init();

	}

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @param   array   $args 
	 * @return  void 
	 */
	function __construct( $args = array() ) {

		$this->default_field_args = array_merge( $this->default_field_args, array(
			'has_column'  => false, 
			'is_sortable' => false, 
		) );
		$this->set_args( $args );
		$this->screen_id = array( 'user-edit', 'profile' );
		$this->nonce_key = '_wp_backstage_user_nonce';
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has errors or not. 
	 */
	public function set_args( $args = array() ) {

		$this->args = wp_parse_args( $args, $this->default_args );

	}

	/**
	 * Set Errors
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function set_errors() {

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_user_arg', sprintf( 
						/* translators: 1:required arg key. */
						__( '[user] The %1$s key is required.', 'wp-backstage' ), 
						'<code>' . $required_arg . '</code>'
					) );

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

		if ( $this->has_errors() ) {
			
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			
			return;

		}

		add_action( 'show_user_profile', array( $this, 'render_edit_nonce' ), 10 );
		add_action( 'edit_user_profile', array( $this, 'render_edit_nonce' ), 10 );
		add_action( 'show_user_profile', array( $this, 'render_field_groups' ), 10 );
		add_action( 'edit_user_profile', array( $this, 'render_field_groups' ), 10 );
		add_action( 'personal_options_update', array( $this, 'save' ), 10 );
		add_action( 'edit_user_profile_update', array( $this, 'save' ), 10 );
		add_filter( 'manage_users_columns', array( $this, 'add_field_columns' ), 10 );
		add_filter( 'manage_users_sortable_columns', array( $this, 'manage_sortable_columns' ), 10 );
		add_filter( 'manage_users_custom_column', array( $this, 'manage_admin_column_content' ), 10, 3 );
		add_action( 'pre_get_users', array( $this, 'manage_sorting' ), 10 );

		parent::init();

	}

	/**
	 * Render Add nonce
	 * 
	 * @since   0.0.1
	 * @return  string 
	 */
	public function render_add_nonce() {

		wp_nonce_field( 'add', $this->nonce_key );

	}

	/**
	 * Render Add nonce
	 * 
	 * @since   0.0.1
	 * @return  string 
	 */
	public function render_edit_nonce() {

		wp_nonce_field( 'edit', $this->nonce_key );

	}

	/**
	 * Get Meta Boxes
	 * 
	 * @since   0.0.1
	 * @return  array  
	 */
	public function get_field_groups() {

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
	 * @return  array  
	 */
	public function get_fields() {

		$field_groups = $this->get_field_groups();
		$fields = array();

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
	 * @return  void 
	 */
	public function render_field_groups( $user = null ) {

		$field_groups = $this->get_field_groups();

		if ( is_array( $field_groups ) && ! empty( $field_groups ) ) { 

			foreach ( $field_groups as $field_group ) { ?>

				<h2><?php 

					echo esc_html( $field_group['title'] ); 

				?></h2>

				<?php if ( ! empty( $field_group['description'] ) ) { ?>

					<p class="description"><?php 

						echo wp_kses( $field_group['description'], $this->kses_p );

					?></p>

				<?php } ?>

				<table class="form-table">

					<tbody><?php 

						$this->render_fields( $field_group, $user );

					?></tbody>

				</table>

			<?php }

		}

	}

	/**
	 * Render Fields
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_fields( $field_group = array(), $user = null ) {

		if ( is_array( $field_group['fields'] ) && ! empty( $field_group['fields'] ) ) {
			
			foreach ( $field_group['fields'] as $field ) {

				$field['value'] = get_user_meta( $user->ID, $field['name'], true ); ?>

				<tr>
					
					<th>
						
						<label><?php 

							echo wp_kses( $field['label'], $this->kses_label ); 

						?></label>

					</th>

					<td><?php 

						$this->render_field_by_type( $field ); 

					?></td>

				</tr>

			<?php }

		}

	}

	/**
	 * Save
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function save( $user_id = 0 ) {

		if ( ! $user_id > 0 ) { return; }
		if ( ! current_user_can( 'edit_user', $user_id ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( empty( $_POST[$this->nonce_key] ) ) { return; }
		if ( ! wp_verify_nonce( $_POST[$this->nonce_key], 'add' ) && ! wp_verify_nonce( $_POST[$this->nonce_key], 'edit' ) ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				if ( isset( $_POST[$field['name']] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']] );

					update_user_meta( $user_id, $field['name'], $value );

					$values[$field['name']] = $value;

				} elseif ( in_array( $field['type'], array( 'checkbox', 'checkbox_set', 'radio' ) ) ) {

					$null_val = ( $field['type'] === 'radio' ) ? '' : false;

					update_user_meta( $user_id, $field['name'], $null_val );

				} 

			}

			if ( ! empty( $this->args['group_meta_key'] ) ) {

				update_user_meta( $user_id, $this->args['group_meta_key'], $values );

			}

		}

	}

	/**
	 * Manage Admin Column Content
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function manage_admin_column_content( $content = '', $column = '', $user_id = 0 ) {

		$field = $this->get_field_by( 'name', $column );

		if ( ! empty( $field ) ) {

			$value = get_user_meta( $user_id, $column, true );
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
	 * Manage Sorting
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function manage_sorting( $query = null ) {

		$field = $this->get_field_by( 'name', $query->get( 'orderby' ) );

		if ( is_array( $field ) && ! empty( $field ) ) {

			if ( $field['is_sortable'] ) {

				$query->set( 'meta_query', array(
					'relation' => 'OR',
					array(
						'key'     => $field['name'], 
						'compare' => 'EXISTS'
					),
					array(
						'key'     => $field['name'], 
						'compare' => 'NOT EXISTS'
					)
				) );

				if ( $field['type'] === 'number' ) {
					
					$query->set( 'orderby', 'meta_value_num' );

				} else {

					$query->set( 'orderby', 'meta_value' );

				}

			}

		}

	}

}