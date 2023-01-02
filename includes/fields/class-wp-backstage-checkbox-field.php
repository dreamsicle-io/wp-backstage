<?php
/**
 * WP Backstage Checkbox Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Checkbox Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Checkbox_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'hide_label',
	);

	/**
	 * Schema
	 *
	 * @since 4.0.0
	 * @var array $schema The REST API schema definition.
	 */
	protected array $schema = array(
		'type' => 'boolean',
	);

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return boolean The santizied value.
	 */
	public function sanitize( $value = null ) {
		return boolval( $value );
	}

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {
		$text = _x( 'True', 'checkbox column - true', 'wp_backstage' ); ?>
		<span title="<?php echo esc_attr( $text ); ?>">
			<i class="dashicons dashicons-yes"></i>
			<span class="screen-reader-text"><?php
				echo esc_html( $text );
			?></span>
		</span>
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

			<label 
			id="<?php $this->element_id( $field, 'label' ); ?>"
			style="display:inline-block;">

				<input 
				type="checkbox" 
				value="1"
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php $this->element_id( $field ); ?>" 
				<?php checked( true, $field['value'] ); ?>
				<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value', 'checked' ) ); ?> />

				<span id="<?php $this->element_id( $field, 'text' ); ?>"><?php
					$this->label( $field );
				?></span>

			</label>

		</span>

	<?php }
}
