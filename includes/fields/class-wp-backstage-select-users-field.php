<?php
/**
 * WP Backstage Select Users Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Select Users Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Select_Users_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'select_control',
	);

	/**
	 * Default Args
	 *
	 * @since 4.0.0
	 * @var array $default_args An array of default select users field arguments.
	 */
	protected array $default_args = array(
		'option_none_label' => '',
		'query'             => array(),
	);

	/**
	 * Default Query
	 *
	 * @since 4.0.0
	 * @var array $default_query An array of default query arguments.
	 */
	protected array $default_query = array(
		'number' => -1,
		'count'  => false,
	);

	/**
	 * Schema
	 *
	 * @since 4.0.0
	 * @var array $schema The REST API schema definition.
	 */
	protected array $schema = array(
		'type' => 'integer',
	);

	/**
	 * Construct
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function __construct() {
		$this->default_args = array_merge(
			$this->default_args,
			array(
				'option_none_label' => _x( 'Select a User', 'select users field - default option none label', 'wp_backstage' ),
			)
		);
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return int|null The santizied value.
	 */
	public function sanitize( $value = null ) {
		return is_numeric( $value ) ? absint( $value ) : null;
	}

	/**
	 * Add REST API Link
	 *
	 * @since 3.4.0
	 * @param WP_REST_Response $response The response object to manipulate.
	 * @param array            $field An array of field arguments.
	 * @param mixed            $value The field's value.
	 * @return WP_REST_Response The augmented response object.
	 */
	public function add_rest_api_link( WP_REST_Response $response, array $field = array(), $value = null ): WP_REST_Response {
		$user_id = absint( $value );
		if ( $user_id > 0 ) {
			$response->add_link(
				$this->get_rest_api_link_key( $field ),
				rest_url( sprintf( '/wp/v2/users/%1$d', $user_id ) ),
				array(
					'embeddable' => true,
				)
			);
		}
		return $response;
	}

	/**
	 * Get Query
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return array An array of `get_posts()` arguments.
	 */
	protected function get_query( array $field = array() ): array {
		$args = $this->get_args( $field );
		return wp_parse_args( $args['query'], $this->default_query );
	}

	/**
	 * Get Posts
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return WP_User[] An array of `get_posts()` arguments.
	 */
	protected function get_users( array $field = array() ): array {
		$query = $this->get_query( $field );
		return get_users( $query );
	}

	/**
	 * Render
	 *
	 * @since 4.0.0
	 * @param array $field an array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void {

		$args  = $this->get_args( $field );
		$users = $this->get_users( $field ); ?>

		<span 
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

			<select 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			id="<?php $this->element_id( $field ); ?>" 
			<?php $this->input_attrs( $field, array( 'name', 'id' ) ); ?>>

				<option value="" <?php selected( true, empty( $field['value'] ) ); ?>><?php
					printf( '― %1$s ―', esc_html( $args['option_none_label'] ) );
				?></option>

				<?php foreach ( $users as $user ) { ?>

					<option 
					value="<?php echo esc_attr( $user->ID ); ?>" 
					<?php selected( $field['value'], $user->ID ); ?>><?php
						printf(
							/* translators: 1: user display name, 2: user username */
							esc_html_x( '%1$s (%2$s)', 'select users field - option label', 'wp_backstage' ),
							esc_html( $user->display_name ),
							esc_html( $user->user_login )
						);
					?></option>

				<?php } ?>

			</select>

		</span>

	<?php }

}
