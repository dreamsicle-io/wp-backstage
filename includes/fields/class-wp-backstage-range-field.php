<?php
/**
 * WP Backstage Range Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Range Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Range_Field extends WP_Backstage_Field {

	/**
	 * Schema
	 *
	 * @since  4.0.0
	 * @var    array  $schema  The REST API schema definition.
	 */
	protected array $schema = array(
		'type' => array( 'number', 'null' ),
	);

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return float|null The santizied value.
	 */
	public function sanitize( mixed $value ): float|null {
		return is_numeric( $value ) ? floatval( $value ) : null;
	}
}
