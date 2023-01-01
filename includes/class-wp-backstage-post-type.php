<?php
/**
 * WP Backstage Post Type
 *
 * @since       0.0.1
 * @since       3.0.0  linted and formatted with phpcs
 * @package     WPBackstage
 * @subpackage  Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Post Type
 *
 * @since       0.0.1
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
	 * @since  3.2.0 Adds support for post formats.
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'menu_name'       => '',
		'singular_name'   => '',
		'plural_name'     => '',
		'thumbnail_label' => '',
		'description'     => '',
		'help'            => '',
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
			'post-formats',
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
		'help'        => '',
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
	 * @param   string $slug  The slug for the post type.
	 * @param   array  $args  The arguments for this instance.
	 * @return  WP_Backstage_Post_Type  A fully constructed instance of `WP_Backstage_Post_Type`.
	 */
	public static function add( $slug = '', $args = array() ) {

		$component = new WP_Backstage_Post_Type( $slug, $args );
		$component->init();
		return $component;

	}

	/**
	 * Modify
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_post/ WP_Post
	 *
	 * @since   2.0.0
	 * @param   string $slug  The slug for the post type.
	 * @param   array  $args  The arguments for this instance.
	 * @return  WP_Backstage_Post_Type  A fully constructed instance of `WP_Backstage_Post_Type`.
	 */
	public static function modify( $slug = '', $args = array() ) {

		$component = new WP_Backstage_Post_Type( $slug, $args, false );
		$component->init();
		return $component;

	}

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 * @since   2.0.0   Adds $new parameter for distinguishing between `add` and `modify` behavior.
	 * @param   string $slug  The developer-provided slug for the post type.
	 * @param   array  $args  The developer-provided arguments for this instance.
	 * @param   bool   $new   Whether this instance constructs a new post type or modifies an existing one.
	 * @return  void
	 */
	public function __construct( $slug = '', $args = array(), $new = true ) {

		$this->default_field_args = array_merge(
			$this->default_field_args,
			array(
				'has_column'    => false,
				'is_sortable'   => false,
				'is_filterable' => false,
			)
		);

		$this->new  = boolval( $new );
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
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['thumbnail_label'] ) ) {

			$this->args['thumbnail_label'] = _x( 'Featured Image', 'post type - default thumbnail label', 'wp_backstage' );

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

		foreach ( $this->args['meta_boxes'] as $i => $field_group ) {
			$this->args['meta_boxes'][ $i ] = wp_parse_args( $field_group, $this->default_meta_box_args );
			foreach ( $this->args['meta_boxes'][ $i ]['fields'] as $ii => $field ) {
				$this->args['meta_boxes'][ $i ]['fields'][ $ii ] = wp_parse_args( $field, $this->default_field_args );
			}
		}

	}

	/**
	 * Set Errors
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	protected function set_errors() {

		if ( empty( $this->slug ) ) {

			$this->errors[] = new WP_Error(
				'required_post_type_slug',
				sprintf(
					/* translators: 1: post type slug. */
					_x( '[Post Type: %1$s] A slug is required when adding a new post type.', 'post type - required slug error', 'wp_backstage' ),
					$this->slug
				)
			);

		} elseif ( strlen( $this->slug ) > 20 ) {

			$this->errors[] = new WP_Error(
				'post_type_slug_length',
				sprintf(
					/* translators: 1: post type slug. */
					_x( '[Post Type: %1$s] A post type slug must be between 1 and 20 characters.', 'post type - slug length error', 'wp_backstage' ),
					$this->slug
				)
			);

		} elseif ( $this->new && in_array( $this->slug, get_post_types() ) ) {

			$this->errors[] = new WP_Error(
				'post_type_exists',
				sprintf(
					/* translators: 1: post type slug, 2: method suggestion */
					_x( '[Post Type: %1$s] A post type with this slug already exists. Use the %2$s method to modify an existing post type.', 'post type - existing slug error', 'wp_backstage' ),
					$this->slug,
					'<code>WP_Backstage_Post_type::modify()</code>'
				)
			);

		} elseif ( ! $this->new && ! in_array( $this->slug, get_post_types() ) ) {

			$this->errors[] = new WP_Error(
				'post_type_not_exists',
				sprintf(
					/* translators: 1: post type slug, 2: method suggestion */
					_x( '[Post Type: %1$s] A post type with this slug does not exist. Use the %2$s method to create a new post type.', 'post type - nonexisting slug error', 'wp_backstage' ),
					$this->slug,
					'<code>WP_Backstage_Post_type::add()</code>'
				)
			);

		}

		$required_args = ! $this->new ? $this->required_args_modify : $this->required_args;

		if ( is_array( $required_args ) && ! empty( $required_args ) ) {

			foreach ( $required_args as $required_arg ) {

				if ( empty( $this->args[ $required_arg ] ) ) {

					$this->errors[] = new WP_Error(
						'required_post_type_arg',
						sprintf(
							/* translators: 1: post type slug, 2: required arg key. */
							_x( '[Post Type: %1$s] The %2$s key is required.', 'post type - required arg error', 'wp_backstage' ),
							$this->slug,
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
	 * @since   3.2.0 Added more specific hooks for attachments.
	 * @since   3.4.0 Hooks nonces to `edit_form_after_title` instead of `edit_form_top` to support the Block Editor.
	 * @since   3.6.0 Removes `sprintf` templates from hook names.
	 * @since   4.0.0 Removes error checking of the `WP_Backstage` class as it no longer reports errors.
	 * @return  void
	 */
	public function init() {

		// These actions are only fired if a new custom post type is being added.
		if ( $this->new ) {
			add_action( 'init', array( $this, 'register' ), 0 );
			add_filter( 'dashboard_glance_items', array( $this, 'manage_dashboard_glance_items' ), 10 );
			add_filter( 'dashboard_recent_posts_query_args', array( $this, 'manage_dashboard_activity_query_args' ), 10 );
			add_filter( 'admin_print_scripts-index.php', array( $this, 'inline_dashboard_glance_item_style' ), 10 );
			add_filter( 'the_title', array( $this, 'manage_post_title' ), 10, 2 );
			add_filter( 'post_updated_messages', array( $this, 'manage_updated_messages' ), 10 );
			add_filter( 'bulk_post_updated_messages', array( $this, 'manage_bulk_updated_messages' ), 10, 2 );
		}
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		// If the post type is an attachment, there are several different hooks and filters
		// to use that don't align with the dynamic hooks of other post types.
		if ( $this->slug === 'attachment' ) {
			add_action( 'edit_attachment', array( $this, 'save' ), 10 );
			add_filter( 'manage_media_columns', array( $this, 'add_field_columns' ), 10 );
			add_action( 'manage_media_custom_column', array( $this, 'render_admin_column' ), 10, 2 );
			add_filter( 'manage_upload_sortable_columns', array( $this, 'manage_sortable_columns' ), 10 );
		} else {
			add_action( "save_post_{$this->slug}", array( $this, 'save' ), 10, 3 );
			add_filter( "manage_{$this->slug}_posts_columns", array( $this, 'add_thumbnail_column' ), 10 );
			add_filter( "manage_{$this->slug}_posts_columns", array( $this, 'add_field_columns' ), 10 );
			add_filter( "manage_edit-{$this->slug}_sortable_columns", array( $this, 'manage_sortable_columns' ), 10 );
			add_action( "manage_{$this->slug}_posts_custom_column", array( $this, 'render_admin_column' ), 10, 2 );
		}
		add_filter( 'default_hidden_meta_boxes', array( $this, 'manage_default_hidden_meta_boxes' ), 10, 2 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_filter( 'edit_form_after_title', array( $this, 'render_edit_nonce' ), 10 );
		add_action( 'query_vars', array( $this, 'manage_query_vars' ), 10 );
		add_action( 'pre_get_posts', array( $this, 'manage_filtering' ), 10 );
		add_action( 'pre_get_posts', array( $this, 'manage_sorting' ), 10 );
		add_action( 'restrict_manage_posts', array( $this, 'render_table_filter_form' ), 10, 2 );
		add_action( 'rest_api_init', array( $this, 'register_api_meta' ), 10 );
		add_filter( "rest_prepare_{$this->slug}", array( $this, 'prepare_rest_post' ), 10, 3 );
		add_action( 'current_screen', array( $this, 'add_help_tabs' ), 10 );

		parent::init();

	}

	/**
	 * Manage Bulk Updated Messages
	 *
	 * This method is responsible for filtering the bulk update messages displayed in the admin.
	 * WordPress does not implement these as part of the post type's labels, so they must be
	 * managed here. This method uses as much of the existing labels as possible.
	 *
	 * @since 3.4.0
	 * @param array $messages A keyed array of messages.
	 * @param array $counts A keyed array of counts.
	 * @return array An array of filtered messages.
	 */
	public function manage_bulk_updated_messages( $messages = array(), $counts = array() ) {
		global $post_type_object;

		// posts updated.
		$posts_updated = sprintf(
			/* translators: 1: post type plural name, 2: updated count. */
			_x( '%2$d %1$s updated.', 'post bulk updated message - updated plural', 'wp_backstage' ),
			$post_type_object->labels->name,
			$counts['updated']
		);
		if ( $counts['updated'] === 1 ) {
			$posts_updated = sprintf(
				/* translators: 1: post type singular name. */
				_x( '1 %1$s updated.', 'post bulk updated message - updated singular', 'wp_backstage' ),
				$post_type_object->labels->singular_name
			);
		}
		// posts locked.
		$posts_locked = sprintf(
			/* translators: 1: post type plural name, 2: locked count. */
			_x( '%2$d %1$s not updated, somebody is editing them.', 'post bulk updated message - locked plural', 'wp_backstage' ),
			$post_type_object->labels->name,
			$counts['locked']
		);
		if ( $counts['locked'] === 1 ) {
			$posts_locked = sprintf(
				/* translators: 1: post type singular name. */
				_x( '1 %1$s not updated, somebody is editing it.', 'post bulk updated message - locked singular', 'wp_backstage' ),
				$post_type_object->labels->singular_name
			);
		}
		// posts deleted.
		$posts_deleted = sprintf(
			/* translators: 1: post type plural name, 2: deleted count. */
			_x( '%2$d %1$s permanently deleted.', 'post bulk updated message - deleted plural', 'wp_backstage' ),
			$post_type_object->labels->name,
			$counts['deleted']
		);
		if ( $counts['deleted'] === 1 ) {
			$posts_deleted = sprintf(
				/* translators: 1: post type singular name. */
				_x( '1 %1$s permanently deleted.', 'post bulk updated message - deleted singular', 'wp_backstage' ),
				$post_type_object->labels->singular_name
			);
		}
		// posts trashed.
		$posts_trashed = sprintf(
			/* translators: 1: post type plural name, 2: trashed count. */
			_x( '%2$d %1$s moved to the Trash.', 'post bulk updated message - trashed plural', 'wp_backstage' ),
			$post_type_object->labels->name,
			$counts['trashed']
		);
		if ( $counts['trashed'] === 1 ) {
			$posts_trashed = sprintf(
				/* translators: 1: post type singular name. */
				_x( '1 %1$s moved to the Trash.', 'post bulk updated message - trashed singular', 'wp_backstage' ),
				$post_type_object->labels->singular_name
			);
		}
		// posts untrashed.
		$posts_untrashed = sprintf(
			/* translators: 1: post type plural name, 2: untrashed count. */
			_x( '%2$d %1$s restored from the Trash.', 'post bulk updated message - untrashed plural', 'wp_backstage' ),
			$post_type_object->labels->name,
			$counts['untrashed']
		);
		if ( $counts['untrashed'] === 1 ) {
			$posts_untrashed = sprintf(
				/* translators: 1: post type singular name. */
				_x( '1 %1$s restored from the Trash.', 'post bulk updated message - untrashed singular', 'wp_backstage' ),
				$post_type_object->labels->singular_name
			);
		}
		$messages[ $this->slug ] = array(
			'updated'   => $posts_updated,
			'locked'    => $posts_locked,
			'deleted'   => $posts_deleted,
			'trashed'   => $posts_trashed,
			'untrashed' => $posts_untrashed,
		);

		return $messages;
	}

	/**
	 * Manage Updated Messages
	 *
	 * This method is responsible for filtering the post update messages displayed in the admin.
	 * WordPress does not implement these as part of the post type's labels, so they must be
	 * managed here. This method uses as much of the existing labels as possible.
	 *
	 * @since 3.4.0
	 * @param array $messages A keyed array of messages.
	 * @return array An array of filtered messages.
	 */
	public function manage_updated_messages( $messages = array() ) {
		global $post;
		global $post_type;
		global $post_type_object;

		// phpcs:ignore WordPress.Security.NonceVerification
		$params = wp_unslash( $_GET );

		$viewable    = is_post_type_viewable( $post_type );
		$permalink   = get_permalink( $post->ID );
		$preview_url = get_preview_post_link( $post );

		$scheduled_date     = date_i18n(
			_x( 'M j, Y', 'post updated messages - scheduled date template', 'wp_backstage' ),
			strtotime( $post->post_date )
		);
		$scheduled_time     = date_i18n(
			_x( 'H:i', 'post updated messages - scheduled time template', 'wp_backstage' ),
			strtotime( $post->post_date )
		);
		$scheduled_datetime = sprintf(
			/* translators: 1: scheduled date, 2: scheduled time. */
			_x( '%1$s at %2$s', 'post updated messages - scheduled datetime', 'wp_backstage' ),
			$scheduled_date,
			$scheduled_time
		);

		$preview_post = sprintf(
			/* translators: 1: post type singular name. */
			_x( 'Preview %1$s', 'post updated messages - preview post link', 'wp_backstage' ),
			$post_type_object->labels->singular_name
		);
		$post_saved = sprintf(
			/* translators: 1: post type singular name. */
			_x( '%1$s saved.', 'post updated messages - saved singular', 'wp_backstage' ),
			$post_type_object->labels->singular_name
		);
		$post_submitted = sprintf(
			/* translators: 1: post type singular name. */
			_x( '%1$s submitted.', 'post updated messages - submitted singular', 'wp_backstage' ),
			$post_type_object->labels->singular_name
		);
		$post_scheduled = sprintf(
			/* translators: 1: post type singular name, 2: scheduled datetime. */
			_x( '%1$s scheduled for: %2$s.', 'post updated messages - scheduled singular', 'wp_backstage' ),
			$post_type_object->labels->singular_name,
			'<strong>' . $scheduled_datetime . '</strong>'
		);
		$post_draft_updated = sprintf(
			/* translators: 1: post type singular name. */
			_x( '%1$s draft updated.', 'post updated messages - draft updated singular', 'wp_backstage' ),
			$post_type_object->labels->singular_name,
		);

		$post_revision_restored = false;
		if ( isset( $params['revision'] ) ) {
			$post_revision_restored = sprintf(
				/* translators: 1: post type singular name, 2: revision title. */
				_x( '%1$s restored to revision from %2$s.', 'post updated messages - revision restored singular', 'wp_backstage' ),
				$post_type_object->labels->singular_name,
				wp_post_revision_title( (int) $params['revision'], false )
			);
		}

		$preview_post_link_html   = '';
		$scheduled_post_link_html = '';
		$view_post_link_html      = '';

		if ( $viewable ) {
			// Preview post link.
			$preview_post_link_html = sprintf(
				' <a target="_blank" href="%1$s">%2$s</a>',
				esc_url( $preview_url ),
				$preview_post
			);
			// Scheduled post preview link.
			$scheduled_post_link_html = sprintf(
				' <a target="_blank" href="%1$s">%2$s</a>',
				esc_url( $permalink ),
				$preview_post
			);
			// View post link.
			$view_post_link_html = sprintf(
				' <a href="%1$s">%2$s</a>',
				esc_url( $permalink ),
				$post_type_object->labels->view_item
			);
		}

		$messages[ $this->slug ] = array(
			0  => $messages['post'][0], // Unused. Messages start at index 1.
			1  => $post_type_object->labels->item_updated . $view_post_link_html,
			2  => $messages['post'][2],
			3  => $messages['post'][3],
			4  => $post_type_object->labels->item_updated,
			5  => $post_revision_restored,
			6  => $post_type_object->labels->item_published . $view_post_link_html,
			7  => $post_saved,
			8  => $post_submitted . $preview_post_link_html,
			9  => $post_scheduled . $scheduled_post_link_html,
			10 => $post_draft_updated . $preview_post_link_html,
		);

		return $messages;
	}

	/**
	 * Prepare Rest Post
	 *
	 * This method is responsible for preparing the REST API response for the post before it is
	 * sent out to the consumer. "Links" are added for the fields that reference another content
	 * type (posts, attachments, users, etc.), allowing for the content to be embedded if requested.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/ Extending the REST API
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/ Modifying Responses
	 * @link https://developer.wordpress.org/reference/classes/wp_rest_response/add_link/ WP_REST_Response::add_link()
	 *
	 * @since 3.4.0
	 * @param WP_REST_Response $response The current API response.
	 * @param WP_Post          $post The requested post.
	 * @param WP_REST_Request  $request The current API request.
	 * @return WP_REST_Response The filtered API response.
	 */
	public function prepare_rest_post( $response = null, $post = null, $request = null ) {

		$fields = $this->get_fields_by( 'show_in_rest', true );

		foreach ( $fields as $field ) {

			$value = get_post_meta( $post->ID, $field['name'], true );

			$response = $this->add_rest_api_field_link( $response, $field, $value );
		}

		return $response;
	}

	/**
	 * Add Help Tabs
	 *
	 * Registers post type help tabs.
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
	 *
	 * @since   3.4.0
	 * @param   WP_Screen $screen  an instance of `WP_Screen`.
	 * @return  void
	 */
	public function add_help_tabs( $screen = null ) {

		if ( $screen->base === 'edit' && $screen->post_type === $this->slug ) {

			if ( $this->new ) {

				// overview help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_overview',
						'title'    => _x( 'Overview', 'post type overview help tab - title', 'wp_backstage' ),
						'callback' => array( $this, 'render_overview_help_tab' ),
						'priority' => 10,
					)
				);
				// screen content help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_screen_content',
						'title'    => _x( 'Screen Content', 'post type screen content help tab - title', 'wp_backstage' ),
						'callback' => array( $this, 'render_screen_content_help_tab' ),
						'priority' => 10,
					)
				);
				// available actions help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_available_actions',
						'title'    => _x( 'Available Actions', 'post type available actions help tab - title', 'wp_backstage' ),
						'callback' => array( $this, 'render_available_actions_help_tab' ),
						'priority' => 10,
					)
				);
				// available actions help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_bulk_actions',
						'title'    => _x( 'Bulk Actions', 'post type bulk actions help tab - title', 'wp_backstage' ),
						'callback' => array( $this, 'render_bulk_actions_help_tab' ),
						'priority' => 10,
					)
				);
			}
		} elseif ( $screen->base === 'post' && $screen->post_type === $this->slug ) {

			if ( $this->new ) {
				// customize display help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_customize_display',
						'title'    => _x( 'Customizing This Display', 'post type customize display help tab - title', 'wp_backstage' ),
						'callback' => array( $this, 'render_customize_display_help_tab' ),
						'priority' => 10,
					)
				);

				if ( post_type_supports( $screen->post_type, 'title' ) || post_type_supports( $screen->post_type, 'editor' ) ) {
					// title and editor help tab.
					$screen->add_help_tab(
						array(
							'id'       => 'wp_backstage_title_and_editor',
							'title'    => _x( 'Title and Editor', 'post type title and editor help tab - title', 'wp_backstage' ),
							'callback' => array( $this, 'render_title_and_editor_help_tab' ),
							'priority' => 10,
						)
					);
				}

				if ( post_type_supports( $screen->post_type, 'editor' ) ) {
					// inserting media help tab.
					$screen->add_help_tab(
						array(
							'id'       => 'wp_backstage_inserting_media',
							'title'    => _x( 'Inserting Media', 'post type inserting media help tab - title', 'wp_backstage' ),
							'callback' => array( $this, 'render_inserting_media_help_tab' ),
							'priority' => 10,
						)
					);
				}

				// publish settings help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_publish_settings',
						'title'    => _x( 'Publish Settings', 'post type publish settings help tab - title', 'wp_backstage' ),
						'callback' => array( $this, 'render_publish_settings_help_tab' ),
						'priority' => 10,
					)
				);

				if ( post_type_supports( $screen->post_type, 'comments' ) || post_type_supports( $screen->post_type, 'trackbacks' ) ) {
					// dusicussion settings help tab.
					$screen->add_help_tab(
						array(
							'id'       => 'wp_backstage_discussion_settings',
							'title'    => _x( 'Discussion Settings', 'post type discussion settings help tab - title', 'wp_backstage' ),
							'callback' => array( $this, 'render_discussion_settings_help_tab' ),
							'priority' => 10,
						)
					);
				}
			}

			// REST API preview help tab.
			$screen->add_help_tab(
				array(
					'id'       => 'wp_backstage_rest_api_preview',
					'title'    => _x( 'REST API', 'post type rest api preview help tab - title', 'wp_backstage' ),
					'callback' => array( $this, 'render_rest_api_preview_help_tab' ),
					'priority' => 90,
				)
			);
		}
	}

	/**
	 * Render Discussion Settings Help Tab
	 *
	 * This method is responsible for rendering the post type Discussion Settings help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_discussion_settings_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );

		$content = '';

		if ( post_type_supports( $screen->post_type, 'trackbacks' ) ) {
			$content .= _x( '<strong>Send Trackbacks</strong> — Trackbacks are a way to notify legacy blog systems that you\'ve linked to them. Enter the URL(s) you want to send trackbacks. If you link to other WordPress sites they\'ll be notified automatically using pingbacks, and this field is unnecessary.', 'discussion settings help tab - trackbacks', 'wp_backstage' );
		}
		if ( post_type_supports( $screen->post_type, 'comments' ) ) {
			if ( ! empty( $content ) ) {
				$content .= '<br/><br/>';
			}
			$content .= sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Discussion</strong> — You can turn comments and pings on or off, and if there are comments on the %1$s, you can see them here and moderate them.', 'discussion settings help tab - comments', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}

		/**
		 * Fires before the post type discussion settings help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_discussion_settings_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the post type discussion settings help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_discussion_settings_help_tab_after', $screen, $args );
	}

	/**
	 * Render Publish Settings Help Tab
	 *
	 * This method is responsible for rendering the post type Publish Settings help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_publish_settings_help_tab( $screen = null, $args = array() ) {
		$post_type_obj        = get_post_type_object( $screen->post_type );
		$post_type_taxonomies = get_object_taxonomies( $screen->post_type, 'objects' );

		$taxonomies = array();
		foreach ( $post_type_taxonomies as $taxonomy ) {
			if ( $taxonomy->show_ui && $taxonomy->meta_box_cb ) {
				$taxonomies[] = $taxonomy;
			}
		}

		$content = _x( 'Several boxes on this screen contain settings for how your content will be published, including:', 'post publish settings help tab - overview', 'wp_backstage' );

		$bullets = array();

		$bullets['publish'] = sprintf(
			/* translators: 1: post type singular name. */
			_x( '<strong>Publish</strong> — You can set the terms of publishing your %1$s in the Publish box. For Status, Visibility, and Publish (immediately), click on the Edit link to reveal more options. Visibility includes options for password-protecting a %1$s. The Password protected option allows you to set an arbitrary password for each %1$s. The Private option hides the %1$s from everyone except editors and administrators. Publish (immediately) allows you to set a future or past date and time, so you can schedule a %1$s to be published in the future or backdate a %1$s.', 'post publish settings help tab - publish', 'wp_backstage' ),
			$post_type_obj->labels->singular_name
		);
		if ( post_type_supports( $screen->post_type, 'post-formats' ) ) {
			$bullets['post_formats'] = sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Format</strong> — Formats designate how your theme will display a specific %1$s. For example, you could have a <em>standard</em> %1$s with a title and paragraphs, or a short <em>aside</em> that omits the title and contains a short text blurb. Your theme could enable all or some of 10 possible formats. <a href="https://wordpress.org/support/article/post-formats/" target="_blank" rel="noopener">Learn more about formats</a>.', 'post publish settings help tab - format', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}
		if ( post_type_supports( $screen->post_type, 'thumbnail' ) ) {
			$bullets['thumbnail'] = sprintf(
				/* translators: 1: featured image label, 2: post type singular name. */
				_x( '<strong>%1$s</strong> — This allows you to associate an image with your %2$s without inserting it. This is usually useful only if your theme makes use of the image as a thumbnail on the home page, a custom header, etc.', 'post publish settings help tab - thumbnail', 'wp_backstage' ),
				$post_type_obj->labels->featured_image,
				$post_type_obj->labels->singular_name
			);
		}
		if ( post_type_supports( $screen->post_type, 'excerpt' ) ) {
			$bullets['excerpt'] = sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Excerpt</strong> — Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="https://wordpress.org/support/article/excerpt/" target="_blank" rel="noopener">Learn more about manual excerpts</a>.', 'post publish settings help tab - excerpt', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}
		if ( post_type_supports( $screen->post_type, 'slug' ) ) {
			$bullets['slug'] = sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Slug</strong> — The slug of the post is a unique, URL-friendly identifier of the %1$s and will be used when constructing the permalink. <a href="https://wordpress.org/support/article/using-permalinks/" target="_blank" rel="noopener">Learn more about permalinks</a>.', 'post publish settings help tab - slug', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}
		if ( post_type_supports( $screen->post_type, 'page-attributes' ) ) {
			$bullets['page_attributes'] = sprintf(
				/* translators: 1: post type singular name, 2: post type plural name. */
				_x( '<strong>%1$s Attributes</strong> — Set the numerical order of this %1$s. This can be used to sort the %2$s when querying them.', 'post publish settings help tab - page attributes order', 'wp_backstage' ),
				$post_type_obj->labels->singular_name,
				$post_type_obj->labels->name
			);
			if ( $post_type_obj->hierarchical ) {
				$bullets['page_attributes'] .= ' ';
				$bullets['page_attributes'] .= sprintf(
					/* translators: 1: post type singular name, 2: post type plural name. */
					_x( 'The parent %1$s can be set here inorder to create a hierarchy of %2$s.', 'post publish settings help tab - page attributes hierarchy', 'wp_backstage' ),
					$post_type_obj->labels->singular_name,
					$post_type_obj->labels->name
				);
			}
			$bullets['page_attributes'] .= ' ';
			$bullets['page_attributes'] .= _x( '<a href="https://make.wordpress.org/support/user-manual/pages/page-attributes/" target="_blank" rel="noopener">Learn more about attributes</a>.', 'post publish settings help tab - page attributes learn more', 'wp_backstage' );
		}
		if ( post_type_supports( $screen->post_type, 'author' ) ) {
			$bullets['slug'] = sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Author</strong> — The user attributed as the author of the %1$s.', 'post publish settings help tab - author', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}
		if ( post_type_supports( $screen->post_type, 'custom-fields' ) ) {
			$bullets['custom_fields'] = sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Custom Fields</strong> — Custom fields can be used to add extra metadata to the %1$s that you can use in your theme. <a href="https://wordpress.org/support/article/custom-fields/" target="_blank" rel="noopener">Learn more about custom fields</a>.', 'post publish settings help tab - custom fields', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}
		if ( post_type_supports( $screen->post_type, 'revisions' ) ) {
			$bullets['revisions'] = sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Revisions</strong> — This allows you to view the %1$s revisions. <a href="https://wordpress.org/support/article/revisions/" target="_blank" rel="noopener">Learn more about revisions</a>.', 'post publish settings help tab - revisions', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}

		foreach ( $taxonomies as $taxonomy ) {
			$bullets[ $taxonomy->name ] = sprintf(
				/* translators: 1: taxonomy plural name, 2: post type singular name, 3: post type plural name. */
				_x( '<strong>%1$s</strong> ― Manage the %1$s attached to the %2$s. <a href="https://wordpress.org/support/article/taxonomies/" target="_blank" rel="noopener">Learn more about taxonomies</a>.', 'post publish settings help tab - taxonomy', 'wp_backstage' ),
				$taxonomy->labels->name,
				$post_type_obj->labels->singular_name,
				$post_type_obj->labels->name,
			);
		}

		$meta_boxes = $this->get_meta_boxes();
		foreach ( $meta_boxes as $meta_box ) {
			$bullets[ $meta_box['id'] ] = sprintf(
				'<strong>%1$s</strong> ― %2$s',
				$meta_box['title'],
				! empty( $meta_box['help'] ) ? $meta_box['help'] : $meta_box['description'],
			);
		}

		/**
		 * Fires before the post type publish settings help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_publish_settings_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Filters the bullets printed in the post type publish settings help tab.
		 *
		 * @since   3.4.0
		 * @param   array      $bullets  An array of bullet strings.
		 * @param   WP_Screen  $screen   the current instance of the WP_Screen object.
		 * @param   array      $args     An array of help tab arguments.
		 * @return  array      The filtered array of bullet strings.
		 */
		$bullets = apply_filters( 'wp_backstage_post_type_publish_settings_help_tab_bullets', $bullets, $screen, $args );

		if ( ! empty( $bullets ) ) { ?>
			<ul>
				<?php foreach ( $bullets as $bullet ) { ?>
					<li><?php echo wp_kses( $bullet, 'wp_backstage_help_list_item' ); ?></li>
				<?php } ?>
			</ul>
		<?php }

		/**
		 * Fires after the post type publish settings help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_publish_settings_help_tab_after', $screen, $args );
	}

	/**
	 * Render Inserting Media Help Tab
	 *
	 * This method is responsible for rendering the post type Inserting Media help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_inserting_media_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );

		$content = sprintf(
			/* translators: 1: post type singular name. */
			_x( 'You can upload and insert media (images, audio, documents, etc.) by clicking the Add Media button. You can select from the images and files already uploaded to the Media Library, or upload new media to add to your %1$s. To create an image gallery, select the images to add and click the “Create a new gallery” button.<br/><br/>You can also embed media from many popular websites including Twitter, YouTube, Flickr and others by pasting the media URL on its own line into the content of your %1$s. <a href="https://wordpress.org/support/article/embeds/" target="_blank" rel="noopener">Learn more about embeds</a>.', 'post inserting media help tab - overview', 'wp_backstage' ),
			$post_type_obj->labels->singular_name
		);

		/**
		 * Fires before the post type inserting media help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_inserting_media_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the post type inserting media help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_inserting_media_help_tab_after', $screen, $args );
	}

	/**
	 * Render Title and Editor Help Tab
	 *
	 * This method is responsible for rendering the post type Title and Editor help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_title_and_editor_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );

		$content = '';
		if ( post_type_supports( $screen->post_type, 'title' ) ) {
			$content .= sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Title</strong> — Enter a title for your %1$s.', 'post title and editor help tab - title support', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
			if ( $post_type_obj->public ) {
				$content .= ' ';
				$content .= _x( 'After you enter a title, you\'ll see the permalink below if the post, which you can edit.', 'post title and editor help tab - permalink support', 'wp_backstage' );
			}
		}
		if ( post_type_supports( $screen->post_type, 'editor' ) ) {
			if ( ! empty( $content ) ) {
				$content .= '<br/><br/>';
			}
			$content .= sprintf(
				/* translators: 1: post type singular name. */
				_x( '<strong>Editor</strong> — Enter the text for your %1$s. There are two modes of editing: Visual and Text. Choose the mode by clicking on the appropriate tab.<br/><br/>Visual mode gives you an editor that is similar to a word processor. Click the Toolbar Toggle button to get a second row of controls.<br/><br/>The Text mode allows you to enter HTML along with your %1$s text. Note that &lt;p&gt; and &lt;br&gt; tags are converted to line breaks when switching to the Text editor to make it less cluttered. When you type, a single line break can be used instead of typing &lt;br&gt;, and two line breaks instead of paragraph tags. The line breaks are converted back to tags automatically.<br/><br/>You can insert media files by clicking the button above the editor and following the directions. You can align or edit images using the inline formatting toolbar available in Visual mode.<br/><br/>You can enable distraction-free writing mode using the icon to the right. This feature is not available for old browsers or devices with small screens, and requires that the full-height editor be enabled in Screen Options.<br/><br/>Keyboard users: When you are working in the visual editor, you can use <code>Alt + F10</code> to access the toolbar.', 'post title and editor help tab - editor support', 'wp_backstage' ),
				$post_type_obj->labels->singular_name
			);
		}

		/**
		 * Fires before the post type title and editor help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_title_and_editor_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the post type title and editor help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_title_and_editor_help_tab_after', $screen, $args );
	}

	/**
	 * Render Customize Display Help Tab
	 *
	 * This method is responsible for rendering the post type Customize Display help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_customize_display_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );

		global $wp_meta_boxes;
		$meta_boxes = array();
		foreach ( $wp_meta_boxes[ $screen->post_type ] as $section ) {
			foreach ( $section as $priority ) {
				foreach ( $priority as $meta_box ) {
					$meta_boxes[] = $meta_box['title'];
				}
			}
		}

		$content = sprintf(
			/* translators: 1: post type singular name, 2: list of meta box titles. */
			_x( 'The title field and the big %1$s Editing Area are fixed in place, but you can reposition all the other boxes using drag and drop. You can also minimize or expand them by clicking the title bar of each box. Use the Screen Options tab to unhide more boxes (%2$s) or to choose a 1- or 2-column layout for this screen.', 'post customize display help tab - overview', 'wp_backstage' ),
			$post_type_obj->labels->singular_name,
			! empty( $meta_boxes ) ? implode( ', ', $meta_boxes ) : '―'
		);

		/**
		 * Fires before the post type customize display help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_customize_display_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the post type customize display help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_customize_display_help_tab_after', $screen, $args );
	}

	/**
	 * Render Bulk Actions Help Tab
	 *
	 * This method is responsible for rendering the post type Bulk Actions help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_bulk_actions_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );

		$content = sprintf(
			/* translators: 1: post type plural name, 2: post type singular name. */
			_x( 'You can also edit or move multiple %1$s to the Trash at once. Select the %1$s you want to act on using the checkboxes, then select the action you want to take from the Bulk actions menu and click Apply.<br/><br/>When using Bulk Edit, you can change the metadata for all selected %1$s at once. To remove a %2$s from the grouping, just click the x next to its name in the Bulk Edit area that appears.', 'post bulk actions help tab - overview', 'wp_backstage' ),
			$post_type_obj->labels->name,
			$post_type_obj->labels->singular_name
		);

		/**
		 * Fires before the post type bulk actions help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_bulk_actions_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the post type available actions help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_bulk_actions_help_tab_after', $screen, $args );
	}

	/**
	 * Render Available Actions Help Tab
	 *
	 * This method is responsible for rendering the post type Available Actions help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_available_actions_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );

		$content = sprintf(
			/* translators: 1: post type plural name, 2: post type singular name. */
			_x( 'Hovering over a row in the %1$s list will display action links that allow you to manage your %2$s. You can perform the following actions:', 'post available actions help tab - overview', 'wp_backstage' ),
			$post_type_obj->labels->name,
			$post_type_obj->labels->singular_name
		);

		/**
		 * Fires before the post type available actions help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen  the current instance of the WP_Screen object.
		 * @param  array      $args    An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_available_actions_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		$bullets = array();

		$bullets['edit'] = sprintf(
			/* translators: 1: post type singular name. */
			_x( '<strong>Edit</strong> takes you to the editing screen for that %1$s. You can also reach that screen by clicking on the %1$s title.', 'post available actions help tab - edit action', 'wp_backstage' ),
			$post_type_obj->labels->singular_name
		);
		$bullets['quick_edit'] = sprintf(
			/* translators: 1: post type singular name. */
			_x( '<strong>Quick Edit</strong> provides inline access to the metadata of your %1$s, allowing you to update %1$s details without leaving this screen.', 'post available actions help tab - quick edit action', 'wp_backstage' ),
			$post_type_obj->labels->singular_name
		);
		$bullets['trash'] = sprintf(
			/* translators: 1: post type singular name. */
			_x( '<strong>Trash</strong> removes your %1$s from this list and places it in the Trash, from which you can permanently delete it.', 'post available actions help tab - trash action', 'wp_backstage' ),
			$post_type_obj->labels->singular_name
		);
		$bullets['view'] = sprintf(
			/* translators: 1: post type singular name. */
			_x( '<strong>Preview</strong> will show you what your draft %1$s will look like if you publish it. <strong>View</strong> will take you to your live site to view the %1$s. Which link is available depends on your post\'s status.', 'post available actions help tab - view and preview actions', 'wp_backstage' ),
			$post_type_obj->labels->singular_name
		);

		/**
		 * Filters the bullets printed in the post type available actions help tab.
		 *
		 * @since   3.4.0
		 * @param   array      $bullets  An array of bullet strings.
		 * @param   WP_Screen  $screen   the current instance of the WP_Screen object.
		 * @param   array      $args     An array of help tab arguments.
		 * @return  array      The filtered array of bullet strings.
		 */
		$bullets = apply_filters( 'wp_backstage_post_type_available_actions_help_tab_bullets', $bullets, $screen, $args );

		if ( ! empty( $bullets ) ) { ?>
			<ul>
				<?php foreach ( $bullets as $bullet ) { ?>
					<li><?php echo wp_kses( $bullet, 'wp_backstage_help_list_item' ); ?></li>
				<?php } ?>
			</ul>
		<?php }

		/**
		 * Fires after the post type available actions help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_available_actions_help_tab_after', $screen, $args );
	}

	/**
	 * Render Screen Content Help Tab
	 *
	 * This method is responsible for rendering the post type Screen Content help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_screen_content_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );
		$taxonomies    = get_object_taxonomies( $screen->post_type, 'objects' );

		$content = _x( 'You can customize the display of this screen\'s contents in a number of ways:', 'post screen content help tab - overview', 'wp_backstage' );

		$filterable_fields = $this->get_fields_by_query(
			array(
				'is_filterable' => true,
				'has_column'    => true,
			)
		);

		$taxonomy_labels = array();
		foreach ( $taxonomies as $taxonomy ) {
			$taxonomy_labels[] = $taxonomy->labels->name;
		}

		$filterable_field_labels = array();
		foreach ( $filterable_fields as $field ) {
			$field = wp_parse_args( $field, $this->default_field_args );
			if ( in_array( $field['type'], $this->filterable_fields ) ) {
				$filterable_field_labels[] = ! empty( $field['label'] ) ? $field['label'] : $field['name'];
			}
		}

		$bullets = array();

		$bullets['columns'] = sprintf(
			/* translators: 1: post type plural name. */
			_x( 'You can hide/display columns based on your needs and decide how many %1$s to list per screen using the Screen Options tab.', 'post screen content help tab - columns', 'wp_backstage' ),
			$post_type_obj->labels->name
		);
		$bullets['statuses'] = sprintf(
			/* translators: 1: post type plural name. */
			_x( 'You can filter the list of %1$s by post status using the text links above the %1$s list to only show %1$s with that status. The default view is to show all %1$s.', 'post screen content help tab - statuses', 'wp_backstage' ),
			$post_type_obj->labels->name
		);
		$bullets['view_mode'] = sprintf(
			/* translators: 1: post type plural name. */
			_x( 'You can view %1$s in a simple title list or with an excerpt using the Screen Options tab.', 'post screen content help tab - view mode', 'wp_backstage' ),
			$post_type_obj->labels->name
		);
		$bullets['filter'] = sprintf(
			/* translators: 1: post type plural name, 2: taxonomy labels 3: filterable field labels. */
			_x( 'You can refine the list to show only %1$s from a specific month, those in a specific taxonomy (%2$s), or those with a specific value for filterable fields (%3$s) by using the dropdown menus above the %1$s list. Click the Filter button after making your selection. You can also refine the list by clicking on the author, taxonomies (%2$s), and filterable fields (%3$s) in the %1$s list.', 'post screen content help tab - filter', 'wp_backstage' ),
			$post_type_obj->labels->name,
			! empty( $taxonomy_labels ) ? implode( ', ', $taxonomy_labels ) : '―',
			! empty( $filterable_field_labels ) ? implode( ', ', $filterable_field_labels ) : '―'
		);

		/**
		 * Fires before the post type screen content help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_screen_content_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Filters the bullets printed in the post type screen content help tab.
		 *
		 * @since   3.4.0
		 * @param   array      $bullets  An array of bullet strings.
		 * @param   WP_Screen  $screen   the current instance of the WP_Screen object.
		 * @param   array      $args     An array of help tab arguments.
		 * @return  array      The filtered array of bullet strings.
		 */
		$bullets = apply_filters( 'wp_backstage_post_type_screen_content_help_tab_bullets', $bullets, $screen, $args );

		if ( ! empty( $bullets ) ) { ?>
			<ul>
				<?php foreach ( $bullets as $bullet ) { ?>
					<li><?php echo wp_kses( $bullet, 'wp_backstage_help_list_item' ); ?></li>
				<?php } ?>
			</ul>
		<?php }

		/**
		 * Fires after the post type screen content help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_screen_content_help_tab_after', $screen, $args );
	}

	/**
	 * Render Overview Help Tab
	 *
	 * This method is responsible for rendering the post type Overview help tab content.
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current `WP_Screen` object.
	 * @param array     $args An array of help tab args.
	 * @return void
	 */
	public function render_overview_help_tab( $screen = null, $args = array() ) {
		$post_type_obj = get_post_type_object( $screen->post_type );
		$taxonomies    = get_object_taxonomies( $screen->post_type, 'objects' );

		$content = sprintf(
			/* translators: 1: post type plural name. */
			_x( 'This screen provides access to all of your %1$s. You can customize the display of this screen to suit your workflow.', 'post type overview help tab - overview', 'wp_backstage' ),
			$post_type_obj->labels->name,
		);

		// if the capability type is page, let the user know the management is similar to pages.
		if ( $post_type_obj->capability_type === 'page' ) {
			$post_post_type_object = get_post_type_object( 'page' );
			if ( ! empty( $content ) ) {
				$content .= '<br/><br/>';
			}
			$content .= sprintf(
				/* translators: 1: post type plural name, 2: post post type plural name. */
				_x( '%1$s are similar to %2$s in that they have the same management capability, meaning the same user roles that can manage %2$s can manage %1$s.', 'post type overview help tab - capability type: page', 'wp_backstage' ),
				$post_type_obj->labels->name,
				$post_post_type_object->labels->name
			);
		}
		// if the capability type is post, let the user know the management is similar to posts.
		if ( $post_type_obj->capability_type === 'post' ) {
			$page_post_type_object = get_post_type_object( 'post' );
			if ( ! empty( $content ) ) {
				$content .= '<br/><br/>';
			}
			$content .= sprintf(
				/* translators: 1: post type plural name, 2: page post type plural name. */
				_x( '%1$s are similar to %2$s in that they have the same management capability, meaning the same user roles that can manage %2$s can manage %1$s.', 'post type overview help tab - capability type: post', 'wp_backstage' ),
				$post_type_obj->labels->name,
				$page_post_type_object->labels->name
			);
		}
		// If the post type is hierarchical, let the user know that the items can have parent/child relationships.
		if ( $post_type_obj->hierarchical ) {
			if ( ! empty( $content ) ) {
				$content .= ' ';
			}
			$content .= sprintf(
				/* translators: 1: post type plural name. */
				_x( '%1$s can have a hierarchy. You can nest %1$s under other %1$s by making one the "Parent" of the other, creating a group of %1$s.', 'post type overview help tab - hierarchy', 'wp_backstage' ),
				$post_type_obj->labels->name
			);
		}
		// If there are taxonomies attached, let the user know these items can be organized.
		if ( ! empty( $taxonomies ) ) {
			$taxonomy_links = array();
			foreach ( $taxonomies as $taxonomy ) {
				$edit_taxonomy_url = add_query_arg(
					array(
						'taxonomy'  => $taxonomy->name,
						'post_type' => $post_type_obj->name,
					),
					admin_url( '/edit-tags.php' )
				);
				$taxonomy_links[]  = sprintf(
					'<a href="%1$s">%2$s</a>',
					$edit_taxonomy_url,
					$taxonomy->labels->name,
				);
			}
			if ( ! empty( $content ) ) {
				$content .= '<br/><br/>';
			}
			$content .= sprintf(
				/* translators: 1: post type plural name, 2: taxonomy links. */
				_x( '%1$s can be organized using their related taxonomies: %2$s.', 'post overview help tab - taxonomies', 'wp_backstage' ),
				$post_type_obj->labels->name,
				implode( ', ', $taxonomy_links )
			);
		}

		/**
		 * Fires before the post type overview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_overview_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the post type overview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_overview_help_tab_after', $screen, $args );
	}

	/**
	 * Render API Preview Help Tab
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current WP_Screen instance.
	 * @param array     $args An array of help tab arguments.
	 * @return void
	 */
	public function render_rest_api_preview_help_tab( $screen = null, $args = array() ) {
		$post_id       = get_the_ID();
		$post_type_obj = get_post_type_object( $this->slug );
		$path          = sprintf( '/%1$s/%2$s/%3$d', $post_type_obj->rest_namespace, $post_type_obj->rest_base, $post_id );

		/**
		 * Fires before the post type REST API preview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_rest_api_preview_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( _x( '<strong>REST API</strong> ― Preview the WordPress REST API response for this post. All contexts can be previewed including <code>view</code>, <code>embed</code>, and <code>edit</code>. The <code>_embed</code> flag can be also be enabled by checking the checkbox to preview embedded records.', 'post type rest api preview help tab - title', 'wp_backstage' ) ) );
		$this->render_rest_api_preview( $path );

		/**
		 * Fires after the post type REST API preview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_post_type_rest_api_preview_help_tab_after', $screen, $args );
	}

	/**
	 * Register API Meta
	 *
	 * This method is responsible for registering the post meta fields with the REST API,
	 * and generating the schema for each.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/ Extending the REST API
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/ Modifying Responses
	 * @link https://developer.wordpress.org/reference/functions/register_post_meta/ register_post_meta()
	 *
	 * @since 3.4.0
	 * @return void
	 */
	public function register_api_meta() {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			$field_class = $this->get_field_class( $field['type'] );
			$schema      = $field_class->get_schema();

			$show_in_rest = false;
			if ( $field['show_in_rest'] ) {
				$show_in_rest = array(
					'schema' => $schema,
				);
			}

			register_post_meta(
				$this->slug,
				$field['name'],
				array(
					'description'       => wp_strip_all_tags( $field['description'], true ),
					'type'              => $schema['type'],
					'single'            => true,
					'sanitize_callback' => array( $field_class, 'sanitize' ),
					'show_in_rest'      => $show_in_rest,
				)
			);
		}
	}

	/**
	 * Manage Post Title
	 *
	 * @since   0.0.1
	 * @param   string $title  The post title.
	 * @param   int    $id     The post ID.
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
					$title         = esc_html(
						sprintf(
							/* translators: 1: post type, 2: post title. */
							_x( '%1$s: %2$s', 'dashboard activity post link title', 'wp_backstage' ),
							$post_type_obj->labels->singular_name,
							$title
						)
					);
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
	 * @param  string $template  A localized `sprintf()` template where `%1$s` is the post type singular name, `%2$s` is the post type plural name, and `%3$s` is the thumbnail label.
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
			'featured_image'           => $this->args['thumbnail_label'],
			'add_new'                  => _x( 'Add New', 'post type - add new', 'wp_backstage' ),
			'archives'                 => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s Archives', 'post type - archives', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'attributes'               => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s Attributes', 'post type - attributes', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'parent_item'              => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Parent %1$s', 'post type - parent item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'parent_item_colon'        => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Parent %1$s:', 'post type - parent item colon', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'all_items'                => sprintf(
				/* translators: 1: post type plural name. */
				_x( 'All %1$s', 'post type - all items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'add_new_item'             => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Add New %1$s', 'post type - add new item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'new_item'                 => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'New %1$s', 'post type - new item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'edit_item'                => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Edit %1$s', 'post type - edit item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'update_item'              => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Update %1$s', 'post type - update item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'view_item'                => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'View %1$s', 'post type - view item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'view_items'               => sprintf(
				/* translators: 1: post type plural name. */
				_x( 'View %1$s', 'post type - view items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'search_items'             => sprintf(
				/* translators: 1: post type plural name. */
				_x( 'Search %1$s', 'post type - search items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'not_found'                => sprintf(
				/* translators: 1: post type plural name. */
				_x( 'No %1$s found', 'post type - not found', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'not_found_in_trash'       => sprintf(
				/* translators: 1: post type plural name. */
				_x( 'No %1$s found in trash', 'post type - not found in trash', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'set_featured_image'       => sprintf(
				/* translators: 1: post type thumbnail label. */
				_x( 'Set %1$s', 'post type - set featured image', 'wp_backstage' ),
				$this->args['thumbnail_label']
			),
			'remove_featured_image'    => sprintf(
				/* translators: 1: post type thumbnail label. */
				_x( 'Remove %1$s', 'post type - remove featured image', 'wp_backstage' ),
				$this->args['thumbnail_label']
			),
			'use_featured_image'       => sprintf(
				/* translators: 1: post type thumbnail label. */
				_x( 'Use as %1$s', 'post type - use featured image', 'wp_backstage' ),
				$this->args['thumbnail_label']
			),
			'insert_into_item'         => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Insert into %1$s', 'post type - insert into item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'uploaded_to_this_item'    => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'Uploaded to this %1$s', 'post type - uploaded to this item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'items_list'               => sprintf(
				/* translators: 1: post type plural name. */
				_x( '%1$s list', 'post type - items list', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'items_list_navigation'    => sprintf(
				/* translators: 1: post type plural name. */
				_x( '%1$s list navigation', 'post type - items list navigation', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'filter_items_list'        => sprintf(
				/* translators: 1: post type plural name. */
				_x( 'Filter %1$s list', 'post type - filter items list', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'item_published'           => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s published.', 'post type - item published', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'item_published_privately' => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s published privately.', 'post type - item published privately', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'item_reverted_to_draft'   => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s reverted to draft.', 'post type - item reverted to draft', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'item_scheduled'           => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s scheduled.', 'post type - item scheduled', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'item_updated'             => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s updated.', 'post type - item updated', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'item_link'                => sprintf(
				/* translators: 1: post type singular name. */
				_x( '%1$s Link', 'post type - item link', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'item_link_description'    => sprintf(
				/* translators: 1: post type singular name. */
				_x( 'A link to a %1$s', 'post type - item link description', 'wp_backstage' ),
				$this->args['singular_name']
			),
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
		return $this->args['meta_boxes'];
	}

	/**
	 * Get Fields
	 *
	 * @since   0.0.1
	 * @return  array  an array of field arg arrays.
	 */
	protected function get_fields() {

		$meta_boxes = $this->get_meta_boxes();
		$fields     = array();

		foreach ( $meta_boxes as $meta_box ) {
			$fields = array_merge( $fields, $meta_box['fields'] );
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
	 * @param   int     $post_id  The ID of the post being saved.
	 * @param   WP_Post $post     The full `WP_Post` object for the post being saved.
	 * @param   bool    $update   Whether the post is being updated or not.
	 * @return  void
	 */
	public function save( $post_id = 0, $post = null, $update = false ) {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( empty( $post_data ) ) {
			return;
		}
		if ( empty( $post_data[ $this->nonce_key ] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $post_data[ $this->nonce_key ], 'edit' ) ) {
			return;
		}

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			if ( isset( $post_data[ $field['name'] ] ) ) {

				$field_class = $this->get_field_class( $field['type'] );
				$value       = $field_class->sanitize( $field, $post_data[ $field['name'] ] );

				update_post_meta( $post_id, $field['name'], $value );

				if ( $field['type'] === 'media' ) {

					$this->handle_attachments( $post_id, $value, $field );

				}
			} else {

				delete_post_meta( $post_id, $field['name'] );

			}
		}

	}

	/**
	 * Handle Attachments
	 *
	 * Attaches all media used in media uploader fields to the post being saved.
	 *
	 * @since   0.0.1
	 * @since   3.4.1     Refactored to make sure the value is always an array.
	 * @param   int       $post_id  The ID of the post being saved.
	 * @param   int|array $value    The attachment ID or array of attachment IDs to attach.
	 * @param   array     $field    An array of field arguments.
	 * @return  void
	 */
	protected function handle_attachments( $post_id = null, $value = null, $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );

		if ( $field['type'] !== 'media' ) {
			return;
		}

		$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );

		if ( ! $args['attach'] ) {
			return;
		}

		if ( ! empty( $value ) ) {

			// ensure this is always an array.
			$value = is_array( $value ) ? $value : array( $value );

			foreach ( $value as $attachment_id ) {

				// ensure the id references an attachment.
				if ( get_post_type( $attachment_id ) === 'attachment' ) {

					// check if the attachment is already attached.
					$parent_id = absint( wp_get_post_parent_id( $attachment_id ) );

					// only attach if the attachment has no parent.
					if ( $parent_id === 0 ) {
						wp_update_post(
							array(
								'ID'          => $attachment_id,
								'post_parent' => $post_id,
							)
						);
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
	 * @param   array     $hidden  An array of already-set hidden meta box IDs.
	 * @param   WP_Screen $screen  An instance of `WP_Screen`.
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
	 * @param   array $columns  An array of already-set columns.
	 * @return  array  The filtered columns.
	 */
	public function add_thumbnail_column( $columns = array() ) {

		if ( post_type_supports( $this->slug, 'thumbnail' ) && is_array( $columns ) ) {

			// loop the columns so that the new columns can
			// be inserted where they are wanted.
			foreach ( $columns as $column_key => $column_label ) {

				// unset this column to make room for the new column,
				// all information needed to reset the column is already here.
				unset( $columns[ $column_key ] );

				// if the loop is currently at the checkbox column,
				// reset the checkbox column followed by the new
				// thumbnail column.
				if ( $column_key === 'cb' ) {

					// if the loop is currently at the checkbox column,
					// reset the checkbox column followed by the new
					// thumbnail column.
					$columns[ $column_key ] = $column_label;
					$columns['thumbnail']   = '<i class="dashicons dashicons-format-image" style="color:#444444;"></i><span class="screen-reader-text">' . esc_html( $this->args['thumbnail_label'] ) . '</span>';

				} else {

					// else reset the column as is.
					$columns[ $column_key ] = $column_label;

				}
			}
		}

		return $columns;

	}

	/**
	 * Render Thumbnail
	 *
	 * @since   0.0.1
	 * @param   int $post_id  The post ID of the post to render the thumbnail for.
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
	 * @param   string $column   The column name.
	 * @param   int    $post_id  The post ID for this row.
	 * @return  void
	 */
	public function render_admin_column( $column = '', $post_id = null ) {

		if ( $column === 'thumbnail' ) {

			$this->render_thumbnail( $post_id );

		} else {

			$field = $this->get_field_by( 'name', $column );

			if ( ! empty( $field ) ) {

				$value = get_post_meta( $post_id, $column, true );

				/**
				 * Filters the post type custom field's admin column content.
				 *
				 * Returning any value here will short circuit the plugin's
				 * output and render this content instead.
				 *
				 * @since 0.0.1
				 *
				 * @param string $content The existing column content.
				 * @param array $field an array of field arguments.
				 * @param mixed $value the field's value.
				 * @param int $post_id The post ID of the current post.
				 * @return string The filtered content
				 */
				$content = apply_filters( "wp_backstage_{$this->slug}_{$column}_column_content", '', $field, $value, $post_id );

				if ( ! empty( $content ) ) {
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $content;
					return;
				}

				if ( ! empty( $value ) ) {

					$field_class = $this->get_field_class( $field['type'] );
					$field_class->render_column( $field, $value );

				} else {

					echo '&horbar;';

				}
			}
		}

	}

	/**
	 * Render Table Filter Form
	 *
	 * This method is responsible for rendering additional filters at the top of the admin post type list table.
	 * Because the user list table already has filters, it is not necessary to add the filter action submit
	 * button here.
	 *
	 * @since 3.1.0
	 * @param string $post_type The post type of the current screen.
	 * @param string $which whether the form is displayed at the top or bottom, or both. Possible values are `top`, `bottom`, or an empty string.
	 * @return void
	 */
	public function render_table_filter_form( $post_type = '', $which = 'top' ) {

		if ( $post_type === $this->slug ) {

			$this->render_table_filter_controls();

		}

	}

	/**
	 * Manage Sorting
	 *
	 * The method is responsible for managing sorting on the query. If a field's
	 * name is found in the `orderby` key, then its key is added as the meta key
	 * for the query, and the orderby is reset to either `meta_value` or `meta_value_num`
	 * according to if the value is expected to be numeric or not. If no meta query is set,
	 * this will add a meta query that filters for posts that either do or do not have the meta
	 * value set for the field. By default, setting just `meta_key` is not sufficient if the
	 * desire is to show posts that don't have a value as well.
	 *
	 * @since   0.0.1
	 * @since   3.1.0  Added a check to see if there is already a meta query before setting the meta query that is added in order to get posts both with or without a value set for the field.
	 * @param   WP_Query $query  An instance of `WP_Query`.
	 * @return  void
	 */
	public function manage_sorting( $query = null ) {

		$query_post_type = $query->get( 'post_type' );
		$is_post_type    = is_array( $query_post_type ) ? in_array( $this->slug, $query_post_type ) : ( $query_post_type === $this->slug );

		if ( $is_post_type ) {

			$field = $this->get_field_by( 'name', $query->get( 'orderby' ) );

			if ( is_array( $field ) && ! empty( $field ) && $field['is_sortable'] ) {

				$field_class = $this->get_field_class( $field['type'] );
				$schema      = $field_class->get_schema();
				$is_numeric  = in_array( $schema['type'], array( 'number', 'integer' ) );

				// If there is currently no meta query, get all items whether
				// they have the meta key or not by setting a meta query.
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

				if ( $is_numeric ) {
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
	 * a field's name is set. The fields are looped over, and if a field is
	 * found with the matching query var, builds an array of meta query filters.
	 * At the end of the loop, if there is a meta query to be set, the "AND" relation
	 * is also added to the meta query, allowing for complex filtering to be accomplished.
	 * See `WP_Backstage_Post_Type::manage_query_vars()` to see how the fields are made
	 * available as public query vars.
	 *
	 * @since   3.1.0
	 * @param   WP_Query $query  An instance of `WP_Query`.
	 * @return  void
	 */
	public function manage_filtering( $query = null ) {

		$query_post_type = $query->get( 'post_type' );
		$is_post_type    = is_array( $query_post_type ) ? in_array( $this->slug, $query_post_type ) : ( $query_post_type === $this->slug );

		if ( $is_post_type ) {

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
	}

	/**
	 * Manage Query Vars
	 *
	 * This method is responsible for adding all field name's as public query vars.
	 * This will make them available to `WP_Query` and allow for filtering based on
	 * the field name.
	 *
	 * @since 3.1.0
	 * @param array $query_vars  An array of the currently public query vars.
	 * @return array The filtered query vars array.
	 */
	public function manage_query_vars( $query_vars = array() ) {

		$fields = $this->get_fields();
		foreach ( $fields as $field ) {
			$query_vars[] = $field['name'];
		}

		return $query_vars;
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
	 * @param   WP_Post $post      An instance of `WP_Post`.
	 * @param   array   $meta_box  An array of WP meta box args passed from the `add_meta_box()` function.
	 * @return  void
	 */
	public function render_meta_box( $post = null, $meta_box = array() ) {

		$meta_box = wp_parse_args(
			$meta_box,
			array(
				'id'    => '',
				'title' => '',
				'args'  => array(
					'descripton' => '',
					'fields'     => array(),
				),
			)
		);

		foreach ( $meta_box['args']['fields'] as $field ) {

			$field['value'] = get_post_meta( $post->ID, $field['name'], true );

			/**
			 * Filters the field arguments just before the field is rendered.
			 *
			 * @since 0.0.1
			 *
			 * @param array $field an array of field arguments.
			 * @param WP_Post $post an array of field arguments.
			 */
			$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $post );

			$field_class = $this->get_field_class( $field['type'] );

			if ( $field_class->has_tag( 'text_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
			}

			if ( $field_class->has_tag( 'textarea_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
				$field = $this->set_field_textarea_dimensions( $field, 5, 50 );
			}

			/**
			 * Fires before the custom meta field is rendered.
			 *
			 * @since 0.0.1
			 *
			 * @param array $field an array of field arguments.
			 * @param WP_Post $post an array of field arguments.
			 */
			do_action( "wp_backstage_{$this->slug}_field_before", $field, $post );

			$this->render_field_label( $field );

			$field_class->render( $field );

			/**
			 * Fires after the custom meta field is rendered.
			 *
			 * @since 0.0.1
			 *
			 * @param array $field an array of field arguments.
			 * @param WP_Post $post an array of field arguments.
			 */
			do_action( "wp_backstage_{$this->slug}_field_after", $field, $post );

			$this->render_field_description( $field );

		}

		if ( ! empty( $meta_box['args']['description'] ) ) { ?>

			<div style="margin: 12px -12px -12px; padding: 12px; background: #f6f7f7; border-top: 1px solid #dcdcde;">

				<p style="margin: 0;"><?php
					echo wp_kses( $meta_box['args']['description'], 'wp_backstage_meta_box_description' );
				?></p>

			</div>

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

			<p 
			class="howto"
			id="<?php printf( '%1$s-desc', esc_attr( $field_class->get_id( $field ) ) ); ?>"><?php
				$field_class->description( $field );
			?></p>

		<?php }

	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Note that this will only work if this post type's columns
	 * UI has never been modified by the user.
	 *
	 * @since   0.0.1
	 * @since   3.0.0      Only add the field to hidden columns array if the field is set to have a column.
	 * @param   array     $hidden  An array of already-set hidden column names.
	 * @param   WP_Screen $screen  An instance of `WP_Screen`.
	 * @return  array      An array of column names
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $this->is_screen( 'post_type', $this->slug ) ) {

			$fields = $this->get_fields();

			foreach ( $fields as $field ) {
				if ( $field['has_column'] ) {
					$hidden[] = $field['name'];
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
	 * @param   array $items  The array of alread-set glance items.
	 * @return  array  The filtered glance items array.
	 */
	public function manage_dashboard_glance_items( $items = array() ) {

		if ( $this->args['glance_item'] ) {

			$counts = wp_count_posts( $this->slug );

			if ( $counts ) {

				$published     = intval( $counts->publish );
				$post_type_obj = get_post_type_object( $this->slug );

				$label = sprintf(
					/* translators: 1: published count, 2: post type label */
					_x( '%1$d %2$s', 'dashboard glance item', 'wp_backstage' ),
					number_format_i18n( $published ),
					$published === 1 ? $post_type_obj->labels->singular_name : $post_type_obj->labels->name
				);

				$url   = add_query_arg( array( 'post_type' => $this->slug ), admin_url( '/edit.php' ) );
				$class = sprintf( '%1$s-count', $this->slug );
				$icon  = '<i class="' . sprintf( 'dashicons %1$s', $post_type_obj->menu_icon ) . '"></i>';

				$items[] = '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . $icon . '<span>' . esc_html( $label ) . '</span></a>';

			}
		}

		return $items;
	}

	/**
	 * Manage Dashboard Activity Query Args
	 *
	 * @since   0.0.1
	 * @param   array $args  The array of already-set query arguments.
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
	 * @since   3.4.0 Updated dashicon color.
	 * @return  void
	 */
	public function inline_dashboard_glance_item_style() { ?>

		<style 
		id="<?php printf( 'wp_backstage_%1$s_dashboard_glance_item_style', esc_attr( $this->slug ) ); ?>"
		type="text/css"><?php

			printf( '#dashboard_right_now ul li > .%1$s-count::before { content: unset; }', sanitize_html_class( $this->slug ) );
			printf( '#dashboard_right_now ul li > .%1$s-count > .dashicons { color: #646970; speak: none; padding: 0 5px 0 0; position: relative; }', sanitize_html_class( $this->slug ) );

		?></style>

	<?php }

}
