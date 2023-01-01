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
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return float|null The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		return is_numeric( $value ) ? floatval( $value ) : null;
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
