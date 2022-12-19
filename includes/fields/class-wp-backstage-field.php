<?php
/**
 * WP Backstage Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Field {

	/**
	 * Schema
	 *
	 * @since  4.0.0
	 * @var    array  $schema  The REST API schema definition.
	 */
	protected array $schema = array(
		'type' => 'string',
	);

	/**
	 * Init
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function init(): void {
		add_action( 'admin_print_styles', array( $this, 'inline_style' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_script' ), 10 );
	}

	/**
	 * Get Schema
	 *
	 * @since 4.0.0
	 * @return array The field's REST API schema.
	 */
	public function get_schema(): array {
		return $this->schema;
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsanitized value.
	 * @return mixed The sanitized value.
	 */
	public function sanitize( mixed $value ): mixed {
		return sanitize_text_field( $value );
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void {

	}

	/**
	 * Inline Script
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_script(): void {

	}

	/**
	 * Element ID
	 *
	 * @since 4.0.0
	 * @param array  $field An array of field arguments.
	 * @param string $suffix A suffix to append to the ID (will be prefixed by an underscore).
	 * @return void
	 */
	protected function element_id( array $field = array(), string $suffix = '' ): void {
		// Use the field's `name` argument if no `id` argument is set.
		$id = ! empty( $field['id'] ) ? $field['id'] : $field['name'];
		// If a suffix is passed, prefix it with an underscore.
		$suffix = ! empty( $suffix ) ? "_{$suffix}" : $suffix;
		// concatenate the id and suffix values.
		$id_attr = sprintf( '%1$s%2$s', $id, $suffix );
		// Echo the sanitized and escaped `id` attribute.
		echo esc_attr( sanitize_key( $id_attr ) );
	}

	/**
	 * Root Class
	 *
	 * @since 4.0.0
	 * @param array    $field An array of field arguments.
	 * @param string[] $more An array of extra classes.
	 * @return void
	 */
	protected function root_class( array $field = array(), array $more = array() ): void {
		// Prepare the the array of classes.
		$classes = array(
			'wp-backstage-field',
			"wp-backstage-field--type-{$field['type']}",
		);
		// Merge the classes with any more classes that were passed in.
		$classes = array_merge( $classes, $more );
		// Sanitize each string in the array.
		$classes = array_map( 'sanitize_html_class', $classes );
		// Echo the escaped, imploded classes.
		echo esc_attr( implode( ' ', $classes ) );
	}

	/**
	 * Input Attrs
	 *
	 * A utility method for formatting an array of `$key => $value` pairs into a
	 * string of sanitized HTML element attributes.
	 *
	 * @since   4.0.0
	 * @param   array $field  An array of field arguments.
	 * @param   array $ignored  An array of attributes to ignore, usefull if preventing setting of existing attributes is necessary.
	 * @return  void
	 */
	protected function input_attrs( array $field = array(), array $ignored = array() ): void {
		// Get the input attributes from the field arguments.
		$attrs = is_array( $field['input_attrs'] ) ? $field['input_attrs'] : array();
		// Prepare the array of formatted attributes.
		$formatted_attrs = array();
		// Loop over the attribute entries.
		foreach ( $attrs as $key => $value ) {
			// Check if the key should be ignored according to the passed array of ignored keys.
			if ( ! in_array( $key, $ignored ) ) {
				// Push the formatted attribute string to the array of formatted attributes.
				$formatted_attrs[] = sprintf(
					'%1$s="%2$s"',
					sanitize_key( $key ),
					esc_attr( $value )
				);
			}
		}
		// Echo the imploded attributes.
		// phpcs:ignore WordPress.Security.EscapeOutput
		echo implode( ' ', $formatted_attrs );
	}

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field, mixed $value = null ): void {
		echo esc_html( $value );
	}

	/**
	 * Render
	 *
	 * Render the default field field. This will render all fields except those
	 * that expose their own `render()` method.
	 *
	 * @since   4.0.0
	 * @param   array $field  An array of field arguments.
	 *
	 * @return  void
	 */
	public function render( array $field = array() ): void { ?>

		<span 
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>"
		style="display:block;">

			<input 
			type="<?php echo esc_attr( $field['type'] ); ?>" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			id="<?php $this->element_id( $field ); ?>" 
			value="<?php echo esc_attr( $field['value'] ); ?>" 
			<?php disabled( true, $field['disabled'] ); ?>
			<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value', 'disabled' ) ); ?> />

		</span>

	<?php }
}
