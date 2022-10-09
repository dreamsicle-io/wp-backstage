<?php
/**
 * WP Backstage Post Type
 *
 * @since       0.0.1
 * @package     wp_backstage
 * @subpackage  includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

/**
 * WP Backstage Post Type
 *
 * @since       0.0.1
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Post_Type extends WP_Backstage_Component {

	/**
	 * Hidden Meta Boxes
	 * 
	 * @since  0.0.1
	 * @var    array  $hidden_meta_boxes  An array of hidden meta box IDs.
	 */
	protected $hidden_meta_boxes = array( 
		'trackbacksdiv', 
		'slugdiv', 
		'authordiv', 
		'commentstatusdiv', 
		'postcustom', 
	);

	/**
	 * Default Args
	 * 
	 * @since  0.0.1
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'menu_name'       => '', 
		'singular_name'   => '', 
		'plural_name'     => '', 
		'thumbnail_label' => '', 
		'description'     => '', 
		'public'          => true, 
		'hierarchical'    => false, 
		'with_front'      => false, 
		'singular_base'   => '', 
		'archive_base'    => '', 
		'rest_base'       => '', 
		'menu_icon'       => 'dashicons-admin-post', 
		'glance_item'     => true, 
		'activity'        => true, 
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
	 * Required Args - Add
	 * 
	 * @since  0.0.1
	 * @var    array  $required_args  The required argument keys for this instance if adding.
	 */
	protected $required_args = array(
		'singular_name', 
		'plural_name', 
	);

	/**
	 * Required Args - Modify
	 * 
	 * @since 2.0.0
	 * @var   array  $required_args  The required argument keys for this instance if modifying.
	 */
	protected $required_args_modify = array();

	/**
	 * Default Meta Box Args
	 * 
	 * @since  0.0.1
	 * @var    array  $default_meta_box_args  The default meta box arguments for this instance.
	 */
	protected $default_meta_box_args = array( 
		'id'          => '', 
		'title'       => '', 
		'description' => '', 
		'context'     => '', 
		'priority'    => '', 
		'hidden'      => '', 
		'fields'      => array(), 
	);

	/**
	 * Add
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_post/ WP_Post
	 * 
	 * @since   0.0.1
	 * @param   string                 $slug  The slug for the post type.
	 * @param   array                  $args  The arguments for this instance.
	 * @return  WP_Backstage_Post_Type  A fully constructed instance of `WP_Backstage_Post_Type`. 
	 */
	public static function add( $slug = '', $args = array() ) {

		$Post_Type = new WP_Backstage_Post_Type( $slug, $args );
		$Post_Type->init();
		return $Post_Type;

	}

	/**
	 * Modify
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_post/ WP_Post
	 * 
	 * @since   2.0.0
	 * @param   string                  $slug  The slug for the post type.
	 * @param   array                   $args  The arguments for this instance.
	 * @return  WP_Backstage_Post_Type  A fully constructed instance of `WP_Backstage_Post_Type`. 
	 */
	public static function modify( $slug = '', $args = array() ) {

		$Post_Type = new WP_Backstage_Post_Type( $slug, $args, false );
		$Post_Type->init();
		return $Post_Type;

	}

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @since   2.0.0   Adds $new parameter for distinguishing between `add` and `modify` behavior.
	 * @param   string  $slug  The developer-provided slug for the post type.
	 * @param   array   $args  The developer-provided arguments for this instance.
	 * @param   bool    $new   Whether this instance constructs a new post type or modifies an existing one.
	 * @return  void 
	 */
	public function __construct( $slug = '', $args = array(), $new = true ) {

		$this->default_field_args = array_merge( $this->default_field_args, array(
			'has_column'  => false, 
			'is_sortable' => false, 
		) );
		$this->new = boolval($new);
		$this->slug = sanitize_key( $slug );
		$this->set_args( $args );
		$this->screen_id = array( $this->slug, sprintf( 'edit-%1$s', $this->slug ) );
		$this->nonce_key = sprintf( '_wp_backstage_post_type_%1$s_nonce', $this->slug );
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 * 
	 * @since   0.0.1
	 * @param   array  $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {

		if ( current_theme_supports( 'post-formats' ) ) {

			$this->default_args['supports'][] = 'post-formats';
			
		}

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['thumbnail_label'] ) ) {

			$this->args['thumbnail_label'] = __( 'Featured Image', 'wp-backstage' );

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
	 * @param   bool  $new  Whether the errors should be set for a new post type or an existing one.
	 * @return  void 
	 */
	protected function set_errors() {

		if ( empty( $this->slug ) ) {
			
			$this->errors[] = new WP_Error( 'required_post_type_slug', sprintf( 
				/* translators: 1: post type slug. */
				__( '[post type: %1$s] A slug is required when adding a new post type.', 'wp-backstage' ), 
				$this->slug
			) );
		
		} elseif ( strlen( $this->slug ) > 20 ) {
			
			$this->errors[] = new WP_Error( 'post_type_slug_length', sprintf( 
				/* translators: 1: post type slug. */
				__( '[post type: %1$s] A post type slug must be between 1 and 20 characters.', 'wp-backstage' ), 
				$this->slug
			) );
		
		} elseif ( $this->new && in_array( $this->slug, get_post_types() ) ) {

			$this->errors[] = new WP_Error( 'post_type_exists', sprintf( 
				/* translators: 1: post type slug, 2: method suggestion */
				__( '[post type: %1$s] A post type with this slug already exists. Use the %2$s method to modify an existing post type.', 'wp-backstage' ), 
				$this->slug,
				'<code>WP_Backstage_Post_type::modify()</code>'
			) );

		} elseif ( ! $this->new && ! in_array( $this->slug, get_post_types() ) ) {

			$this->errors[] = new WP_Error( 'post_type_not_exists', sprintf( 
				/* translators: 1: post type slug, 2: method suggestion */
				__( '[post type: %1$s] A post type with this slug does not exist. Use the %2$s method to create a new post type.', 'wp-backstage' ), 
				$this->slug,
				'<code>WP_Backstage_Post_type::add()</code>'
			) );

		}

		$required_args = ! $this->new ? $this->required_args_modify : $this->required_args;

		if ( is_array( $required_args ) && ! empty( $required_args ) ) {

			foreach ( $required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_post_type_arg', sprintf( 
						/* translators: 1: post type slug, 2:required arg key. */
						__( '[post type: %1$s] The %2$s key is required.', 'wp-backstage' ), 
						$this->slug,
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

		global $wp_backstage;

		if ( $wp_backstage->has_errors() ) {
			return;
		}

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		if ( $this->new ) {
			add_action( 'init', array( $this, 'register' ), 0 );
			add_filter( 'dashboard_glance_items', array( $this, 'manage_dashboard_glance_items' ), 10 );
			add_filter( 'dashboard_recent_posts_query_args', array( $this, 'manage_dashboard_activity_query_args' ), 10 );
			add_filter( 'admin_print_scripts-index.php', array( $this, 'inline_dashboard_glance_item_style' ), 10 );
			add_filter( 'the_title', array( $this, 'manage_post_title' ), 10, 2 );
		}
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		if ( $this->slug === 'attachment' ) {
			add_action( 'edit_attachment', array( $this, 'save' ), 10 );
		} else {
			add_action( sprintf( 'save_post_%1$s', $this->slug ), array( $this, 'save' ), 10, 3 );
		}
		add_filter( 'default_hidden_meta_boxes', array( $this, 'manage_default_hidden_meta_boxes' ), 10, 2 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_filter( 'edit_form_top', array( $this, 'render_edit_nonce' ), 10 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'add_thumbnail_column' ), 10 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'add_field_columns' ), 10 );
		add_action( sprintf( 'manage_%1$s_posts_custom_column', $this->slug ), array( $this, 'render_admin_column' ), 10, 2 );
		add_filter( sprintf( 'manage_edit-%1$s_sortable_columns', $this->slug ), array( $this, 'manage_sortable_columns' ), 10 );
		add_action( 'pre_get_posts', array( $this, 'manage_sorting' ), 10 );

		parent::init();

	}

	/**
	 * Manage Post Title
	 * 
	 * @since   0.0.1
	 * @param   string  $title  The post title.
	 * @param   int     $id     The post ID.
	 * @return  string  The filtered post title.
	 */
	public function manage_post_title( $title = '', $id = null ) {
		if ( is_admin() && ! is_customize_preview() ) {
			// prepend the post type to the post title on the dashboard. This is 
			// useful for the activity dashboard widget.
			if ( $this->is_screen( 'id', 'dashboard' ) && $this->args['activity'] ) {
				$post_type = get_post_type( $id );
				if ( $post_type === $this->slug ) {
					$post_type_obj = get_post_type_object( $post_type );
					$title = esc_html( sprintf( 
						/* translators: 1: post type, 2: post title. */
						_x( '%1$s: %2$s', 'dashboard activity post link title', 'wp_backstage' ), 
						$post_type_obj->labels->singular_name, 
						$title 
					) );
				}
			}
		}
		return $title;
	}

	/**
	 * Get Label
	 *
	 * A utility method to get a localized label for the various post type 
	 * labels needed when registering a post type.
	 * 
	 * @param  string  $template  A localized `sprintf()` template where `%1$s` is the post type 
	 *                            singular name, `%2$s` is the post type plural name, and `%3$s` is 
	 *                            the thumbnail label.
	 * @param  array   $field     An array of field arguments.
	 * @return string  The formatted text.
	 */
	protected function get_label( $template = '' ) {

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
	 * This method does the actual registration of the post type. It will set 
	 * everything needed to extend WordPress to allow for the new post type such 
	 * as adding all the labels, setting the rewrite rules and REST API base, 
	 * and configures the WP admin UI. `%1$s` refers to the singular label, 
	 * while `%2$s` refers to the plural label. `%3$s` refers to the thumbnail label.
	 *
	 * @link   https://developer.wordpress.org/reference/functions/register_post_type/ register_post_type()
	 * @link   https://developer.wordpress.org/reference/classes/wp_post_type/ WP_Post_Type
	 * 
	 * @since  0.0.1
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'                     => $this->args['plural_name'],
			'singular_name'            => $this->args['singular_name'],
			'menu_name'                => ! empty( $this->args['menu_name'] ) ? $this->args['menu_name'] : $this->args['plural_name'],
			'name_admin_bar'           => $this->args['singular_name'],
			'archives'                 => $this->get_label( __( '%1$s Archives', 'wp-backstage' ) ),
			'attributes'               => $this->get_label( __( '%1$s Attributes', 'wp-backstage' ) ),
			'parent_item_colon'        => $this->get_label( __( 'Parent %1$s:', 'wp-backstage' ) ),
			'all_items'                => $this->get_label( __( 'All %2$s', 'wp-backstage' ) ),
			'add_new_item'             => $this->get_label( __( 'Add New %1$s', 'wp-backstage' ) ),
			'add_new'                  => $this->get_label( __( 'Add New', 'wp-backstage' ) ),
			'new_item'                 => $this->get_label( __( 'New %1$s', 'wp-backstage' ) ),
			'edit_item'                => $this->get_label( __( 'Edit %1$s', 'wp-backstage' ) ),
			'update_item'              => $this->get_label( __( 'Update %1$s', 'wp-backstage' ) ),
			'view_item'                => $this->get_label( __( 'View %1$s', 'wp-backstage' ) ),
			'view_items'               => $this->get_label( __( 'View %2$s', 'wp-backstage' ) ),
			'search_items'             => $this->get_label( __( 'Search %2$s', 'wp-backstage' ) ),
			'not_found'                => $this->get_label( __( 'No %2$s found', 'wp-backstage' ) ),
			'not_found_in_trash'       => $this->get_label( __( 'No %2$s found in trash', 'wp-backstage' ) ),
			'featured_image'           => $this->args['thumbnail_label'],
			'set_featured_image'       => $this->get_label( __( 'Set %3$s', 'wp-backstage' ) ),
			'remove_featured_image'    => $this->get_label( __( 'Remove %3$s', 'wp-backstage' ) ),
			'use_featured_image'       => $this->get_label( __( 'Use as %3$s', 'wp-backstage' ) ),
			'insert_into_item'         => $this->get_label( __( 'Insert into %1$s', 'wp-backstage' ) ),
			'uploaded_to_this_item'    => $this->get_label( __( 'Uploaded to this %1$s', 'wp-backstage' ) ),
			'items_list'               => $this->get_label( __( '%2$s list', 'wp-backstage' ) ),
			'items_list_navigation'    => $this->get_label( __( '%2$s list navigation', 'wp-backstage' ) ),
			'filter_items_list'        => $this->get_label( __( 'Filter %2$s list', 'wp-backstage' ) ),
			'item_published'           => $this->get_label( __( '%1$s published.', 'wp-backstage' ) ), 
			'item_published_privately' => $this->get_label( __( '%1$s published privately.', 'wp-backstage' ) ), 
			'item_reverted_to_draft'   => $this->get_label( __( '%1$s reverted to draft.', 'wp-backstage' ) ), 
			'item_scheduled'           => $this->get_label( __( '%1$s scheduled.', 'wp-backstage' ) ), 
			'item_updated'             => $this->get_label( __( '%1$s updated.', 'wp-backstage' ) ), 
			'item_link'                => $this->get_label( __( '%1$s Link', 'wp-backstage' ) ), 
			'item_link_description'    => $this->get_label( __( 'A link to a %1$s', 'wp-backstage' ) ), 
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
			'menu_position'       => 4,
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
			'taxonomies'          => $this->args['taxonomies'], 
		);

		register_post_type( $this->slug, $args );

	}

	/**
	 * Get Meta Boxes
	 * 
	 * @since   0.0.1
	 * @return  array  An array of meta box argument arrays.  
	 */
	protected function get_meta_boxes() {

		$meta_boxes = array();

		if ( is_array( $this->args['meta_boxes'] ) && ! empty( $this->args['meta_boxes'] ) ) {
			
			foreach ( $this->args['meta_boxes'] as $meta_box ) {
			
				$meta_boxes[] = wp_parse_args( $meta_box, $this->default_meta_box_args );
			
			}
		
		}

		return $meta_boxes;

	}

	/**
	 * Get Fields
	 * 
	 * @since   0.0.1
	 * @return  array  an array of field arg arrays. 
	 */
	protected function get_fields() {

		$meta_boxes = $this->get_meta_boxes();
		$fields = array();

		if ( is_array( $meta_boxes ) && ! empty( $meta_boxes ) ) {
			
			foreach ( $meta_boxes as $meta_box ) {
			
				if ( is_array( $meta_box['fields'] ) && ! empty( $meta_box['fields'] ) ) {

					foreach ( $meta_box['fields'] as $field ) {

						$fields[] = wp_parse_args( $field, $this->default_field_args );

					}

				}
			
			}
		
		}

		return $fields;

	}

	/**
	 * Save
	 *
	 * Saves the form data as individual keys.
	 * 
	 * Note that on attachments, the `edit_attachment` hook only sends 
	 * the first parameter ($post_id).
	 *
	 * @since   0.0.1
	 * @param   int      $post_id  The ID of the post being saved.
	 * @param   WP_Post  $post     The full `WP_Post` object for the post being saved.
	 * @param   bool     $update   Whether the post is being updated or not.
	 * @return  void 
	 */
	public function save( $post_id = 0, $post = null, $update = false ) {
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }
		if ( defined('DOING_AJAX') && DOING_AJAX ) { return; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( empty( $_POST[$this->nonce_key] ) ) { return; }
		if ( ! wp_verify_nonce( $_POST[$this->nonce_key], 'edit' ) ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				if ( isset( $_POST[$field['name']] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']] );

					update_post_meta( $post_id, $field['name'], $value );

					if ( $field['type'] === 'media' ) {

						$this->handle_attachments( $post_id, $value, $field );

					}

				} else {

					delete_post_meta( $post_id, $field['name'] );

				}

			}

		}

	}

	/**
	 * Handle Attachments
	 *
	 * Attaches all media used in media uploader fields to the post being saved. 
	 * 
	 * @param   int        $post_id  The ID of the post being saved.
	 * @param   int|array  $value    The attachment ID or array of attachment IDs to attach.
	 * @param   array      $field    An array of field arguments.
	 * @return  void
	 */
	protected function handle_attachments( $post_id = null, $value = null, $field = array() ) {

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
	 * @param   array      $hidden  An array of already-set hidden meta box IDs.
	 * @param   WP_Screen  $screen  An instance of `WP_Screen`.
	 * @return  array      An array of meta box ids
	 */
	public function manage_default_hidden_meta_boxes( $hidden = array(), $screen = null ) {

		if ( $screen->post_type === $this->slug ) {

			$meta_boxes = $this->get_meta_boxes();

			$hidden = array_merge( $hidden, $this->hidden_meta_boxes );

			if ( is_array( $meta_boxes ) && ! empty( $meta_boxes ) ) {

				foreach ( $meta_boxes as $meta_box ) {

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
	 * @param   array  $columns  An array of already-set columns.
	 * @return  array  The filtered columns.
	 */
	public function add_thumbnail_column( $columns = array() ) {

		if ( post_type_supports( $this->slug, 'thumbnail' ) && is_array( $columns ) ) {

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
	 * Render Thumbnail
	 * 
	 * @since   0.0.1
	 * @param   int    $post_id  The post ID of the post to render the thumbnail for.
	 * @return  void
	 */
	protected function render_thumbnail( $post_id = null ) {

		if ( post_type_supports( $this->slug, 'thumbnail' ) ) { ?>
		
			<a 
			title="<?php the_title_attribute( array( '', '', true, $post_id ) ); ?>"
			href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>" 
			style="display:block;width:40px;height:40px;overflow:hidden;background-color:#e7e7e7;"><?php 

				if ( has_post_thumbnail( $post_id ) ) {

					echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'style' => 'width:40px;height:auto;' ) );

				}

			?></a>

		<?php }

	}

	/**
	 * Render Admin Column
	 * 
	 * @since   0.0.1
	 * @param   string  $column   The column name.
	 * @param   int     $post_id  The post ID for this row.
	 * @return  void
	 */
	public function render_admin_column( $column = '', $post_id = null ) {

		if ( $column === 'thumbnail' ) {

			$this->render_thumbnail( $post_id );

		} else {

			$field = $this->get_field_by( 'name', $column );

			if ( ! empty( $field ) ) {

				$value = get_post_meta( $post_id, $column, true );

				// short circuit the column content and allow developer to add their own.
				$content = apply_filters( $this->format_column_content_filter( $column ), '', $field, $value, $post_id );
				if ( ! empty( $content ) ) {
					echo $content;
					return;
				}

				$formatted_value = $this->format_field_value( $value, $field );

				if ( ! empty( $formatted_value ) ) {

					echo $formatted_value;

				} else {

					echo '&horbar;';

				}

			}

		}

	}

	/**
	 * Manage Sorting
	 * 
	 * @since   0.0.1
	 * @param   WP_Query  $query  An instance of `WP_Query`.
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

		$meta_boxes = $this->get_meta_boxes();

		if ( is_array( $meta_boxes ) && ! empty( $meta_boxes ) ) {

			foreach ( $meta_boxes as $meta_box ) {

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
	 * @param   WP_Post  $post      An instance of `WP_Post`.
	 * @param   array    $meta_box  An array of WP meta box args passed from the `add_meta_box()` function.
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

				$field['value'] = get_post_meta( $post->ID, $field['name'], true );
				$input_class = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

				if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows = ( $field['type'] === 'editor' ) ? 15 : 5;
					$field['input_attrs']['class'] = ( $field['type'] === 'editor' ) ? $input_class : sprintf( 'large-text %1$s', $input_class );
					$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : 90;
					$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
				}
				
				$field = apply_filters( $this->format_field_action( 'args' ), $field, $post );

				do_action( $this->format_field_action( 'before' ), $field, $post );

				$this->render_field_by_type( $field );

				do_action( $this->format_field_action( 'after' ), $field, $post );

			}

		}

		if ( ! empty( $meta_box['args']['description'] ) ) { ?>

			<div style="margin: 12px -12px -12px; padding: 12px; background: #f6f7f7; border-top: 1px solid #dcdcde;">

				<p style="margin: 0;"><?php 
					echo wp_kses( $meta_box['args']['description'], WP_Backstage::$kses_p );
				?></p>

			</div>

		<?php }

	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Note that this will only work if this post type's columns 
	 * UI has never been modified by the user.
	 * 
	 * @since   0.0.1
	 * @since   2.5.0      Only add the field to hidden columns array if the field is set to have a column.
	 * @param   array      $hidden  An array of already-set hidden column names.
	 * @param   WP_Screen  $screen  An instance of `WP_Screen`.
	 * @return  array      An array of column names 
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $this->is_screen( 'post_type', $this->slug ) ) {

			$fields = $this->get_fields();

			if ( is_array( $fields ) && ! empty( $fields ) ) {

				foreach ( $fields as $field ) {

					if ( $field['has_column'] ) {
						$hidden[] = $field['name'];
					}

				}

			}

		}

		return $hidden;

	}

	/**
	 * Manage Dashboard Glance Items
	 *
	 * Note that the output will be wrapped in `<li>` tags.
	 *
	 * @since   0.0.1
	 * @param   array  $items  The array of alread-set glance items.
	 * @return  array  The filtered glance items array.
	 */
	public function manage_dashboard_glance_items( $items = array() ) {
		
		if ( $this->args['glance_item'] ) {

			$counts = wp_count_posts( $this->slug );

			if ( $counts ) {

				$published = intval( $counts->publish );
				$post_type_obj = get_post_type_object( $this->slug );
				$label_template = _nx( 
					'%s ' . $post_type_obj->labels->singular_name, // singular
					'%s ' . $post_type_obj->labels->name, // plural
					$published, // number to compare
					'dashboard glance item label', // context
					'photo-walk' // textdomain
				);
				$label = sprintf( $label_template, number_format_i18n( $published ) );
				$url = add_query_arg( array( 'post_type' => $this->slug ), admin_url( '/edit.php' ) );
				$class = sprintf( '%1$s-count', $this->slug );
				$icon = '<i class="' . sprintf( 'dashicons %1$s', $post_type_obj->menu_icon ) . '"></i>';

				$items[] = '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . $icon . '<span>' . esc_html( $label ) . '</span></a>';

			}

		}

		return $items; 
	}

	/**
	 * Manage Dashboard Activity Query Args
	 *
	 * @since   0.0.1
	 * @param   array  $args  The array of already-set query arguments.
	 * @return  array  The filtered array of query arguments.
	 */
	public function manage_dashboard_activity_query_args( $args = array() ) {
		
		if ( $this->args['activity'] ) {

			if ( ! isset( $args['post_type'] ) || empty( $args['post_type'] ) ) {

				$args['post_type'] = array( $this->slug );

			} elseif ( is_array( $args['post_type'] ) ) {

				if ( ! in_array( $this->slug, $args['post_type'] ) ) {
					$args['post_type'][] = $this->slug;
				}

			} elseif ( is_string( $args['post_type'] ) ) {

				$args['post_type'] = array( $args['post_type'] );
				if ( ! in_array( $this->slug, $args['post_type'] ) ) {
					$args['post_type'][] = $this->slug;
				}

			}

		}

		return $args; 
	}

	/**
	 * Inline Dashboard Glance Item Style
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function inline_dashboard_glance_item_style() { ?>
		
		<style 
		id="<?php printf( 'wp_backstage_%1$s_dashboard_glance_item_style', $this->slug ); ?>"
		type="text/css"><?php 

			printf( '#dashboard_right_now ul li > .%1$s-count::before { content: unset; }', $this->slug ); 
			printf( '#dashboard_right_now ul li > .%1$s-count > .dashicons { color: #82878c; speak: none; padding: 0 5px 0 0; position: relative; }', $this->slug ); 

		?></style>

	<?php }

}
