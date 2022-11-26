<?php
/**
 * WP Backstage Taxonomy
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
 * WP Backstage Taxonomy
 *
 * @since       0.0.1
 */
class WP_Backstage_Taxonomy extends WP_Backstage_Component {

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
	 * @return  WP_Backstage_Taxonomy  A fully constructed instance of `WP_Backstage_User`.
	 */
	public static function add( $slug = '', $args = array() ) {

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
	 * @return  WP_Backstage_Taxonomy  A fully constructed instance of `WP_Backstage_User`.
	 */
	public static function modify( $slug = '', $args = array() ) {

		$component = new WP_Backstage_Taxonomy( $slug, $args, false );
		$component->init();
		return $component;

	}

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 * @since   2.0.0   Adds $new parameter for distinguishing between `add` and `modify` behavior.
	 * @param   string $slug  The developer-provided slug for the taxonomy.
	 * @param   array  $args  The developer-provided arguments for this instance.
	 * @param   bool   $new   Whether this instance constructs a new taxonomy or modifies an existing one.
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
		$this->new                = boolval( $new );
		$this->slug               = sanitize_key( $slug );
		$this->set_args( $args );
		$this->screen_id = sprintf( 'edit-%1$s', $this->slug );
		$this->nonce_key = sprintf( '_wp_backstage_taxonomy_%1$s_nonce', $this->slug );
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 *
	 * @since   0.0.1
	 * @param   array $args  The developer-provided arguments for this instance.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {

		$this->args = wp_parse_args( $args, $this->default_args );

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

		} elseif ( $this->new && in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error(
				'taxonomy_exists',
				sprintf(
					/* translators: 1: taxonomy slug, 2: method suggestion */
					_x( '[Taxonomy: %1$s] A taxonomy with this slug already exists. Use the %2$s method to modify an existing taxonomy.', 'taxonomy - existing slug error', 'wp_backstage' ),
					$this->slug,
					'<code>WP_Backstage_Taxonomy::modify()</code>'
				)
			);

		} elseif ( ! $this->new && ! in_array( $this->slug, get_taxonomies() ) ) {

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

		$required_args = ! $this->new ? $this->required_args_modify : $this->required_args;

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

	}

	/**
	 * Init
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Ensures a new taxonomy is only registered if adding a new one.
	 * @since   3.4.0  Adds help tabs, term update messages, and registers meta with the REST API.
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

		// Only perform these hooks and filters if the taxonomy is new.
		if ( $this->new ) {
			add_action( 'init', array( $this, 'register' ), 0 );
			add_filter( 'term_updated_messages', array( $this, 'manage_term_updated_messages' ), 10 );
		}
		add_action( sprintf( '%1$s_add_form_fields', $this->slug ), array( $this, 'render_add_nonce' ), 10 );
		add_action( sprintf( '%1$s_term_edit_form_top', $this->slug ), array( $this, 'render_edit_nonce' ), 10 );
		add_action( sprintf( '%1$s_add_form_fields', $this->slug ), array( $this, 'render_add_fields' ), 10 );
		add_action( sprintf( '%1$s_edit_form_fields', $this->slug ), array( $this, 'render_edit_fields' ), 10, 2 );
		add_action( sprintf( 'edited_%1$s', $this->slug ), array( $this, 'save' ), 10, 2 );
		add_action( sprintf( 'created_%1$s', $this->slug ), array( $this, 'save' ), 10, 2 );
		add_filter( sprintf( 'manage_edit-%1$s_columns', $this->slug ), array( $this, 'add_field_columns' ), 10 );
		add_filter( sprintf( 'manage_edit-%1$s_sortable_columns', $this->slug ), array( $this, 'manage_sortable_columns' ), 10 );
		add_filter( sprintf( 'manage_%1$s_custom_column', $this->slug ), array( $this, 'manage_admin_column_content' ), 10, 3 );
		add_filter( 'parse_term_query', array( $this, 'add_list_table_query_actions' ), 0 );
		add_action( "wp_backstage_{$this->slug}_terms_list_table_query", array( $this, 'manage_list_table_query' ), 10 );
		add_action( "wp_backstage_{$this->slug}_terms_list_table_count_query", array( $this, 'manage_list_table_query' ), 10 );
		add_action( 'parse_term_query', array( $this, 'manage_filtering' ), 10 );
		add_action( 'parse_term_query', array( $this, 'manage_sorting' ), 10 );
		add_action( "after-{$this->slug}-table", array( $this, 'render_table_filter_form' ), 10 );
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
	 * @param array|string    $args     Array or query string of arguments passed to wp_insert_term().
	 * @return string|WP_Error The original term name or a new WP_Error.
	 */
	public function validate_term( $term = '', $taxonomy = '', $args = array() ) {

		if ( $taxonomy === $this->slug ) {

			$fields = $this->get_fields();

			foreach ( $fields as $field ) {

				$field = wp_parse_args( $field, $this->default_field_args );

				if ( isset( $args[ $field['name'] ] ) ) {

					$value = $this->sanitize_field( $field, $args[ $field['name'] ] );

					// validate minimum.
					if ( isset( $field['input_attrs']['min'] ) ) {
						if ( floatval( $value ) < $field['input_attrs']['min'] ) {
							return new WP_Error( 'wp_backstage_term_validation', 'The value is less than the minimum' );
						}
					}
					// validate maximum.
					if ( isset( $field['input_attrs']['max'] ) ) {
						if ( floatval( $value ) > $field['input_attrs']['max'] ) {
							return new WP_Error( 'wp_backstage_term_validation', 'The value is greater than the maximum' );
						}
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
	 * @param WP_Term          $term The requested term.
	 * @param WP_REST_Request  $request The current API request.
	 * @return WP_REST_Response The filtered API response.
	 */
	public function prepare_rest_term( $response = null, $term = null, $request = null ) {

		$fields = $this->get_fields_by( 'show_in_rest', true );

		foreach ( $fields as $field ) {

			$value = get_term_meta( $term->term_id, $field['name'], true );

			$response = $this->add_rest_api_field_link( $response, $field, $value );
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
	public function manage_term_updated_messages( $messages = array() ) {
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
	 * @return  void
	 */
	public function add_help_tabs( $screen = null ) {

		if ( $screen->base === 'edit-tags' && $screen->taxonomy === $this->slug ) {

			if ( $this->new ) {

				$taxonomy_obj = get_taxonomy( $screen->taxonomy );

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
		} elseif ( $screen->base === 'term' && $screen->taxonomy === $this->slug ) {

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
	 * @param array     $args An array of help tab arguments.
	 * @return void
	 */
	public function render_adding_terms_help_tab( $screen = null, $args = array() ) {
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
					<li><?php echo wp_kses( $bullet, WP_Backstage::$kses_p ); ?></li>
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
	 * @param array     $args An array of help tab arguments.
	 * @return void
	 */
	public function render_overview_help_tab( $screen = null, $args = array() ) {
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
	 * @param array     $args An array of help tab arguments.
	 * @return void
	 */
	public function render_rest_api_preview_help_tab( $screen = null, $args = array() ) {
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
	 * Register API Meta
	 *
	 * This method is responsible for registering the term meta fields with the REST API,
	 * and generating the schema for each.
	 *
	 * @since 3.4.0
	 * @return void
	 */
	public function register_api_meta() {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			$schema = $this->get_field_schema( $field );

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
					'description'       => $field['label'],
					'type'              => $schema['type'],
					'single'            => true,
					'sanitize_callback' => array( $this, $this->get_sanitize_callback( $field ) ),
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
	 * @return void
	 */
	public function render_table_filter_form( $taxonomy = '' ) { ?>

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
	 * @return void
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
	protected function get_fields() {

		$fields = array();

		if ( is_array( $this->args['fields'] ) && ! empty( $this->args['fields'] ) ) {

			foreach ( $this->args['fields'] as $field ) {

				$fields[] = wp_parse_args( $field, $this->default_field_args );

			}
		}

		return $fields;

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
	 * @param   string $taxonomy  The taxonomy slug as registered.
	 * @return  void
	 */
	public function render_add_fields( $taxonomy = '' ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows                 = ( $field['type'] === 'textarea' ) ? 5 : 10;
					$default_cols                 = 40;
					$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $default_cols;
				}

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
				$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, null ); ?>

				<div class="form-field"><?php

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

					$this->render_field_by_type( $field );

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

				?></div>

			<?php }
		}

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
	 * @param   WP_Term $term      An instance of `WP_Term`.
	 * @param   string  $taxonomy  The taxonomy slug as registered.
	 * @return  void
	 */
	public function render_edit_fields( $term = null, $taxonomy = null ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				$field['value']      = get_term_meta( $term->term_id, $field['name'], true );
				$field['show_label'] = false;
				$input_class         = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows                  = ( $field['type'] === 'textarea' ) ? 5 : 10;
					$default_cols                  = 40;
					$field['input_attrs']['rows']  = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols']  = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $default_cols;
					$field['input_attrs']['class'] = sprintf( 'large-text %1$s', $input_class );
				}

				/**
				 * Filters the field arguments just before the field is rendered on the "Edit" form.
				 *
				 * @since 0.0.1
				 *
				 * @param array $field an array of field arguments.
				 * @param WP_Term $term The current taxonomy term.
				 */
				$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $term ); ?>

				<tr class="form-field">

					<th scope="row">

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

						/**
						 * Fires before the field is rendered on the "Edit" form.
						 *
						 * @since 0.0.1
						 *
						 * @param array $field an array of field arguments.
						 * @param WP_Term $term The current taxonomy term.
						 */
						do_action( "wp_backstage_{$this->slug}_field_edit_before", $field, $term );

						$this->render_field_by_type( $field, $term );

						/**
						 * Fires after the field is rendered on the "Edit" form.
						 *
						 * @since 0.0.1
						 *
						 * @param array $field an array of field arguments.
						 * @param WP_Term $term The current taxonomy term.
						 */
						do_action( "wp_backstage_{$this->slug}_field_edit_after", $field, $term );

					?></td>

				</tr>

			<?php }
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
	 * @param   int $term_id  The ID of the term being saved.
	 * @param   int $tt_id    the tt ID of the term being saved.
	 * @return  void
	 */
	public function save( $term_id = 0, $tt_id = 0 ) {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( ! current_user_can( 'manage_categories' ) ) {
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

			foreach ( $fields as $field ) {

				if ( isset( $post_data[ $field['name'] ] ) ) {

					$value = $this->sanitize_field( $field, $post_data[ $field['name'] ] );

					update_term_meta( $term_id, $field['name'], $value );

				} else {

					delete_term_meta( $term_id, $field['name'] );

				}
			}
		}

	}

	/**
	 * Manage Admin Column Content
	 *
	 * @since   0.0.1
	 * @param   string $content  The already-set content for this column.
	 * @param   string $column   The column name.
	 * @param   int    $term_id  The ID of the term for this row.
	 * @return  string  The populated column content for this column.
	 */
	public function manage_admin_column_content( $content = '', $column = '', $term_id = 0 ) {

		$field = $this->get_field_by( 'name', $column );

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
	 * @return void
	 */
	public function add_list_table_query_actions( $query = null ) {

		if ( is_admin() && in_array( $this->slug, $query->query_vars['taxonomy'] ) ) {

			if ( $this->is_screen( 'id', $this->screen_id ) && $this->is_screen( 'base', 'edit-tags' ) ) {

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
	 * @return void
	 */
	public function manage_list_table_query( $query = null ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				// phpcs:ignore WordPress.Security.NonceVerification
				$url_params = wp_unslash( $_GET );

				if ( isset( $url_params[ $field['name'] ] ) ) {
					$query->query_vars[ $field['name'] ] = $url_params[ $field['name'] ];
				}
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
	 * @return void
	 */
	public function manage_sorting( $query = null ) {

		if ( in_array( $this->slug, $query->query_vars['taxonomy'] ) ) {

			$field = $this->get_field_by( 'name', $query->query_vars['orderby'] );

			if ( is_array( $field ) && ! empty( $field ) ) {

				if ( $field['is_sortable'] ) {

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

					if ( $field['type'] === 'number' ) {

						$query->query_vars['orderby'] = 'meta_value_num';

					} else {

						$query->query_vars['orderby'] = 'meta_value';

					}
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
	 * @return void
	 */
	public function manage_filtering( $query = null ) {

		if ( in_array( $this->slug, $query->query_vars['taxonomy'] ) ) {

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
	 * @since   3.0.0      Only add the field to hidden columns array if the field is set to have a column.
	 * @param   array     $hidden  An array of hidden columns.
	 * @param   WP_Screen $screen  An instance of `WP_Screen`.
	 * @return  array      An array of column names
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $this->is_screen( 'taxonomy', $this->slug ) ) {

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

}
