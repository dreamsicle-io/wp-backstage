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
		global $wp;
		// Prepare the query args array.
		$query_args = array();
		// Set the field name to the current value.
		$query_args[ $field['name'] ] = $value;
		// Prepare the dynamic URL.
		$url = admin_url( add_query_arg( $query_args, $wp->request ) );
		// Get the option label.
		$label = $this->get_option_label( $field, $value );
		// Prepare the link title.
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
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

			<?php foreach ( $options as $i => $option ) { ?>

				<span 
				id="<?php $this->option_id( $field, $option, 'container' ); ?>"
				style="display:block;">

					<label 
					id="<?php $this->option_id( $field, $option, 'label' ); ?>"
					style="display:inline-block;">

						<input 
						type="radio" 
						name="<?php echo esc_attr( $field['name'] ); ?>" 
						id="<?php $this->option_id( $field, $option ); ?>" 
						value="<?php echo esc_attr( $option['value'] ); ?>" 
						<?php checked( true, ( $field['value'] === $option['value'] ) || ( empty( $field['value'] ) && ( $i === 0 ) ) ); ?>
						<?php disabled( true, ( $field['disabled'] || $option['disabled'] ) ); ?>
						<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value', 'disabled', 'checked' ) ); ?> />

						<span id="<?php $this->option_id( $field, $option, 'text' ); ?>"><?php
							$this->option_label( $option );
						?></span>

					</label>

				</span>

			<?php } ?>

		</span>

	<?php }
}
