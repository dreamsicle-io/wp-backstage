<?php
/**
 * WP Backstage Date Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Date Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Date_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array();

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( $value = null ) {
		return ( is_string( $value ) && ! empty( $value ) ) ? gmdate( 'Y-m-d', strtotime( $value ) ) : '';
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_date_field_style">

			.form-field .wp-backstage-field--type-date input {
				width: auto;
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

		<script id="wp_backstage_date_field_script">

			(function($) {

				function getAll(container = document) {
					return container.querySelectorAll('.wp-backstage-field--type-date');
				}

				function getInput(datePicker = null) {
					const fieldId = datePicker.getAttribute('data-field-id');
					return datePicker.querySelector('#' + fieldId);
				}

				function init(datePicker = null) {
					const input = getInput(datePicker);
					$(input).datepicker({ dateFormat: 'yy-mm-dd' });
				}

				function destroy(datePicker = null) {
					const input = getInput(datePicker);
					$(input).datepicker('destroy');
				}

				function refresh(datePicker = null) {
					const input = getInput(datePicker);
					$(input).datepicker('refresh');
				}

				function reset(datePicker = null) {
					const input = getInput(datePicker);
					input.value = input.defaultValue;
				}

				function initAll(container = document) {
					const datePickers = getAll(container);
					datePickers.forEach(function(datePicker) {
						init(datePicker);
					});
				}

				function destroyAll(container = document) {
					const datePickers = getAll(container);
					datePickers.forEach(function(datePicker) {
						destroy(datePicker);
					});
				}

				function resetAll(container = document) {
					const datePickers = getAll(container);
					datePickers.forEach(function(datePicker) {
						reset(datePicker);
					});
				}

				function refreshAll(container = document) {
					const datePickers = getAll(container);
					datePickers.forEach(function(datePicker) {
						refresh(datePicker);
					});
				}

				window.wpBackstage.fields.datePicker = {
					initAll: initAll,
					init: init,
					destroyAll: destroyAll,
					destroy: destroy,
					refreshAll: refreshAll,
					refresh: refresh,
					resetAll: resetAll,
					reset: reset,
				};

			})(jQuery);

		</script>

	<?php }

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {
		echo esc_html( gmdate( get_option( 'date_format' ), strtotime( $value ) ) );
	}

	/**
	 * Render
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
			type="text" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			id="<?php $this->element_id( $field ); ?>" 
			value="<?php echo esc_attr( $field['value'] ); ?>" 
			<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value' ) ); ?> />

		</span>

	<?php }
}
