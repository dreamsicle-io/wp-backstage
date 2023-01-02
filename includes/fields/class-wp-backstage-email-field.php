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
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( $value = null ) {
		return sanitize_email( $value );
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
		// Validate email.
		if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return $this->validation_error(
				sprintf(
					/* translators: 1: field label. */
					_x( 'The value for %1$s is not a valid email address.', 'email field - validate', 'wp_backstage' ),
					$this->get_label( $field )
				)
			);
		}
		// Run the default validations.
		return parent::validate( $field, $value );
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
