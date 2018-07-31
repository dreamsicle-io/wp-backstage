<?php

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
	 * Arg Types
	 * 
	 * @since 0.0.1
	 */
	public $arg_types = array(
		'menu_name'       => 'string', 
		'singular_name'   => 'string', 
		'plural_name'     => 'string', 
		'thumbnail_label' => 'string', 
		'description'     => 'string', 
		'public'          => 'boolean', 
		'hierarchical'    => 'boolean', 
		'with_front'      => 'boolean', 
		'rest_base'       => 'string', 
		'menu_icon'       => 'string', 
		'capability_type' => array( 'post', 'page' ), 
		'taxonomies'      => array(), 
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
		'taxonomies'      => array(), 
	);

	/**
	 * Errors
	 * 
	 * @since 0.0.1
	 */
	public $errors = array();

	/**
	 * Add
	 * 
	 * @since 0.0.1
	 */
	public static function add( $slug = '', $args = array() ) {

		$CPT = new WP_CPT( $slug, $args );

		if ( ! empty( $CPT->errors ) ) {

			foreach ( $CPT->errors as $error ) {

				if ( is_wp_error( $error ) ) {
					echo $error;
				}

			}

			return;

		}

		$CPT->init();

	}

	/**
	 * Construct
	 * 
	 * @since 0.0.1
	 */
	function __construct( $slug = '', $args = array() ) {

		$this->slug = sanitize_title_with_dashes( $slug );
		
		$this->args = wp_parse_args( $args, $this->default_args );

		$this->set_errors();

	}

	/**
	 * Init
	 * 
	 * @since 0.0.1
	 */
	public function init() {

		add_action( 'init', array( $this, 'register' ), 10 );

	}

	/**
	 * Set Errors
	 * 
	 * @since 0.0.1
	 */
	public function set_errors() {

		if ( empty( $this->slug ) ) {

			$this->errors[] = new WP_Error( 'slug', esc_html__( 'A post type slug is required when adding a new post type.', 'WP_CPT' ) );
		
		}

		foreach ( $this->args as $key => $value ) {
			
			if ( ! empty( $this->arg_types[$key] ) ) {
				
				$arg_type = $this->arg_types[$key];
				
				if ( is_array( $arg_type ) ) {
					
					if ( ! in_array( $value, $arg_type ) ) {
						
						$this->errors[] = new WP_Error( 'arg', sprintf(
							esc_html__( 'The value "%1$s" for key "%2$s" is not one of [%3$s].', 'WP_CPT' ), 
							$value, 
							$key, 
							implode( ', ', $arg_type )
						) );

					}

				} else {

					$has_error = false;

					switch ( $arg_type ) {
						case 'string':
							$has_error = ! is_string( $value );
							break;
						case 'boolean':
							$has_error = ! is_bool( $value );
							break;
						case 'integer':
							$has_error = ! is_int( $value );
							break;
						case 'float':
							$has_error = ( ! is_float( $value ) && ! is_int( $value ) );
							break;
						case 'object':
							$has_error = ! is_object( $value );
							break;
						case 'array':
							$has_error = ! is_array( $value );
							break;
					}

					if ( $has_error ) {

						$this->errors[] = new WP_Error( 'arg', sprintf(
							esc_html__( 'The value "%1$s" for key "%2$s" is not of type "%3$s".', 'WP_CPT' ), 
							$value, 
							$key, 
							$arg_type
						) );

					}

				}

			}

		}

	}

	/**
	 * Get Label
	 * 
	 * @since 0.0.1
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
	 * @since 0.0.1
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
			'slug'       => $this->slug,
			'with_front' => $this->args['with_front'],
			'pages'      => $this->args['public'],
			'feeds'      => $this->args['public'],
		);

		$support = array( 
			'title', 
			'editor', 
			'thumbnail', 
			'comments', 
			'trackbacks', 
			'revisions', 
			'custom-fields', 
			'page-attributes', 
			'post-formats' 
		);

		$args = array(
			'label'               => ! empty( $this->args['menu_name'] ) ? $this->args['menu_name'] : $this->args['plural_name'],
			'description'         => $this->args['description'], 
			'labels'              => $labels,
			'supports'            => $support,
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
			'rewrite'             => $rewrite,
			'capability_type'     => $this->args['capability_type'],
			'show_in_rest'        => ( $this->args['public'] && ! empty( $this->args['rest_base'] ) ),
			'rest_base'           => $this->args['rest_base'],
		);

		register_post_type( $this->slug, $args );

	}

}