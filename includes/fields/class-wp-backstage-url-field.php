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
	 * Validate
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return null|WP_Error true if valid, or an instance of `WP_Error` if invalid.
	 */
	public function validate( array $field = array(), $value = null ): ?WP_Error {
		// Validate URL.
		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return $this->validation_error(
				sprintf(
					/* translators: 1: field label. */
					_x( 'The value for %1$s is not a valid URL.', 'url field - validate', 'wp_backstage' ),
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
		<a href="<?php echo esc_url( $value ) ?>" target="_blank" rel="noopener noreferrer"><?php
			echo esc_html( $value );
		?></a>
	<?php }
}
