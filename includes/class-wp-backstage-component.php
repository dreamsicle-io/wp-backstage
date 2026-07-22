<?php
/**
 * WP Backstage Component
 *
 * @since       0.0.1
 * @since       3.0.0  linted and formatted with phpcs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Component
 *
 * @since       0.0.1
 */
class WP_Backstage_Component {

	/**
	 * Slug
	 *
	 * This is the main text identifier of the instance. It is alpha-numeric and
	 * only contains lowercase letters, underscores and hyphens. The slug is used
	 * when building nonces, creating dynamic hooks, and registering post types,
	 * taxonomies, and options pages. Note that on instances of `WP_Backstage_User`,
	 * the slug is set to `user`. The slug is sanitized using WordPress's
	 * `sanitize_key()` function that is used when sanitizing
	 * slugs.
	 *
	 * @link https://developer.wordpress.org/reference/functions/sanitize_key/ sanitize_key()
	 *
	 * @since  0.0.1
	 * @var    string  $slug  the text slug that identifies the instance.
	 */
	protected string $slug = '';

	/**
	 * Args
	 *
	 * @since 0.0.1
	 * @var array $args An array of component arguments.
	 */
	protected array $args = array();

	/**
	 * Errors
	 *
	 * @since  0.0.1
	 * @var    array  $errors  The array of all errors on the instance.
	 */
	protected array $errors = array();

	/**
	 * Screen ID
	 *
	 * @link  https://developer.wordpress.org/reference/functions/get_current_screen/ get_current_screen()
	 *
	 * @since  0.0.1
	 * @var    string|array  $screen_id  The screen ID or IDs that apply to this instance.
	 */
	protected string|array $screen_id = '';

	/**
	 * Default Field Args
	 *
	 * @since  0.0.1
	 * @since  3.4.0  Added `show_in_rest` argument.
	 * @var    array  $default_field_args  An array of default field args.
	 */
	protected array $default_field_args = array(
		'id'           => '',
		'type'         => 'text',
		'name'         => '',
		'label'        => '',
		'value'        => null,
		'description'  => '',
		'help'         => '',
		'show_label'   => true,
		'show_in_rest' => false,
		'options'      => array(),
		'input_attrs'  => array(),
		'args'         => array(),
	);

	/**
	 * Required Field Args
	 *
	 * @since  4.0.0
	 * @var    array  $required_field_args  An array of required field argument keys.
	 */
	protected array $required_field_args = array(
		'name',
	);

	/**
	 * Default Filter Control Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_filter_control_args  The default filter control args for this instance.
	 */
	protected array $default_filter_control_args = array(
		'name'              => '',
		'value'             => null,
		'label'             => '',
		'option_none_label' => '',
		'options'           => array(), // Array of options or string of formatted HTML options.
	);

	/**
	 * Default Option Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_option_args  An array of default option arguments.
	 */
	protected array $default_option_args = array(
		'value'    => '',
		'label'    => '',
		'disabled' => false,
	);

	/**
	 * Filterable Fields
	 *
	 * @since  0.0.1
	 * @var    array  $filterable_fields  Field types that should have the `for` attribute removed labels.
	 */
	protected array $filterable_fields = array(
		'select',
		'radio',
		'select_posts',
		'select_users',
	);

	/**
	 * Nonce Key
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_nonce_field/ wp_nonce_field
	 * @link  https://codex.wordpress.org/WordPress_Nonces WP nonces
	 *
	 * @since  0.0.1
	 * @var    string  $nonce_key  The key for nonce fields.
	 */
	protected string $nonce_key = '_wp_backstage_nonce';

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 */
	protected function __construct() {
	}

	/**
	 * Has Errors
	 *
	 * A utility method to easily check if the instance has errors or not.
	 *
	 * @since   0.0.1
	 * @return  bool  Whether the instance has errors or not.
	 */
	public function has_errors(): bool {
		return is_array( $this->errors ) && ! empty( $this->errors );
	}

