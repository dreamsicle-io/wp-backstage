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
	 * @since   0.0.1
	 * @param   string  $slug 
	 * @param   array   $args 
	 * @return  void 
	 */
	function __construct( $slug = '', $args = array() ) {

		$this->slug = sanitize_title_with_dashes( $slug );
		
		$this->args = wp_parse_args( $args, array(
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
			'meta_boxes'      => array(), 
		) );

		$this->set_errors();

	}

	/**
	 * Init
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function init() {

		add_action( 'init', array( $this, 'register' ), 10 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );

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

	/**
	 * Add Meta Boxes
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function add_meta_boxes() {

		if ( is_array( $this->args['meta_boxes'] ) && ! empty( $this->args['meta_boxes'] ) ) {

			foreach ( $this->args['meta_boxes'] as $meta_box ) {

				$meta_box = wp_parse_args( $meta_box, array( 
					'id'       => '', 
					'title'    => '', 
					'context'  => '', 
					'priority' => '', 
					'fields'   => array(), 
				) );

				add_meta_box( 
					$meta_box['id'], 
					$meta_box['title'], 
					array( $this, 'render_meta_box' ), 
					$this->slug, 
					$meta_box['context'], 
					$meta_box['priority'], 
					array( 
						'fields' => $meta_box['fields'],  
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
			'id'       => '', 
			'title'    => '', 
			'args'     => array(
				'fields' => array(), 
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

	}

	/**
	 * Render Input
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_input( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, array(
			'type'        => 'text', 
			'name'        => '', 
			'label'       => '', 
			'description' => '', 
			'input_attrs' => array(),
		) );

		$id = sanitize_title_with_dashes( $field['name'] );
		$value = get_post_meta( $post->ID, $field['name'], true );
		$formatted_attrs = array();

		if ( is_array( $field['input_attrs'] ) && ! empty( $field['input_attrs'] ) ) {
			foreach ( $field['input_attrs'] as $attr_key => $attr_value ) {
				$formatted_attrs[] = sprintf( '%1$s="%2$s"', esc_attr( $attr_key ), esc_attr( $attr_value ) );
			}
		} ?>

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
				<?php echo implode( ' ', $formatted_attrs ); ?>>
			
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

	public static function format_attrs( $attrs = array() ) {

		$formatted_attrs = array();

		if ( is_array( $attrs ) && ! empty( $attrs ) ) {
			foreach ( $attrs as $key => $value ) {
				$formatted_attrs[] = sprintf( '%1$s="%2$s"', esc_attr( $key ), esc_attr( $value ) );
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
	public function render_textarea( $field = array(), $post = null ) {

		$field = wp_parse_args( $field, array(
			'name'        => '', 
			'label'       => '', 
			'description' => '', 
			'input_attrs' => array(),
		) );

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

}