<?php
/**
 * WP Backstage Select Posts Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Select Posts Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Select_Posts_Field extends WP_Backstage_Field {

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
	 * @var array $default_args An array of default select posts field arguments.
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
		'posts_per_page' => -1,
		'post_type'      => 'page',
		'post_status'    => 'any',
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
				'option_none_label' => _x( 'Select a Post', 'select posts field - default option none label', 'wp_backstage' ),
			)
		);
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return int|null The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		return is_numeric( $value ) ? absint( $value ) : null;
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
	 * Get Users
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return WP_Post[] An array of `get_posts()` arguments.
	 */
	protected function get_posts( array $field = array() ): array {
		$query = $this->get_query( $field );
		return get_posts( $query );
	}

	/**
	 * Post Options
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	protected function post_options( array $field = array() ): void {
		$posts = $this->get_posts( $field );
		// phpcs:ignore WordPress.Security.EscapeOutput
		echo walk_page_dropdown_tree(
			$posts,
			0,
			array(
				'value_field' => 'ID',
				'selected'    => absint( $field['value'] ),
			)
		);
	}

	/**
	 * Render
	 *
	 * @since 4.0.0
	 * @param array $field an array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void {

		$args = $this->get_args( $field ); ?>

		<span 
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>">

			<select 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			id="<?php $this->element_id( $field ); ?>" 
			<?php disabled( true, $field['disabled'] ); ?>
			<?php $this->input_attrs( $field, array( 'name', 'id', 'disabled' ) ); ?>>

				<option value="" <?php selected( true, empty( $field['value'] ) ); ?>><?php
					printf( '― %1$s ―', esc_html( $args['option_none_label'] ) );
				?></option>

				<?php $this->post_options( $field ); ?>

			</select>

		</span>

	<?php }

}