	/**
	 * Print Errors
	 *
	 * @link     https://developer.wordpress.org/reference/classes/wp_error/ WP_Error()
	 *
	 * @since   0.0.1
	 */
	public function print_errors() {

		if ( $this->has_errors() ) {

			foreach ( $this->errors as $error ) {

				if ( is_wp_error( $error ) ) {

					$message = sprintf(
						/* translators: 1: error message. */
						_x( 'Error: %1$s', 'component error message', 'wp_backstage' ),
						$error->get_error_message()
					); ?>

					<div class="notice notice-error">

						<p><?php

							echo wp_kses( $message, 'wp_backstage_error_message' );

						?></p>

					</div>

				<?php }
			}
		}
	}

	/**
	 * Set Errors
	 *
	 * Validates parsed field arguments that are required across all components.
	 *
	 * @since  4.0.0
	 */
	protected function set_errors() {

		foreach ( $this->get_fields() as $i => $field ) {

			$field = wp_parse_args( $field, $this->default_field_args );

			$identifier = "field ({$i})";
			if ( ! empty( $field['label'] ) ) {
				$identifier = $field['label'];
			} elseif ( ! empty( $field['name'] ) ) {
				$identifier = $field['name'];
			} elseif ( ! empty( $field['id'] ) ) {
				$identifier = $field['id'];
			}

			foreach ( $this->required_field_args as $required_field_arg ) {

				if ( empty( $field[ $required_field_arg ] ) ) {

					$this->errors[] = new WP_Error(
						'required_component_field_arg',
						sprintf(
							/* translators: 1: component slug, 2: field identifier, 3: required field arg key. */
							_x( '[Component: %1$s] Field "%2$s" requires the %3$s key.', 'component - required field arg error', 'wp_backstage' ),
							$this->slug,
							$identifier,
							'<code>' . $required_field_arg . '</code>'
						)
					);

				}
			}
		}
	}

	/**
	 * Is Screen
	 *
	 * A utility method to easily check values returned by `get_current_screen()`.
	 *
	 * @link     https://developer.wordpress.org/reference/functions/get_current_screen/ get_current_screen()
	 *
	 * @since   0.0.1
	 * @since   3.7.1 Returns false if `get_current_screen()` is not defined.
	 * @param   string         $key    The key of the `WP_Screen` object to check.
	 * @param   string|array   $value  The value or array of values to check.
	 * @param   WP_Screen|null $screen The passed in screen to check. Leave null to call `get_current_screen()`.
	 * @return  bool If the match was successful or not.
	 */
	protected function is_screen( string $key, string|array $value, ?WP_Screen $screen = null ): bool {

		$is_screen = false;

		if ( ! $screen && function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
		}

		if ( ! $screen ) {
			$is_screen = false;
		} elseif ( is_array( $value ) ) {
			$is_screen = in_array( $screen->$key, $value );
		} else {
			$is_screen = ( $value === $screen->$key );
		}

		return $is_screen;
	}

