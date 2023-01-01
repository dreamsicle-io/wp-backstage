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
	 * Tags
	 *
	 * Possible tags: `text_control`, `textarea_control`, `select_control`, `remove_label_for`.
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'text_control',
	);

	/**
	 * Default Args
	 *
	 * @since 4.0.0
	 * @var array $default_args The default field-type-specific args.
	 */
	protected array $default_args = array();

	/**
	 * Default Option Args
	 *
	 * @since 4.0.0
	 * @var array $default_option_args An array of default option arguments.
	 */
	protected array $default_option_args = array(
		'value'    => '',
		'label'    => '',
		'disabled' => false,
	);

	/**
	 * Schema
	 *
	 * @since 4.0.0
	 * @var array $schema The REST API schema definition.
	 */
	protected array $schema = array(
		'type' => 'string',
	);

	/**
	 * Construct
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

	}

	/**
	 * Has Tag
	 *
	 * @since 4.0.0
	 * @param string $tag The tag to search for.
	 * @return bool Whether the tag was found or not.
	 */
	public function has_tag( string $tag = '' ): bool {
		return in_array( $tag, $this->tags );
	}

	/**
	 * Init
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function init(): void {
		add_action( 'admin_print_styles', array( $this, 'inline_style' ), 30 );
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
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
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
	 * Get Args
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return array The parsed field-type-specific args.
	 */
	public function get_args( array $field = array() ): array {
		$args = is_array( $field['args'] ) ? $field['args'] : array();
		$args = wp_parse_args( $args, $this->default_args );
		return $args;
	}

	/**
	 * Get Field ID
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return string The field ID.
	 */
	public function get_id( array $field = array() ): string {
		return ! empty( $field['id'] ) ? $field['id'] : $field['name'];
	}

	/**
	 * Element ID
	 *
	 * @since 4.0.0
	 * @param array  $field An array of field arguments.
	 * @param string $suffix A suffix to append to the ID (will be prefixed by an underscore).
	 * @return void
	 */
	public function element_id( array $field = array(), string $suffix = '' ): void {
		$id      = $this->get_id( $field );
		$suffix  = ! empty( $suffix ) ? "_{$suffix}" : $suffix;
		$id_attr = sprintf( '%1$s%2$s', $id, $suffix );
		echo esc_attr( $id_attr );
	}

	/**
	 * Option ID
	 *
	 * @since 4.0.0
	 * @param array  $field An array of field arguments.
	 * @param array  $option An array of option arguments.
	 * @param string $suffix A suffix to append to the ID (will be prefixed by an underscore).
	 * @return void
	 */
	public function option_id( array $field = array(), array $option = array(), string $suffix = '' ): void {
		// Use the field's `name` argument if no `id` argument is set.
		$field_piece = $this->get_id( $field );
		// Use the value prefixed with an underscore for the option portion of the ID. If not set use "_empty".
		$option_piece = ! empty( $option['value'] ) ? "_{$option['value']}" : '_empty';
		// If a suffix is passed, prefix it with an underscore.
		$suffix = ! empty( $suffix ) ? "_{$suffix}" : $suffix;
		// concatenate the id and suffix values.
		$id_attr = sprintf( '%1$s%2$s%3$s', $field_piece, $option_piece, $suffix );
		// Echo the escaped `id` attribute.
		echo esc_attr( $id_attr );
	}

	/**
	 * Root Class
	 *
	 * @since 4.0.0
	 * @param array    $field An array of field arguments.
	 * @param string[] $more An array of extra classes.
	 * @return void
	 */
	public function root_class( array $field = array(), array $more = array() ): void {
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
	 * Option Label
	 *
	 * @since 4.0.0
	 * @param array $option An array of option arguments.
	 * @return void
	 */
	public function option_label( array $option = array() ): void {
		// Use the option's value if no label is set.
		$label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
		echo esc_html( $label );
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
	public function input_attrs( array $field = array(), array $ignored = array() ): void {
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
	 * @see https://developer.wordpress.org/reference/functions/esc_html/ esc_html()
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {
		echo esc_html( $value );
	}

	/**
	 * Get Options
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return array An array of parsed options arguments.
	 */
	public function get_options( array $field = array() ): array {
		$options = array();
		foreach ( $field['options'] as $option ) {
			$option = wp_parse_args( $option, $this->default_option_args );
			// If the label is empty, use the value as the label.
			if ( empty( $option['label'] ) ) {
				$option['label'] = $option['value'];
			}
			$options[] = $option;
		}
		return $options;
	}

	/**
	 * Get Option Labels
	 *
	 * @since   4.0.0
	 * @param array $field An array of field arguments.
	 * @return array An array of `$value => $label` pairs.
	 */
	public function get_option_labels( array $field = array() ): array {
		$labels = array();
		foreach ( $field['options'] as $option ) {
			$labels[ $option['value'] ] = $option['label'];
		}
		return $labels;
	}

	/**
	 * Get Option Label
	 *
	 * @since 4.0.0
	 * @param array  $field An array of field arguments.
	 * @param string $value A value to find a label for.
	 * @return string The found option label.
	 */
	public function get_option_label( array $field = array(), string $value = '' ): string {
		$labels = $this->get_option_labels( $field );
		return ! empty( $labels[ $value ] ) ? $labels[ $value ] : '';
	}

	/**
	 * Label
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function label( array $field = array() ): void {
		$label = ! empty( $field['label'] ) ? $field['label'] : $field['name'];
		echo wp_kses( $label, 'wp_backstage_field_label' );
	}

	/**
	 * Label
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function description( array $field = array() ): void {
		echo wp_kses( $field['description'], 'wp_backstage_field_description' );
	}

	/**
	 * Render
	 *
	 * Render the default field control. This will render all fields except those
	 * that expose their own `render()` method.
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void { ?>

		<span 
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

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
