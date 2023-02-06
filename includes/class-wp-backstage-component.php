<?php
/**
 * WP Backstage Component
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
	protected $slug = '';

	/**
	 * Args
	 *
	 * @since 0.0.1
	 * @var array $args An array of component arguments.
	 */
	protected $args = array();

	/**
	 * Errors
	 *
	 * @since  0.0.1
	 * @var    array  $errors  The array of all errors on the instance.
	 */
	protected $errors = array();

	/**
	 * Screen ID
	 *
	 * @link  https://developer.wordpress.org/reference/functions/get_current_screen/ get_current_screen()
	 *
	 * @since  0.0.1
	 * @var    string|array  $screen_id  The screen ID or IDs that apply to this instance.
	 */
	protected $screen_id = '';

	/**
	 * Countries
	 *
	 * @since  0.0.1
	 * @var    array  $countries  An array of localized countries.
	 * @deprecated 4.0.0
	 */
	protected $countries = array();

	/**
	 * US States
	 *
	 * @since  0.0.1
	 * @var    array  $us_states  An array of localized US states.
	 * @deprecated 4.0.0
	 */
	protected $us_states = array();

	/**
	 * Default Field Args
	 *
	 * @since  0.0.1
	 * @since  3.4.0  Added `show_in_rest` argument.
	 * @var    array  $default_field_args  An array of default field args.
	 */
	protected $default_field_args = array(
		'id'           => '',
		'type'         => 'text',
		'name'         => '',
		'label'        => '',
		'title'        => '',
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
	 * Default Filter Control Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_filter_control_args  The default filter control args for this instance.
	 */
	protected $default_filter_control_args = array(
		'name'              => '',
		'value'             => null,
		'label'             => '',
		'option_none_label' => '',
		'options'           => array(), // Array of options or string of formatted HTML options.
	);

	/**
	 * Date Format
	 *
	 * @since  0.0.1
	 * @var    string  $date_format  The php date format.
	 * @deprecated 4.0.0
	 */
	protected $date_format = '';

	/**
	 * Default Option Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_option_args  An array of default option arguments.
	 */
	protected $default_option_args = array(
		'value'    => '',
		'label'    => '',
		'disabled' => false,
	);

	/**
	 * Default Media Uploader Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_media_uploader_args  An array of default media field arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_media_uploader_args = array(
		'type'     => '',
		'multiple' => false,
		'attach'   => false,
	);

	/**
	 * Default Date Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_date_args  An array of default date field arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_date_args = array(
		'format' => 'yy-mm-dd',
	);

	/**
	 * Default Color Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_color_args  An array of default color field arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_color_args = array(
		'mode'     => '', // hsl, hsv.
		'palettes' => true,
	);

	/**
	 * Default Editor Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_editor_args  An array of default editor field arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_editor_args = array(
		'max_width'     => '100%',
		'format_select' => false,
		'media_buttons' => false,
		'kitchen_sink'  => false,
	);

	/**
	 * Default Code Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_code_args  An array of default code editor arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_code_args = array(
		'settings_key' => '',
		'mime'         => 'text/html',
		'max_width'    => '100%',
	);

	/**
	 * Default Address Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_address_args  An array of default address arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_address_args = array(
		'max_width' => '100%',
	);

	/**
	 * Default Select Posts Args
	 *
	 * @since  3.0.0
	 * @since  3.1.0  Allows for full query args to be passed.
	 * @var    array  $default_select_posts_args  An array of default select posts arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_select_posts_args = array(
		'option_none_label' => '',
		'query'             => array(
			'posts_per_page' => -1,
			'post_type'      => 'page',
			'post_status'    => 'any',
		),
	);

	/**
	 * Default Select Users Args
	 *
	 * @since  3.0.0
	 * @var    array  $default_select_users_args  An array of default select users arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_select_users_args = array(
		'option_none_label' => '',
		'query'             => array(
			'number' => -1,
			'count'  => false,
		),
	);

	/**
	 * Default Address Values
	 *
	 * @since  0.0.1
	 * @var    array  $default_address_values  An array of default address field arguments.
	 * @deprecated 4.0.0
	 */
	protected $default_address_values = array(
		'country'   => 'US',
		'address_1' => '',
		'address_2' => '',
		'city'      => '',
		'state'     => 'AL',
		'zip'       => '',
	);

	/**
	 * Filterable Fields
	 *
	 * @since  0.0.1
	 * @var    array  $filterable_fields  Field types that should have the `for` attribute removed labels.
	 */
	protected $filterable_fields = array(
		'select',
		'radio',
		'select_posts',
		'select_users',
	);

	/**
	 * Remove Label For Fields
	 *
	 * @since  0.0.1
	 * @var    array  $remove_label_for_fields  Field types that should have the `for` attribute removed labels.
	 */
	protected $remove_label_for_fields = array(
		'radio',
		'checkbox_set',
		'time',
		'address',
	);

	/**
	 * Non Regular Text Fields
	 *
	 * @since  0.0.1
	 * @var    array  $non_regular_text_fields  Field types that do not include text-style inputs.
	 */
	protected $non_regular_text_fields = array(
		'number',
		'textarea',
		'editor',
		'select',
		'checkbox',
		'checkbox_set',
		'radio',
		'media',
		'code',
		'date',
		'time',
		'address',
		'select_posts',
		'select_users',
	);

	/**
	 * Textarea Control Fields
	 *
	 * @since  0.0.1
	 * @var    array  $textarea_control_fields  Field types that use a textarea input as a control.
	 */
	protected $textarea_control_fields = array(
		'textarea',
		'editor',
		'code',
	);

	/**
	 * Time Pieces
	 *
	 * This configuration is used in order to create the 3 `<select>` fields
	 * needed to create a time string as `00:00:00`. This will register the
	 * localized label and set the number of options that are necessary for each
	 * time piece (`hour`, `minute`, `second`) respectively.
	 *
	 * @since  0.0.1
	 * @var    array  $time_pieces  The configuration for time fields.
	 * @deprecated 4.0.0
	 */
	protected $time_pieces = array();

	/**
	 * Global Code Settings
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_enqueue_code_editor/ wp_enqueue_code_editor()
	 *
	 * @since  0.0.1
	 * @var    array $global_code_settings  Global settings for CodeMirror.
	 */
	protected $global_code_settings = array(
		'codemirror' => array(
			'lineWrapping' => false,
		),
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
	protected $nonce_key = '_wp_backstage_nonce';

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 * @return  void
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
	public function has_errors() {
		return is_array( $this->errors ) && ! empty( $this->errors );
	}

	/**
	 * Print Errors
	 *
	 * @link     https://developer.wordpress.org/reference/classes/wp_error/ WP_Error()
	 *
	 * @since   0.0.1
	 * @return  void
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
	 * Is Screen
	 *
	 * A utility method to easily check values returned by `get_current_screen()`.
	 *
	 * @link     https://developer.wordpress.org/reference/functions/get_current_screen/ get_current_screen()
	 *
	 * @since   0.0.1
	 * @since   3.7.1 Returns false if `get_current_screen()` is not defined.
	 * @param   string       $key    The key of the `WP_Screen` object to check.
	 * @param   string|array $value  The value or array of values to check.
	 * @return  bool If the match was successful or not.
	 */
	protected function is_screen( $key = '', $value = '' ) {

		$is_screen = false;

		if ( function_exists( 'get_current_screen' ) ) {

			$screen = get_current_screen();

			if ( empty( $screen ) ) {
				$is_screen = false;
			} elseif ( is_array( $value ) ) {
				$is_screen = in_array( $screen->$key, $value );
			} else {
				$is_screen = ( $value === $screen->$key );
			}
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
	 * @return void
	 */
	public function init() {

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}
	}

	/**
	 * Render Edit nonce
	 *
	 * Renders a nonce with this instance's `$nonce_key` and the action set to
	 * `edit`.
	 *
	 * @since   0.0.1
	 * @return  string  The formatted `edit` nonce.
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
	 * @return  string  The formatted `add` nonce.
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
	 * @param string[] $more An array of field arguments.
	 * @return array A filtered list of field arguments.
	 */
	public function add_field_input_classes( array $field = array(), array $more = array() ): array {
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
	 * @param int   $rows An array of field arguments.
	 * @param int   $cols An array of field arguments.
	 * @return array A filtered list of field arguments.
	 */
	public function set_field_textarea_dimensions( array $field = array(), int $rows, int $cols ): array {
		$field['input_attrs']['rows'] = ! empty( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $rows;
		$field['input_attrs']['cols'] = ! empty( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $cols;
		return $field;
	}

	/**
	 * Set Field Input Size
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param int   $size An array of field arguments.
	 * @return array A filtered list of field arguments.
	 */
	public function set_field_input_size( array $field = array(), int $size ): array {
		$field['input_attrs']['size'] = ! empty( $field['input_attrs']['size'] ) ? $field['input_attrs']['size'] : $size;
		return $field;
	}

	/**
	 * Render Field Description
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	protected function render_field_label( $field = array() ) {

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
	 * @return void
	 */
	protected function render_field_description( $field = array() ) {

		if ( ! empty( $field['description'] ) ) {

			$field_class = $this->get_field_class( $field['type'] ); ?>

			<p id="<?php printf( '%1$s-description', esc_attr( $field_class->get_id( $field ) ) ); ?>"><?php
				$field_class->description( $field );
			?></p>

		<?php }

	}

	/**
	 * Inline Code Editor Script
	 *
	 * Inlines the code editor settings objects. This provides necessary context to
	 * the code editor scripts when initializing code editor fields.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/ wp_enqueue_script()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_style/ wp_enqueue_style()
	 * @link    https://developer.wordpress.org/reference/functions/wp_add_inline_script/ wp_add_inline_script()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_media/ wp_enqueue_media()
	 * @link    https://developer.wordpress.org/reference/functions/did_action/ did_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ hook: admin_enqueue_scripts
	 * @link    https://developer.wordpress.org/themes/basics/including-css-javascript/ Including CSS and Javascript in WP
	 *
	 * @since   0.0.1
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_code_editor_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Code_Field::enqueue_settings()' );

		$code_editors = $this->get_fields_by( 'type', 'code' );

		if ( ! empty( $code_editors ) ) {

			foreach ( $code_editors as $code_editor ) {

				$code_editor_args = wp_parse_args( $code_editor['args'], $this->default_code_args );

				$code_editor_settings = wp_enqueue_code_editor(
					array_merge(
						$this->global_code_settings,
						array(
							'type' => $code_editor_args['mime'],
						)
					)
				);

				if ( $code_editor_settings ) {

					wp_add_inline_script(
						'code-editor',
						sprintf(
							'window.wpBackstage.codeEditor.settings.%1$s = %2$s;',
							sanitize_key( $code_editor['name'] ),
							wp_json_encode( $code_editor_settings )
						)
					);

				}
			}
		}
	}

	/**
	 * Sanitize Text
	 *
	 * @link    https://developer.wordpress.org/reference/functions/sanitize_text_field/ sanitize_text_field()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   string $value  The value to sanitize. Expects a string.
	 * @return  string  a text field sanitized string.
	 * @deprecated 4.0.0
	 */
	public function sanitize_text( $value = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::sanitize()' );

		return sanitize_text_field( $value );
	}

	/**
	 * Sanitize Textarea
	 *
	 * @link    https://developer.wordpress.org/reference/functions/sanitize_textarea_field/ sanitize_textarea_field()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   string $value  The value to sanitize. Expects a string.
	 * @return  string  a textarea sanitized string.
	 * @deprecated 4.0.0
	 */
	public function sanitize_textarea( $value = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Textarea_Field::sanitize()' );

		return sanitize_textarea_field( $value );
	}

	/**
	 * Sanitize Editor
	 *
	 * @link    https://developer.wordpress.org/reference/functions/wp_kses_post/ wp_kses_post()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   string $value  The value to sanitize. Expects a string.
	 * @return  string  the string sanitized as post content.
	 * @deprecated 4.0.0
	 */
	public function sanitize_editor( $value = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Editor_Field::sanitize()' );

		return wp_kses_post( $value );
	}

	/**
	 * Sanitize Code
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   string $value  The value to sanitize. Expects a string.
	 * @return  string  An unsanitized string.
	 * @deprecated 4.0.0
	 */
	public function sanitize_code( $value = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Code_Field::sanitize()' );

		return is_string( $value ) ? $value : ''; // unsanitized.
	}

	/**
	 * Sanitize Number
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   int|float $value  The value to sanitize. Expects a numeric value.
	 * @return  float      a float, or null if empty.
	 * @deprecated 4.0.0
	 */
	public function sanitize_number( $value = null ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Number_Field::sanitize()' );

		return ( $value !== '' ) ? floatval( $value ) : null;
	}

	/**
	 * Sanitize URL
	 *
	 * @link    https://codex.wordpress.org/Function_Reference/esc_url_raw esc_url_raw()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   string $value  The value to sanitize. Expects a URL.
	 * @return  string  A URL.
	 * @deprecated 4.0.0
	 */
	public function sanitize_url( $value = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_URL_Field::sanitize()' );

		return esc_url_raw( $value );
	}

	/**
	 * Sanitize Email
	 *
	 * @link    https://developer.wordpress.org/reference/functions/sanitize_email/ sanitize_email()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   string $value  The value to sanitize. Expects an email address.
	 * @return  string  An email address.
	 * @deprecated 4.0.0
	 */
	public function sanitize_email( $value = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Email_Field::sanitize()' );

		return sanitize_email( $value );
	}

	/**
	 * Sanitize Checkbox
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @param   bool $value  The value to sanitize. Expects a value that can be cast to a boolean.
	 * @return  bool  A boolean.
	 * @deprecated 4.0.0
	 */
	public function sanitize_checkbox( $value = false ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Checkbox_Field::sanitize()' );

		return boolval( $value );
	}

	/**
	 * Sanitize Checkbox Set
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Sanitizes more strictly to support strange behavior on menu items.
	 * @since   3.4.0  Maps using `sanitize_text_field()` instead of `esc_attr()`.
	 * @param   array $values  The values to sanitize. Expects an array of strings.
	 * @return  array  An array of values.
	 * @deprecated 4.0.0
	 */
	public function sanitize_checkbox_set( $values = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Checkbox_Set_Field::sanitize()' );

		$new_values = array();
		if ( is_array( $values ) && ! empty( $values ) ) {
			foreach ( $values as $key => $value ) {
				if ( is_numeric( $key ) ) {
					$new_values[] = sanitize_text_field( $value );
				}
			}
		}
		return $new_values;
	}

	/**
	 * Sanitize Address
	 *
	 * @link    https://developer.wordpress.org/reference/functions/esc_attr/ esc_attr()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Parses against default address values.
	 * @since   3.4.0  Maps values with `sanitize_text_field()` instead of `esc_attr()`.
	 * @param   array $value  The value to sanitize. Expects an array of address `key => value` pairs.
	 * @return  array  An array of address key => value pairs.
	 * @deprecated 4.0.0
	 */
	public function sanitize_address( $value = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Address_Field::sanitize()' );

		$value = wp_parse_args( $value, $this->default_address_values );
		return array_map( 'sanitize_text_field', $value );
	}

	/**
	 * Sanitize Time
	 *
	 * @link    https://developer.wordpress.org/reference/functions/esc_attr/ esc_attr()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @since   2.0.0   Parses more strictly to support customizer changes.
	 * @since   2.4.0   Fixes bug introduced at 2.0.0 that parsed the values incorrectly.
	 * @param   mixed $value  The value to sanitize. Expects an array of 3 2-digit time values keyed as "hour", "minute", "second"; or a time string as hh:mm:ss.
	 * @return  string  a string as `hh:mm:ss`.
	 * @deprecated 4.0.0
	 */
	public function sanitize_time( $value = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Time_Field::sanitize()' );

		if ( ! is_array( $value ) && ! empty( $value ) ) {
			$pieces = explode( ':', $value );
			$value  = array(
				'hour'   => isset( $pieces[0] ) ? $pieces[0] : '00',
				'minute' => isset( $pieces[1] ) ? $pieces[1] : '00',
				'second' => isset( $pieces[2] ) ? $pieces[2] : '00',
			);
		}
		$new_value = array(
			'hour'   => isset( $value['hour'] ) ? $value['hour'] : '00',
			'minute' => isset( $value['minute'] ) ? $value['minute'] : '00',
			'second' => isset( $value['second'] ) ? $value['second'] : '00',
		);
		return implode( ':', array_map( 'esc_attr', $new_value ) );
	}

	/**
	 * Sanitize Media
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Removed check for single vs. multiple and treats both as array.
	 * @param   mixed $value  The value to sanitize. Expects a CSV string or array of attachment IDs.
	 * @return  array   An array of integers.
	 * @deprecated 4.0.0
	 */
	public function sanitize_media( $value = null ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Media_Field::sanitize()' );

		if ( ! is_array( $value ) && ! empty( $value ) ) {
			$value = explode( ',', $value );
		}
		return ! empty( $value ) ? array_map( 'absint', $value ) : array();
	}

	/**
	 * Sanitize Select Posts
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   3.0.0
	 * @param   mixed $value  The value to sanitize. Expects a post ID.
	 * @return  array   A non-negative integer.
	 * @deprecated 4.0.0
	 */
	public function sanitize_select_posts( $value = 0 ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Select_Posts_Field::sanitize()' );

		return absint( $value );
	}

	/**
	 * Sanitize Select Users
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   3.1.0
	 * @param   mixed $value  The value to sanitize. Expects a user ID.
	 * @return  array   A non-negative integer.
	 * @deprecated 4.0.0
	 */
	public function sanitize_select_users( $value = 0 ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Select_Users_Field::sanitize()' );

		return absint( $value );
	}

	/**
	 * Sanitize Field
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Removed check for single media vs. multiple media.
	 * @since   3.0.0  Added case for select_posts.
	 * @since   3.1.0  Added case for select_users.
	 * @param   array $field  The field args.
	 * @param   mixed $value  The field value.
	 * @return  mixed  The sanitized value according to the field type.
	 * @deprecated 4.0.0
	 */
	public function sanitize_field( $field = array(), $value = null ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::sanitize()' );

		switch ( $field['type'] ) {
			case 'textarea':
				$value = $this->sanitize_textarea( $value );
				break;
			case 'editor':
				$value = $this->sanitize_editor( $value );
				break;
			case 'code':
				$value = $this->sanitize_code( $value );
				break;
			case 'number':
				$value = $this->sanitize_number( $value );
				break;
			case 'url':
				$value = $this->sanitize_url( $value );
				break;
			case 'email':
				$value = $this->sanitize_email( $value );
				break;
			case 'checkbox':
				$value = $this->sanitize_checkbox( $value );
				break;
			case 'checkbox_set':
				$value = $this->sanitize_checkbox_set( $value );
				break;
			case 'address':
				$value = $this->sanitize_address( $value );
				break;
			case 'time':
				$value = $this->sanitize_time( $value );
				break;
			case 'media':
				$value = $this->sanitize_media( $value );
				break;
			case 'select_posts':
				$value = $this->sanitize_select_posts( $value );
				break;
			case 'select_users':
				$value = $this->sanitize_select_users( $value );
				break;
			default:
				$value = $this->sanitize_text( $value );
				break;
		}

		return $value;

	}

	/**
	 * Get Sanitize Callback
	 *
	 * Since the `WP_Backstage_Options` class is using the WP Settings API, it
	 * is necessary to provide a `sanitize_callback` to the `register_setting()`
	 * function. This method provides a mask of all of this class's
	 * `sanitize_field` methods as strings per field type.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/register_setting/ register_setting()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 *
	 * @since   0.0.1
	 * @since   2.0.0   Removed check for single media vs. multiple media.
	 * @since   3.0.0   Added case for select_posts.
	 * @since   3.1.0   Added case for select_users.
	 * @param   array $field  The field args.
	 * @return  string  The sanitize callback function name as a string.
	 * @deprecated 4.0.0
	 */
	protected function get_sanitize_callback( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::sanitize()' );

		switch ( $field['type'] ) {
			case 'textarea':
				return 'sanitize_textarea';
			case 'editor':
				return 'sanitize_editor';
			case 'code':
				return 'sanitize_code';
			case 'number':
				return 'sanitize_number';
			case 'url':
				return 'sanitize_url';
			case 'email':
				return 'sanitize_email';
			case 'checkbox':
				return 'sanitize_checkbox';
			case 'checkbox_set':
				return 'sanitize_checkbox_set';
			case 'address':
				return 'sanitize_address';
			case 'time':
				return 'sanitize_time';
			case 'media':
				return 'sanitize_media';
			case 'select_posts':
				return 'sanitize_select_posts';
			case 'select_users':
				return 'sanitize_select_users';
			default:
				return 'sanitize_text';
		}
	}

	/**
	 * Get Field Schema
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_meta/ register_meta()
	 * @link https://make.wordpress.org/core/2019/10/03/wp-5-3-supports-object-and-array-meta-types-in-the-rest-api/
	 *
	 * @since 3.4.0
	 * @param array $field An array of field arguments.
	 * @return array An array of schema arguments.
	 * @deprecated 4.0.0
	 */
	protected function get_field_schema( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::get_schema()' );

		switch ( $field['type'] ) {
			case 'checkbox_set':
				return array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string',
					),
				);
			case 'address':
				return array(
					'type'       => 'object',
					'properties' => array(
						'country'   => array(
							'type' => 'string',
						),
						'address_1' => array(
							'type' => 'string',
						),
						'address_2' => array(
							'type' => 'string',
						),
						'city'      => array(
							'type' => 'string',
						),
						'state'     => array(
							'type' => 'string',
						),
						'zip'       => array(
							'type' => 'string',
						),
					),
				);
			case 'media':
				return array(
					'type'  => 'array',
					'items' => array(
						'type' => 'integer',
					),
				);
			case 'number':
				return array(
					'type' => 'integer',
				);
			case 'select_posts':
				return array(
					'type' => 'integer',
				);
			case 'select_users':
				return array(
					'type' => 'integer',
				);
			case 'checkbox':
				return array(
					'type' => 'boolean',
				);
			default:
				return array(
					'type' => 'string',
				);
		}
	}

	/**
	 * Get Fields
	 *
	 * @since   0.0.1
	 * @return  array  an array of field arg arrays.
	 */
	protected function get_fields() {
		return array();
	}

	/**
	 * Get Fields By
	 *
	 * Get all fields that matches the passed `$key` and `$value`.
	 *
	 * @since   0.0.1
	 * @param   string $key     the key of the field arg to check.
	 * @param   mixed  $value   the value of the passed field arg key to check.
	 * @param   int    $number  the number of fields to return.
	 * @return  array   an array of field arg arrays if found, or an empty array.
	 */
	protected function get_fields_by( $key = '', $value = null, $number = 0 ) {

		$fields = $this->get_fields();
		$result = array();

		if ( ! empty( $key ) && ( is_array( $fields ) && ! empty( $fields ) ) ) {

			$i = 0;

			foreach ( $fields as $field ) {

				if ( isset( $field[ $key ] ) && ( $field[ $key ] === $value ) ) {

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
	 * Get Fields By Query
	 *
	 * Get all fields that matches the passed query array.
	 *
	 * @since   3.4.0
	 * @param   array $query  An array of key values to check against.
	 * @param   int   $number  the number of fields to return.
	 * @return  array   an array of field arg arrays if found, or an empty array.
	 */
	protected function get_fields_by_query( $query = array(), $number = 0 ) {

		$fields = $this->get_fields();
		$result = array();

		$i = 0;

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

			if ( ( $number > 0 ) && ( $number === ( $i + 1 ) ) ) {
				break;
			}

			$i++;
		}

		return $result;

	}

	/**
	 * Get Field By
	 *
	 * Get the first field that matches the passed `$key` and `$value`.
	 *
	 * @since   0.0.1
	 * @param   string $key     the key of the field arg to check.
	 * @param   mixed  $value   the value of the passed field arg key to check.
	 * @return  array   the first field arg array if found, or an empty array.
	 */
	protected function get_field_by( $key = '', $value = null ) {

		$fields = $this->get_fields_by( $key, $value, 1 );
		$result = null;

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			$result = $fields[0];

		}

		return $result;

	}

	/**
	 * Add REST API Field Link
	 *
	 * @since 3.4.0
	 * @param WP_REST_Response $response The response object to manipulate.
	 * @param array            $field An array of field arguments.
	 * @param mixed            $value The field's value.
	 * @return WP_REST_Response The augmented response object.
	 * @deprecated 4.0.0
	 */
	public function add_rest_api_field_link( $response = null, $field = array(), $value = null ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::add_rest_api_link()' );

		$link_base = 'wpBackstage';
		$link_key  = "{$link_base}:{$field['name']}";

		switch ( $field['type'] ) {
			case 'media':
				$attachment_post_type_obj = get_post_type_object( 'attachment' );
				$attachment_ids           = is_array( $value ) ? array_map( 'absint', $value ) : array();
				if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {
					foreach ( $attachment_ids as $attachment_id ) {
						if ( $attachment_id > 0 ) {
							$attachment_path = sprintf( '/%1$s/%2$s/%3$d', $attachment_post_type_obj->rest_namespace, $attachment_post_type_obj->rest_base, $attachment_id );
							$response->add_link(
								$link_key,
								rest_url( $attachment_path ),
								array(
									'embeddable' => true,
								)
							);
						}
					}
				}
				break;
			case 'select_posts':
				$post_id = absint( $value );
				if ( $post_id > 0 ) {
					$post_type     = get_post_type( $post_id );
					$post_type_obj = get_post_type_object( $post_type );
					$post_path     = sprintf( '/%1$s/%2$s/%3$d', $post_type_obj->rest_namespace, $post_type_obj->rest_base, $post_id );
					$response->add_link(
						$link_key,
						rest_url( $post_path ),
						array(
							'postType'   => $post_type,
							'embeddable' => true,
						)
					);
				}
				break;
			case 'select_users':
				$user_id = absint( $value );
				if ( $user_id > 0 ) {
					$user_namespace = 'wp/v2';
					$user_base      = 'users';
					$user_path      = sprintf( '/%1$s/%2$s/%3$d', $user_namespace, $user_base, $user_id );
					$response->add_link(
						$link_key,
						rest_url( $user_path ),
						array(
							'embeddable' => true,
						)
					);
				}
				break;
		}

		return $response;
	}

	/**
	 * Render Field By Type
	 *
	 * This will render a field by type, given an array of field arguments.
	 * Depending on the field type, different render field methods will be
	 * called in order to render the appropriate field HTML.
	 *
	 * @since   0.0.1
	 * @since   3.0.0 Added case for select_posts.
	 * @since   3.1.0 Added case for select_users.
	 * @param   array $field  An array of field args.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_field_by_type( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		switch ( $field['type'] ) {
			case 'textarea':
				$this->render_textarea( $field );
				break;
			case 'editor':
				$this->render_editor( $field );
				break;
			case 'select':
				$this->render_select( $field );
				break;
			case 'radio':
				$this->render_radio( $field );
				break;
			case 'checkbox':
				$this->render_checkbox( $field );
				break;
			case 'checkbox_set':
				$this->render_checkbox_set( $field );
				break;
			case 'media':
				$this->render_media_uploader( $field );
				break;
			case 'date':
				$this->render_date( $field );
				break;
			case 'time':
				$this->render_time( $field );
				break;
			case 'color':
				$this->render_color( $field );
				break;
			case 'code':
				$this->render_code( $field );
				break;
			case 'address':
				$this->render_address( $field );
				break;
			case 'select_posts':
				$this->render_select_posts( $field );
				break;
			case 'select_users':
				$this->render_select_users( $field );
				break;
			default:
				$this->render_input( $field );
				break;
		}
	}

	/**
	 * Render Table Filter Controls
	 *
	 * This method is responsible for rendering the filter controls for fields. The fields will
	 * get their value from the parsed URL query parameters and set up arguments for the filter
	 * select as defined in `WP_Backstage_Component::render_table_filter_control()`.
	 *
	 * @since 3.1.0
	 * @return void
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
	 * @return void
	 */
	public function render_table_filter_control( $args = array() ) {

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
	 * Format Field Value
	 *
	 * This will format a fields value based on a given array of field args.
	 * According to the field type, different formatting will be applied to the
	 * value.
	 *
	 * @since   0.0.1
	 * @since   2.4.0   Renders the actual value if no label is found on fields like select, radio, and checkbox set.
	 * @since   3.0.0   Adds case for select_posts.
	 * @since   3.1.0   Adds case for select_users.
	 * @since   3.2.0   Abstracts filterable value rendering to the `format_filterable_value()` method and fixes issue where the color `<i>` elements were having "display:block" stripped from the inline CSS.
	 * @param mixed $value  The value to format.
	 * @param array $field  An array of field arguments.
	 * @return string  The value of the field as a string
	 * @deprecated 4.0.0
	 */
	protected function format_field_value( $value = null, $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render_column()' );

		$content = '';

		if ( ! empty( $value ) && ( is_array( $field ) && ! empty( $field ) ) ) {

			switch ( $field['type'] ) {
				case 'url':
					$content = '<a href="' . esc_attr( $value ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a>';
					break;
				case 'email':
					$content = '<a href="mailto:' . esc_attr( $value ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a>';
					break;
				case 'tel':
					$content = '<a href="tel:' . esc_attr( preg_replace( '/[^0-9]/', '', $value ) ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a>';
					break;
				case 'radio':
					$labels  = $this->get_option_labels( $field );
					$label   = isset( $labels[ $value ] ) ? $labels[ $value ] : $value;
					$content = $this->format_filterable_value( $value, $label, $field['name'] );
					break;
				case 'select':
					$labels  = $this->get_option_labels( $field );
					$label   = isset( $labels[ $value ] ) ? $labels[ $value ] : $value;
					$content = $this->format_filterable_value( $value, $label, $field['name'] );
					break;
				case 'checkbox':
					$content = '<i class="dashicons dashicons-yes"></i><span class="screen-reader-text">' . esc_html_x( 'True', 'checkbox column - true', 'wp_backstage' ) . '</span>';
					break;
				case 'textarea':
					$content = wpautop( sanitize_textarea_field( $value ) );
					break;
				case 'editor':
					$content = wpautop( wp_kses_post( $value ) );
					break;
				case 'code':
					$content = '<textarea disabled rows="3" style="font-size:10px;">' . esc_textarea( $value ) . '</textarea>';
					break;
				case 'color':
					$icon_style = 'width:24px;height:24px;border:1px solid #e1e1e1;background-color:' . esc_attr( $value ) . ';';
					$content    = '<div style="' . $icon_style . '" title="' . esc_attr( $value ) . '" aria-hidden="true"></div><span class="screen-reader-text">' . esc_html( $value ) . '</span>';
					break;
				case 'date':
					$content = gmdate( $this->date_format, strtotime( $value ) );
					break;
				case 'checkbox_set':
					if ( is_array( $value ) && ! empty( $value ) ) {
						$option_labels = $this->get_option_labels( $field );
						foreach ( $value as $key ) {
							$labels[] = isset( $option_labels[ $key ] ) ? $option_labels[ $key ] : $key;
						}
					}
					$content = esc_html( implode( ', ', $labels ) );
					break;
				case 'address':
					$value   = is_array( $value ) ? $value : array();
					$parsed  = wp_parse_args( $value, $this->default_address_values );
					$address = array();

					if ( ! empty( $parsed['address_1'] ) ) {
						$address[] = $parsed['address_1'];
					}
					if ( ! empty( $parsed['address_2'] ) ) {
						$address[] = $parsed['address_2'];
					}
					if ( ! empty( $parsed['city'] ) ) {
						$address[] = $parsed['city'];
					}
					if ( ! empty( $parsed['state'] ) ) {
						$address[] = $parsed['state'];
					}
					if ( ! empty( $parsed['zip'] ) ) {
						$address[] = $parsed['zip'];
					}
					if ( ! empty( $parsed['country'] ) ) {
						$address[] = $parsed['country'];
					}

					$formatted_address     = implode( ', ', array_map( 'esc_html', $address ) );
					$formatted_address_url = sprintf( 'https://www.google.com/maps/place/%1$s', implode( ',+', array_map( 'rawurlencode', $address ) ) );

					$content = sprintf(
						'<address><a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s<span>%3$s<span><a></address>',
						esc_url( $formatted_address_url ),
						'<i class="dashicons dashicons-location" aria-hidden="true" style="font-size:inherit;height:auto;width:auto;margin-top:-2px;margin-right:2px;vertical-align:middle;"></i>',
						esc_html( $formatted_address )
					);
					break;
				case 'media':
					$thumbnail_size  = 20;
					$thumbnail_style = 'height:' . $thumbnail_size . 'px;width:auto;margin:0 4px 4px 0;display:block;float:left;border:1px solid #e1e1e1;';
					if ( is_array( $value ) ) {
						$value = array_map( 'absint', $value );
					} else {
						$value = array( absint( $value ) );
					}
					$attachments = array();
					foreach ( $value as $i => $attachment_id ) {
						$attachments[] = wp_get_attachment_image(
							absint( $attachment_id ),
							array( $thumbnail_size, $thumbnail_size ),
							true,
							array(
								'style' => $thumbnail_style,
								'title' => get_the_title( $attachment_id ),
							)
						);
					}
					$content = implode( '', $attachments );
					break;
				case 'select_posts':
					$value   = absint( $value );
					$content = $this->format_filterable_value( $value, get_the_title( $value ), $field['name'] );
					break;
				case 'select_users':
					$value   = absint( $value );
					$user    = get_user_by( 'ID', $value );
					$content = $this->format_filterable_value( $value, $user->display_name, $field['name'] );
					break;
				default:
					$content = $value;
					break;
			}
		}

		return $content;

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
	protected function format_filterable_value( $value = null, $label = '', $query_arg = '' ) {
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
	 * @param   string $columns  The columns that are currently set.
	 * @return  array   The filtered columns with the new columns added.
	 */
	public function add_field_columns( $columns = array() ) {

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
	public function manage_sortable_columns( $columns = array() ) {

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {

			if ( $field['has_column'] && $field['is_sortable'] ) {

				$columns[ $field['name'] ] = $field['name'];

			}
		}

		return $columns;

	}

	/**
	 * Format Attrs
	 *
	 * A utility method for formatting an array of `$key => $value` pairs into a
	 * string of sanitized HTML element attributes.
	 *
	 * @since   0.0.1
	 * @param   array $attrs  An array of attributes as `$key => $value` pairs.
	 * @return  string  The imploded, escaped, formatted attributes.
	 * @deprecated 4.0.0
	 */
	protected function format_attrs( $attrs = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::input_attrs()' );

		$formatted_attrs = array();

		if ( is_array( $attrs ) && ! empty( $attrs ) ) {

			foreach ( $attrs as $key => $field['value'] ) {

				$formatted_attrs[] = sprintf(
					'%1$s="%2$s"',
					esc_attr( trim( $key ) ),
					esc_attr( trim( $field['value'] ) )
				);

			}
		}

		return implode( ' ', $formatted_attrs );
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
	protected function get_option_labels( $field = array() ) {

		$option_labels = array();

		if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

			foreach ( $field['options'] as $option ) {

				$option_labels[ $option['value'] ] = $option['label'];

			}
		}

		return $option_labels;
	}

	/**
	 * Render Input
	 *
	 * Render an input field. This method will handle all HTML `<input>` types
	 * except for `radio`, `checkbox`, and those with their own methods like
	 * `date`.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_input( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );
		$id    = $field['id'] ? $field['id'] : sanitize_key( $field['name'] ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-input"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span 
			id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>"
			style="display:block;">

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<input 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $field['value'] ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?> />

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Date
	 *
	 * Render a date field using `jQuery UI Datepicker`. This was separated out
	 * from this class's `render_input()` method because of the JavaScript
	 * integration. This UI method ensures a full-proof way of ensuring date
	 * strings are always ISO compliant.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_date( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );
		$id    = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args  = wp_parse_args( $field['args'], $this->default_date_args ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-date"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		data-date-picker-id="<?php echo esc_attr( $id ); ?>"
		data-date-picker-format="<?php echo esc_attr( $args['format'] ); ?>"
		style="display:block;">

			<span 
			id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>"
			style="display:block;">

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<input 
				size="12"
				type="text" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $field['value'] ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				style="width:auto;"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?> />

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Time Options
	 *
	 * This is used in order to create all `<option>` elements needed to create
	 * a time piece `<select>` as used in this class's `render_time()` method.
	 *
	 * @since   0.0.1
	 * @param   int    $number    The number of options to render.
	 * @param   string $selected  The selected option's value.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_time_options( $number = 0, $selected = '' ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Time_Field::render_time_options()' );

		if ( ! $number > 0 ) {
			return;
		}

		for ( $i = 0; $i < $number; $i++ ) {
			$option = esc_attr( $i );
			if ( strlen( $option ) === 1 ) {
				$option = '0' . $option;
			}
			printf(
				'<option value="%1$s" %2$s>%1$s</option>',
				esc_html( $option ),
				selected( $option, $selected )
			);
		}

	}

	/**
	 * Render Time
	 *
	 * Render a time field. This will create the 3 `<select>` fields needed to
	 * create a time string as `00:00:00`. This UI method ensures a full-proof
	 * way of ensuring time strings are always ISO compliant.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_time( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id           = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$value_pieces = ! empty( $field['value'] ) ? explode( ':', $field['value'] ) : array(); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-time"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<?php if ( $field['show_label'] ) { ?>

				<legend 
				id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
				style="padding:2px 0;font-size:inherit;display:inline-block;"><?php

					echo wp_kses( $field['label'], 'wp_backstage_field_label' );

				?></legend>

			<?php } ?>

			<span 
			id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>"
			style="display:block;padding:0 0 2px;">

				<?php
				$i = 0;
				foreach ( $this->time_pieces as $piece_key => $piece ) {

					$select_name = sprintf( '%1$s[%2$s]', $field['name'], $piece_key );
					$select_id   = sprintf( '%1$s_%2$s', $id, $piece_key );
					$selected    = ( isset( $value_pieces[ $i ] ) && ! empty( $value_pieces[ $i ] ) ) ? $value_pieces[ $i ] : ''; ?>

					<span style="display:inline-block;vertical-align:top;">

						<label 
						for="<?php echo esc_attr( $select_id ); ?>"
						style="display:inline-block;padding:0 2px;">

							<small><?php

								echo wp_kses( $piece['label'], 'wp_backstage_field_label' );

							?></small>

						</label>

						<br/>

						<span>

							<select 
							name="<?php echo esc_attr( $select_name ); ?>" 
							id="<?php echo esc_attr( $select_id ); ?>" 
							aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
							<?php disabled( true, $field['disabled'] ); ?>
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput
							echo $this->format_attrs( $field['input_attrs'] );
							?>>

								<?php $this->render_time_options( $piece['number_options'], $selected ); ?>

							</select>

							<?php if ( ( $i + 1 ) < count( $this->time_pieces ) ) { ?>
								<span class="sep" style="display:inline-block;vertical-align:middle;">:</span>
							<?php } ?>

						</span>

					</span>

					<?php
					$i++;

				} ?>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Color
	 *
	 * Render a color picker field. This uses the the native `Iris` JavaScript
	 * library as included in WordPress Core to render the same robust color
	 * pickers found in WordPress. The field is configurable with arguments for
	 * `hsl` and `hsv` color modes, as well as custom color palettes.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_color( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id   = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_color_args );

		if ( is_array( $args['palettes'] ) ) {
			$palettes = implode( ',', $args['palettes'] );
		} else {
			$palettes = $args['palettes'] ? 'true' : 'false';
		} ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-color"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		data-color-picker-id="<?php echo esc_attr( $id ); ?>"
		data-color-picker-mode="<?php echo esc_attr( $args['mode'] ); ?>"
		data-color-picker-palettes="<?php echo esc_attr( $palettes ); ?>"
		style="display:block;">

			<span id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<input 
				type="text" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $field['value'] ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?> />

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Checkbox
	 *
	 * Render a checkbox field. This was separated out from this class's
	 * `render_input()` method because the markup is significantly different.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_checkbox( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id = $field['id'] ? $field['id'] : sanitize_key( $field['name'] ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-checkbox"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span 
			id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>"
			style="display:block;">

				<input 
				type="checkbox" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="1" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php checked( true, $field['value'] ); ?>
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?> />

				<label 
				id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
				for="<?php echo esc_attr( $id ); ?>"
				style="display:inline-block;vertical-align:top;"><?php

					echo wp_kses( $field['label'], 'wp_backstage_field_label' );

				?></label>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Textarea
	 *
	 * Render a textarea field.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_textarea( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id = $field['id'] ? $field['id'] : sanitize_key( $field['name'] ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-textarea"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span 
			id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>"
			style="display:block;">

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<textarea 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?>><?php echo esc_textarea( $field['value'] ); ?></textarea>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Editor
	 *
	 * This will render a WordPress editor complete with `TinyMCE` and
	 * `quicktags`. These provide a WYSIWYG environment where content creation
	 * can happen in a familiar WordPress flow. All WordPress caveats, like
	 * bugs when moving WP Editors around in the DOM in meta boxes, and bugs
	 * when displaying a meta box that was hidden on page load, have been handled.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_editor( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id                            = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args                          = wp_parse_args( $field['args'], $this->default_editor_args );
		$input_class                   = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';
		$field['input_attrs']['class'] = sprintf( 'wp-editor-area %1$s', $input_class ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-editor"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		data-editor-id="<?php echo esc_attr( $id ); ?>"
		data-media-buttons="<?php echo ( $args['media_buttons'] ) ? 'true' : 'false'; ?>"
		data-format-select="<?php echo ( $args['format_select'] ) ? 'true' : 'false'; ?>"
		data-kitchen-sink="<?php echo ( $args['kitchen_sink'] ) ? 'true' : 'false'; ?>"
		style="display:block;max-width:<?php echo esc_attr( $args['max_width'] ); ?>;">

			<span id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<textarea 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?>><?php echo esc_textarea( $field['value'] ); ?></textarea>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Code
	 *
	 * Render a code editor using the native `CodeMirror` integration in
	 * WordPress Core. This field supports multiple mime types like
	 * `text/javascript`, `text/css`, `text/html`, and `application/pdf`, etc.
	 * WordPress's provided configuration will lint, show errors in code, and
	 * provide autocompletes. All WordPress caveats, like bugs when moving code
	 * editors around in the DOM in meta boxes, and bugs when displaying a meta
	 * box that was hidden on page load, have been handled.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_code( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id           = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args         = wp_parse_args( $field['args'], $this->default_code_args );
		$settings_key = $args['settings_key'] ? $args['settings_key'] : $id; ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-code"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		data-code-editor-id="<?php echo esc_attr( $id ); ?>"
		data-code-editor-settings="<?php echo esc_attr( $settings_key ); ?>"
		style="display:block;max-width:<?php echo esc_attr( $args['max_width'] ); ?>;">

			<span id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;margin-bottom:4px;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<textarea 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?>><?php echo esc_textarea( $field['value'] ); ?></textarea>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Select
	 *
	 * Render a select that allow for a single value to be set for a
	 * field. The options are set as an array of the field's `options` key.
	 * These can be dynamically created by looping post types, taxonomies,
	 * users, options, etc.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_select( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id = $field['id'] ? $field['id'] : sanitize_key( $field['name'] ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-select"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<select 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?>>

					<?php if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) { ?>

						<?php foreach ( $field['options'] as $option ) {

							$option       = wp_parse_args( $option, $this->default_option_args );
							$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value']; ?>

							<option 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php selected( $option['value'], $field['value'] ); ?>
							<?php disabled( true, $option['disabled'] ); ?>><?php

								echo esc_html( $option_label );

							?></option>

						<?php } ?>

					<?php } ?>

				</select>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Radio
	 *
	 * Render a set of radios that allow for a single value to be set for a
	 * field. The options are set as an array of the field's `options` key.
	 * These can be dynamically created by looping post types, taxonomies,
	 * users, options, etc.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_radio( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id = $field['id'] ? $field['id'] : sanitize_key( $field['name'] ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-radio"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span 
			id="<?php echo esc_attr( $id ); ?>"
			aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
			style="display:block;">

				<?php if ( $field['show_label'] ) { ?>

					<legend style="display:inline-block;padding:2px 0;font-size:inherit;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></legend>

				<?php } ?>

				<?php if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) { ?>

					<?php foreach ( $field['options'] as $i => $option ) {

						$option       = wp_parse_args( $option, $this->default_option_args );
						$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
						$input_id     = sprintf( esc_attr( '%1$s_%2$s' ), $id, sanitize_key( $option['value'] ) ); ?>

						<span 
						id="<?php printf( '%1$s_input_container', esc_attr( $input_id ) ); ?>"
						style="display:block;padding:2px 0;">

							<input
							type="radio" 
							id="<?php echo esc_attr( $input_id ); ?>" 
							name="<?php echo esc_attr( $field['name'] ); ?>" 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput
							echo $this->format_attrs( $field['input_attrs'] ); ?> 
							<?php ( empty( $field['value'] ) && ( $i === 0 ) ) ? checked( true, true ) : checked( $option['value'], $field['value'] ); ?>
							<?php disabled( true, ( $option['disabled'] || $field['disabled'] ) ); ?> />

							<label 
							id="<?php printf( '%1$s_label', esc_attr( $input_id ) ); ?>"
							for="<?php echo esc_attr( $input_id ); ?>"
							style="display:inline-block;margin:0;"><?php

								echo esc_html( $option_label );

							?></label>

						</span>

					<?php } ?>

				<?php } ?>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Checkbox Set
	 *
	 * Render a set of checkboxes that allow for multiple values to be set for a
	 * field. The options are set as an array of the field's `options` key.
	 * These can be dynamically created by looping post types, taxonomies,
	 * users, options, etc.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_checkbox_set( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id    = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$value = is_array( $field['value'] ) ? $field['value'] : array(); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-checkbox-set"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span 
			id="<?php echo esc_attr( $id ); ?>"
			aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
			style="display:block;">

				<?php if ( $field['show_label'] ) { ?>

					<legend 
					id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
					style="display:inline-block;padding:2px 0;font-size:inherit;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></legend>

				<?php } ?>

				<?php if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) { ?>

					<?php foreach ( $field['options'] as $option ) {

						$option       = wp_parse_args( $option, $this->default_option_args );
						$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
						$input_id     = sprintf( esc_attr( '%1$s_%2$s' ), $id, sanitize_key( $option['value'] ) ); ?>

						<span 
						id="<?php printf( '%1$s_input_container', esc_attr( $input_id ) ); ?>"
						style="display:block;padding:2px 0;">

							<input
							type="checkbox" 
							id="<?php echo esc_attr( $input_id ); ?>" 
							name="<?php echo esc_attr( $field['name'] ); ?>[]" 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php
							// phpcs:ignore WordPress.Security.EscapeOutput
							echo $this->format_attrs( $field['input_attrs'] ); ?> 
							<?php disabled( true, ( $option['disabled'] || $field['disabled'] ) ); ?>
							<?php checked( true, in_array( $option['value'], $value ) ); ?>/>

							<label 
							id="<?php printf( '%1$s_label', esc_attr( $input_id ) ); ?>"
							for="<?php echo esc_attr( $input_id ); ?>"
							style="display:inline-block;vertical-align:top;"><?php

								echo esc_html( $option_label );

							?></label>

						</span>

					<?php } ?>

				<?php } ?>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Media Uploader
	 *
	 * The media uploader field is capable of selecting media files of all mime
	 * types, and supports single and multiple image selection. This field is
	 * deeply integrated into the WordPress Media Uploader, and there are
	 * arguments for mime type selection. Fields that allow multiple attachments
	 * to be selected also support selective removal, addition, and drag-and-drop
	 * sorting.
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Full rewrite of the media uploader markup.
	 * @since   3.3.0  Adds error and loader elements and removes the `clone` methodology in favor of ajax rendering.
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_media_uploader( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id   = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );

		// Prepare uploader labels.
		$single_modal_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Set %1$s', 'media uploader field - modal single button', 'wp_backstage' ),
			$field['label']
		);
		$multiple_modal_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Add to %1$s', 'media uploader field - modal multiple button', 'wp_backstage' ),
			$field['label']
		);
		$add_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Add %1$s', 'media uploader field - add button', 'wp_backstage' ),
			$field['label']
		);
		$add_to_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Add to %1$s', 'media uploader field - add to button', 'wp_backstage' ),
			$field['label']
		);
		$replace_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Replace %1$s', 'media uploader field - replace button', 'wp_backstage' ),
			$field['label']
		);
		$remove_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Remove %1$s', 'media uploader field - remove button', 'wp_backstage' ),
			$field['label']
		);
		$loader_text           = _x( 'Loading preview...', 'media uploader field - loader', 'wp_backstage' );
		$error_text            = _x( 'There was an error rendering the preview.', 'media uploader field - error', 'wp_backstage' );
		$try_again_button_text = _x( 'Try again', 'media uploader field - try again button', 'wp_backstage' ) ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-media wp-backstage-media-uploader"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		data-media-uploader-id="<?php echo esc_attr( $id ); ?>"
		data-media-uploader-multiple="<?php echo $args['multiple'] ? 'true' : 'false'; ?>"
		data-media-uploader-type="<?php echo esc_attr( $args['type'] ); ?>"
		data-media-uploader-title="<?php echo esc_attr( $field['label'] ); ?>"
		data-media-uploader-button="<?php echo esc_attr( $args['multiple'] ? $multiple_modal_button_text : $single_modal_button_text ); ?>">

			<?php if ( $field['show_label'] ) { ?>

				<legend 
				class="wp-backstage-media-uploader__legend"
				id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"><?php
					echo wp_kses( $field['label'], 'wp_backstage_field_label' );
				?></legend>

			<?php } ?>

			<input 
			type="hidden" 
			id="<?php echo esc_attr( $id ); ?>" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			value="<?php echo is_array( $field['value'] ) ? esc_attr( implode( ',', $field['value'] ) ) : esc_attr( $field['value'] ); ?>"
			aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput
			echo $this->format_attrs( $field['input_attrs'] );
			?> />

			<span 
			class="wp-backstage-media-uploader__preview"
			id="<?php printf( '%1$s_preview', esc_attr( $id ) ); ?>">

				<span 
				id="<?php printf( '%1$s_error', esc_attr( $id ) ); ?>"
				class="wp-backstage-media-uploader__error notice inline notice-error">
					<span>
						<?php echo esc_html( $error_text ); ?>
						<button 
						type="button"
						id="<?php printf( '%1$s_button_try_again', esc_attr( $id ) ); ?>" 
						class="wp-backstage-media-uploader__try-again button-link"><?php
							echo esc_html( $try_again_button_text );
						?></button>
					</span>
				</span>

				<span 
				class="wp-backstage-media-uploader__preview-list"
				id="<?php printf( '%1$s_preview_list', esc_attr( $id ) ); ?>">

				</span>
			</span>

			<span
			class="wp-backstage-media-uploader__buttons" 
			id="<?php printf( '%1$s_buttons', esc_attr( $id ) ); ?>">

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--add button" 
				id="<?php printf( '%1$s_button_add', esc_attr( $id ) ); ?>"
				type="button"
				style="vertical-align: middle;"><?php
					echo esc_html( $add_button_text );
				?></button>

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--add-to button" 
				id="<?php printf( '%1$s_button_add_to', esc_attr( $id ) ); ?>"
				type="button"
				disabled
				style="vertical-align: middle; display:none;"><?php
					echo esc_html( $add_to_button_text );
				?></button>

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--replace button" 
				id="<?php printf( '%1$s_button_replace', esc_attr( $id ) ); ?>"
				type="button"
				disabled
				style="vertical-align: middle; display:none;"><?php
					echo esc_html( $replace_button_text );
				?></button>

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--remove button-link" 
				id="<?php printf( '%1$s_button_remove', esc_attr( $id ) ); ?>"
				type="button" 
				disabled
				style="vertical-align: middle; display:none;"><?php
					echo esc_html( $remove_button_text );
				?></button>

			</span>

			<span 
			id="<?php printf( '%1$s_loader', esc_attr( $id ) ); ?>"
			class="wp-backstage-media-uploader__loader">
				<img 
				src="/wp-admin/images/spinner.gif" 
				alt="<?php echo esc_attr( $loader_text ); ?>" />
				&nbsp;
				<span><?php echo esc_html( $loader_text ); ?></span>
			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Address
	 *
	 * Render a group of fields that will provide all necessary inputs to create
	 * a full address. The value of this field is an array of address pieces as
	 * `country`, `address`, `address_2`, `city`, `state`, `zip`. If the US is
	 * selected as the country, then a `<select>` of localized US states will
	 * replace the "State/Province/Region" input.
	 *
	 * @since   0.0.1
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_address( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );

		$id     = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$value  = is_array( $field['value'] ) ? $field['value'] : array();
		$values = wp_parse_args( $value, $this->default_address_values );
		$args   = wp_parse_args( $field['args'], $this->default_address_args ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-address"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		data-address-id="<?php echo esc_attr( $id ); ?>"
		data-default-country="<?php echo esc_attr( $this->default_address_values['country'] ); ?>""
		data-default-state="<?php echo esc_attr( $this->default_address_values['state'] ); ?>""
		style="display:block;max-width:<?php echo esc_attr( $args['max_width'] ); ?>;">

			<?php if ( $field['show_label'] ) { ?>

				<legend 
				id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
				style="display:inline-block;font-size:inherit;"><?php

					echo wp_kses( $field['label'], 'wp_backstage_field_label' );

				?></legend>

			<?php } ?>

			<span 
			id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>"
			style="display:block;">

				<span 
				id="<?php printf( '%1$s_country_container', esc_attr( $id ) ); ?>"
				style="display:block;">

					<label 
					for="<?php printf( '%1$s_country', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'Country', 'address field - country label', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<select
					id="<?php printf( '%1$s_country', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[country]', esc_attr( $field['name'] ) ); ?>"
					style="width:100%;max-width:100%;box-sizing:border-box;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?>>

						<?php foreach ( $this->countries as $country_code => $country_label ) { ?>

							<option 
							value="<?php echo esc_attr( $country_code ); ?>"
							<?php selected( $country_code, $values['country'] ); ?>><?php

								echo esc_html( $country_label );

							?></option>

						<?php } ?>

					</select>

				</span>

				<span 
				id="<?php printf( '%1$s_address_1_container', esc_attr( $id ) ); ?>"
				style="display:block;">

					<label 
					for="<?php printf( '%1$s_address_1', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'Address', 'address field - line 1', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( '%1$s_address_1', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[address_1]', esc_attr( $field['name'] ) ); ?>"
					value="<?php echo esc_attr( $values['address_1'] ); ?>"
					aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?> />

				</span>

				<span 
				id="<?php printf( '%1$s_address_2_container', esc_attr( $id ) ); ?>"
				style="display:block;">

					<label 
					for="<?php printf( '%1$s_address_2', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'Address (Line 2)', 'address field - line 2', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( '%1$s_address_2', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[address_2]', esc_attr( $field['name'] ) ); ?>"
					value="<?php echo esc_attr( $values['address_2'] ); ?>"
					aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?> />

				</span>

				<span 
				id="<?php printf( '%1$s_city_container', esc_attr( $id ) ); ?>"
				style="display:block;width:49%;float:left;margin-right:2%;">

					<label 
					for="<?php printf( '%1$s_city', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'City', 'address field - city', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( '%1$s_city', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[city]', esc_attr( $field['name'] ) ); ?>"
					value="<?php echo esc_attr( $values['city'] ); ?>"
					aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?> />

				</span>

				<span 
				id="<?php printf( '%1$s_state_container', esc_attr( $id ) ); ?>"
				style="display:block;width:49%;float:left;">

					<label 
					for="<?php printf( '%1$s_state', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'State / Province / Region', 'address field - state input', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( '%1$s_state', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[state]', esc_attr( $field['name'] ) ); ?>"
					value="<?php echo esc_attr( $values['state'] ); ?>"
					aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?> />

				</span>

				<span id="<?php printf( '%1$s_us_state_container', esc_attr( $id ) ); ?>"
				style="display:block;width:49%;float:left;">

					<label 
					for="<?php printf( '%1$s_us_state', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'State', 'address field - state select', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<select
					id="<?php printf( '%1$s_us_state', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[state]', esc_attr( $field['name'] ) ); ?>"
					style="width:100%;max-width:100%;box-sizing:border-box;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?>>

						<?php foreach ( $this->us_states as $us_state_code => $us_state_name ) { ?>

							<option 
							value="<?php echo esc_attr( $us_state_code ); ?>"
							<?php selected( $us_state_code, $values['state'] ); ?>><?php

								echo esc_html( $us_state_name );

							?></option>

						<?php } ?>

					</select>

				</span>

				<span 
				id="<?php printf( '%1$s_zip_container', esc_attr( $id ) ); ?>"
				style="display:block;">

					<label 
					for="<?php printf( '%1$s_zip', esc_attr( $id ) ); ?>"
					style="display:inline-block;">

						<small><?php

							echo wp_kses( _x( 'Zip Code', 'address field - zip', 'wp_backstage' ), 'wp_backstage_field_label' );

						?></small>

					</label>

					<br/>

					<input 
					type="tel" 
					id="<?php printf( '%1$s_zip', esc_attr( $id ) ); ?>"
					name="<?php printf( '%1$s[zip]', esc_attr( $field['name'] ) ); ?>"
					value="<?php echo esc_attr( $values['zip'] ); ?>"
					aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo $this->format_attrs( $field['input_attrs'] );
					?> />

				</span>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Select Posts
	 *
	 * Render a select field prepopulared by WordPress posts.
	 *
	 * @since   3.0.0
	 * @since   3.1.0 Allows for full query args to be passed.
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_select_posts( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );
		$id    = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args  = wp_parse_args( $field['args'], $this->default_select_posts_args );
		$query = wp_parse_args( $args['query'], $this->default_select_posts_args['query'] );

		$default_option_none_label = _x( 'Select', 'select posts field - default option none label', 'wp_backstage' );
		$option_none_label         = ! empty( $args['option_none_label'] ) ? $args['option_none_label'] : $default_option_none_label;

		$posts = get_posts( $query );

		$post_options = walk_page_dropdown_tree(
			$posts,
			0,
			array(
				'value_field' => 'ID',
				'selected'    => absint( $field['value'] ),
			)
		); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-select-posts"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<select 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?>>

					<option value="" <?php selected( '', $field['value'] ); ?>><?php

						printf( '― %1$s ―', esc_html( $option_none_label ) );

					?></option>

					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput 
					echo $post_options; ?>

				</select>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render Select Users
	 *
	 * Render a select field prepopulared by WordPress users.
	 *
	 * @since   3.1.0
	 * @param   array $field  An array of field arguments.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	protected function render_select_users( $field = array() ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Field::render()' );

		$field = wp_parse_args( $field, $this->default_field_args );
		$id    = $field['id'] ? $field['id'] : sanitize_key( $field['name'] );
		$args  = wp_parse_args( $field['args'], $this->default_select_users_args );
		$query = wp_parse_args( $args['query'], $this->default_select_users_args['query'] );

		$default_option_none_label = _x( 'Select', 'select users field - default option none label', 'wp_backstage' );
		$option_none_label         = ! empty( $args['option_none_label'] ) ? $args['option_none_label'] : $default_option_none_label;

		$users = get_users( $query ); ?>

		<span 
		class="wp-backstage-field wp-backstage-field--type-select-users"
		id="<?php printf( '%1$s_container', esc_attr( $id ) ); ?>"
		style="display:block;">

			<span id="<?php printf( '%1$s_input_container', esc_attr( $id ) ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php

						echo wp_kses( $field['label'], 'wp_backstage_field_label' );

					?></label>

					<br/>

				<?php } ?>

				<select 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $this->format_attrs( $field['input_attrs'] );
				?>>

					<option value="" <?php selected( '', $field['value'] ); ?>><?php

						printf( '― %1$s ―', esc_html( $option_none_label ) );

					?></option>

					<?php foreach ( $users as $user ) {

						$option_label = sprintf(
							/* translators: 1: user display name, 2: user username */
							_x( '%1$s (%2$s)', 'select users field - option label', 'wp_backstage' ),
							esc_html( $user->display_name ),
							esc_html( $user->user_login )
						); ?>

						<option value="<?php echo esc_attr( $user->ID ); ?>" <?php selected( true, absint( $field['value'] ) === absint( $user->ID ) ); ?>><?php

							echo esc_html( $option_label );

						?></option>

					<?php } ?>

				</select>

			</span>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<span 
				id="<?php printf( '%1$s_description', esc_attr( $id ) ); ?>" 
				class="description"
				style="display:block;"><?php

					echo wp_kses( $field['description'], 'wp_backstage_field_description' );

				?></span>

			<?php } ?>

		</span>

	<?php }

	/**
	 * Render REST API Preview
	 *
	 * This method renders a REST API preview for a given path. Code mirror is used to initialize a
	 * json editor area that is read only. Filters for `context` and `_embed` are provided for
	 * through api response checks.
	 *
	 * @since 3.4.0
	 * @since 3.4.2 Fixes bug where event listeners were being added instead of removed on destroy.
	 * @param string $path An API path to fetch.
	 * @return void
	 */
	public function render_rest_api_preview( $path = '' ) {
		$loader_text       = _x( 'Loading...', 'rest api preview - loading', 'wp_backstage' );
		$instructions_text = _x( '<strong>No data fetched yet</strong> ― Click the fetch button to get started.', 'rest api preview - instructions', 'wp_backstage' );
		$full_url          = get_rest_url( null, $path ); ?>
		<div 
		id="wp_backstage_rest_api_preview"
		data-api-path="<?php echo esc_url( $path ); ?>">
			<form id="wp_backstage_rest_api_preview_form" style="margin-bottom: 1em;">
				<select name="wp_backstage_rest_api_preview_context" title="context" style="margin-right:15px;">
					<option value="view" selected>view</option>
					<option value="embed">embed</option>
					<option value="edit">edit</option>
				</select>
				<label>
					<input type="checkbox" name="wp_backstage_rest_api_preview_embed" value="true" />
					<span>_embed</span>
				</label>
				<button type="sumbit" class="button"><?php
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

				function showInstructions() {
					const instructions = document.getElementById('wp_backstage_rest_api_preview_instructions');
					instructions.style.display = 'block';
				}

				function hideInstructions() {
					const instructions = document.getElementById('wp_backstage_rest_api_preview_instructions');
					instructions.style.display = 'none';
				}

				function showLoader() {
					const loader = document.getElementById('wp_backstage_rest_api_preview_loader');
					loader.style.display = 'block';
				}

				function hideLoader() {
					const loader = document.getElementById('wp_backstage_rest_api_preview_loader');
					loader.style.display = 'none';
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
					formData = new FormData(form);
					hideInstructions();
					showLoader();
					window.wp.apiRequest({
						path: path,
						type: 'GET',
						data: {
							context: formData.get('wp_backstage_rest_api_preview_context'),
							_embed: (formData.get('wp_backstage_rest_api_preview_embed') === 'true'),
						},
					})
					.then(function(data = null) {
						setValue(JSON.stringify(data, null, 2));
						hideLoader();
					})
					.fail(function(request = null, statusText = '') {
						var message = statusText;
						if (request.responseJSON && request.responseJSON.message) {
							message = request.responseJSON.message;
						}
						console.error(message);
						setValue(JSON.stringify(request.responseJSON, null, 2));
						hideLoader();
					});
				}

				document.addEventListener('DOMContentLoaded', function() {
					init();
				});
			})();
		</script>
	<?php }

}
