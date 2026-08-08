<?php
/**
 * WP Backstage Taxonomy
 *
 * @since       0.0.1
 * @since       3.0.0  linted and formatted with phpcs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Taxonomy
 *
 * @since       0.0.1
 */
class WP_Backstage_Taxonomy extends WP_Backstage_Component {

	/**
	 * Add
	 *
	 * @since 2.0.0
	 * @var bool $add Whether the instance is creating a add taxonomy or modifying an existing one.
	 */
	protected bool $add = true;

	/**
	 * Quick Edit Data
	 *
	 * Stores quick edit field values captured before core taxonomy quick edit
	 * hands the request payload to `wp_update_term()`.
	 *
	 * @since 4.0.0
	 * @var array $quick_edit_data An array of quick edit field values if available.
	 */
	protected array $quick_edit_data = array();

	/**
	 * Default Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'singular_name' => '',
		'plural_name'   => '',
		'description'   => '',
		'public'        => true,
		'hierarchical'  => true,
		'with_front'    => false,
		'archive_base'  => '',
		'rest_base'     => '',
		'post_types'    => array(),
		'fields'        => array(),
	);

	/**
	 * Required Args
	 *
	 * @since  0.0.1
	 * @var    array  $required_args  The required argument keys for this instance.
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
	 * Add
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_taxonomy/ WP_Taxonomy
	 *
	 * @since   0.0.1
	 * @param   string $slug  The slug for the taxonomy.
	 * @param   array  $args  The arguments for this instance.
	 * @return  WP_Backstage_Taxonomy  A fully constructed instance of `WP_Backstage_Taxonomy`.
	 */
	public static function add( string $slug, array $args ): WP_Backstage_Taxonomy {

		$component = new WP_Backstage_Taxonomy( $slug, $args );
		$component->init();
		return $component;
	}

	/**
	 * Modify
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_taxonomy/ WP_Taxonomy
	 *
	 * @since   2.0.0
	 * @param   string $slug  The slug for the taxonomy.
	 * @param   array  $args  The arguments for this instance.
	 * @return  WP_Backstage_Taxonomy  A fully constructed instance of `WP_Backstage_Taxonomy`.
	 */
	public static function modify( string $slug, array $args ): WP_Backstage_Taxonomy {

		$component = new WP_Backstage_Taxonomy( $slug, $args, false );
		$component->init();
		return $component;
	}

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 * @since   2.0.0   Adds $add parameter for distinguishing between `add` and `modify` behavior.
	 * @param   string $slug  The developer-provided slug for the taxonomy.
	 * @param   array  $args  The developer-provided arguments for this instance.
	 * @param   bool   $add   Whether this instance constructs a add taxonomy or modifies an existing one.
	 */
	public function __construct( string $slug, array $args, bool $add = true ) {

		$this->default_field_args = array_merge(
			$this->default_field_args,
			array(
				'has_column'    => false,
				'is_sortable'   => false,
				'is_filterable' => false,
				'quick_add'     => false,
				'quick_edit'    => false,
			)
		);

		$this->add  = boolval( $add );
		$this->slug = sanitize_key( $slug );
		$this->set_args( $args );
		$this->screen_id = "edit-{$this->slug}";
		$this->nonce_key = "_wp_backstage_taxonomy_{$this->slug}_nonce";
		$this->set_errors();

		parent::__construct();
	}

