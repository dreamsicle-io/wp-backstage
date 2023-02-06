<?php
/**
 * WP Backstage Checkbox Set Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Checkbox Set Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Checkbox_Set_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'remove_label_for',
	);

	/**
	 * Schema
	 *
	 * @since 4.0.0
	 * @var array $schema The REST API schema definition.
	 */
	protected array $schema = array(
		'type'  => 'array',
		'items' => array(
			'type' => 'string',
		),
	);

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {
		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $key ) {
				$label    = $this->get_option_label( $field, $key );
				$labels[] = ! empty( $label ) ? $label : $key;
			}
		}
		echo esc_html( implode( ', ', $labels ) );
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return array The santizied value.
	 */
	public function sanitize( $value = null ) {
		return is_array( $value ) ? array_values( array_map( 'sanitize_text_field', $value ) ) : array();
	}

	/**
	 * Is Option Checked
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param array $option An array of option arguments.
	 * @return bool Whether the option is checked or not.
	 */
	public function is_option_checked( array $field = array(), array $option = array() ): bool {
		$values = is_array( $field['value'] ) ? $field['value'] : array();
		return in_array( $option['value'], $values );
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_checkbox_set_field_style">

			.wp-backstage-checkbox-set-field__option-label {
				margin: 0.35em 0 0.5em !important;
				display: inline-block !important;
				padding: 0 !important;
				line-height: 1.4;
			}

		</style>

	<?php }

	/**
	 * Inline Script
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_script(): void { ?>

		<script id="wp_backstage_checkbox_set_field_script">

			(function() {

				function setValue(control = null, value = []) {
					const checkboxes = control.querySelectorAll('input[type="checkbox"]');
					checkboxes.forEach(function(checkbox) {
						if (value.includes(checkbox.value)) checkbox.checked = true;
					});
				}

				window.wpBackstage.fields.checkbox_set = {
					setValue: setValue,
				}

			})();

		</script>

	<?php }

	/**
	 * Render
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void {

		$options = $this->get_options( $field ); ?>

		<span 
		class="<?php $this->root_class( $field, array( 'wp-backstage-checkbox-set-field' ) ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

			<?php foreach ( $options as $i => $option ) { ?>

				<label 
				class="wp-backstage-checkbox-set-field__option-label"
				id="<?php $this->option_id( $field, $option, 'label' ); ?>">

					<input 
					type="checkbox" 
					name="<?php printf( '%1$s[%2$d]', esc_attr( $field['name'] ), esc_attr( $i ) ); ?>" 
					id="<?php $this->option_id( $field, $option ); ?>" 
					value="<?php echo esc_attr( $option['value'] ); ?>" 
					<?php checked( true, $this->is_option_checked( $field, $option ) ); ?>
					<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value', 'checked' ) ); ?> />

					<span 
					class="wp-backstage-checkbox-set-field__option-text"
					id="<?php $this->option_id( $field, $option, 'text' ); ?>"><?php
						$this->option_label( $option );
					?></span>

				</label>

				<?php if ( ( $i + 1 ) < count( $options ) ) { ?>
					<br />
				<?php } ?>

			<?php } ?>

		</span>

	<?php }
}
