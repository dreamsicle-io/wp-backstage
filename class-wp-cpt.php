<?php
/**
 * WP CPT
 * 
 * @version  0.0.1
 */
class WP_CPT {

	/**
	 * Slug
	 * 
	 * @since 0.0.1
	 */
	public $slug = '';

	/**
	 * Args
	 * 
	 * @since 0.0.1
	 */
	public $args = array();

	/**
	 * Errors
	 * 
	 * @since 0.0.1
	 */
	public $errors = array();

	/**
	 * Notices
	 * 
	 * @since 0.0.1
	 */
	public $notices = array();

	/**
	 * Notices
	 * 
	 * @since 0.0.1
	 */
	public $hidden_meta_boxes = array( 
		'trackbacksdiv', 
		'slugdiv', 
		'authordiv', 
		'commentstatusdiv', 
		'postcustom', 
	);

	/**
	 * Default Args
	 * 
	 * @since 0.0.1
	 */
	public $default_args = array(
		'menu_name'       => '', 
		'singular_name'   => '', 
		'plural_name'     => '', 
		'thumbnail_label' => '', 
		'description'     => '', 
		'public'          => true, 
		'hierarchical'    => false, 
		'with_front'      => false, 
		'rest_base'       => '', 
		'menu_icon'       => 'dashicons-admin-post', 
		'capability_type' => 'post', 
		'supports'        => array(
			'title', 
			'slug', 
			'author', 
			'editor', 
			'excerpt', 
			'thumbnail', 
			'comments', 
			'trackbacks', 
			'revisions', 
			'custom-fields', 
			'page-attributes', 
		), 
		'taxonomies'      => array(), 
		'meta_boxes'      => array(), 
		'debug'           => false, 
	);

	/**
	 * Default Meta Box Args
	 * 
	 * @since 0.0.1
	 */
	public $default_meta_box_args = array( 
		'id'          => '', 
		'title'       => '', 
		'description' => '', 
		'context'     => '', 
		'priority'    => '', 
		'hidden'      => '', 
		'fields'      => array(), 
	);

	/**
	 * Default Field Args
	 * 
	 * @since 0.0.1
	 */
	public $default_field_args = array(
		'type'        => 'text', 
		'name'        => '', 
		'label'       => '', 
		'title'       => '', 
		'description' => '', 
		'has_column'  => '', 
		'is_sortable' => '', 
		'input_attrs' => array(),
	);

	/**
	 * KSES for P Tags
	 *
	 * @since 0.0.1
	 */
	public $kses_p = array(
		'a' => array(
			'class'  => array(), 
			'id'     => array(), 
			'style'  => array(), 
			'href'   => array(),
			'title'  => array(), 
			'target' => array(), 
			'rel'    => array(), 
		),
		'br' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'em' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'strong' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'code' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'i' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
	);

	/**
	 * Add
	 * 
	 * @since   0.0.1
	 * @param   string  $slug 
	 * @param   array   $args 
	 * @return  void 
	 */
	public static function add( $slug = '', $args = array() ) {

		$CPT = new WP_CPT( $slug, $args );

		$CPT->init();

	}

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @param   string  $slug 
	 * @param   array   $args 
	 * @return  void 
	 */
	function __construct( $slug = '', $args = array() ) {

		$this->set_slug( $slug );
		$this->set_args( $args );
		$this->set_errors();

	}

	/**
	 * Set Slug
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has errors or not. 
	 */
	public function set_slug( $slug = '' ) {

		$this->slug = sanitize_title_with_dashes( $slug );

	}

