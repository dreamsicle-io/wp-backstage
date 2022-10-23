<?php
/**
 * WP Backstage Taxonomy
 *
 * @since       0.0.1
 * @since       2.5.0  linted and formatted with phpcs
 * @package     wp-backstage
 * @subpackage  includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Taxonomy
 *
 * @since       0.0.1
 * @package     wp-backstage
 * @subpackage  includes
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
				'has_column'  => false,
				'is_sortable' => false,
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
					_x( '[taxonomy: %1$s] A slug is required when adding a new taxonomy.', 'taxonomy - required slug error', 'wp_backstage' ),
					$this->slug
				)
			);

		} elseif ( strlen( $this->slug ) > 32 ) {

			$this->errors[] = new WP_Error(
				'taxonomy_slug_length',
				sprintf(
					/* translators: 1: taxonomy slug. */
					_x( '[taxonomy: %1$s] A taxonomy slug must be between 1 and 32 characters.', 'taxonomy - slug length error', 'wp_backstage' ),
					$this->slug
				)
			);

		} elseif ( $this->new && in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error(
				'taxonomy_exists',
				sprintf(
					/* translators: 1: taxonomy slug, 2: method suggestion */
					_x( '[taxonomy: %1$s] A taxonomy with this slug already exists. Use the %2$s method to modify an existing taxonomy.', 'taxonomy - existing slug error', 'wp_backstage' ),
					$this->slug,
					'<code>WP_Backstage_Taxonomy::modify()</code>'
				)
			);

		} elseif ( ! $this->new && ! in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error(
				'taxonomy_not_exists',
				sprintf(
					/* translators: 1: taxonomy slug, 2: method suggestion */
					_x( '[taxonomy: %1$s] A taxonomy with this slug does not exist. Use the %2$s method to create a new taxonomy.', 'taxonomy - nonexisting slug error', 'wp_backstage' ),
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
							_x( '[taxonomy: %1$s] The %2$s key is required.', 'taxonomy - required arg error', 'wp_backstage' ),
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
		add_filter( 'terms_clauses', array( $this, 'manage_sorting' ), 10, 3 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );

		parent::init();

	}

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
				_x( 'All %1$s', 'taxonomy - all items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'parent_item'                => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Parent %1$s', 'taxonomy - parent item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'parent_item_colon'          => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Parent %1$s:', 'taxonomy - parent item colon', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'new_item_name'              => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'New %1$s Name', 'taxonomy - new item name', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'add_new_item'               => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Add New %1$s', 'taxonomy - add new item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'edit_item'                  => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Edit %1$s', 'taxonomy - edit item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'update_item'                => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'Update %1$s', 'taxonomy - update item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'view_item'                  => sprintf(
				/* translators: 1: Taxonomy singular name. */
				_x( 'View %1$s', 'taxonomy - view item', 'wp_backstage' ),
				$this->args['singular_name']
			),
			'separate_items_with_commas' => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Separate %1$s with commas', 'taxonomy - separate items with commas', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'add_or_remove_items'        => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Add or remove %1$s', 'taxonomy - add or remove items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'choose_from_most_used'      => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Choose from the most used %1$s', 'taxonomy - choose from most used', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'popular_items'              => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Popular %1$s', 'taxonomy - popular items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'search_items'               => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Search %1$s', 'taxonomy - search items', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'not_found'                  => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'No %1$s Found', 'taxonomy - not found', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'no_terms'                   => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'No %1$s', 'taxonomy - no terms', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'items_list'                 => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( '%1$s list', 'taxonomy - items list', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'items_list_navigation'      => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( '%1$s list navigation', 'taxonomy - items list navigation', 'wp_backstage' ),
				$this->args['plural_name']
			),
			'back_to_items'              => sprintf(
				/* translators: 1: Taxonomy plural name. */
				_x( 'Back to %1$s', 'taxonomy - back to items', 'wp_backstage' ),
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

			$values = array();

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
			 * @param array $field an array of field arguments.
			 * @param mixed $content the current content.
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
	 * Manage Sorting
	 *
	 * Adds sorting by parsing the `SQL` statements on the `parse_term_query`
	 * hook.
	 *
	 * @todo    Try to normalize this with other queryies by using `meta_query`.
	 *          If this is still not possible, Ensure term sorting does not
	 *          ignore those terms without the meta value logged in the termmeta
	 *          table.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/parse_term_query/ Hook: parse_term_query
	 *
	 * @since   0.0.1
	 * @since   2.5.0  Makes table alias unique in each run of the function to suppress sql warnings.
	 * @param   array $pieces      An array of query pieces that make up the `SQL` statement.
	 * @param   array $taxonomies  An array of taxonomy names that this query is handling.
	 * @param   array $args        An array of arguments.
	 * @return  array  The filtered query pieces with new sorting applied.
	 */
	public function manage_sorting( $pieces = array(), $taxonomies = array(), $args = array() ) {

		global $wpdb;
		$table_alias = uniqid( 'tm_' );

		if ( in_array( $this->slug, $taxonomies ) ) {

			// phpcs:ignore WordPress.Security.NonceVerification
			$get_data = ! empty( $_GET ) ? wp_unslash( $_GET ) : null;

			$orderby = isset( $get_data['orderby'] ) ? esc_attr( $get_data['orderby'] ) : '';

			if ( ! empty( $orderby ) ) {

				$field = $this->get_field_by( 'name', $orderby );

				if ( is_array( $field ) && ! empty( $field ) ) {

					if ( $field['has_column'] && $field['is_sortable'] ) {

						$pieces['join']  .= ' INNER JOIN ' . $wpdb->termmeta . ' AS ' . $table_alias . ' ON t.term_id = ' . $table_alias . '.term_id ';
						$pieces['where'] .= ' AND ' . $table_alias . '.meta_key = "' . esc_attr( $field['name'] ) . '" ';

						if ( $field['type'] === 'number' ) {
							$pieces['orderby'] = ' ORDER BY CAST(' . $table_alias . '.meta_value AS SIGNED) ';
						} else {
							$pieces['orderby'] = ' ORDER BY ' . $table_alias . '.meta_value ';
						}
					}
				}
			}
		}

		return $pieces;

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
	 * @since   2.5.0      Only add the field to hidden columns array if the field is set to have a column.
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
