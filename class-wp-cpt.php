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
	 * Date Format
	 * 
	 * @since 0.0.1
	 */
	public $date_format = '';

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
		'singular_base'       => '', 
		'archive_base'       => '', 
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
	);

	/**
	 * Required Args
	 * 
	 * @since 0.0.1
	 */
	public $required_args = array(
		'singular_name', 
		'plural_name', 
	);

	/**
	 * Default Taxonomy Args
	 * 
	 * @since 0.0.1
	 */
	public $default_taxonomy_args = array(
		'singular_name'   => '', 
		'plural_name'     => '', 
		'description'     => '', 
		'public'          => true, 
		'hierarchical'    => true, 
		'with_front'      => false, 
		'archive_base'    => '', 
		'rest_base'       => '', 
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
		'disabled'    => false, 
		'description' => '', 
		'has_column'  => '', 
		'is_sortable' => '', 
		'options'     => array(),
		'input_attrs' => array(),
		'args'        => array(), 
	);

	/**
	 * Default Option Args
	 * 
	 * @since 0.0.1
	 */
	public $default_option_args = array(
		'value'       => '', 
		'label'       => '', 
		'disabled'    => false,
	);

	/**
	 * Default Media Uploader Args
	 * 
	 * @since 0.0.1
	 */
	public $default_media_uploader_args = array(
		'multiple' => '', 
		'type'     => '', 
	);

	/**
	 * Default Date Args
	 * 
	 * @since 0.0.1
	 */
	public $default_date_args = array(
		'format' => 'yy-mm-dd', 
	);

	/**
	 * Default Color Args
	 * 
	 * @since 0.0.1
	 */
	public $default_color_args = array(
		'palettes' => true, 
	);

	/**
	 * Default Code Args
	 * 
	 * @since 0.0.1
	 */
	public $default_code_args = array(
		'type' => 'htmlmixed', 
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
	 * KSES for Label Tags
	 *
	 * @since 0.0.1
	 */
	public $kses_label = array(
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

		$this->date_format = get_option( 'date_format' );
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

			$this->args['thumbnail_label'] = __( 'Featured Image', 'WP_CPT' );

		}

		if ( empty( $this->args['singular_base'] ) ) {

			$this->args['singular_base'] = $this->slug;

		}

		if ( empty( $this->args['archive_base'] ) ) {

			$this->args['archive_base'] = $this->slug;

		}

		if ( empty( $this->args['menu_name'] ) ) {

			if ( ! empty( $this->args['plural_name'] ) ) {

				$this->args['menu_name'] = $this->args['plural_name'];

			} elseif ( ! empty( $this->args['singular_name'] ) ) {

				$this->args['menu_name'] = $this->args['singular_name'];

			} else {

				$this->args['menu_name'] = $this->slug;

			}

		}

	}

	/**
	 * Set Errors
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function set_errors() {

		if ( empty( $this->slug ) ) {
			
			$this->errors[] = new WP_Error( 'required_slug', __( 'A post type slug is required when adding a new post type.', 'WP_CPT' ) );
		
		} elseif ( in_array( $this->slug, get_post_types() ) ) {

			$this->errors[] = new WP_Error( 'post_type_exists', __( 'A post type with this slug already exists.', 'WP_CPT' ) );

		}

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_arg', sprintf( 
						/* translators: 1: required arg key. */
						__( 'The %1$s key is required.', 'WP_CPT' ), 
						'<code>' . $required_arg . '</code>'
					) );

				}

			}

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

		add_action( 'init', array( $this, 'register_post_type' ), 0 );
		add_action( 'init', array( $this, 'register_taxonomies' ), 0 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		add_action( sprintf( 'save_post_%1$s', $this->slug ), array( $this, 'save' ), 10, 3 );
		add_filter( 'default_hidden_meta_boxes', array( $this, 'manage_default_hidden_meta_boxes' ), 10, 2 );
		add_filter( 'edit_form_top', array( $this, 'render_edit_nonces' ), 10 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'manage_admin_columns' ), 10 );
		add_action( sprintf( 'manage_%1$s_posts_custom_column', $this->slug ), array( $this, 'render_admin_column' ), 10, 2 );
		add_filter( sprintf( 'manage_edit-%1$s_sortable_columns', $this->slug ), array( $this, 'manage_sortable_columns' ), 10 );
		add_action( 'pre_get_posts', array( $this, 'manage_sorting' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		add_action( 'admin_footer', array( $this, 'inline_media_uploader_script' ), 10 );
		add_action( 'admin_footer', array( $this, 'inline_datepicker_script' ), 10 );
		add_action( 'admin_footer', array( $this, 'inline_colorpicker_script' ), 10 );

	}

	/**
	 * Enqueue Admin Scripts
	 * 
	 * @since   0.0.1
	 * @return  string 
	 */
	public function enqueue_admin_scripts() {

		if ( ! $this->is_screen( 'id', $this->slug ) ) {
			return;
		}

		$has_media_uploader = ! empty( $this->get_field_by( 'type', 'media' ) );
		$has_date = ! empty( $this->get_field_by( 'type', 'date' ) );
		$has_color = ! empty( $this->get_field_by( 'type', 'color' ) );
		$code_editors = $this->get_fields_by( 'type', 'code' );

		if ( $has_media_uploader || $has_date ) {

			if ( ! wp_script_is( 'jquery-ui-core', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-core' );
			}

			if ( ! wp_script_is( 'jquery-ui-theme-default', 'enqueued' ) ) {
				wp_enqueue_style( 
					'jquery-ui-theme-default', 
					'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', 
					array(), 
					'1.12.1' 
				);
			}

		}

		if ( $has_media_uploader ) {
			
			if ( ! wp_script_is( 'media-editor', 'enqueued' ) ) {
				wp_enqueue_media();
			}

			if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}

		}

		if ( $has_date ) {

			if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-datepicker' );
			}

		}

		if ( $has_color ) {

			if ( ! wp_script_is( 'wp-color-picker', 'enqueued' ) ) {
				wp_enqueue_script( 'wp-color-picker' );
			}
			if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
				wp_enqueue_style( 'wp-color-picker' );
			}

		}

		if ( ! empty( $code_editors ) ) {

			$global_settings =  array( 
				'codemirror' => array(
					'lineWrapping' => false, 
				), 
			);

			foreach ( $code_editors as $code_editor ) {

				$code_editor_args = wp_parse_args( $code_editor['args'], $this->default_code_args );

				$code_editor_settings = wp_enqueue_code_editor( array_merge( $global_settings, array( 
					'type' => $code_editor_args['type'], 
				) ) );

				if ( $code_editor_settings ) {

					wp_add_inline_script(
						'code-editor',
						sprintf(
							'jQuery( function() { wp.codeEditor.initialize( "%1$s", %2$s ); } );',
							sanitize_title_with_dashes( $code_editor['name'] ), 
							wp_json_encode( $code_editor_settings )
						)
					);

				}

			}

		}

	}


	/**
	 * Is Screen
	 * 
	 * @since   0.0.1
	 * @return  boolean  If the match was successful or not. 
	 */
	public function is_screen( $key = '', $value = '' ) {

		$screen = get_current_screen();

		return ( $value === $screen->$key );

	}

	/**
	 * Render nonce
	 * 
	 * @since   0.0.1
	 * @return  string 
	 */
	public function render_edit_nonces() {

		wp_nonce_field( 'edit', sprintf( '_%1$s_nonce', $this->slug ) );

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
	 * Get Taxonomy Label
	 * 
	 * @since   0.0.1
	 * @param   string  $template 
	 * @return  string 
	 */
	public function get_taxonomy_label( $template = '', $taxonomy = array() ) {

		return sprintf(
			/* translators: 1: taxonomy singular name, 2: taxonomy plural name. */
			$template,
			$taxonomy['singular_name'], 
			$taxonomy['plural_name']
		);

	}

	/**
	 * Register
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function register_post_type() {

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

	public function register_taxonomies() {

		if ( is_array( $this->args['taxonomies'] ) && ! empty( $this->args['taxonomies'] ) ) {

			foreach ( $this->args['taxonomies'] as $taxonomy ) {

				$taxonomy = wp_parse_args( $taxonomy, $this->default_taxonomy_args );

				$labels = array(
					'name'                       => $taxonomy['plural_name'],
					'singular_name'              => $taxonomy['singular_name'],
					'menu_name'                  => $taxonomy['plural_name'],
					'all_items'                  => $this->get_taxonomy_label( __( 'All %2$s', 'WP_CPT' ), $taxonomy ),
					'parent_item'                => $this->get_taxonomy_label( __( 'Parent %1$s', 'WP_CPT' ), $taxonomy ),
					'parent_item_colon'          => $this->get_taxonomy_label( __( 'Parent %1$s:', 'WP_CPT' ), $taxonomy ),
					'new_item_name'              => $this->get_taxonomy_label( __( 'New %1$s Name', 'WP_CPT' ), $taxonomy ),
					'add_new_item'               => $this->get_taxonomy_label( __( 'Add New %1$s', 'WP_CPT' ), $taxonomy ),
					'edit_item'                  => $this->get_taxonomy_label( __( 'Edit %1$s', 'WP_CPT' ), $taxonomy ),
					'update_item'                => $this->get_taxonomy_label( __( 'Update %1$s', 'WP_CPT' ), $taxonomy ),
					'view_item'                  => $this->get_taxonomy_label( __( 'View %1$s', 'WP_CPT' ), $taxonomy ),
					'separate_items_with_commas' => $this->get_taxonomy_label( __( 'Separate %2$s with commas', 'WP_CPT' ), $taxonomy ),
					'add_or_remove_items'        => $this->get_taxonomy_label( __( 'Add or remove %2$s', 'WP_CPT' ), $taxonomy ),
					'choose_from_most_used'      => $this->get_taxonomy_label( __( 'Choose from the most used %2$s', 'WP_CPT' ), $taxonomy ),
					'popular_items'              => $this->get_taxonomy_label( __( 'Popular %2$s', 'WP_CPT' ), $taxonomy ),
					'search_items'               => $this->get_taxonomy_label( __( 'Search %2$s', 'WP_CPT' ), $taxonomy ),
					'not_found'                  => $this->get_taxonomy_label( __( 'No %2$s Found', 'WP_CPT' ), $taxonomy ),
					'no_terms'                   => $this->get_taxonomy_label( __( 'No %2$s', 'WP_CPT' ), $taxonomy ),
					'items_list'                 => $this->get_taxonomy_label( __( '%2$s list', 'WP_CPT' ), $taxonomy ),
					'items_list_navigation'      => $this->get_taxonomy_label( __( '%2$s list navigation', 'WP_CPT' ), $taxonomy ),
				);

				$rewrite = array(
					'slug'                       => $taxonomy['archive_base'],
					'with_front'                 => $taxonomy['with_front'],
					'hierarchical'               => $taxonomy['hierarchical'],
				);

				$args = array(
					'labels'                     => $labels,
					'hierarchical'               => $taxonomy['hierarchical'],
					'public'                     => $taxonomy['public'],
					'show_ui'                    => true,
					'show_admin_column'          => true,
					'show_in_nav_menus'          => $taxonomy['public'],
					'show_tagcloud'              => $taxonomy['public'],
					'rewrite'                    => $taxonomy['public'] ? $rewrite : false,
					'show_in_rest'               => ( $taxonomy['public'] && ! empty( $taxonomy['rest_base'] ) ),
					'rest_base'                  => $taxonomy['rest_base'],
				);

				register_taxonomy( $taxonomy['slug'], $this->slug, $args );

			}

		}

	}

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

		switch ( $field['type'] ) {
			case 'text':
				$value = sanitize_text_field( $value );
				break;
			case 'textarea':
				$value = sanitize_textarea_field( $value );
				break;
			case 'code':
				$value = $value;
				break;
			case 'number':
				if ( $value !== '' ) {
					$value = floatval( $value );
				} else {
					$value = null;
				}
				break;
			case 'url':
				$value = esc_url( $value );
				break;
			case 'email':
				$value = sanitize_email( $value );
				break;
			case 'checkbox':
				$value = boolval( $value );
				break;
			case 'checkbox_set':
				$value = array_map( 'esc_attr', $value );
				break;
			case 'media':
				$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );
				if ( $args['multiple'] ) {
					if ( ! empty( $value ) ) {
						$value = array_map( 'intval', explode( ',', $value ) );
					} else {
						$value = null;
					}
				} else {
					$value = absint( $value );
					if ( ! $value > 0 ) {
						$value = null;
					}
				}
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

		$nonce_key = sprintf( '_%1$s_nonce', $this->slug );

		if ( ! $post_id > 0 ) { return; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( $_POST['post_type'] !== $this->slug ) { return; }
		if ( empty( $_POST[$nonce_key] ) ) { return; }
		if ( ! wp_verify_nonce( $_POST[$nonce_key], 'edit' ) ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( isset( $_POST[$field['name']] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']] );

					update_post_meta( $post_id, $field['name'], $value );

					$values[$field['name']] = $value;

					if ( $field['type'] === 'media' ) {

						$this->handle_attachments( $post_id, $value, $field );

					}

				} elseif ( in_array( $field['type'], array( 'checkbox', 'checkbox_set' ) ) ) {

					update_post_meta( $post_id, $field['name'], false );

				} 

			}

			if ( ! empty( $this->args['group_meta_key'] ) ) {

				update_post_meta( $post_id, $this->args['group_meta_key'], $values );

			}

		}

	}

	public function handle_attachments( $post_id = 0, $value = 0, $field = array() ) {

		if ( $field['type'] !== 'media') {
			return;
		}

		$media_uploader_args = wp_parse_args( $field['args'], $this->default_media_uploader_args );

		if ( ! $media_uploader_args['attach'] ) {
			return;
		}

		if ( ! empty( $value ) ) {
			
			if ( $media_uploader_args['multiple'] ) {

				if ( is_array( $value ) && ! empty( $value ) ) {

					foreach( $value as $attachment_id ) {

						if ( get_post_type( $attachment_id ) === 'attachment' ) {

							$parent_id = wp_get_post_parent_id( $attachment_id );
							if ( ! $parent_id > 0 ) {
								wp_update_post( array(
									'ID'          => $attachment_id, 
									'post_parent' => $post_id,
								) );
							}

						}

					}

				}

			} else {

				if ( ! empty( $value ) ) {
				
					if ( get_post_type( $value ) === 'attachment' ) {
				
						$parent_id = wp_get_post_parent_id( $value );
						if ( ! $parent_id > 0 ) {
							wp_update_post( array(
								'ID'          => $value, 
								'post_parent' => $post_id,
							) );
						}
				
					}
				
				}
			
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
	 * Add Thumbnail Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered columns.
	 */
	public function add_thumbnail_column( $columns = array() ) {

		if ( is_array( $columns ) && ! empty( $columns ) ) {

			// loop the columns so that the new columns can
			// be inserted where they are wanted
			foreach ( $columns as $column_key => $column_label ) {

				// unset this column to make room for the new column,
				// all information needed to reset the column is already here
				unset( $columns[$column_key] );

				// if the loop is currently at the checkbox column, 
				// reset the checkbox column followed by the new 
				// thumbnail column
				if ( $column_key === 'cb' ) {

					// if the loop is currently at the checkbox column, 
					// reset the checkbox column followed by the new 
					// thumbnail column
					$columns[$column_key] = $column_label;
					$columns['thumbnail']  = '<i class="dashicons dashicons-format-image" style="color:#444444;"></i><span class="screen-reader-text">' . esc_html( $this->args['thumbnail_label'] ) . '</span>';

				} else {

					// else reset the column as is
					$columns[$column_key] = $column_label;

				}

			}
		
		}

		return $columns;

	}

	/**
	 * Add Field Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered columns. 
	 */
	public function add_field_columns( $columns = array() ) {

		if ( is_array( $columns ) && ! empty( $columns ) ) {
		
			$fields = $this->get_fields();

			// Add all field columns
			if ( is_array( $fields ) && ! empty( $fields ) ) {

				// set which columns should be removed to make way 
				// for new columns (will be added back later as is), 
				// date is included by default, but sometimes comments
				// are there, and this should be at the end as well
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

		}

		return $columns;

	}

	/**
	 * Manage Admin Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered columns. 
	 */
	public function manage_admin_columns( $columns = array() ) {

		$columns = $this->add_thumbnail_column( $columns );
		$columns = $this->add_field_columns( $columns );

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
	 * Render Thumbnail
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function render_thumbnail( $post_id = 0 ) {

		if ( post_type_supports( $this->slug, 'thumbnail' ) ) { ?>
		
			<a 
			title="<?php the_title_attribute( array( '', '', true, $post_id ) ); ?>"
			href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>" 
			style="display:block; width:40px; height:40px; overflow:hidden; background-color:#e7e7e7;"><?php 

				if ( has_post_thumbnail( $post_id ) ) {

					echo get_the_post_thumbnail( $post_id, 'thumbnail' );

				}

			?></a>

		<?php }

	}

	/**
	 * Render Column Content
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function render_column_content( $value = null, $field = array() ) {

		$content = '&horbar;';

		if ( ! empty( $value ) && ( is_array( $field ) && ! empty( $field ) ) ) {

			switch ( $field['type'] ) {
				case 'url':
					$content = '<a href="' . esc_attr( $value ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a>';
					break;
				case 'email':
					$content = '<a href="mailto:' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a>';
					break;
				case 'tel':
					$content = '<a href="tel:' . esc_attr( preg_replace('/[^0-9]/', '', $value ) ) . '">' . esc_html( $value ) . '</a>';
					break;
				case 'radio':
					$labels = $this->get_option_labels( $field );
					$content = esc_html( $labels[$value] );
					break;
				case 'select':
					$labels = $this->get_option_labels( $field );
					$content = esc_html( $labels[$value] );
					break;
				case 'checkbox':
					$content = $value ? '<i class="dashicons dashicons-yes"></i><span class="screen-reader-text">' . esc_html__( 'true', 'WP_CPT' ) . '</span>' : '&horbar;';
					break;
				case 'textarea':
					$content = $value ? wpautop( sanitize_textarea_field( $value ) ) : '&horbar;';
					break;
				case 'code':
					$content = $value ? '<textarea disabled rows="3" style="font-size:10px;">' . esc_textarea( $value ) . '</textarea>' : '&horbar;';
					break;
				case 'color':
					$content = $value ? '<i style="display:block;width:24px;height:24px;border:1px solid #e1e1e1;background-color:' . esc_attr( $value ) . ';" title="' . esc_attr( $value ) . '"></i>' : '&horbar;';
					break;
				case 'date':
					$content = $value ? date( $this->date_format, strtotime( $value ) ) : '&horbar;';
					break;
				case 'checkbox_set':
					if ( is_array( $value ) && ! empty( $value ) ) {
						$option_labels = $this->get_option_labels( $field );
						foreach( $value as $key ) {
							$labels[] = $option_labels[$key];
						}
					}
					$content = esc_html( implode( ', ', $labels ) );
					break;
				case 'media':
					$thumbnail_size = 20;
					$thumbnail_style = 'height:' . $thumbnail_size . 'px;width:auto;margin:0 4px 4px 0;display:block;float:left;border:1px solid #e1e1e1;';
					if ( is_array( $value ) ) {
						$value = array_map( 'absint', $value );
					} else {
						$value = array( absint( $value ) );
					}
					$attachments = array();
					foreach( $value as $i => $attachment_id ) {
						$attachments[] = wp_get_attachment_image( 
							intval( $attachment_id ), 
							array($thumbnail_size, $thumbnail_size), 
							true, 
							array( 
								'style' => $thumbnail_style, 
								'title' => get_the_title( $attachment_id ), 
							) 
						);
					}
					$content = implode( '', $attachments );
					break;
				default:
					$content = $value;
					break;
			}

		}

		echo $content;

	}

	/**
	 * Get Option Labels
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function get_option_labels( $field, $post_id = 0 ) {
		
		$option_labels = array();
		
		if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {
			
			foreach( $field['options'] as $option ) {
				
				$option_labels[$option['value']] = $option['label'];
		
			}
		
		}

		return $option_labels;
	}

	/**
	 * Render Admin Column
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function render_admin_column( $column = '', $post_id = 0 ) {

		if ( $column === 'thumbnail' ) {

			$this->render_thumbnail( $post_id );

		} else {

			$field = $this->get_field_by( 'name', $column );

			if ( ! empty( $field ) ) {

				$value = get_post_meta( $post_id, $column, true );

				if ( ! empty( $value ) ) {

					$this->render_column_content( $value, $field );

				} else {

					echo '&horbar;';

				}

			}

		}

	}

	/**
	 * Get Fields By
	 * 
	 * @since   0.0.1
	 * @return  array  the fields if found, or an empty array.
	 */
	public function get_fields_by( $key = '', $value = null ) {

		$fields = $this->get_fields();
		$result = array();

		if ( ! empty( $key ) && ( is_array( $fields ) && ! empty( $fields ) ) ) {

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( isset( $field[$key] ) && ( $field[$key] === $value ) ) {

					$result[] = $field;

				}

			}

		}

		return $result;

	}

	/**
	 * Get Field By
	 * 
	 * @since   0.0.1
	 * @return  array  the field if found, or an empty array.
	 */
	public function get_field_by( $key = '', $value = null ) {

		$fields = $this->get_fields();
		$result = null;

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

		$query_post_type = $query->get( 'post_type' );
		$is_post_type = is_array( $query_post_type ) ? in_array( $this->slug, $query_post_type ) : ( $query_post_type === $this->slug );
		
		if ( $is_post_type ) {

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

				switch ( $field['type'] ) {
					case 'textarea':
						$this->render_textarea( $field, $post );
						break;
					case 'select':
						$this->render_select( $field, $post );
						break;
					case 'radio':
						$this->render_radio( $field, $post );
						break;
					case 'checkbox':
						$this->render_checkbox( $field, $post );
						break;
					case 'checkbox_set':
						$this->render_checkbox_set( $field, $post );
						break;
					case 'media':
						$this->render_media_uploader( $field, $post );
						break;
					case 'date':
						$this->render_date( $field, $post );
						break;
					case 'color':
						$this->render_color( $field, $post );
						break;
					case 'code':
						$this->render_code( $field, $post );
						break;
					default:
						$this->render_input( $field, $post );
						break;
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
	public function format_attrs( $attrs = array() ) {

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

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></label>

				<br/>

				<input 
				class="widefat"
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
			
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
	 * Render Date
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_date( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true );
		$args = wp_parse_args( $field['args'], $this->default_date_args ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-datepicker-id="<?php echo esc_attr( $id ); ?>"
		data-datepicker-format="<?php echo esc_attr( $args['format'] ); ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></label>

				<br/>

				<input 
				class="widefat"
				type="text" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
			
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
	 * Render Color
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_color( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true );
		$args = wp_parse_args( $field['args'], $this->default_color_args );

		if ( is_array( $args['palettes'] ) ) {
			$palettes = implode( ',', array_map( 'esc_attr', $args['palettes'] ) );
		} else {
			$palettes = $args['palettes'] ? 'true' : 'false';
		} ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-colorpicker-id="<?php echo esc_attr( $id ); ?>"
		data-colorpicker-hide="<?php echo $args['hide'] ? 'true' : 'false'; ?>"
		data-colorpicker-palettes="<?php echo $palettes; ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></label>

				<br/>

				<input 
				class="widefat"
				type="text" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
			
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
	 * Render Checkbox
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_checkbox( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<input 
				type="checkbox" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="1" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php checked( true, $value ); ?>
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></label>
			
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
	 * Render Textarea
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

					echo wp_kses( $field['label'], $this->kses_label );
				
				?></label>

				<br/>

				<textarea 
				class="widefat"
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

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
	 * Render Code
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_code( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_label );
				
				?></label>

				<br/>

				<textarea 
				class="widefat"
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $value ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

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
	 * Render Select
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_select( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<p id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<label for="<?php echo esc_attr( $id ); ?>"><?php 

					echo wp_kses( $field['label'], $this->kses_label );
				
				?></label>

				<br/>

				<select 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

					if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

						foreach ( $field['options'] as $option ) { 

							$option = wp_parse_args( $option, $this->default_option_args );
							$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value']; ?>

							<option 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php selected( $option['value'], $value ); ?>
							<?php disabled( true, $option['disabled'] ); ?>><?php 

								echo strip_tags( $option_label );

							?></option>

						<?php }

					}

				?></select>
			
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
	 * Render Radio
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_radio( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<fieldset 
			id="<?php echo esc_attr( $id ); ?>"
			aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>">

				<legend><?php 

					echo wp_kses( $field['label'], $this->kses_label );
				
				?></legend>

				<?php 
				if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

					foreach ( $field['options'] as $option ) { 

						$option = wp_parse_args( $option, $this->default_option_args );
						$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
						$input_id = sprintf( esc_attr( '%1$s_%2$s' ), $id, sanitize_title_with_dashes( $option['value'] ) ); ?>

						<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>">

							<input
							type="radio" 
							id="<?php echo esc_attr( $input_id ); ?>" 
							name="<?php echo esc_attr( $field['name'] ); ?>" 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php echo $this->format_attrs( $field['input_attrs'] ); ?>
							<?php checked( $option['value'], $value ); ?>
							<?php disabled( true, ( $option['disabled'] || $field['disabled'] ) ); ?>/>

							<label for="<?php echo esc_attr( $input_id ); ?>"><?php 

								echo esc_html( $option_label );
							
							?></label>

						</div>

					<?php }

				} ?>
			
			</fieldset>

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
	 * Render Checkbox Set
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_checkbox_set( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true ); ?>

		<div id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<fieldset 
			id="<?php echo esc_attr( $id ); ?>"
			aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>">

				<legend><?php 

					echo wp_kses( $field['label'], $this->kses_label );
				
				?></legend>

				<?php 
				if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

					foreach ( $field['options'] as $option ) { 

						$option = wp_parse_args( $option, $this->default_option_args );
						$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
						$input_id = sprintf( esc_attr( '%1$s_%2$s' ), $id, sanitize_title_with_dashes( $option['value'] ) ); ?>

						<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>">

							<input
							type="checkbox" 
							id="<?php echo esc_attr( $input_id ); ?>" 
							name="<?php echo esc_attr( $field['name'] ); ?>[]" 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php echo $this->format_attrs( $field['input_attrs'] ); ?>
							<?php disabled( true, ( $option['disabled'] || $field['disabled'] ) ); ?>
							<?php checked( true, in_array( $option['value'], $value ) ); ?>/>

							<label for="<?php echo esc_attr( $input_id ); ?>"><?php 

								echo esc_html( $option_label );
							
							?></label>

						</div>

					<?php }

				} ?>
			
			</fieldset>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	public function get_media_uploader_label( $template = '', $field = array() ) {

		if ( ! empty( $template ) ) {

			return sprintf( 
				/* translators: 1: image label. */
				$template, 
				$field['label'] 
			);

		} else {

			return $field['label'];

		}

	}

	
	/**
	 * Render Media Uploader Thumbnail
	 *
	 * @since   0.0.1 
	 * @param   string  $attachment_id 
	 * @param   string  $type           `template` or `clone`.
	 * @param   string  $args           media uploader field args.
	 * @return  void
	 */
	public function render_media_uploader_thumbnail( $attachment_id = 0, $type = 'clone', $args = array() ) {

		$orientation_class = 'portrait';
		$src = '';
		$cursor_style = ( $args['multiple'] ) ? 'cursor:move;' : 'cursor:normal;';
		$display_style = ( $type === 'template' ) ? 'display:none;' : 'display:block;';

		if ( ( $attachment_id > 0 ) && ( $type === 'clone' ) ) {
			
			$image_attrs = wp_get_attachment_image_src( absint( $attachment_id ), 'medium', true );
			$src = $image_attrs[0];
			
			if ( $image_attrs[1] > $image_attrs[2] ) {
				$orientation_class = 'landscape';
			}

		}

		if ( ( $attachment_id > 0 ) || ( $type === 'template' ) ) {

			$thumbnail_type_attr = sprintf( 
				'data-media-uploader-%1$s="%2$s"', 
				esc_attr( $type ), 
				( $type === 'clone' ) ? absint( $attachment_id ) : 'true' 
			);

			$mime_type = ( $type !== 'template' ) ? get_post_mime_type( $attachment_id ) : ''; ?>

			<figure 
			tabindex="0" 
			class="attachment" 
			style="<?php echo esc_attr( $cursor_style . $display_style ); ?>"
			<?php echo $thumbnail_type_attr; ?>>

				<div 
				class="attachment-preview <?php echo esc_attr( $orientation_class ); ?>"
				style="<?php echo esc_attr( $cursor_style ); ?>">

					<div class="thumbnail">

						<div class="centered">

							<img src="<?php echo esc_url( $src ); ?>">

						</div>

						<div class="filename" style="<?php echo ( strpos( $mime_type, 'image' ) === false ) ? 'display:block;' : 'display:none;'; ?>">

							<div class="filename-inside-div"><?php 

								if ($type !== 'template') {

									echo esc_html( basename( get_attached_file( $attachment_id ) ) );

								}

							?></div>

						</div>

					</div>

				</div>

				<button 
				type="button" 
				class="check" 
				tabindex="0">
					
					<i 
					class="media-modal-icon"
					style="background-position:-60px 0;"></i>

					<span class="screen-reader-text"><?php 

						echo esc_attr( $this->get_media_uploader_label( __( 'Remove %1$s', 'WP_CPT' ), $field ) ); 

					?></span>

				</button>

			</figure>

		<?php }

	}

	/**
	 * Render Checkbox Set
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_media_uploader( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true );
		$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );
		$modal_button_template = $args['multiple'] ? __( 'Add to %1$s', 'WP_CPT' ) : __( 'Set %1$s', 'WP_CPT' ); ?>

		<fieldset 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-media-uploader-id="<?php echo esc_attr( $id ); ?>"
		data-media-uploader-multiple="<?php echo $args['multiple'] ? 'true' : 'false'; ?>"
		data-media-uploader-type="<?php echo esc_attr( $args['type'] ); ?>"
		data-media-uploader-title="<?php echo esc_attr( $field['label'] ); ?>"
		data-media-uploader-button="<?php echo esc_attr( $this->get_media_uploader_label( $modal_button_template, $field ) ); ?>">
				
			<legend 
			id="<?php printf( esc_attr( '%1$s_legend' ), $id ); ?>"
			style="cursor:pointer;"><?php 

				echo wp_kses( $field['label'], $this->kses_label ); 
		
			?></legend>

			<div 
			id="<?php printf( esc_attr( '%1$s_preview' ), $id ); ?>"
			style="<?php echo empty( $value ) ? 'display:none;' : 'display:block;'; ?>">

				<?php
				$this->render_media_uploader_thumbnail( '', 'template', $args ); 

				if ( ! empty( $value ) ) {

					if ( is_array( $value ) ) {

						foreach ( $value as $attachment_id ) {

							$this->render_media_uploader_thumbnail( absint( $attachment_id ), 'clone', $args );

						}

					} else {

						$this->render_media_uploader_thumbnail( absint( $value ), 'clone', $args );
					}

				} ?>

			</div>

			<div class="clear"></div>

			<p>

				<button 
				id="<?php printf( esc_attr( '%1$s_button_set' ), $id ); ?>"
				type="button"
				class="button"
				style="<?php echo ! empty( $value ) ? 'display:none;' : 'display:inline-block;'; ?>"
				<?php disabled( true, ! empty( $value) ); ?>><?php 

						echo esc_html( $this->get_media_uploader_label( __( 'Upload %1$s', 'WP_CPT' ), $field ) ); 

				?></button>

				<?php if ( $args['multiple'] ) { ?>

					<button 
					id="<?php printf( esc_attr( '%1$s_button_add' ), $id ); ?>"
					type="button"
					class="button"
					style="<?php echo empty( $value ) ? 'display:none;' : 'display:inline-block;'; ?>"
					<?php disabled( true, empty( $value ) ); ?>><?php 

							echo esc_html( $this->get_media_uploader_label( __( 'Add to %1$s', 'WP_CPT' ), $field ) ); 

					?></button>

				<?php } ?>

				<button 
				id="<?php printf( esc_attr( '%1$s_button_remove' ), $id ); ?>"
				type="button" 
				class="button"
				style="<?php echo empty( $value ) ? 'display:none;' : 'display:inline-block;'; ?>"
				<?php disabled( true, empty( $value ) ); ?>><?php 

						echo esc_html( $this->get_media_uploader_label( __( 'Remove %1$s', 'WP_CPT' ), $field ) ); 

				?></button>

			</p>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 

				?></p>

			<?php } ?>

			<input 
			type="hidden" 
			id="<?php echo esc_attr( $id ); ?>" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			value="<?php echo is_array( $value ) ? esc_attr( implode( ',', $value ) ) : esc_attr( $value ); ?>"
			aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" />

		</fieldset>

	<?php } 

	/**
	 * Inline Media Uploader Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_media_uploader_script() {

		if ( ! $this->is_screen( 'id', $this->slug ) || empty( $this->get_field_by( 'type', 'media' ) ) ) {
			return;
		} ?>

		<script type="text/javascript">

			(function($) {

				function init(uploader = null) {
					
					if (! uploader) { 
						return; 
					}
						
					const fieldId = uploader.getAttribute('data-media-uploader-id');
					const input = uploader.querySelector('#' + fieldId);
					const legend = uploader.querySelector('#' + fieldId + '_legend');
					const setButton = uploader.querySelector('#' + fieldId + '_button_set');
					const addButton = uploader.querySelector('#' + fieldId + '_button_add');
					const removeButton = uploader.querySelector('#' + fieldId + '_button_remove');
					const preview = uploader.querySelector('#' + fieldId + '_preview');
					const previewTemplate = uploader.querySelector('[data-media-uploader-template]');
					const initialClones = uploader.querySelectorAll('[data-media-uploader-clone]');
					const title = uploader.getAttribute('data-media-uploader-title');
					const buttonText = uploader.getAttribute('data-media-uploader-button');
					const type = uploader.getAttribute('data-media-uploader-type');
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					
					const modal = wp.media({
						title: title,
						multiple: isMultiple, 
						library: { type: type || 'image' }, 
						button: { text: buttonText },
						frame: 'select', 
					});

					function handleOpen(e = null) {
						modal.open();
					}
					function handleRemove(e = null) {
						e.preventDefault();
						removeClones();
						resetField();
					}
					function handleSelect() {
						const selection = modal.state().get('selection').toJSON();
						if (selection && (selection.length > 0)) {
							var saveIds = (input.value && isMultiple) ? input.value.split(',').map(function(id) { return parseInt(id); }) : [];
							if (! isMultiple) {
								removeClones();
							}
							for (var i = 0; i < selection.length; i++) {
								const attachment = selection[i];
								const attachmentId = parseInt(attachment.id, 10);
								saveIds.push(attachmentId);
								preview.appendChild(getClone(attachment));
							}
							setField(saveIds.join(','));
							if (isMultiple) {
								refreshSorting();
							}
						}
					}
					function getClone(attachment = null) {
						const clone = previewTemplate.cloneNode(true);
						const cloneImg = clone.querySelector('img');
						const orientationContainer = clone.querySelector('.attachment-preview');
						const filename = clone.querySelector('.filename > div');

						clone.removeAttribute('data-media-uploader-template');
						clone.setAttribute('data-media-uploader-clone', parseInt(attachment.id, 10));
						cloneImg.setAttribute('src', attachment.mime.includes('image') ? attachment.url : attachment.icon);
						clone.style.display = 'block';

						if (attachment.width > attachment.height) {
							orientationContainer.classList.remove('portrait');
							orientationContainer.classList.add('landscape');
						} else {
							orientationContainer.classList.add('portrait');
							orientationContainer.classList.remove('landscape');
						}
						filename.innerHTML = attachment.filename;
						filename.style.display = (attachment.mime.indexOf('image') === -1) ? 'block' : 'none';

						initClone(clone);

						return clone;
					}
					function removeClones() {
						const clones = getClones();
						if (clones && (clones.length > 0)) {
							for (var i = 0; i < clones.length; i++) {
								preview.removeChild(clones[i]);
							}
						}
					}
					function enableButton(button = null) {
						if (button) {
							button.removeAttribute('disabled', true);
							button.style.display = 'inline-block';
						}
					}
					function disableButton(button = null) {
						if (button) {
							button.setAttribute('disabled', true);
							button.style.display = 'none';
						}
					}
					function setField(value = null) {
						input.value = value;
						preview.style.display = 'block';
						disableButton(setButton);
						enableButton(removeButton);
						if (isMultiple) {
							enableButton(addButton);
						}
					}
					function resetField() {
						input.value = '';
						preview.style.display = 'none';
						enableButton(setButton);
						disableButton(removeButton);
						if (isMultiple) {
							disableButton(addButton);
						}
					}
					function initSorting() {
						$(preview).sortable({
							items: '[data-media-uploader-clone]', 
							stop: handleSortStop,  
						});
					}
					function refreshSorting() {
						$(preview).sortable('refresh');
					}
					function handleSortStop(e = null, ui = null) {
						const clones = getClones();
						const saveIds = [];
						if (clones && (clones.length > 0)) {
							for (var i = 0; i < clones.length; i++) {
								const attachmentId = parseInt(clones[i].getAttribute('data-media-uploader-clone'), 10);
								saveIds.push(attachmentId);
							}
						}
						input.value = saveIds.join(',');
					}
					function handleCloneMouseEnter(e = null) {
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.classList.add('selected');
							e.target.classList.add('details');
						}
					}
					function handleCloneMouseLeave(e = null) {
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.classList.remove('selected');
							e.target.classList.remove('details');
						}
					}
					function handleCloneClick(e = null) {
						e.preventDefault();
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.focus();
						} else {
							getParentClone(e.target).focus();
						}
					}
					function handleCheckClick(e = null) {
						e.preventDefault();
						const clone = getParentClone(e.target);
						const attachmentId = parseInt(clone.getAttribute('data-media-uploader-clone'), 10);
						var values = input.value ? input.value.split(',').map(function(id) { return parseInt(id, 10); }) : [];
						const valuesIndex = values.indexOf(attachmentId);
						if (valuesIndex !== -1) {
							const removed = values.splice(valuesIndex, 1);
						}
						input.value = values.join(',');
						preview.removeChild(clone);
						if (! input.value) {
							resetField();
						}
					}
					function initClone(clone = null) {
						if (clone) {
							const check = clone.querySelector('.check');
							clone.addEventListener('mouseenter', handleCloneMouseEnter);
							clone.addEventListener('mouseleave', handleCloneMouseLeave);
							clone.addEventListener('click', handleCloneClick);
							check.addEventListener('click', handleCheckClick);
						}
					}
					function getClones() {
						return preview.querySelectorAll('[data-media-uploader-clone]');
					}
					function getParentClone(el = null) {
						while ((el = el.parentElement) && ! el.getAttribute('data-media-uploader-clone'));
						return el;
					}

					modal.on('select', handleSelect);

					legend.addEventListener('click', handleOpen);
					setButton.addEventListener('click', handleOpen);
					removeButton.addEventListener('click', handleRemove);
					if (initialClones && (initialClones.length > 0)) {
						for (var i = 0; i < initialClones.length; i++) {
							initClone(initialClones[i]);
						}
					}
					if (isMultiple) {
						addButton.addEventListener('click', handleOpen);
						initSorting();
					}
				}

				function initAll() {
					const uploaders = document.querySelectorAll('[data-media-uploader-id]');
					if (uploaders && (uploaders.length > 0)) {
						for (var i = 0; i < uploaders.length; i++) {
							init(uploaders[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Datepicker Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_datepicker_script() {

		if ( ! $this->is_screen( 'id', $this->slug ) || empty( $this->get_field_by( 'type', 'date' ) ) ) {
			return;
		} ?>

		<script type="text/javascript">

			(function($) {

				function init(datepicker = null) {
					if (datepicker) { 
						const fieldId = datepicker.getAttribute('data-datepicker-id');
						const format = datepicker.getAttribute('data-datepicker-format');
						const input = datepicker.querySelector('#' + fieldId);

						$(input).datepicker({
							dateFormat: format || 'yy-mm-dd', 
						});
					}
				}

				function initAll() {
					const datepickers = document.querySelectorAll('[data-datepicker-id]');
					if (datepickers && (datepickers.length > 0)) {
						for (var i = 0; i < datepickers.length; i++) {
							init(datepickers[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Colorpicker Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_colorpicker_script() {

		if ( ! $this->is_screen( 'id', $this->slug ) || empty( $this->get_field_by( 'type', 'color' ) ) ) {
			return;
		} ?>

		<script type="text/javascript">

			(function($) {

				function init(colorpicker = null) {
					if (colorpicker) { 
						const fieldId = colorpicker.getAttribute('data-colorpicker-id');
						const input = colorpicker.querySelector('#' + fieldId);
						var palettes = colorpicker.getAttribute('data-colorpicker-palettes');

						if ((palettes === 'true') || (palettes === 'false')) {
							palettes = (palettes === 'true');
						} else {
							palettes = palettes.split(',');
						}

						$(input).wpColorPicker({
							defaultColor: false, // bool
							hide: true, // bool
							palettes: palettes // bool, []
						});
					}
				}

				function initAll() {
					const colorpickers = document.querySelectorAll('[data-colorpicker-id]');
					if (colorpickers && (colorpickers.length > 0)) {
						for (var i = 0; i < colorpickers.length; i++) {
							init(colorpickers[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

}