	/**
	 * Init
	 *
	 * Hook all methods to WordPress.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/add_action/ add_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ hook: admin_enqueue_scripts
	 * @link    https://developer.wordpress.org/reference/hooks/admin_notices/ hook: admin_notices
	 * @link    https://developer.wordpress.org/reference/hooks/admin_head/ hook: admin_head
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts/ hook: admin_print_footer_scripts
	 * @link    https://developer.wordpress.org/plugins/hooks/actions/ WP Actions
	 * @link    https://developer.wordpress.org/plugins/hooks/filters/ WP Filters
	 *
	 * @since 0.0.1
	 * @since 3.7.2 Moves code editor inline script to priority 20 to solve customizer "Additional CSS" panel bug.
	 * @since 4.0.0 Removes error checking of the `WP_Backstage` class as it no longer reports errors.
	 */
	public function init() {

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
		}
	}

	/**
	 * Render Edit nonce
	 *
	 * Renders a nonce with this instance's `$nonce_key` and the action set to
	 * `edit`.
	 *
	 * @since   0.0.1
	 */
	public function render_edit_nonce() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		wp_nonce_field( 'edit', $this->nonce_key );
	}

	/**
	 * Render Add nonce
	 *
	 * Renders a nonce with this instance's `$nonce_key` with the action set to
	 * `add`.
	 *
	 * @since   0.0.1
	 */
	public function render_add_nonce() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		wp_nonce_field( 'add', $this->nonce_key );
	}

	/**
	 * Add Field Input Classes
	 *
	 * @since 4.0.0
	 * @param array    $field An array of field arguments.
	 * @param string[] $more  Additional classes to merge into the field input classes.
	 * @return array A filtered list of field arguments.
	 */
	public function add_field_input_classes( array $field, array $more ): array {
		$classes = ! empty( $field['input_attrs']['class'] ) ? explode( ' ', $field['input_attrs']['class'] ) : array();
		foreach ( $more as $class ) {
			if ( ! empty( $class ) && ! in_array( $class, $classes ) ) {
				$classes[] = $class;
			}
		}
		$field['input_attrs']['class'] = implode( ' ', array_map( 'sanitize_html_class', $classes ) );
		return $field;
	}

	/**
	 * Set Field Textarea Dimensions
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param int   $rows  The textarea row count to apply when one is not already set.
	 * @param int   $cols  The textarea column count to apply when one is not already set.
	 * @return array A filtered list of field arguments.
	 */
	public function set_field_textarea_dimensions( array $field, int $rows, int $cols ): array {
		$field['input_attrs']['rows'] = ! empty( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $rows;
		$field['input_attrs']['cols'] = ! empty( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $cols;
		return $field;
	}

	/**
	 * Set Field Input Size
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param int   $size  The input size to apply when one is not already set.
	 * @return array A filtered list of field arguments.
	 */
	public function set_field_input_size( array $field, int $size ): array {
		$field['input_attrs']['size'] = ! empty( $field['input_attrs']['size'] ) ? $field['input_attrs']['size'] : $size;
		return $field;
	}

	/**
	 * Render Field Label
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 */
	protected function render_field_label( array $field ) {

		$field_class = $this->get_field_class( $field['type'] );

		if ( $field_class->has_tag( 'remove_label_for' ) ) { ?>

			<legend class="<?php echo $field_class->has_tag( 'hide_label' ) ? 'screen-reader-text' : ''; ?>"><?php
				$field_class->label( $field );
			?></legend>

		<?php } else { ?>

			<label 
			for="<?php $field_class->element_id( $field ); ?>"
			class="<?php echo $field_class->has_tag( 'hide_label' ) ? 'screen-reader-text' : ''; ?>"><?php
				$field_class->label( $field );
			?></label>

		<?php }
	}

	/**
	 * Render Field Description
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 */
	protected function render_field_description( array $field ) {

		if ( ! empty( $field['description'] ) ) {

			$field_class = $this->get_field_class( $field['type'] ); ?>

			<p id="<?php $field_class->element_id( $field, 'description' ); ?>"><?php
				$field_class->description( $field );
			?></p>

		<?php }
	}

	/**
	 * Get Fields
	 *
	 * @since   0.0.1
	 * @return  array  an array of field arg arrays.
	 */
	protected function get_fields(): array {
		return array();
	}

	/**
	 * Get Fields By Query
	 *
	 * Get all fields that matches the passed query array.
	 *
	 * @since   3.4.0
	 * @param   array $query  An array of key values to check against.
	 * @return  array   an array of field arg arrays if found, or an empty array.
	 */
	protected function get_fields_by_query( array $query ): array {

		$fields = $this->get_fields();
		$result = array();

		foreach ( $fields as $field ) {

			$matches_query = true;

			foreach ( $query as $key => $value ) {
				if ( ! isset( $field[ $key ] ) || ( $field[ $key ] !== $value ) ) {
					$matches_query = false;
					break;
				}
			}

			if ( $matches_query ) {
				$result[] = $field;
			}
		}

		return $result;
	}

	/**
	 * Get Field
	 *
	 * Get a field by name.
	 *
	 * @since   4.0.0
	 * @param   string $name The field's name to search for.
	 * @return  ?array The field if found.
	 */
	protected function get_field( string $name ): ?array {

		$fields = $this->get_fields();
		$result = null;

		foreach ( $fields as $field ) {
			if ( $field['name'] === $name ) {
				$result = $field;
				break;
			}
		}

		return $result;
	}

	/**
	 * Render Table Filter Controls
	 *
	 * This method is responsible for rendering the filter controls for fields. The fields will
	 * get their value from the parsed URL query parameters and set up arguments for the filter
	 * select as defined in `WP_Backstage_Component::render_table_filter_control()`.
	 *
	 * @since 3.1.0
	 */
	public function render_table_filter_controls() {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			$field_class = $this->get_field_class( $field['type'] );

			if ( $field['is_filterable'] && $field_class->has_tag( 'is_filterable' ) ) {

				// phpcs:ignore WordPress.Security.NonceVerification
				$url_params = wp_unslash( $_GET );

				$value = isset( $url_params[ $field['name'] ] ) ? $url_params[ $field['name'] ] : null;

				$args = $field_class->get_filter_args( $field, $value );

				$this->render_table_filter_control( $args );
			}
		}
	}

	/**
	 * Render Table Filter Control
	 *
	 * This method is responsible for rendering a single filter control according to the
	 * array of arguments passed in. This will always render an HTML `<select>` element
	 * and is constructed in the same way that the existing table filter controls are
	 * rendered in core WordPress table fitlers. Note that the options key can either be
	 * an array of option arguments, or a string of fully built HTML `<options>`, to be able
	 * to support the drop down walkers for `select_users` and `select_posts`.
	 *
	 * @since 3.1.0
	 * @param array $args The incoming args for this control.
	 */
	public function render_table_filter_control( array $args = array() ) {

		$args  = wp_parse_args( $args, $this->default_filter_control_args );
		$label = ! empty( $args['label'] ) ? $args['label'] : $args['name']; ?>

		<label 
		id="<?php printf( '%1$s_label', esc_attr( $args['name'] ) ); ?>"
		for="<?php printf( '%1$s_filter', esc_attr( $args['name'] ) ); ?>"
		class="screen-reader-text"><?php

			echo wp_kses( $label, 'wp_backstage_filter_label' );

		?></label>

		<select 
		name="<?php echo esc_attr( $args['name'] ); ?>" 
		id="<?php printf( '%1$s_filter', esc_attr( $args['name'] ) ); ?>"
		title="<?php echo esc_attr( $label ); ?>">

			<option value=""><?php
				echo esc_html( $args['option_none_label'] );
			?></option>

			<?php if ( is_array( $args['options'] ) && ! empty( $args['options'] ) ) { ?>

				<?php foreach ( $args['options'] as $option ) { ?>

					<option 
					value="<?php echo esc_attr( $option['value'] ); ?>"
					<?php selected( $option['value'], $args['value'] ); ?>><?php
						echo esc_html( $option['label'] );
					?></option>

				<?php } ?>

			<?php } elseif ( is_string( $args['options'] ) ) {

				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $args['options'];

			} ?>

		</select>

	<?php }

	/**
	 * Get Field Class
	 *
	 * @since 4.0.0
	 * @param string $field_type The field type.
	 * @return WP_Backstage_Field The found field class instance from the global WP_Backstage instance.
	 */
	protected function get_field_class( string $field_type ): WP_Backstage_Field {
		/**
		 * Global WP_Backstage instance
		 *
		 * @var WP_Backstage $wp_backstage
		 */
		global $wp_backstage;
		return $wp_backstage->get_field_class( $field_type );
	}

	/**
	 * Format Filterable Value
	 *
	 * This method is responsible for formatting filterable values. It accepts a value, a label,
	 * and a query arg and will determine what the link should be based on what component is
	 * currently being called.
	 *
	 * @since 3.2.0
	 * @param mixed  $value The query arg's value.
	 * @param string $label The label that will be printed.
	 * @param string $query_arg The key of the query arg that will be added to the URL.
	 */
	protected function format_filterable_value( mixed $value = null, string $label = '', string $query_arg = '' ): string {
		$url_base   = admin_url( '/' );
		$query_args = array();

		if ( $this instanceof WP_Backstage_Taxonomy ) {
			$url_base   = admin_url( '/edit-tags.php' );
			$query_args = array( 'taxonomy' => $this->slug );
			// phpcs:ignore WordPress.Security.NonceVerification
			$url_params = wp_unslash( $_GET );
			if ( isset( $url_params['post_type'] ) && ! empty( $url_params['post_type'] ) ) {
				$query_args['post_type'] = $url_params['post_type'];
			}
		} elseif ( $this instanceof WP_Backstage_Post_type ) {
			$url_base   = admin_url( '/edit.php' );
			$query_args = array( 'post_type' => $this->slug );
		} elseif ( $this instanceof WP_Backstage_User ) {
			$url_base = admin_url( '/users.php' );
		}

		$query_args[ $query_arg ] = $value;

		$link_title = sprintf(
			/* translators: 1: value label. */
			_x( 'Filter by %1$s', 'filterable value link title', 'wp_backstage' ),
			$label
		);

		return sprintf(
			'<a href="%1$s" title="%2$s">%3$s</a>',
			esc_url( add_query_arg( $query_args, $url_base ) ),
			esc_attr( $link_title ),
			wp_strip_all_tags( $label )
		);
	}

	/**
	 * Add Field Columns
	 *
	 * This will embed the field columns into the columns array. Looping through
	 * the already-set column names, if the column name is `comments`, `date`,
	 * or `posts`, The new field columns will be placed before the first instance
	 * of one of them. This method is hooked by objects screens that have tables,
	 * like `WP_Backstage_User`, `WP_Backstage_Post_Type`, and
	 * `WP_Backstage_Taxonomy`. Columns will only be placed for the field if the
	 * field's `has_column` argument is set to `true`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/ hook: manage_{$post_type}_posts_columns
	 *
	 * @since   0.0.1
	 * @param   array $columns  The columns that are currently set.
	 * @return  array   The filtered columns with the new columns added.
	 */
	public function add_field_columns( array $columns = array() ): array {

		if ( is_array( $columns ) ) {

			$fields = $this->get_fields();

			// Add all field columns.
			if ( is_array( $fields ) && ! empty( $fields ) ) {

				// Set which columns should be removed to make way
				// for new columns (will be added back later as is),
				// date is included by default, but sometimes comments
				// are there, and this should be at the end as well.
				$columns_to_remove = array( 'comments', 'date', 'posts' );

				$removed_columns = array();

				// Unset removed columns to make space
				// also ensure storage of the original
				// column for resetting later.
				if ( ! empty( $columns_to_remove ) ) {
					foreach ( $columns_to_remove as $removed ) {
						if ( isset( $columns[ $removed ] ) ) {
							$removed_columns[ $removed ] = $columns[ $removed ];
							unset( $columns[ $removed ] );
						}
					}
				}

				foreach ( $fields as $field ) {
					if ( $field['has_column'] ) {
						$columns[ $field['name'] ] = $field['label'];
					}
				}

				// Reset stored removed columns.
				if ( ! empty( $columns_to_remove ) ) {
					foreach ( $columns_to_remove as $removed ) {
						if ( isset( $removed_columns[ $removed ] ) ) {
							$columns[ $removed ] = $removed_columns[ $removed ];
						}
					}
				}
			}
		}

		return $columns;
	}

	/**
	 * Manage Sortable Columns
	 *
	 * This will set which columns are sortable. This method is hooked by object
	 * screens that have tables, like `WP_Backstage_User`, `WP_Backstage_Post_Type`,
	 * and `WP_Backstage_Taxonomy`. Columns will only be made sortable if the field's
	 * `has_column` and `is_sortable` arguments are set to `true`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/manage_this-screen-id_sortable_columns/ hook: manage_{$screen_id}_sortable_columns
	 *
	 * @since   0.0.1
	 * @param   array $columns  The sortable columns that are currently set.
	 * @return  array  The sortable columns with the new sortable columns added.
	 */
	public function manage_sortable_columns( array $columns = array() ): array {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			if ( $field['has_column'] && $field['is_sortable'] ) {

				$columns[ $field['name'] ] = $field['name'];

			}
		}

		return $columns;
	}

	/**
	 * Get Option Labels
	 *
	 * A utility method to get the localized labels for a given field. This will
	 * return a `$value => $label` array that can be used to pluck an option
	 * label for a given option value for a field. This is useful when displaying
	 * the value of a `radio`, `checkbox`, or `checkbox_set` where the value is
	 * not "pretty".
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  array  An array of `$value => $label` pairs.
	 */
	protected function get_option_labels( array $field = array() ): array {

		$option_labels = array();

		if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

			foreach ( $field['options'] as $option ) {

				$option_labels[ $option['value'] ] = $option['label'];

			}
		}

		return $option_labels;
	}

	/**
	 * Render REST API Preview
	 *
	 * This method renders a REST API preview for a given path. Code mirror is used to initialize a
	 * JSON editor area that is read only. Controls for `context` and `_embed` can be disabled for
	 * endpoints that do not support them natively.
	 *
	 * @since 3.4.0
	 * @since 3.4.2 Fixes bug where event listeners were being added instead of removed on destroy.
	 * @since 4.0.0 Adds arguments.
	 * @param string $path An API path to fetch.
	 * @param array  $args Optional preview configuration arguments.
	 */
	public function render_rest_api_preview( string $path, array $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'supports_context' => true,
				'supports_embed'   => true,
			)
		);

		$loader_text       = _x( 'Loading...', 'rest api preview - loading', 'wp_backstage' );
		$instructions_text = _x( '<strong>No data fetched yet</strong> ― Click the fetch button to get started.', 'rest api preview - instructions', 'wp_backstage' );
		$full_url          = get_rest_url( null, $path ); ?>

		<div 
		id="wp_backstage_rest_api_preview"
		data-api-path="<?php echo esc_url( $path ); ?>"
		data-supports-context="<?php echo esc_attr( $args['supports_context'] ? 'true' : 'false' ); ?>"
		data-supports-embed="<?php echo esc_attr( $args['supports_embed'] ? 'true' : 'false' ); ?>">
			<form id="wp_backstage_rest_api_preview_form" style="margin-bottom: 1em;">
				<?php if ( $args['supports_context'] ) { ?>
					<select name="wp_backstage_rest_api_preview_context" title="context" style="margin-right:15px;">
						<option value="view" selected>view</option>
						<option value="embed">embed</option>
						<option value="edit">edit</option>
					</select>
				<?php } ?>
				<?php if ( $args['supports_embed'] ) { ?>
					<label>
						<input type="checkbox" name="wp_backstage_rest_api_preview_embed" value="true" />
						<span>_embed</span>
					</label>
				<?php } ?>
				<button type="submit" class="button"><?php
					echo esc_html( _x( 'Fetch', 'rest api preview - form submit', 'wp_backstage' ) );
				?></button>
			</form>
			<input 
			readonly 
			type="url" 
			value="<?php echo esc_url( $full_url ); ?>" 
			style="background-color:#ffffff;display:block;width:100%;border-radius:4px 4px 0 0;margin:0;border:1px solid #c3c4c7;border-bottom:none;box-sizing:border-box;" />
			<div style="position:relative;">
				<textarea readonly id="wp_backstage_rest_api_preview_code"></textarea>
				<div id="wp_backstage_rest_api_preview_loader" style="display:none;position:absolute;top:0;left:0;width:100%;height:100%;text-align:center;background-color:#f7f7f7;border:1px solid #c3c4c7;box-sizing:border-box;z-index:10;">
					<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
						<img 
						src="/wp-admin/images/spinner.gif" 
						alt="<?php echo esc_attr( $loader_text ); ?>"
						style="display:inline-block;vertical-align:middle" />
						&nbsp;
						<span style="display:inline-block;vertical-align:middle;"><?php
							echo esc_html( $loader_text );
						?></span>
					</div>
				</div>
				<div id="wp_backstage_rest_api_preview_instructions" style="position:absolute;top:0;left:0;width:100%;height:100%;text-align:center;background-color:#f7f7f7;border:1px solid #c3c4c7;box-sizing:border-box;z-index:10;">
					<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
						<span style="display:inline-block;vertical-align:middle;"><?php
							echo wp_kses_post( $instructions_text );
						?></span>
					</div>
				</div>
			</div>
		</div>
		<script>
			(function() {

				var refreshTriggerTimer = null;

				function init() {
					const form = document.getElementById('wp_backstage_rest_api_preview_form');
					const helpButton = document.getElementById('contextual-help-link');
					const panelButton = document.querySelector('#tab-link-wp_backstage_rest_api_preview > a');
					const settings = window.wpBackstage.codeSettings.jsonReadOnly;
					// Add event listeners.
					panelButton.addEventListener('click', handleRefreshtrigger);
					helpButton.addEventListener('click', handleRefreshtrigger);
					form.addEventListener('submit', handleFormSubmit);
					// Init CodeMirror.
					window.wp.codeEditor.initialize('wp_backstage_rest_api_preview_code', settings);
				}

				function handleRefreshtrigger(e = null) {
					if (refreshTriggerTimer) window.clearTimeout(refreshTriggerTimer);
					refreshTriggerTimer = setTimeout(function() {
						const panel = document.getElementById('tab-panel-wp_backstage_rest_api_preview');
						if (panel.classList.contains('active')) {
							refresh();
						}
					}, 250);
				}

				function setValue(value = '') {
					codeMirrorInst = getCodeMirrorInstance();
					codeMirrorInst.setValue(value);
					codeMirrorInst.clearHistory();
				}

				function showInstructions(show = true) {
					const instructions = document.getElementById('wp_backstage_rest_api_preview_instructions');
					instructions.style.display = show ? 'block' : 'none';
				}

				function showLoader(show = true) {
					const loader = document.getElementById('wp_backstage_rest_api_preview_loader');
					loader.style.display = show ? 'block' : 'none';
				}

				function enableForm(enabled = true) {
					const form = document.getElementById('wp_backstage_rest_api_preview_form');
					if (form instanceof HTMLFormElement) {
						const controls = form.querySelectorAll('button, input, select, textarea');
						controls.forEach(function(control) {
							control.disabled = !enabled;
						});
					}
				}

				function refresh() {
					codeMirrorInst = getCodeMirrorInstance();
					codeMirrorInst.refresh();
				}

				function handleFormSubmit(e = null) {
					e.preventDefault();
					fetchData();
				}

				function getCodeMirrorInstance() {
					const preview = document.getElementById('wp_backstage_rest_api_preview');
					const codeMirrorEl = preview.querySelector('.CodeMirror');
					return codeMirrorEl.CodeMirror;
				}

				function destroy() {
					const form = document.getElementById('wp_backstage_rest_api_preview_form');
					const code = document.getElementById('wp_backstage_rest_api_preview_code');
					const helpButton = document.getElementById('contextual-help-link');
					const panelButton = document.querySelector('#tab-link-wp_backstage_rest_api_preview_help > a');
					// Clear the value.
					setValue('');
					// Remove event listeners.
					panelButton.removeEventListener('click', handleRefreshtrigger);
					helpButton.removeEventListener('click', handleRefreshtrigger);
					form.removeEventListener('submit', handleFormSubmit);
					// Destory CodeMirror.
					const codeMirrorInst = getCodeMirrorInstance();
					codeMirrorInst.destroy();
				}

				function fetchData() {
					const preview = document.getElementById('wp_backstage_rest_api_preview');
					const form = document.getElementById('wp_backstage_rest_api_preview_form');
					const path = preview.getAttribute('data-api-path');
					const supportsContext = (preview.dataset.supportsContext === 'true');
					const supportsEmbed = (preview.dataset.supportsEmbed === 'true');
					const query = {};
					const formData = new FormData(form);
					if (supportsContext) {
						query.context = formData.get('wp_backstage_rest_api_preview_context');
					}
					if (supportsEmbed) {
						query._embed = (formData.get('wp_backstage_rest_api_preview_embed') === 'true');
					}
					enableForm(false);
					showInstructions(false);
					showLoader(true);
					window.wp.apiRequest({
						type: 'GET',
						path: path,
						data: query,
					})
					.then(function(data = null) {
						setValue(JSON.stringify(data, null, 2));
						showLoader(false);
						enableForm(true);
					})
					.fail(function(request = null, statusText = '') {
						var message = statusText;
						if (request.responseJSON && request.responseJSON.message) {
							message = request.responseJSON.message;
						}
						console.error(message);
						setValue(JSON.stringify(request.responseJSON, null, 2));
						showLoader(false);
						enableForm(true);
					});
				}

				document.addEventListener('DOMContentLoaded', function() {
					init();
				});
			})();
		</script>
	<?php }
}
