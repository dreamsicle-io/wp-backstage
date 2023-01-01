<?php
/**
 * WP Backstage Email Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Email Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Email_Field extends WP_Backstage_Field {

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		return sanitize_email( $value );
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

}
