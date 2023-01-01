<?php
/**
 * WP Backstage Textarea Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Textarea Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Textarea_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'textarea_control',
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
		return sanitize_textarea_field( $value );
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
		<textrea readonly><?php echo esc_textarea( $value ); ?></textrea>
	<?php }

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

			<textarea 
			name="<?php echo esc_attr( $field['name'] ); ?>"
			id="<?php $this->element_id( $field ); ?>"
			<?php $this->input_attrs( $field, array( 'name', 'id' ) ); ?>><?php
				echo esc_textarea( $field['value'] );
			?></textarea>

		</span>

	<?php }

}
