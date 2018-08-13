<?php
/**
 * WP Backstage Post Type
 * 
 * @version     0.0.1
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Post_Type extends WP_Backstage {

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
	 * Add
	 * 
	 * @since   0.0.1
	 * @param   string  $slug 
	 * @param   array   $args 
	 * @return  void 
	 */
	public static function add( $slug = '', $args = array() ) {

		$Post_Type = new WP_Backstage_Post_Type( $slug, $args );

		$Post_Type->init();

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

		$this->default_field_args = array_merge( $this->default_field_args, array(
			'has_column'  => false, 
			'is_sortable' => false, 
		) );
		$this->slug = sanitize_title_with_dashes( $slug );
		$this->set_args( $args );
		$this->screen_id = $this->slug;
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
	 * @return  void 
	 */
	public function set_errors() {

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
		
		} elseif ( in_array( $this->slug, get_post_types() ) ) {

			$this->errors[] = new WP_Error( 'post_type_exists', sprintf( 
				/* translators: 1: post type slug */
				__( '[post type: %1$s] A post type with this slug already exists.', 'wp-backstage' ), 
				$this->slug
			) );

		}

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

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

		if ( $this->has_errors() ) {
			
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			
			return;

		}

		add_action( 'init', array( $this, 'register_post_type' ), 0 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		add_action( sprintf( 'save_post_%1$s', $this->slug ), array( $this, 'save' ), 10, 3 );
		add_filter( 'default_hidden_meta_boxes', array( $this, 'manage_default_hidden_meta_boxes' ), 10, 2 );
		add_filter( 'edit_form_top', array( $this, 'render_edit_nonces' ), 10 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'add_thumbnail_column' ), 10 );
		add_filter( sprintf( 'manage_%1$s_posts_columns', $this->slug ), array( $this, 'add_field_columns' ), 10 );
		add_action( sprintf( 'manage_%1$s_posts_custom_column', $this->slug ), array( $this, 'render_admin_column' ), 10, 2 );
		add_filter( sprintf( 'manage_edit-%1$s_sortable_columns', $this->slug ), array( $this, 'manage_sortable_columns' ), 10 );
		add_action( 'pre_get_posts', array( $this, 'manage_sorting' ), 10 );

		parent::init();

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
	public function register_post_type() {

		$labels = array(
			'name'                  => $this->args['plural_name'],
			'singular_name'         => $this->args['singular_name'],
			'menu_name'             => ! empty( $this->args['menu_name'] ) ? $this->args['menu_name'] : $this->args['plural_name'],
			'name_admin_bar'        => $this->args['singular_name'],
			'archives'              => $this->get_label( __( '%1$s Archives', 'wp-backstage' ) ),
			'attributes'            => $this->get_label( __( '%1$s Attributes', 'wp-backstage' ) ),
			'parent_item_colon'     => $this->get_label( __( 'Parent %1$s:', 'wp-backstage' ) ),
			'all_items'             => $this->get_label( __( 'All %2$s', 'wp-backstage' ) ),
			'add_new_item'          => $this->get_label( __( 'Add New %1$s', 'wp-backstage' ) ),
			'add_new'               => $this->get_label( __( 'Add New', 'wp-backstage' ) ),
			'new_item'              => $this->get_label( __( 'New %1$s', 'wp-backstage' ) ),
			'edit_item'             => $this->get_label( __( 'Edit %1$s', 'wp-backstage' ) ),
			'update_item'           => $this->get_label( __( 'Update %1$s', 'wp-backstage' ) ),
			'view_item'             => $this->get_label( __( 'View %1$s', 'wp-backstage' ) ),
			'view_items'            => $this->get_label( __( 'View %2$s', 'wp-backstage' ) ),
			'search_items'          => $this->get_label( __( 'Search %2$s', 'wp-backstage' ) ),
			'not_found'             => $this->get_label( __( 'No %2$s found', 'wp-backstage' ) ),
			'not_found_in_trash'    => $this->get_label( __( 'Not %2$s found in Trash', 'wp-backstage' ) ),
			'featured_image'        => $this->args['thumbnail_label'],
			'set_featured_image'    => $this->get_label( __( 'Set %3$s', 'wp-backstage' ) ),
			'remove_featured_image' => $this->get_label( __( 'Remove %3$s', 'wp-backstage' ) ),
			'use_featured_image'    => $this->get_label( __( 'Use as %3$s', 'wp-backstage' ) ),
			'insert_into_item'      => $this->get_label( __( 'Insert into %1$s', 'wp-backstage' ) ),
			'uploaded_to_this_item' => $this->get_label( __( 'Uploaded to this %1$s', 'wp-backstage' ) ),
			'items_list'            => $this->get_label( __( '%2$s list', 'wp-backstage' ) ),
			'items_list_navigation' => $this->get_label( __( '%2$s list navigation', 'wp-backstage' ) ),
			'filter_items_list'     => $this->get_label( __( 'Filter %2$s list', 'wp-backstage' ) ),
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
			'taxonomies'          => $this->args['taxonomies'], 
		);

		register_post_type( $this->slug, $args );

	}

	/**
	 * Get Meta Boxes
	 * 
	 * @since   0.0.1
	 * @return  array  
	 */
	public function get_meta_boxes() {

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
	 * @return  array  
	 */
	public function get_fields() {

		$meta_boxes = $this->get_meta_boxes();
		$fields = array();

		if ( is_array( $meta_boxes ) && ! empty( $meta_boxes ) ) {
			
			foreach ( $meta_boxes as $meta_box ) {
			
				$meta_box_fields = array();

				if ( is_array( $meta_box['fields'] ) && ! empty( $meta_box['fields'] ) ) {

					foreach ( $meta_box['fields'] as $field ) {

						$meta_box_fields[] = wp_parse_args( $field, $this->default_field_args );

					}

					$fields = array_merge( $fields, $meta_box_fields );

				}
			
			}
		
		}

		return $fields;

	}

	/**
	 * Render nonce
	 * 
	 * @since   0.0.1
	 * @return  string 
	 */
	public function render_edit_nonces() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		wp_nonce_field( 'edit', sprintf( '_%1$s_nonce', $this->slug ) );

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

				if ( isset( $_POST[$field['name']] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']] );

					update_post_meta( $post_id, $field['name'], $value );

					$values[$field['name']] = $value;

					if ( $field['type'] === 'media' ) {

						$this->handle_attachments( $post_id, $value, $field );

					}

				} elseif ( in_array( $field['type'], array( 'checkbox', 'checkbox_set', 'radio' ) ) ) {

					$null_val = ( $field['type'] === 'radio' ) ? '' : false;

					update_post_meta( $post_id, $field['name'], $null_val );

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
	 * Get Fields By
	 * 
	 * @since   0.0.1
	 * @return  array  the fields if found, or an empty array.
	 */
	public function get_fields_by( $key = '', $value = null, $number = 0 ) {

		$fields = $this->get_fields();
		$result = array();

		if ( ! empty( $key ) && ( is_array( $fields ) && ! empty( $fields ) ) ) {

			$i = 0;

			foreach ( $fields as $field ) {

				if ( isset( $field[$key] ) && ( $field[$key] === $value ) ) {

					$result[] = $field;

					if ( ( $number > 0 ) && ( $number === ( $i + 1 ) ) ) {
						break;
					}

					$i++;

				}

			}

		}

		return $result;

	}

	/**
	 * Get Field By
	 * 
	 * @since   0.0.1
	 * @return  array  the first field if found, or null.
	 */
	public function get_field_by( $key = '', $value = null ) {

		$fields = $this->get_fields_by( $key, $value, 1 );
		$result = null;

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			$result = $fields[0];

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

				$this->render_field_by_type( $field );

			}

		}

		if ( ! empty( $meta_box['args']['description'] ) ) { ?>

			<p><?php 

				echo wp_kses( $meta_box['args']['description'], $this->kses_p );

			?></p>

		<?php }

	}

}