	/**
	 * Set Args
	 *
	 * @since   0.0.1
	 * @param   array $args The developer-provided arguments for this instance.
	 */
	protected function set_args( array $args ) {

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['singular_base'] ) ) {
			$this->args['singular_base'] = $this->slug;
		}

		if ( empty( $this->args['archive_base'] ) ) {
			$this->args['archive_base'] = $this->slug;
		}

		if ( empty( $this->args['menu_name'] ) ) {
			$this->args['menu_name'] = $this->args['plural_name'];
		}

		foreach ( $this->args['fields'] as $i => $field ) {
			$this->args['fields'][ $i ] = wp_parse_args( $field, $this->default_field_args );
		}
	}

	/**
	 * Set Errors
	 *
	 * @since   0.0.1
	 */
	protected function set_errors() {

		if ( empty( $this->slug ) ) {

			$this->errors[] = new WP_Error(
				'required_taxonomy_slug',
				sprintf(
					/* translators: 1: taxonomy slug. */
					_x( '[Taxonomy: %1$s] A slug is required when adding a new taxonomy.', 'taxonomy - required slug error', 'wp_backstage' ),
					$this->slug
				)
			);

		} elseif ( strlen( $this->slug ) > 32 ) {

			$this->errors[] = new WP_Error(
				'taxonomy_slug_length',
				sprintf(
					/* translators: 1: taxonomy slug. */
					_x( '[Taxonomy: %1$s] A taxonomy slug must be between 1 and 32 characters.', 'taxonomy - slug length error', 'wp_backstage' ),
					$this->slug
				)
			);

		} elseif ( $this->add && in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error(
				'taxonomy_exists',
				sprintf(
					/* translators: 1: taxonomy slug, 2: method suggestion */
					_x( '[Taxonomy: %1$s] A taxonomy with this slug already exists. Use the %2$s method to modify an existing taxonomy.', 'taxonomy - existing slug error', 'wp_backstage' ),
					$this->slug,
					'<code>WP_Backstage_Taxonomy::modify()</code>'
				)
			);

		} elseif ( ! $this->add && ! in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error(
				'taxonomy_not_exists',
				sprintf(
					/* translators: 1: taxonomy slug, 2: method suggestion */
					_x( '[Taxonomy: %1$s] A taxonomy with this slug does not exist. Use the %2$s method to create a new taxonomy.', 'taxonomy - nonexisting slug error', 'wp_backstage' ),
					$this->slug,
					'<code>WP_Backstage_Taxonomy::add()</code>'
				)
			);

		}

		$required_args = ! $this->add ? $this->required_args_modify : $this->required_args;

		if ( is_array( $required_args ) && ! empty( $required_args ) ) {

			foreach ( $required_args as $required_arg ) {

				if ( empty( $this->args[ $required_arg ] ) ) {

					$this->errors[] = new WP_Error(
						'required_taxonomy_arg',
						sprintf(
							/* translators: 1: taxonomy slug, 2:required arg key. */
							_x( '[Taxonomy: %1$s] The %2$s key is required.', 'taxonomy - required arg error', 'wp_backstage' ),
							$this->slug,
							'<code>' . $required_arg . '</code>'
						)
					);

				}
			}
		}

		parent::set_errors();
	}

	/**
	 * Init
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Ensures a new taxonomy is only registered if adding a new one.
	 * @since   3.4.0  Adds help tabs, term update messages, and registers meta with the REST API.
	 * @since   3.6.0  Removes `sprintf` templates from hook names.
	 * @since   4.0.0 Removes error checking of the `WP_Backstage` class as it no longer reports errors.
	 */
	public function init() {

		// Only perform these hooks and filters if the taxonomy is new.
		if ( $this->add ) {
			add_action( 'init', array( $this, 'register' ), 0 );
			add_filter( 'term_updated_messages', array( $this, 'manage_term_updated_messages' ), 10 );
		}
		add_action( 'admin_init', array( $this, 'capture_quick_edit_request_data' ), 10 );
		add_action( "{$this->slug}_add_form_fields", array( $this, 'render_add_nonce' ), 10 );
		add_action( "{$this->slug}_term_edit_form_top", array( $this, 'render_edit_nonce' ), 10 );
		add_action( "{$this->slug}_add_form_fields", array( $this, 'render_add_fields' ), 10 );
		add_action( "{$this->slug}_edit_form_fields", array( $this, 'render_edit_fields' ), 10, 2 );
		add_action( "edited_{$this->slug}", array( $this, 'save' ), 10, 2 );
		add_action( "edited_{$this->slug}", array( $this, 'save_quick_edit' ), 10, 2 );
		add_action( "created_{$this->slug}", array( $this, 'save' ), 10, 2 );
		add_filter( "manage_edit-{$this->slug}_columns", array( $this, 'add_field_columns' ), 10 );
		add_filter( "manage_edit-{$this->slug}_sortable_columns", array( $this, 'manage_sortable_columns' ), 10 );
		add_filter( "manage_{$this->slug}_custom_column", array( $this, 'manage_admin_column_content' ), 10, 3 );
		add_filter( "{$this->slug}_row_actions", array( $this, 'inline_quick_edit_data' ), 100, 2 );
		add_action( "wp_backstage_{$this->slug}_terms_list_table_query", array( $this, 'manage_list_table_query' ), 10 );
		add_action( "wp_backstage_{$this->slug}_terms_list_table_count_query", array( $this, 'manage_list_table_query' ), 10 );
		add_filter( 'parse_term_query', array( $this, 'add_list_table_query_actions' ), 0 );
		add_action( 'parse_term_query', array( $this, 'manage_filtering' ), 10 );
		add_action( 'parse_term_query', array( $this, 'manage_sorting' ), 10 );
		add_action( "after-{$this->slug}-table", array( $this, 'render_table_filter_form' ), 10 );
		add_action( 'admin_print_footer_scripts-edit-tags.php', array( $this, 'render_quick_edit_fields' ), 10 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_filter( 'pre_insert_term', array( $this, 'validate_term' ), 10, 3 );
		add_action( 'rest_api_init', array( $this, 'register_api_meta' ), 10 );
		add_filter( "rest_prepare_{$this->slug}", array( $this, 'prepare_rest_term' ), 10, 3 );
		add_action( 'current_screen', array( $this, 'add_help_tabs' ), 10 );

		parent::init();
	}

	/**
	 * Validate Term
	 *
	 * @since 3.5.1
	 * @param string|WP_Error $term     The term name to add, or a WP_Error object if there's an error.
	 * @param string          $taxonomy Taxonomy slug.
	 * @param array|string    $args     Array or query string of arguments passed to `wp_insert_term()`.
	 * @return string|WP_Error The original term name or a new WP_Error.
	 */
	public function validate_term( string|WP_Error $term, string $taxonomy, array|string $args ): string|WP_Error {

		if ( $taxonomy === $this->slug ) {
			$args   = wp_parse_args( $args );
			$fields = $this->get_fields_by_query( array( 'quick_add' => true ) );

			foreach ( $fields as $field ) {

				if ( ! empty( $args[ $field['name'] ] ) ) {

					$field_class = $this->get_field_class( $field['type'] );
					$validation  = $field_class->validate( $field, $args[ $field['name'] ] );

					if ( is_wp_error( $validation ) ) {
						return $validation;
					}
				}
			}
		}

		return $term;
	}

	/**
	 * Prepare Rest Term
	 *
	 * This method is responsible for preparing the REST API response for the term before it is
	 * sent out to the consumer. "Links" are added for the fields that reference another content
	 * type (posts, attachments, users, etc.), allowing for the content to be embedded if requested.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/ Extending the REST API
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/ Modifying Responses
	 * @link https://developer.wordpress.org/reference/classes/wp_rest_response/add_link/ WP_REST_Response::add_link()
	 *
	 * @since 3.4.0
	 * @param WP_REST_Response $response The current API response.
	 * @param WP_Term          $term     The requested term.
	 * @param WP_REST_Request  $request  The current API request.
	 * @return WP_REST_Response The filtered API response.
	 */
	public function prepare_rest_term( WP_REST_Response $response, WP_Term $term, WP_REST_Request $request ): WP_REST_Response {

		$fields = $this->get_fields_by_query( array( 'show_in_rest' => true ) );

		foreach ( $fields as $field ) {

			$value       = get_term_meta( $term->term_id, $field['name'], true );
			$field_class = $this->get_field_class( $field['type'] );
			$response    = $field_class->add_rest_api_link( $response, $field, $value );

		}

		return $response;
	}

	/**
	 * Manage Term Updated Messages
	 *
	 * @since 3.4.0
	 * @param array $messages An arry of currently set messages.
	 * @return array $messages An array of filtered messages.
	 */
	public function manage_term_updated_messages( array $messages ): array {
		global $taxonomy;
		$taxonomy_obj = get_taxonomy( $taxonomy );

		$term_added = sprintf(
			/* translators: 1: taxonomy singular name. */
			_x( '%1$s added.', 'term updated messages - added singular', 'wp_backstage' ),
			$taxonomy_obj->labels->singular_name
		);
		$term_deleted = sprintf(
			/* translators: 1: taxonomy singular name. */
			_x( '%1$s deleted.', 'term updated messages - deleted singular', 'wp_backstage' ),
			$taxonomy_obj->labels->singular_name
		);
		$term_updated = sprintf(
			/* translators: 1: taxonomy singular name. */
			_x( '%1$s updated.', 'term updated messages - updated singular', 'wp_backstage' ),
			$taxonomy_obj->labels->singular_name
		);
		$term_not_added = sprintf(
			/* translators: 1: taxonomy singular name. */
			_x( '%1$s not added.', 'term updated messages - not added singular', 'wp_backstage' ),
			$taxonomy_obj->labels->singular_name
		);
		$term_not_updated = sprintf(
			/* translators: 1: taxonomy singular name. */
			_x( '%1$s not updated.', 'term updated messages - not updated singular', 'wp_backstage' ),
			$taxonomy_obj->labels->singular_name
		);
		$terms_deleted = sprintf(
			/* translators: 1: taxonomy plural name. */
			_x( '%1$s deleted.', 'term updated messages - deleted plural', 'wp_backstage' ),
			$taxonomy_obj->labels->name
		);

		$messages[ $this->slug ] = array(
			0 => $messages['_item'][0], // unused, messages start at index 1.
			1 => $term_added,
			2 => $term_deleted,
			3 => $term_updated,
			4 => $term_not_added,
			5 => $term_not_updated,
			6 => $terms_deleted,
		);

		return $messages;
	}

	/**
	 * Add Help Tabs
	 *
	 * Registers the help tabs.
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
	 * @since   3.4.0
	 * @param   WP_Screen $screen  an instance of `WP_Screen`.
	 */
	public function add_help_tabs( WP_Screen $screen ) {

		if ( $this->is_screen( 'base', 'edit-tags', $screen ) && $this->is_screen( 'taxonomy', $this->slug, $screen ) ) {

			$taxonomy_obj = get_taxonomy( $screen->taxonomy );

			if ( $this->add ) {

				// Overview help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_overview',
						'title'    => _x( 'Overview', 'taxonomy overview help tab - title', 'wp_backstage' ),
						'priority' => 90,
						'callback' => array( $this, 'render_overview_help_tab' ),
					)
				);
				// Adding terms help tab.
				$screen->add_help_tab(
					array(
						'id'       => 'wp_backstage_adding_terms',
						'title'    => sprintf(
							/* translators: 1: taxonomy plural name. */
							_x( 'Adding %1$s', 'taxonomy adding terms help tab - title', 'wp_backstage' ),
							$taxonomy_obj->labels->name
						),
						'priority' => 90,
						'callback' => array( $this, 'render_adding_terms_help_tab' ),
					)
				);

			}
			// REST API preview help tab.
			$screen->add_help_tab(
				array(
					'id'       => 'wp_backstage_rest_api_preview',
					'title'    => _x( 'REST API', 'taxonomy collection rest api help tab - title', 'wp_backstage' ),
					'priority' => 90,
					'callback' => array( $this, 'render_rest_api_collection_preview_help_tab' ),
				)
			);

		} elseif ( $this->is_screen( 'base', 'term', $screen ) && $this->is_screen( 'taxonomy', $this->slug, $screen ) ) {

			// REST API preview help tab.
			$screen->add_help_tab(
				array(
					'id'       => 'wp_backstage_rest_api_preview',
					'title'    => _x( 'REST API', 'taxonomy rest api help tab - title', 'wp_backstage' ),
					'priority' => 90,
					'callback' => array( $this, 'render_rest_api_preview_help_tab' ),
				)
			);
		}
	}

	/**
	 * Render Adding Terms Help Tab
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current WP_Screen instance.
	 * @param array     $args   An array of help tab arguments.
	 */
	public function render_adding_terms_help_tab( WP_Screen $screen, array $args ) {
		$taxonomy_obj = get_taxonomy( $screen->taxonomy );
		$bullets      = array();

		// Explain the name field.
		$bullets[] = _x( '<strong>Name</strong> — The name is how it appears on your site.', '', 'wp_backstage' );
		// Explain the slug field.
		$bullets[] = _x( '<strong>Slug</strong> — The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', '', 'wp_backstage' );
		// If the taxonomy is hierarchical, explain parent selection.
		if ( $taxonomy_obj->hierarchical ) {
			$bullets[] = sprintf(
				/* translators: 1: taxonomy plural name, 2: taxonomy singular name. */
				_x( '<strong>Parent</strong> — %1$s can have a hierarchy. You can create a more general parent %2$s, and under that optional child %1$s for more refinement. To create a child %2$s, just choose another %2$s from the Parent dropdown.', '', 'wp_backstage' ),
				$taxonomy_obj->labels->name,
				$taxonomy_obj->labels->singular_name
			);
		}
		// Explain the description.
		$bullets[] = _x( '<strong>Description</strong> — The description is not prominent by default; however, some themes may display it.', '', 'wp_backstage' );
		// field bullets.
		$fields = $this->get_fields();
		foreach ( $fields as $field ) {
			$field     = wp_parse_args( $field, $this->default_field_args );
			$bullets[] = sprintf(
				'<strong>%1$s</strong> — %2$s',
				$field['label'],
				! empty( $field['help'] ) ? $field['help'] : $field['description']
			);
		}

		$content = sprintf(
			/* translators: 1: taxonomy singular name. */
			_x( 'When adding a new %1$s on this screen, you\'ll fill in the following fields:', 'taxonomy adding terms help tab - overview', 'wp_backstage' ),
			$taxonomy_obj->labels->singular_name
		);

		$screen_options = sprintf(
			/* translators: 1: taxonomy plural name. */
			_x( 'You can change the display of this screen using the Screen Options tab to set how many %1$s are displayed per screen and to display/hide columns in the table.', 'taxonomy adding terms help tab - screen options', 'wp_backstage' ),
			$taxonomy_obj->labels->name
		);

		/**
		 * Fires before the taxonomy adding terms help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_adding_terms_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Filters the bullets printed in the taxonomy adding terms help tab.
		 *
		 * @since   3.4.0
		 * @param   array      $bullets  An array of bullet strings.
		 * @param   WP_Screen  $screen   the current instance of the WP_Screen object.
		 * @param   array      $args     An array of help tab arguments.
		 * @return  array      The filtered array of bullet strings.
		 */
		$bullets = apply_filters( 'wp_backstage_taxonomy_adding_terms_help_tab_bullets', $bullets, $screen, $args );

		if ( ! empty( $bullets ) ) { ?>
			<ul>
				<?php foreach ( $bullets as $bullet ) { ?>
					<li><?php echo wp_kses( $bullet, 'wp_backstage_help_list_item' ); ?></li>
				<?php } ?>
			</ul>
		<?php }

		echo wp_kses_post( wpautop( $screen_options ) );

		/**
		 * Fires after the taxonomy adding terms help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_adding_terms_help_tab_after', $screen, $args );
	}

	/**
	 * Render Overview Help Tab
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current WP_Screen instance.
	 * @param array     $args   An array of help tab arguments.
	 */
	public function render_overview_help_tab( WP_Screen $screen, array $args ) {
		$taxonomy_obj = get_taxonomy( $screen->taxonomy );

		$post_type_links = array();
		if ( isset( $taxonomy_obj->object_type ) && ! empty( $taxonomy_obj->object_type ) ) {
			foreach ( $taxonomy_obj->object_type as $post_type ) {
				$post_type_obj      = get_post_type_object( $post_type );
				$edit_post_type_url = add_query_arg(
					array(
						'post_type' => $post_type_obj->name,
					),
					admin_url( '/edit.php' )
				);
				$post_type_links[]  = sprintf(
					'<a href="%1$s">%2$s</a>',
					$edit_post_type_url,
					$post_type_obj->labels->name,
				);
			}
		}

		$content = sprintf(
			/* translators: 1: taxonomy plural name. */
			_x( 'You can use %1$s to define sections of your site and group related content.', 'taxonomy overview help tab - overview', 'wp_backstage' ),
			$taxonomy_obj->labels->name
		);

		if ( ! empty( $post_type_links ) ) {
			if ( ! empty( $content ) ) {
				$content .= '<br/><br/>';
			}
			$content .= sprintf(
				/* translators: 1: taxonomy plural name, 2: post type links. */
				_x( '%1$s can be used to organize items from their related post types: %2$s', 'taxonomy overview help tab - post types', 'wp_backstage' ),
				$taxonomy_obj->labels->name,
				implode( ', ', $post_type_links )
			);
		}

		/**
		 * Fires before the taxonomy overview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_overview_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( $content ) );

		/**
		 * Fires after the taxonomy overview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_overview_help_tab_after', $screen, $args );
	}

	/**
	 * Render REST API Preview Help Tab
	 *
	 * @since 3.4.0
	 * @param WP_Screen $screen The current WP_Screen instance.
	 * @param array     $args   An array of help tab arguments.
	 */
	public function render_rest_api_preview_help_tab( WP_Screen $screen, array $args ) {
		// phpcs:ignore WordPress.Security.NonceVerification
		$params       = wp_unslash( $_GET );
		$term_id      = isset( $params['tag_ID'] ) ? absint( $params['tag_ID'] ) : 0;
		$taxonomy_obj = get_taxonomy( $screen->taxonomy );
		$path         = sprintf( '/%1$s/%2$s/%3$d', $taxonomy_obj->rest_namespace, $taxonomy_obj->rest_base, $term_id );

		/**
		 * Fires before the taxonomy REST API preview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_rest_api_preview_help_tab_before', $screen, $args );

		echo wp_kses_post( wpautop( _x( '<strong>REST API</strong> ― Preview the WordPress REST API response for this term. All contexts can be previewed including <code>view</code>, <code>embed</code>, and <code>edit</code>. The <code>_embed</code> flag can be also be enabled by checking the checkbox to preview embedded records.', 'taxonomy rest api preview help tab - title', 'wp_backstage' ) ) );
		$this->render_rest_api_preview( $path );

		/**
		 * Fires after the taxonomy REST API preview help tab content.
		 *
		 * @since  3.4.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_rest_api_preview_help_tab_after', $screen, $args );
	}

	/**
	 * Render REST API Collection Preview Help Tab
	 *
	 * @since 4.0.0
	 * @param WP_Screen $screen The current WP_Screen instance.
	 * @param array     $args   An array of help tab arguments.
	 */
	public function render_rest_api_collection_preview_help_tab( WP_Screen $screen, array $args ) {
		$taxonomy_obj = get_taxonomy( $screen->taxonomy );
		$path         = sprintf( '/%1$s/%2$s', $taxonomy_obj->rest_namespace, $taxonomy_obj->rest_base );

		/**
		 * Fires before the taxonomy REST API collection preview help tab content.
		 *
		 * @since  4.0.
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_rest_api_collection_preview_help_tab_before', $screen, $args );

		echo wp_kses_post(
			wpautop(
				sprintf(
					/* translators: 1: taxonomy plural name. */
					_x( '<strong>REST API</strong> ― Preview the WordPress REST API response for the %1$s collection. All contexts can be previewed including <code>view</code>, <code>embed</code>, and <code>edit</code>. The <code>_embed</code> flag can also be enabled by checking the checkbox to preview embedded records.', 'taxonomy rest api collection help tab - title', 'wp_backstage' ),
					$taxonomy_obj->labels->name
				)
			)
		);
		$this->render_rest_api_preview( $path );

		/**
		 * Fires after the taxonomy REST API collection preview help tab content.
		 *
		 * @since  4.0.0
		 * @param  WP_Screen  $screen the current instance of the WP_Screen object.
		 * @param  array      $args An array of help tab arguments.
		 */
		do_action( 'wp_backstage_taxonomy_rest_api_collection_preview_help_tab_after', $screen, $args );
	}

	/**
	 * Register API Meta
	 *
	 * This method is responsible for registering the term meta fields with the REST API,
	 * and generating the schema for each.
	 *
	 * @since 3.4.0
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

			register_term_meta(
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
	 * Render Table Filter Form
	 *
	 * This method is responsible for rendering the filter form at the top of the admin taxonomy list table.
	 * Because the taxonomy list table does not have filters, it is necessary to add the filter action submit
	 * button here. The taxonomy table class provides no hooks to render the filters into the form. The class
	 * also renders a form with the method of "post", unlike all the other table forms which use "get". Because
	 * of these caveats, it is necessary to both render the fields underneath the table, which is outside the form,
	 * and to add some javascript to both move the form into the proper area; as well as add some javascript that
	 * will handle submit.
	 *
	 * @since 3.1.0
	 * @param string $taxonomy The taxonomy of the current screen.
	 */
	public function render_table_filter_form( string $taxonomy ) { ?>

		<div id="wp-backstage-taxonomy-table-filters" class="align-left actions">

			<?php $this->render_table_filter_controls(); ?>

			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput
			echo get_submit_button(
				_x( 'Filter', 'taxonomy table filter - submit', 'wp_backstage' ),
				'',
				'filter_action',
				false,
				array(
					'id' => 'taxonomy-query-submit',
				)
			); ?>

		</div>

		<script type="text/javascript">
			(function() {

				function moveForm() {
					var extraActions = document.getElementById('wp-backstage-taxonomy-table-filters');
					var tableNavTop = document.querySelector('.tablenav.top');
					var tableCountTop = tableNavTop.querySelector('.tablenav-pages');
					tableNavTop.insertBefore(extraActions, tableCountTop);
				}

				function handleSubmitButtonClick(e) {
					e.preventDefault();
					e.stopPropagation();
					var params = new URLSearchParams(window.location.search);
					var formData = new FormData(e.target.form);
					formData.forEach(function(value, key) {
						params.set(key, value);
					});
					params.set('paged', '1');
					params.delete('_wpnonce');
					params.delete('_wp_http_referer');
					params.delete('action');
					params.delete('action2');
					window.location.search = params.toString();
				}

				function initSubmitButton() {
					var submitButton = document.getElementById('taxonomy-query-submit');
					submitButton.addEventListener('click', handleSubmitButtonClick);
				}

				initSubmitButton();
				moveForm();

			}());
		</script>

	<?php }

	/**
	 * Register
	 *
	 * This method does the actual registration of the taxonomy. It will set
	 * everything needed to extend WordPress to allow for our new taxonomy such
	 * as adding all the labels, setting the rewrite rules and REST API base,
	 * and configures the WP admin UI.
	 *
	 * @link   https://developer.wordpress.org/reference/functions/register_taxonomy/ register_taxonomy()
	 * @link   https://developer.wordpress.org/reference/classes/wp_taxonomy/ WP_Taxonomy
	 *
	 * @since  0.0.1
	 */
	public function register() {

		$labels = array(
			'name'                       => $this->args['plural_name'],
			'singular_name'              => $this->args['singular_name'],
			'menu_name'                  => $this->args['plural_name'],
			'all_items'                  => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'All %1$s', 'taxonomy labels - all items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'parent_item'                => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Parent %1$s', 'taxonomy labels - parent item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'parent_item_colon'          => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Parent %1$s:', 'taxonomy labels - parent item colon', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'new_item_name'              => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'New %1$s Name', 'taxonomy labels - new item name', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'add_new_item'               => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Add New %1$s', 'taxonomy labels - add new item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'edit_item'                  => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Edit %1$s', 'taxonomy labels - edit item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'update_item'                => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Update %1$s', 'taxonomy labels - update item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'view_item'                  => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'View %1$s', 'taxonomy labels - view item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'separate_items_with_commas' => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Separate %1$s with commas', 'taxonomy labels - separate items with commas', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'add_or_remove_items'        => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Add or remove %1$s', 'taxonomy labels - add or remove items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'choose_from_most_used'      => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Choose from the most used %1$s', 'taxonomy labels - choose from most used', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'popular_items'              => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Popular %1$s', 'taxonomy labels - popular items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'search_items'               => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Search %1$s', 'taxonomy labels - search items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'not_found'                  => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'No %1$s Found', 'taxonomy labels - not found', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'no_terms'                   => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'No %1$s', 'taxonomy labels - no terms', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'items_list'                 => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( '%1$s list', 'taxonomy labels - items list', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'items_list_navigation'      => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( '%1$s list navigation', 'taxonomy labels - items list navigation', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'back_to_items'              => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( '&larr; Go to %1$s', 'taxonomy labels - back to items', 'wp_backstage' ),
				$this->args['plural_name']
			),
		);

		$rewrite = array(
			'slug'         => $this->args['archive_base'],
			'with_front'   => $this->args['with_front'],
			'hierarchical' => $this->args['hierarchical'],
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => $this->args['hierarchical'],
			'public'            => $this->args['public'],
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => $this->args['public'],
			'show_tagcloud'     => $this->args['public'],
			'rewrite'           => $this->args['public'] ? $rewrite : false,
			'show_in_rest'      => ( $this->args['public'] && ! empty( $this->args['rest_base'] ) ),
			'rest_base'         => $this->args['rest_base'],
		);

		register_taxonomy( $this->slug, $this->args['post_types'], $args );
	}

	/**
	 * Get Fields
	 *
	 * @since   0.0.1
	 * @return  array  An array of field arguments if there are any, or an empty array.
	 */
	protected function get_fields(): array {
		return $this->args['fields'];
	}

	/**
	 * Render Add Fields
	 *
	 * This will render all fields on the taxonomy management screen. Note that
	 * this passes the taxonomy string, though this is not necessary, as this
	 * method is only hooked to `{taxonomy}_add_form_fields`. This means that
	 * this will only run on this instance's taxonomy.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/ {taxonomy}_add_form_fields
	 *
	 * @since   0.0.1
	 * @param   string $taxonomy The taxonomy slug as registered.
	 */
	public function render_add_fields( string $taxonomy ) {

		$fields = $this->get_fields_by_query( array( 'quick_add' => true ) );

		foreach ( $fields as $field ) {

			/**
			 * Filters the field arguments just before the field is rendered on the "Add" form.
			 *
			 * For consistency, this filter passes null as the last argument,
			 * in place of the taxonomy term object that would be passed on the
			 * "Edit" form.
			 *
			 * @since 0.0.1
			 *
			 * @param array $field an array of field arguments.
			 * @param null $term a placeholder for the term object, since there is none on the "Add" form.
			 */
			$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, null );

			$field_class = $this->get_field_class( $field['type'] );

			if ( $field_class->has_tag( 'text_control' ) ) {
				$field = $this->set_field_input_size( $field, 40 );
			}

			if ( $field_class->has_tag( 'select_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'postform' ) );
			}

			if ( $field_class->has_tag( 'textarea_control' ) ) {
				$field = $this->set_field_textarea_dimensions( $field, 5, 40 );
			} ?>

			<div class="<?php printf( 'form-field term-%1$s-wrap', esc_attr( $field_class->get_id( $field ) ) ); ?>"><?php

				/**
				 * Fires before the field is rendered on the "Add" form.
				 *
				 * For consistency, this filter passes null as the last argument,
				 * in place of the taxonomy term object that would be passed on the
				 * "Edit" form.
				 *
				 * @since 0.0.1
				 *
				 * @param array $field an array of field arguments.
				 * @param null $term a placeholder for the term object, since there is none on the "Add" form.
				 */
				do_action( "wp_backstage_{$this->slug}_field_add_before", $field, null );

				$this->render_field_label( $field );

				$field_class->render( $field );

				/**
				 * Fires after the field is rendered on the "Add" form.
				 *
				 * For consistency, this filter passes null as the last argument,
				 * in place of the taxonomy term object that would be passed on the
				 * "Edit" form.
				 *
				 * @since 0.0.1
				 *
				 * @param array $field an array of field arguments.
				 * @param null $term a placeholder for the term object, since there is none on the "Add" form.
				 */
				do_action( "wp_backstage_{$this->slug}_field_add_after", $field, null );

				$this->render_add_field_description( $field );

			?></div>

		<?php }
	}

	/**
	 * Render Edit Fields
	 *
	 * This will render all fields on the edit singular term screen. An instance
	 * of `WP_Term` is passed as the first argument. Note that this also passes
	 * the taxonomy string, though this is not necessary, as this method is only
	 * hooked to `{taxonomy}_edit_form_fields`. This means that this will only
	 * run on terms for this instance's taxonomy.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/ {taxonomy}_edit_form_fields
	 * @link    https://developer.wordpress.org/reference/classes/wp_term/ WP_Term
	 *
	 * @since   0.0.1
	 * @param   WP_Term $term     An instance of `WP_Term`.
	 * @param   string  $taxonomy The taxonomy slug as registered.
	 */
	public function render_edit_fields( WP_Term $term, string $taxonomy ) {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			$field['value'] = get_term_meta( $term->term_id, $field['name'], true );

			/**
			 * Filters the field arguments just before the field is rendered on the "Edit" form.
			 *
			 * @since 0.0.1
			 *
			 * @param array $field an array of field arguments.
			 * @param WP_Term $term The current taxonomy term.
			 */
			$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $term );

			$field_class = $this->get_field_class( $field['type'] );

			if ( $field_class->has_tag( 'text_control' ) ) {
				$field = $this->set_field_input_size( $field, 40 );
			}

			if ( $field_class->has_tag( 'select_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'postform' ) );
			}

			if ( $field_class->has_tag( 'textarea_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'large-text' ) );
				$field = $this->set_field_textarea_dimensions( $field, 5, 50 );
			} ?>

			<tr class="<?php printf( 'form-field term-%1$s-wrap', esc_attr( $field_class->get_id( $field ) ) ); ?>">

				<th scope="row">

					<?php if ( $field_class->has_tag( 'remove_label_for' ) ) { ?>

						<legend><?php
							$field_class->label( $field );
						?></legend>

					<?php } else { ?>

						<label for="<?php $field_class->element_id( $field ); ?>"><?php
							$field_class->label( $field );
						?></label>

					<?php } ?>

				</th>

				<td><?php

					/**
					 * Fires before the field is rendered on the "Edit" form.
					 *
					 * @since 0.0.1
					 *
					 * @param array $field an array of field arguments.
					 * @param WP_Term $term The current taxonomy term.
					 */
					do_action( "wp_backstage_{$this->slug}_field_edit_before", $field, $term );

					$field_class->render( $field );

					/**
					 * Fires after the field is rendered on the "Edit" form.
					 *
					 * @since 0.0.1
					 *
					 * @param array $field an array of field arguments.
					 * @param WP_Term $term The current taxonomy term.
					 */
					do_action( "wp_backstage_{$this->slug}_field_edit_after", $field, $term );

					$this->render_edit_field_description( $field );

				?></td>

			</tr>

		<?php }
	}

	/**
	 * Render Add Field Description
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 */
	protected function render_add_field_description( array $field ) {

		if ( ! empty( $field['description'] ) ) {

			$field_class = $this->get_field_class( $field['type'] ); ?>

			<p id="<?php $field_class->element_id( $field, 'description' ); ?>"><?php
				$field_class->description( $field );
			?></p>

		<?php }
	}

	/**
	 * Render Edit Field Description
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 */
	protected function render_edit_field_description( array $field ) {

		if ( ! empty( $field['description'] ) ) {

			$field_class = $this->get_field_class( $field['type'] ); ?>

			<p 
			class="description"
			id="<?php $field_class->element_id( $field, 'description' ); ?>"><?php
				$field_class->description( $field );
			?></p>

		<?php }
	}

	/**
	 * Render Quick Edit Fields
	 *
	 * Renders the shared quick edit template for this taxonomy. The field IDs
	 * use a placeholder token that is rewritten to the active term ID before the
	 * field scripts initialize.
	 *
	 * @since   4.0.0
	 */
	public function render_quick_edit_fields() {

		if ( ! $this->is_screen( 'base', 'edit-tags' ) || ! $this->is_screen( 'taxonomy', $this->slug ) ) {
			return;
		}

		$fields         = $this->get_fields_by_query( array( 'quick_edit' => true ) );
		$id_placeholder = '{{ term_id }}';

		if ( empty( $fields ) ) {
			return;
		} ?>

		<div
		hidden
		inert
		id="wp_backstage_taxonomy_quick_edit_template"
		data-id-placeholder="<?php echo esc_attr( $id_placeholder ); ?>">

			<fieldset class="wp-backstage-quick-edit">

				<div class="inline-edit-col">

					<?php foreach ( $fields as $field ) {

						$field['id'] = sprintf( '%1$s_%2$s', $field['name'], $id_placeholder );
						$field       = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, null );
						$field_class = $this->get_field_class( $field['type'] );

						if ( $field_class->has_tag( 'text_control' ) ) {
							$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
						}

						if ( $field_class->has_tag( 'textarea_control' ) ) {
							$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
							$field = $this->set_field_textarea_dimensions( $field, 5, 50 );
						} ?>

						<div
						class="wp-backstage-quick-edit__field"
						data-wp-backstage-field-name="<?php echo esc_attr( $field['name'] ); ?>"
						data-wp-backstage-field-type="<?php echo esc_attr( $field['type'] ); ?>">

							<span class="title">
								<?php $this->render_field_label( $field ); ?>
							</span>

							<span class="input-text-wrap"><?php

								/**
								 * Fires before the custom quick edit field is rendered.
								 *
								 * @since 0.0.1
								 *
								 * @param array         $field an array of field arguments.
								 * @param WP_Term|null  $term  the current term object if available.
								 */
								do_action( "wp_backstage_{$this->slug}_field_before", $field, null );

								$field_class->render( $field );

								/**
								 * Fires after the custom quick edit field is rendered.
								 *
								 * @since 0.0.1
								 *
								 * @param array         $field an array of field arguments.
								 * @param WP_Term|null  $term  the current term object if available.
								 */
								do_action( "wp_backstage_{$this->slug}_field_after", $field, null );

							?></span>

						</div>

					<?php } ?>

				</div>

			</fieldset>

		</div>

	<?php }

	/**
	 * Inline Quick Edit Data
	 *
	 * Appends JSON-encoded values for quick edit fields to the term row action
	 * markup so the quick edit template can hydrate itself without relying on
	 * visible custom columns.
	 *
	 * @since   4.0.0
	 * @param   array   $actions  An array of row action markup strings.
	 * @param   WP_Term $term     The current term.
	 * @return  array   The filtered row action array.
	 */
	public function inline_quick_edit_data( array $actions, WP_Term $term ): array {
		if ( current_user_can( 'edit_term', $term->term_id ) ) {
			$fields = $this->get_fields_by_query( array( 'quick_edit' => true ) );
			$values = array();
			foreach ( $fields as $field ) {
				$values[ $field['name'] ] = get_term_meta( $term->term_id, $field['name'], true );
			}
			$script = sprintf(
				'<script type="application/json" id="%1$s">%2$s</script>',
				esc_attr( "wp_backstage_quick_edit_data_{$term->term_id}" ),
				wp_json_encode( $values, JSON_HEX_TAG )
			);
			if ( isset( $actions['inline hide-if-no-js'] ) ) {
				$actions['inline hide-if-no-js'] .= $script;
			}
		}

		return $actions;
	}

	/**
	 * Capture Quick Edit Request Data
	 *
	 * Captures WP Backstage quick edit field values before core passes the full
	 * taxonomy quick edit payload into `wp_update_term()`. The captured values
	 * are removed from `$_POST` so core only receives term fields it understands.
	 *
	 * @since   4.0.0
	 */
	public function capture_quick_edit_request_data() {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			return;
		}
		if ( empty( $post_data ) ) {
			return;
		}
		if ( empty( $post_data['action'] ) || ( 'inline-save-tax' !== $post_data['action'] ) ) {
			return;
		}
		if ( empty( $post_data['taxonomy'] ) || ( sanitize_key( $post_data['taxonomy'] ) !== $this->slug ) ) {
			return;
		}
		if ( empty( $post_data['_inline_edit'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $post_data['_inline_edit'], 'taxinlineeditnonce' ) ) {
			return;
		}

		$fields = $this->get_fields_by_query( array( 'quick_edit' => true ) );

		if ( empty( $fields ) ) {
			return;
		}

		$this->quick_edit_data = array();

		foreach ( $fields as $field ) {

			if ( array_key_exists( $field['name'], $post_data ) ) {
				$this->quick_edit_data[ $field['name'] ] = $post_data[ $field['name'] ];
				unset( $_POST[ $field['name'] ] );
			}
		}
	}

	/**
	 * Save
	 *
	 * Saves the form data as individual keys.
	 *
	 * @todo    Document `$tt_id` better.
	 *
	 * @since   0.0.1
	 * @param   int $term_id The ID of the term being saved.
	 * @param   int $tt_id   The term taxonomy ID of the term being saved.
	 */
	public function save( int $term_id, int $tt_id ) {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( ! current_user_can( 'edit_term', $term_id ) ) {
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

		foreach ( $fields as $field ) {

			if ( isset( $post_data[ $field['name'] ] ) ) {

				$field_class = $this->get_field_class( $field['type'] );
				$value       = $field_class->sanitize( $post_data[ $field['name'] ] );

				update_term_meta( $term_id, $field['name'], $value );

			} else {

				delete_term_meta( $term_id, $field['name'] );

			}
		}
	}

	/**
	 * Save Quick Edit
	 *
	 * Saves quick edit field data without touching fields that are only available
	 * on the full add/edit term forms.
	 *
	 * @since   4.0.0
	 * @param   int $term_id The ID of the term being saved.
	 * @param   int $tt_id   The term taxonomy ID of the term being saved.
	 */
	public function save_quick_edit( int $term_id, int $tt_id ) {

		$request_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;
		$post_data    = is_array( $this->quick_edit_data ) ? $this->quick_edit_data : $request_data;

		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			return;
		}
		if ( ! current_user_can( 'edit_term', $term_id ) ) {
			return;
		}
		if ( empty( $request_data ) ) {
			return;
		}
		if ( empty( $request_data['action'] ) || ( 'inline-save-tax' !== $request_data['action'] ) ) {
			return;
		}
		if ( empty( $request_data['_inline_edit'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $request_data['_inline_edit'], 'taxinlineeditnonce' ) ) {
			return;
		}

		$fields = $this->get_fields_by_query( array( 'quick_edit' => true ) );

		foreach ( $fields as $field ) {

			if ( is_array( $post_data ) && array_key_exists( $field['name'], $post_data ) ) {

				$field_class = $this->get_field_class( $field['type'] );
				$value       = $field_class->sanitize( $post_data[ $field['name'] ] );

				update_term_meta( $term_id, $field['name'], $value );

			} else {

				delete_term_meta( $term_id, $field['name'] );

			}
		}
	}

	/**
	 * Manage Admin Column Content
	 *
	 * @since   0.0.1
	 * @param   string $content The already-set content for this column.
	 * @param   string $column  The column name.
	 * @param   int    $term_id The ID of the term for this row.
	 * @return  string  The populated column content for this column.
	 */
	public function manage_admin_column_content( string $content, string $column, int $term_id ): string {

		$field = $this->get_field( $column );

		if ( ! empty( $field ) ) {

			$value = get_term_meta( $term_id, $column, true );

			/**
			 * Filters the taxonomy custom field's admin column content.
			 *
			 * Returning any value here will short circuit the plugin's
			 * output and render this content instead.
			 *
			 * @since 0.0.1
			 *
			 * @param mixed $content the current content.
			 * @param array $field an array of field arguments.
			 * @param mixed $value the field's value.
			 * @param int $term_id The term ID of the current term.
			 */
			$content = apply_filters( "wp_backstage_{$this->slug}_{$column}_column_content", $content, $field, $value, $term_id );

			if ( ! empty( $content ) ) {
				return $content;
			}

			if ( ! empty( $value ) ) {

				ob_start();
				$field_class = $this->get_field_class( $field['type'] );
				$field_class->render_column( $field, $value );
				$content = ob_get_clean();

			} else {

				$content = '&horbar;';

			}
		}

		return $content;
	}

	/**
	 * Add List Table Query Action
	 *
	 * This method is responsible for adding an action to manage specifically the query that
	 * populates the terms list table on the edit taxonomy screens. Currently, there is no way
	 * in core to determine if a query is the main query for taxonomy edit screens. This is
	 * necessary in order to be able to modify the main query without polluting other term queries
	 * that may be on the page. It is safe to assume that the first `get_terms()` call that is
	 * relevant to this taxonomy on the edit screen is the main query that populates the table.
	 * This method also takes into account the main "count" query as well, which is a seperate call.
	 *
	 * @since 3.1.0
	 * @param WP_Term_Query $query The currently set `WP_Term_Query` instance.
	 */
	public function add_list_table_query_actions( WP_Term_Query $query ) {

		$query_taxonomy = $query->query_vars['taxonomy'];
		$is_taxonomy    = is_array( $query_taxonomy ) ? in_array( $this->slug, $query_taxonomy ) : ( $query_taxonomy === $this->slug );

		if ( $this->is_screen( 'id', $this->screen_id ) && $this->is_screen( 'base', 'edit-tags' ) && $is_taxonomy ) {

			if ( $query->query_vars['fields'] === 'count' ) {

				// If this is the first count query, it can be safely assumed that this is the query
				// that populates the total count at the top of the terms list table.
				if ( ! did_action( "wp_backstage_{$this->slug}_terms_list_table_count_query" ) ) {

					/**
					 * Fires when the term query is determined to be the one that populates the list table count.
					 *
					 * @since 3.1.0
					 *
					 * @param WP_Term_Query $query The currently set `WP_Term_Query` instance.
					 */
					do_action( "wp_backstage_{$this->slug}_terms_list_table_count_query", $query );
				}
			} else {

				// If this is the first query that is not a count query, it can be safely assumed that
				// the query is the main query that populates the terms list table.
				if ( ! did_action( "wp_backstage_{$this->slug}_terms_list_table_query" ) ) {

					/**
					 * Fires when the term query is determined to be the one that populates the list table rows.
					 *
					 * @since 3.1.0
					 *
					 * @param WP_Term_Query $query The currently set `WP_Term_Query` instance.
					 */
					do_action( "wp_backstage_{$this->slug}_terms_list_table_query", $query );
				}
			}
		}
	}

	/**
	 * Manage List Table Query Args
	 *
	 * This method is responsible for making the URL query fields available to the main `WP_Term_Query`.
	 * This allows for similar behavior to the query vars filter that is only available for posts. This
	 * method loops over the fields, and checks if the field key is a key of the URL query. If it is, it
	 * then adds the key and value to the args array to be passed to the `WP_Term_Query` that runs the main
	 * terms list table. This hooks to an action added by `WP_Backstage_Taxonomy::add_list_table_query_actions()`.
	 *
	 * @since 3.1.0
	 * @param WP_Term_Query $query The incoming `WP_Term_Query` instance.
	 */
	public function manage_list_table_query( WP_Term_Query $query ) {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			// phpcs:ignore WordPress.Security.NonceVerification
			$url_params = wp_unslash( $_GET );

			if ( isset( $url_params[ $field['name'] ] ) ) {
				$query->query_vars[ $field['name'] ] = $url_params[ $field['name'] ];
			}
		}
	}

	/**
	 * Manage Sorting
	 *
	 * The method is responsible for managing sorting on the query. If a field's
	 * name is found in the `orderby` key, then its key is added as the `meta_key`
	 * for the query, and the orderby is reset to either `meta_value` or `meta_value_num`
	 * according to if the value is expected to be numeric or not. If no meta query is set,
	 * this will add a meta query that filters for terms that either do or do not have the meta
	 * value set for the field. By default, setting just `meta_key` is not sufficient if the
	 * desire is to show terms that don't have a value as well.
	 *
	 * @since 3.1.0
	 * @param WP_Term_Query $query The currently set `WP_Term_Query` instance.
	 */
	public function manage_sorting( WP_Term_Query $query ) {

		$query_taxonomy = $query->query_vars['taxonomy'];
		$is_taxonomy    = is_array( $query_taxonomy ) ? in_array( $this->slug, $query_taxonomy ) : ( $query_taxonomy === $this->slug );

		if ( $is_taxonomy ) {

			$field = $this->get_field( $query->query_vars['orderby'] );

			if ( is_array( $field ) && ! empty( $field ) && $field['is_sortable'] ) {

				$field_class = $this->get_field_class( $field['type'] );
				$schema      = $field_class->get_schema();
				$is_numeric  = in_array( $schema['type'], array( 'number', 'integer' ) );

				if ( ! isset( $query->query_vars['meta_query'] ) || empty( $query->query_vars['meta_query'] ) ) {
					// phpcs:ignore WordPress.DB.SlowDBQuery
					$query->query_vars['meta_query'] = array(
						'relation' => 'OR',
						array(
							'key'     => $field['name'],
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => $field['name'],
							'compare' => 'EXISTS',
						),
					);
				} else {
					// phpcs:ignore WordPress.DB.SlowDBQuery
					$query->query_vars['meta_key'] = $field['name'];
				}

				if ( $is_numeric ) {
					$query->query_vars['orderby'] = 'meta_value_num';
				} else {
					$query->query_vars['orderby'] = 'meta_value';
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
	 * See `WP_Backstage_Taxonomy::manage_list_table_query()` to see how the fields are made
	 * available as public query vars.
	 *
	 * @since 3.1.0
	 * @param WP_Term_Query $query The currently set `WP_Term_Query` instance.
	 */
	public function manage_filtering( WP_Term_Query $query ) {

		$query_taxonomy = $query->query_vars['taxonomy'];
		$is_taxonomy    = is_array( $query_taxonomy ) ? in_array( $this->slug, $query_taxonomy ) : ( $query_taxonomy === $this->slug );

		if ( $is_taxonomy ) {

			$fields = $this->get_fields();

			if ( is_array( $fields ) && ! empty( $fields ) ) {

				$meta_query = array();

				foreach ( $fields as $field ) {

					if ( isset( $query->query_vars[ $field['name'] ] ) && ! empty( $query->query_vars[ $field['name'] ] ) ) {

						$meta_query[] = array(
							'key'     => $field['name'],
							'value'   => $query->query_vars[ $field['name'] ],
							'compare' => '=',
						);
					}
				}

				// If a non-empty meta query was prepared, add the "AND" relation
				// to the meta query and set it.
				if ( is_array( $meta_query ) && ! empty( $meta_query ) ) {
					$meta_query = array_merge( array( 'relation' => 'AND' ), $meta_query );
					// phpcs:ignore WordPress.DB.SlowDBQuery
					$query->query_vars['meta_query'] = $meta_query;
				}
			}
		}
	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Adds all generated fields to the hidden columns array by default, so as
	 * to not choke up the UI. Note that this will only work if this taxonomy's
	 * columns UI has never been modified by the user. Hooked to
	 * `default_hidden_columns`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/default_hidden_columns/ Hook: default_hidden_columns
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 *
	 * @since   0.0.1
	 * @since   4.0.0 Uses screen passed form hook to fix extra column display after quick edit.
	 * @since   3.0.0      Only add the field to hidden columns array if the field is set to have a column.
	 * @param   array     $hidden An array of hidden columns.
	 * @param   WP_Screen $screen An instance of `WP_Screen`.
	 * @return  array      An array of column names
	 */
	public function manage_default_hidden_columns( array $hidden, WP_Screen $screen ): array {

		if ( $this->is_screen( 'taxonomy', $this->slug, $screen ) ) {

			$fields = $this->get_fields();

			foreach ( $fields as $field ) {
				if ( $field['has_column'] ) {
					$hidden[] = $field['name'];
				}
			}
		}

		return $hidden;
	}
}
