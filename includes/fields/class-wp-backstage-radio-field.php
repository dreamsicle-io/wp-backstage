<?php
/**
 * WP Backstage Radio Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Radio Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Radio_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'remove_label_for',
		'is_filterable',
	);

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_radio_field_style">

			.wp-backstage-radio-field__option-label {
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

		<script id="wp_backstage_radio_field_script">

			(function() {

				function setValue(control = null, value = null) {
					const radios = control.querySelectorAll('input[type="radio"]');
					radios.forEach(function(radio) {
						if (radio.value === value) radio.checked = true;
					});
				}

				window.wpBackstage.fields.radio = {
					setValue: setValue,
				}

			})();

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

		$url        = $this->get_filter_url( $field, $value );
		$label      = $this->get_option_label( $field, $value );
		$link_title = sprintf(
			/* translators: 1: value label. */
			_x( 'Filter by %1$s', 'radio field - column filter link title', 'wp_backstage' ),
			$label
		); ?>

		<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $link_title ); ?>"><?php
			echo esc_html( $label );
		?></a>

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
		class="<?php $this->root_class( $field, array( 'wp-backstage-radio-field' ) ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

			<?php foreach ( $options as $i => $option ) { ?>

				<label 
				id="<?php $this->option_id( $field, $option, 'label' ); ?>"
				class="wp-backstage-radio-field__option-label">

					<input 
					type="radio" 
					name="<?php echo esc_attr( $field['name'] ); ?>" 
					id="<?php $this->option_id( $field, $option ); ?>" 
					value="<?php echo esc_attr( $option['value'] ); ?>" 
					<?php checked( true, ( $field['value'] === $option['value'] ) || ( empty( $field['value'] ) && ( $i === 0 ) ) ); ?>
					<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value', 'checked' ) ); ?> />

					<span 
					class="wp-backstage-radio-field__option-text"
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
