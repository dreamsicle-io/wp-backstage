<?php
/**
 * WP Backstage URL Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage URL Field
 *
 * @since 4.0.0
 */
class WP_Backstage_URL_Field extends WP_Backstage_Field {

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		return esc_url_raw( $value );
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
		<a href="<?php echo esc_url( $value ) ?>" target="_blank" rel="noopener noreferrer"><?php
			echo esc_html( $value );
		?></a>
	<?php }
}
