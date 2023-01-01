<?php
/**
 * WP Backstage Color Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Color Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Color_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array();

	/**
	 * Default Args
	 *
	 * @since 4.0.0
	 * @var array $default_args An array of default color field arguments.
	 */
	protected array $default_args = array(
		'mode'     => '', // hsl, hsv.
		'palettes' => true,
	);

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		return sanitize_hex_color( $value );
	}

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void { ?>
		<a href="<?php printf( 'mailto:%1$s', esc_attr( $value ) ); ?>" target="_blank" rel="noopener noreferrer"><?php
			echo esc_html( $value );
		?></a>
	<?php }

	/**
	 * Inline Color Field Script
	 *
	 * @link    http://automattic.github.io/Iris/ Iris
	 * @link    https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ New Color Picker in WP 3.5
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 *
	 * @since   4.0.0
	 * @return  void
	 */
	public function inline_script(): void { ?>

		<script id="wp_backstage_color_field_script">

			(function($) {

				var saveTimer = null;

				function handleChange(e = null, ui = null) {
					if (saveTimer) clearTimeout(saveTimer);
					saveTimer = setTimeout(function() {
						$(e.target).trigger('change');
					}, 500);
				}

				function init(colorPicker = null) {
					const fieldId = colorPicker.getAttribute('data-field-id');
					const input = colorPicker.querySelector('#' + fieldId);
					const mode = colorPicker.getAttribute('data-color-picker-mode');
					var palettes = colorPicker.getAttribute('data-color-picker-palettes');
					palettes = palettes.startsWith('#') ? palettes.split(',') : (palettes === 'true');

					const options = {
						defaultColor: false, // bool, string.
						palettes: palettes, // bool, [].
						change: handleChange,
						clear: handleChange,
					};
					// Add seperately to ensure default WP setting 
					// is respected if no mode is set.
					if (mode) {
						options.mode = mode; // string (hsl, hsv).
					}

					$(input).wpColorPicker(options);

					initLabels(colorPicker);
				}

				function getIrisInstance(colorPicker = null) {
					const fieldId = colorPicker.getAttribute('data-field-id');
					const input = colorPicker.querySelector('#' + fieldId);
					return $(input).iris('instance');
				}

				function getWPColorPickerInstance(colorPicker = null) {
					const fieldId = colorPicker.getAttribute('data-field-id');
					const input = colorPicker.querySelector('#' + fieldId);
					return $(input).wpColorPicker('instance');
				}

				function initLabels(colorPicker = null) {
					const fieldId = colorPicker.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.addEventListener('click', handleLabelClick);
					});
				}

				function destroyLabels(colorPicker = null) {
					const fieldId = colorPicker.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.removeEventListener('click', handleLabelClick);
					});
				}

				function handleLabelClick(e = null) {
					e.preventDefault();
					const fieldId = e.target.getAttribute('for');
					const colorPicker = getColorPickerById(fieldId);
					focus(colorPicker);
				}

				function focus(colorPicker = null) {
					const button = colorPicker.querySelector('.wp-color-result');
					button.focus();
				}

				function getColorPickerById(fieldId = '') {
					return document.querySelector('.wp-backstage-field--type-color[data-field-id="' + fieldId + '"]');
				}

				function initAll(container = document) {
					const colorPickers = container.querySelectorAll('.wp-backstage-field--type-color');
					colorPickers.forEach(function(colorPicker) {
						init(colorPicker);
					});
				}

				function reset(colorPicker = null) {
					const resetButton = colorPicker.querySelector('.wp-picker-clear, .wp-picker-default');
					resetButton.click();
				}

				function resetAll(container = document) {
					const colorPickers = container.querySelectorAll('.wp-backstage-field--type-color');
					colorPickers.forEach(function(colorPicker) {
						reset(colorPicker);
					});
				}

				function destroy(colorPicker = null) {
					// wpColorPicker does not destroy in any meaningul way, so it
					// must be done manually. First, destroy the iris instance AND 
					// the wpColorPicker instance, then the UI has to be destroyed manually.
					const irisInst = getIrisInstance(colorPicker);
					const wpColorPickerInst = getWPColorPickerInstance(colorPicker);
					irisInst.destroy();
					wpColorPickerInst.destroy();

					const fieldId = colorPicker.getAttribute('data-field-id');
					const input = colorPicker.querySelector('#' + fieldId);
					const colorPickerContainer = colorPicker.querySelector('.wp-picker-container');

					// Remove the UI.
					colorPickerContainer.remove();
					// Remove the wp-color-picker class and append the input to the original container.
					input.classList.remove('wp-color-picker');

					// Move the input back to its original container.
					colorPicker.appendChild(input);

					destroyLabels(colorPicker);
				}

				function destroyAll(container = document) {
					const colorPickers = container.querySelectorAll('.wp-backstage-field--type-color');
					colorPickers.forEach(function(colorPicker) {
						destroy(colorPicker);
					});
				}

				window.wpBackstage.fields.colorPicker = {
					initAll: initAll,
					init: init,
					destroyAll: destroyAll,
					destroy: destroy,
					resetAll: resetAll,
					reset: reset,
				};

			})(jQuery);

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

		$args = $this->get_args( $field );

		if ( is_array( $args['palettes'] ) ) {
			$palettes = implode( ',', $args['palettes'] );
		} else {
			$palettes = $args['palettes'] ? 'true' : 'false';
		} ?>

		<span 
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>"
		data-color-picker-mode="<?php echo esc_attr( $args['mode'] ); ?>"
		data-color-picker-palettes="<?php echo esc_attr( $palettes ); ?>">

			<input 
			type="text" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			id="<?php $this->element_id( $field ); ?>" 
			value="<?php echo esc_attr( $field['value'] ); ?>" 
			<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value' ) ); ?> />

		</span>

	<?php }

}
