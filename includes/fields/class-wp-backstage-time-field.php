<?php
/**
 * WP Backstage Time Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Time Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Time_Field extends WP_Backstage_Field {

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
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( $value = null ) {
		$values = array(
			'hour'   => isset( $value['hour'] ) ? $value['hour'] : '00',
			'minute' => isset( $value['minute'] ) ? $value['minute'] : '00',
			'second' => isset( $value['second'] ) ? $value['second'] : '00',
		);
		return implode( ':', array_map( 'sanitize_key', $values ) );
	}

	/**
	 * Get Time Option
	 *
	 * @since 4.0.0
	 * @param int $number The time option number to be converted to a two character string.
	 * @return string A two character string.
	 */
	public function get_time_option( int $number = 0 ): string {
		$option = esc_attr( $number );
		if ( strlen( $option ) === 1 ) {
			$option = '0' . $option;
		}
		return $option;
	}

	/**
	 * Get Time Values
	 *
	 * @since 4.0.0
	 * @param string $value The time string.
	 * @return array An array of values as `[hour] => '00', [minute] => '00', [second] => '00'`.
	 */
	public function get_time_values( string $value = '' ): array {
		$values = explode( ':', $value );
		return array(
			'hour'   => isset( $values[0] ) ? $values[0] : '00',
			'minute' => isset( $values[1] ) ? $values[1] : '00',
			'second' => isset( $values[2] ) ? $values[2] : '00',
		);
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_time_field_style">

			.wp-backstage-time-field {
				display: block;
			}

			.wp-backstage-time-field__piece-container {
				display: inline-block;
				vertical-align: middle;
			}

			.wp-backstage-time-field__piece-container label {
				display: inline-block;
				font-size: 0.875em;
			}

			.wp-backstage-time-field__input-container {
				display: block;
			}

			.wp-backstage-time-field__input-container select {
				width: auto !important;
				display: inline-block !important;
				vertical-align: middle;
			}
			.wp-backstage-time-field__sep {
				display: inline-block;
				vertical-align: middle;
			}

		</style>

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
		echo esc_html( gmdate( get_option( 'time_format' ), strtotime( $value ) ) );
	}

	/**
	 * Render
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void {

		$hour_label   = _x( 'Hour', 'time field - hour', 'wp_backstage' );
		$minute_label = _x( 'Minute', 'time field - minute', 'wp_backstage' );
		$second_label = _x( 'Second', 'time field - second', 'wp_backstage' );
		$value        = ! empty( $field['value'] ) ? $field['value'] : '';

		$values = $this->get_time_values( $value ); ?>

		<span 
		class="<?php $this->root_class( $field, array( 'wp-backstage-time-field' ) ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

			<span 
			id="<?php $this->element_id( $field, 'hour_container' ); ?>"
			class="wp-backstage-time-field__piece-container">

				<label for="<?php $this->element_id( $field, 'hour' ); ?>"><?php
					echo wp_kses( $hour_label, 'wp_backstage_field_label' );
				?></label>

				<span class="wp-backstage-time-field__input-container">

					<select 
					name="<?php printf( '%1$s[hour]', esc_attr( $field['name'] ) ); ?>" 
					id="<?php $this->element_id( $field, 'hour' ); ?>" 
					<?php $this->input_attrs( $field, array( 'name', 'id' ) );?>>

						<?php for ( $i = 0; $i < 24; $i++ ) {
							$option = $this->get_time_option( $i ); ?>
							<option 
							value="<?php echo esc_attr( $option ); ?>"
							<?php selected( $option, $values['hour'] ); ?>><?php
								echo esc_html( $option );
							?></option>
						<?php } ?>

					</select>

					<span class="wp-backstage-time-field__sep">:</span>

				</span>

			</span>

			<span 
			id="<?php $this->element_id( $field, 'minute_container' ); ?>"
			class="wp-backstage-time-field__piece-container">

				<label for="<?php $this->element_id( $field, 'minute' ); ?>"><?php
					echo wp_kses( $minute_label, 'wp_backstage_field_label' );
				?></label>

				<span class="wp-backstage-time-field__input-container">

					<select 
					name="<?php printf( '%1$s[minute]', esc_attr( $field['name'] ) ); ?>" 
					id="<?php $this->element_id( $field, 'minute' ); ?>" 
					<?php $this->input_attrs( $field, array( 'name', 'id' ) );?>>

						<?php for ( $i = 0; $i < 60; $i++ ) {
							$option = $this->get_time_option( $i ); ?>
							<option 
							value="<?php echo esc_attr( $option ); ?>"
							<?php selected( $option, $values['minute'] ); ?>><?php
								echo esc_html( $option );
							?></option>
						<?php } ?>

					</select>

					<span class="wp-backstage-time-field__sep">:</span>

				</span>

			</span>

			<span 
			id="<?php $this->element_id( $field, 'second_container' ); ?>"
			class="wp-backstage-time-field__piece-container">

				<label for="<?php $this->element_id( $field, 'second' ); ?>"><?php
					echo wp_kses( $second_label, 'wp_backstage_field_label' );
				?></label>

				<span class="wp-backstage-time-field__input-container">

					<select 
					name="<?php printf( '%1$s[second]', esc_attr( $field['name'] ) ); ?>" 
					id="<?php $this->element_id( $field, 'second' ); ?>" 
					<?php $this->input_attrs( $field, array( 'name', 'id' ) );?>>

						<?php for ( $i = 0; $i < 60; $i++ ) {
							$option = $this->get_time_option( $i ); ?>
							<option 
							value="<?php echo esc_attr( $option ); ?>"
							<?php selected( $option, $values['second'] ); ?>><?php
								echo esc_html( $option );
							?></option>
						<?php } ?>

					</select>

				</span>

			</span>

		</span>

	<?php }

}