	/**
	 * Replace Args With Notice
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function replace_args_with_notice( $keys = array(), $replace = null ) {

		if ( is_array( $keys ) && ! empty( $keys ) ) {

			foreach ( $keys as $key ) {

				if ( empty( $this->args[$key] ) ) {

					$this->args[$key] = $replace;

					$this->notices[] = new WP_Error( 
						'arg_replacement', 
						sprintf( 
							/* translators: 1: arg key, 2: replacement */
							__( 'The %1$s key was empty; using %2$s as the value.', 'WP_CPT' ), 
							'<code>' . $key . '</code>', 
							'<code>' . $replace . '</code>'
						) 
					);

				}

			}

		}

	}

	/**
	 * Set Args
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has errors or not. 
	 */
	public function set_args( $args = array() ) {

		if ( current_theme_supports( 'post-formats' ) ) {

			$this->default_args['supports'][] = 'post-formats';
			
		}

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['thumbnail_label'] ) ) {

			$this->replace_args_with_notice( 
				array( 'thumbnail_label' ), 
				__( 'Featured Image', 'WP_CPT' ) 
			);

		}

		$this->replace_args_with_notice( 
			array( 'singular_base', 'archive_base', 'rest_base' ), 
			$this->slug 
		);

		$this->replace_args_with_notice( 
			array( 'menu_name', 'singular_name', 'plural_name' ), 
			$this->slug 
		);

	}

	/**
	 * Set Errors
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function set_errors() {

		if ( empty( $this->slug ) ) {
			
			$this->errors[] = new WP_Error( 'slug', __( 'A post type slug is required when adding a new post type.', 'WP_CPT' ) );
		
		}

	}

	/**
	 * Has Errors
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has errors or not. 
	 */
	public function has_errors() {

		return is_array( $this->errors ) && ! empty( $this->errors );

	}

	/**
	 * Print Errors
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function print_errors() {

		if ( $this->has_errors() ) {

			foreach ( $this->errors as $error ) {
				
				if ( is_wp_error( $error ) ) {

					$message = sprintf( 
						/* translators: 1: post type slug, 3: error message. */
						__( 'Error [%1$s]: %2$s', 'WP_CPT' ), 
						$this->slug, 
						$error->get_error_message() 
					); ?>

					<div class="notice notice-error">

						<p><?php 
				
							echo wp_kses( $message, $this->kses_p );

						?></p>

					</div>
				
				<?php }
			
			}

		}

	}

	/**
	 * Has Notices
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has notices or not. 
	 */
	public function has_notices() {

		return is_array( $this->notices ) && ! empty( $this->notices );

	}

	/**
	 * Print Notices
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function print_notices() {

		if ( $this->has_notices() ) {

			foreach ( $this->notices as $notice ) {
				
				if ( is_wp_error( $notice ) ) {

					$message = sprintf( 
						/* translators: 1: post type slug, 3: error message. */
						__( 'Warning [%1$s]: %2$s', 'WP_CPT' ), 
						$this->slug, 
						$notice->get_error_message() 
					); ?>

					<div class="notice notice-warning">

						<p><?php 
				
							echo wp_kses( $message, $this->kses_p );

						?></p>

					</div>
				
				<?php }
			
			}

		}

	}

	public function is_debugging() {

		return boolval( $this->args['debug'] );

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

		if ( $this->has_notices() && $this->is_debugging() ) {
			
			add_action( 'admin_notices', array( $this, 'print_notices' ) );
			
		}

		add_action( 'init', array( $this, 'register' ), 10 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		add_action( sprintf( 'save_post_%1$s', $this->slug ), array( $this, 'save' ), 10, 3 );
		add_filter( 'default_hidden_meta_boxes', array( $this, 'manage_default_hidden_meta_boxes' ), 10, 2 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'manage_thumbnail_column' ), 10 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'manage_field_columns' ), 10 );
		add_action( sprintf( 'manage_%1$s_posts_custom_column', $this->slug ), array( $this, 'render_admin_column' ), 10, 2 );
		add_filter( sprintf( 'manage_edit-%1$s_sortable_columns', $this->slug ), array( $this, 'manage_sortable_columns' ), 10 );
		add_action( 'pre_get_posts', array( $this, 'manage_sorting' ), 10 );

	}

	/**
	 * Get Label
	 * 
	 * @since   0.0.1
	 * @param   string  $template 
	 * @return  string 
	 */
	public function get_label( $template = '' ) {

		return sprintf(
			/* translators: 1: post type singular name, 2: post type plural name, 3: thumbnail label. */
			$template,
			$this->args['singular_name'], 
			$this->args['plural_name'], 
			$this->args['thumbnail_label'] 
		);

	}

	/**
	 * Register
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function register() {

		$labels = array(
			'name'                  => $this->args['plural_name'],
			'singular_name'         => $this->args['singular_name'],
			'menu_name'             => ! empty( $this->args['menu_name'] ) ? $this->args['menu_name'] : $this->args['plural_name'],
			'name_admin_bar'        => $this->args['singular_name'],
			'archives'              => $this->get_label( __( '%1$s Archives', 'WP_CPT' ) ),
			'attributes'            => $this->get_label( __( '%1$s Attributes', 'WP_CPT' ) ),
			'parent_item_colon'     => $this->get_label( __( 'Parent %1$s:', 'WP_CPT' ) ),
			'all_items'             => $this->get_label( __( 'All %2$s', 'WP_CPT' ) ),
			'add_new_item'          => $this->get_label( __( 'Add New %1$s', 'WP_CPT' ) ),
			'add_new'               => $this->get_label( __( 'Add New', 'WP_CPT' ) ),
			'new_item'              => $this->get_label( __( 'New %1$s', 'WP_CPT' ) ),
			'edit_item'             => $this->get_label( __( 'Edit %1$s', 'WP_CPT' ) ),
			'update_item'           => $this->get_label( __( 'Update %1$s', 'WP_CPT' ) ),
			'view_item'             => $this->get_label( __( 'View %1$s', 'WP_CPT' ) ),
			'view_items'            => $this->get_label( __( 'View %2$s', 'WP_CPT' ) ),
			'search_items'          => $this->get_label( __( 'Search %2$s', 'WP_CPT' ) ),
			'not_found'             => $this->get_label( __( 'No %2$s found', 'WP_CPT' ) ),
			'not_found_in_trash'    => $this->get_label( __( 'Not %2$s found in Trash', 'WP_CPT' ) ),
			'featured_image'        => $this->args['thumbnail_label'],
			'set_featured_image'    => $this->get_label( __( 'Set %3$s', 'WP_CPT' ) ),
			'remove_featured_image' => $this->get_label( __( 'Remove %3$s', 'WP_CPT' ) ),
			'use_featured_image'    => $this->get_label( __( 'Use as %3$s', 'WP_CPT' ) ),
			'insert_into_item'      => $this->get_label( __( 'Insert into %1$s', 'WP_CPT' ) ),
			'uploaded_to_this_item' => $this->get_label( __( 'Uploaded to this %1$s', 'WP_CPT' ) ),
			'items_list'            => $this->get_label( __( '%2$s list', 'WP_CPT' ) ),
			'items_list_navigation' => $this->get_label( __( '%2$s list navigation', 'WP_CPT' ) ),
			'filter_items_list'     => $this->get_label( __( 'Filter %2$s list', 'WP_CPT' ) ),
		);

		$rewrite = array(
			'slug'       => ! empty( $this->args['singular_base'] ) ? $this->args['singular_base'] : $this->slug,
			'with_front' => $this->args['with_front'],
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => ! empty( $this->args['menu_name'] ) ? $this->args['menu_name'] : $this->args['plural_name'],
			'description'         => $this->args['description'], 
			'labels'              => $labels,
			'supports'            => $this->args['supports'], 
			'taxonomies'          => $this->args['taxonomies'],
			'hierarchical'        => $this->args['hierarchical'],
			'public'              => $this->args['public'],
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => $this->args['menu_icon'],
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => $this->args['public'],
			'can_export'          => true,
			'has_archive'         => ( $this->args['public'] && ! empty( $this->args['archive_base'] ) ) ? $this->args['archive_base'] : false,
			'exclude_from_search' => ! $this->args['public'],
			'publicly_queryable'  => $this->args['public'],
			'rewrite'             => $this->args['public'] ? $rewrite : false,
			'capability_type'     => $this->args['capability_type'],
			'show_in_rest'        => ( $this->args['public'] && ! empty( $this->args['rest_base'] ) ),
			'rest_base'           => $this->args['rest_base'],
		);

		register_post_type( $this->slug, $args );

	}

	/**
	 * Add Meta Boxes
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function add_meta_boxes() {

		if ( is_array( $this->args['meta_boxes'] ) && ! empty( $this->args['meta_boxes'] ) ) {

			foreach ( $this->args['meta_boxes'] as $meta_box ) {

				$meta_box = wp_parse_args( $meta_box, $this->default_meta_box_args );

				add_meta_box( 
					$meta_box['id'], 
					$meta_box['title'], 
					array( $this, 'render_meta_box' ), 
					$this->slug, 
					$meta_box['context'], 
					$meta_box['priority'], 
					array( 
						'description' => $meta_box['description'], 
						'fields'      => $meta_box['fields'], 
					)
				);

			}

		}

	}

	/**
	 * Render Meta Box
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_meta_box( $post = null, $meta_box = array() ) {

		$meta_box = wp_parse_args( $meta_box, array(
			'id'    => '', 
			'title' => '', 
			'args'  => array(
				'descripton' => '',
				'fields'     => array(), 
			), 
		) );

		if ( is_array( $meta_box['args']['fields'] ) && ! empty( $meta_box['args']['fields'] ) ) {
			
			foreach ( $meta_box['args']['fields'] as $field ) {

				if ( $field['type'] === 'textarea' ) {

					$this->render_textarea( $field, $post );

				} else {

					$this->render_input( $field, $post );

				}

			}

		}

		if ( ! empty( $meta_box['args']['description'] ) ) { ?>

			<p><?php 

				echo wp_kses( $meta_box['args']['description'], $this->kses_p );

			?></p>

		<?php }

	}

	/**
	 * Format Attrs
	 * 
	 * @since   0.0.1
	 * @return  string  The imploded, escaped, formatted attributes.
	 */
	public static function format_attrs( $attrs = array() ) {

		$formatted_attrs = array();

		if ( is_array( $attrs ) && ! empty( $attrs ) ) {
			
			foreach ( $attrs as $key => $value ) {
				
				$formatted_attrs[] = sprintf( 
					'%1$s="%2$s"', 
					esc_attr( $key ), 
					esc_attr( $value ) 
				);

			}
			
		}

		return implode( ' ', $formatted_attrs );
	}

	/**
	 * Render Input
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_input( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_p ); 
				
				?></label>

				<br/>

				<input 
				class="widefat"
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php echo $this::format_attrs( $field['input_attrs'] ); ?>>
			
			</p>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Input
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_textarea( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_p );
				
				?></label>

				<br/>

				<textarea 
				class="widefat"
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php echo $this::format_attrs( $field['input_attrs'] ); ?>><?php 

					echo esc_textarea( $value );

				?></textarea>
			
			</p>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Get Fields
	 * 
	 * @since   0.0.1
	 * @return  array  
	 */
	public function get_fields() {

		$fields = array();

		if ( is_array( $this->args['meta_boxes'] ) && ! empty( $this->args['meta_boxes'] ) ) {
			
			foreach ( $this->args['meta_boxes'] as $meta_box ) {
			
				if ( is_array( $meta_box ) && isset( $meta_box['fields'] ) && ! empty( $meta_box['fields'] ) ) {
			
					$fields = array_merge( $fields, $meta_box['fields'] );
			
				}
			
			}
		
		}

		return $fields;

	}

	/**
	 * Sanitize Field
	 * 
	 * @since   0.0.1
	 * @return  mixed  The sanitized value according to the field type. 
	 */
	public function sanitize_field( $field = array(), $value = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );

		switch ( $field['type'] ) {
			case 'text':
				$value = sanitize_text_field( $value );
				break;
			
			case 'textarea':
				$value = sanitize_textarea_field( $value );
				break;

			case 'number':
				$value = floatval( $value );
				break;

			case 'url':
				$value = esc_url( $value );
				break;
			
			case 'email':
				$value = sanitize_email( $value );
				break;
			
			default:
				$value = esc_attr( $value );
				break;
		}

		return $value;

	}

	/**
	 * Save
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function save( $post_id = 0, $post = null, $update = false ) {

		if ( ! $post_id > 0 ) { return; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( $_POST['post_type'] !== $this->slug ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( isset( $_POST[$field['name']] ) ) {

					$value = $this::sanitize_field( $field, $_POST[$field['name']] );

					update_post_meta( $post_id, $field['name'], $value );

					$values[$field['name']] = $value;

				}

			}

			if ( ! empty( $this->args['group_meta_key'] ) ) {

				update_post_meta( $post_id, $this->args['group_meta_key'], $values );

			}

		}

	}

	/**
	 * Manage Default Hidden Meta Boxes
	 *
	 * Note that this will only work if the post type UI has never 
	 * been modified by the user.
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function manage_default_hidden_meta_boxes( $hidden = array(), $screen = null ) {

		if ( $screen->post_type === $this->slug ) {

			$hidden = array_merge( $hidden, $this->hidden_meta_boxes );

			if ( is_array( $this->args['meta_boxes'] ) && ! empty( $this->args['meta_boxes'] ) ) {

				foreach ( $this->args['meta_boxes'] as $meta_box ) {

					$meta_box = wp_parse_args( $meta_box, $this->default_meta_box_args );

					if ( $meta_box['hidden'] ) {

						$hidden[] = $meta_box['id'];

					}

				}

			}

		}

		return $hidden;

	}

	/**
	 * Manage Thumbnail Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered columns.
	 */
	public function manage_thumbnail_column( $columns = array() ) {

		if ( is_array( $columns ) && ! empty( $columns ) ) {

			foreach ( $columns as $column_key => $column_label ) {

				unset( $columns[$column_key] );

				if ( $column_key === 'cb' ) {

					$columns[$column_key] = $column_label;

					$columns['thumbnail']  = '<i class="dashicons dashicons-format-image" style="color:#444444;"></i>';
					$columns['thumbnail'] .= '<span class="screen-reader-text">' . esc_html( $this->thumbnail_label ) . '</span>';

				} else {

					$columns[$column_key] = $column_label;

				}

			}
		
		}

		return $columns;

	}

	/**
	 * Manage Field Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered columns. 
	 */
	public function manage_field_columns( $columns = array() ) {
		
		$fields = $this->get_fields();

		// Add field columns
		if ( is_array( $fields ) && ! empty( $fields ) ) {

			$columns_to_remove = array( 'comments', 'date' );
			$removed_columns = array();

			// unset removed columns to make space 
			// also ensure storage of the original
			// column for resetting later
			foreach ( $columns_to_remove as $removed ) {
				$removed_columns[$removed] = $columns[$removed];
				unset( $columns[$removed] );
			}

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( $field['has_column'] ) {

					$columns[$field['name']] = $field['label'];

				}

			}

			// reset stored removed columns
			foreach ( $columns_to_remove as $removed ) {
				$columns[$removed] = $removed_columns[$removed];
			}

		}

		return $columns;

	}

	/**
	 * Manage Sortable Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered sortable columns. 
	 */
	public function manage_sortable_columns( $columns = array() ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( $field['has_column'] && $field['is_sortable'] ) {

					$columns[$field['name']] = $field['name'];

				}

			}

		}

		return $columns;

	}

	/**
	 * Render Admin Column
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function render_admin_column( $column = '', $post_id = 0 ) {

		// render thumbnail column
		if ( post_type_supports( $this->slug, 'thumbnail' ) && ( $column === 'thumbnail' ) ) { ?>
		
			<a 
			title="<?php the_title_attribute( array( '', '', true, $post_id ) ); ?>"
			href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>" 
			style="display:block; width:40px; height:40px; overflow:hidden; background-color:#e7e7e7;"><?php 

				if ( has_post_thumbnail( $post_id ) ) {

					echo get_the_post_thumbnail( $post_id, 'thumbnail' );

				}

			?></a>

		<?php } else {

			$field = $this->get_field_by( 'name', $column );

			if ( ! empty( $field ) ) {

				$value = get_post_meta( $post_id, $column, true );

				if ( ! empty( $value ) ) {

					echo wp_kses_post( $value );

				} else {

					echo '&horbar;';

				}

			}

		}

	}

	/**
	 * Get Field By
	 * 
	 * @since   0.0.1
	 * @return  array  the field if found, or an empty array.
	 */
	public function get_field_by( $key = '', $value = null ) {

		$fields = $this->get_fields();
		$result = array();

		if ( ! empty( $key ) && ( is_array( $fields ) && ! empty( $fields ) ) ) {

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( isset( $field[$key] ) && ( $field[$key] === $value ) ) {

					$result = $field;

					// break the foreach once the condition is met.
					break;

				}

			}

		}

		return $result;

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