<?php
/**
 * WP Backstage Tel Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Tel Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Tel_Field extends WP_Backstage_Field {

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void { ?>
		<a href="<?php printf( 'tel:%1$s', esc_attr( preg_replace( '/[^0-9x]/', '', $value ) ) ); ?>" target="_blank" rel="noopener noreferrer"><?php
			echo esc_html( $value );
		?></a>
	<?php }

}
