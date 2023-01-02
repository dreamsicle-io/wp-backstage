<?php
/**
 * WP Backstage Number Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Number Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Number_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array();

	/**
	 * Schema
	 *
	 * @since  4.0.0
	 * @var    array  $schema  The REST API schema definition.
	 */
	protected array $schema = array(
		'type' => 'number',
	);

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return float|null The santizied value.
	 */
	public function sanitize( $value = null ) {
		return is_numeric( $value ) ? floatval( $value ) : null;
	}

	/**
	 * Validate
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return null|WP_Error null if valid, or an instance of `WP_Error` if invalid.
	 */
	public function validate( array $field = array(), $value = null ): ?WP_Error {

		$min = isset( $field['input_attrs']['min'] ) ? floatval( $field['input_attrs']['min'] ) : null;
		$max = isset( $field['input_attrs']['max'] ) ? floatval( $field['input_attrs']['max'] ) : null;

		// Validate minimum.
		if ( ! empty( $min ) ) {
			if ( ! filter_var( $value, FILTER_VALIDATE_FLOAT, array( 'options' => array( 'min_range' => $min ) ) ) ) {
				return $this->validation_error(
					sprintf(
						/* translators: 1: field label, 2: field minimum. */
						_x( 'The value for %1$s must be greater than or equal to %2$d.', 'number field - validate minimum', 'wp_backstage' ),
						$this->get_label( $field ),
						$max
					)
				);
			}
		}

		// Validate maximum.
		if ( ! empty( $max ) ) {
			if ( ! filter_var( $value, FILTER_VALIDATE_FLOAT, array( 'options' => array( 'max_range' => $max ) ) ) ) {
				return $this->validation_error(
					sprintf(
						/* translators: 1: field label, 2: field maximum. */
						_x( 'The value for %1$s must be less than or equal to %2$d.', 'number field - validate maximum', 'wp_backstage' ),
						$this->get_label( $field ),
						$max
					)
				);
			}
		}

		// Run the default validations.
		return parent::validate( $field, $value );
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_number_field_style">

			.form-field .wp-backstage-field--type-number input {
				width: auto;
			}

		</style>

	<?php }
}
