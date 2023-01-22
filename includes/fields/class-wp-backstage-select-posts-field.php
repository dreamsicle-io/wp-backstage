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
		'is_filterable',
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
		$post_id = absint( $value );
		if ( $post_id > 0 ) {
			$post_type = get_post_type( $post_id );
			$response->add_link(
				$this->get_rest_api_link_key( $field ),
				rest_get_route_for_post( $post_id ),
				array(
					'postType'   => $post_type,
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
	 * Get Filter Args
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The value of the filter.
	 * @return array An array of filter control arguments.
	 */
	public function get_filter_args( array $field = array(), $value = null ): array {
		$query = $this->get_query( $field );
		$posts = $this->get_posts( $field );

		$post_type_obj = get_post_type_object( $query['post_type'] );

		$options = walk_page_dropdown_tree(
			$posts,
			0,
			array(
				'value_field' => 'ID',
				'selected'    => absint( $value ),
			)
		);

		return array(
			'name'              => $field['name'],
			'label'             => $field['label'],
			'value'             => absint( $value ),
			'options'           => $options,
			'option_none_label' => $post_type_obj->labels->all_items,
		);
	}

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {

		$post_id    = absint( $value );
		$url        = $this->get_filter_url( $field, $post_id );
		$label      = wp_strip_all_tags( get_the_title( $post_id ) );
		$link_title = sprintf(
			/* translators: 1: value label. */
			_x( 'Filter by %1$s', 'select posts field - column filter link title', 'wp_backstage' ),
			$label
		); ?>

		<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $link_title ); ?>"><?php
			echo esc_html( $label );
		?></a>

	<?php }

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
			<?php $this->input_attrs( $field, array( 'name', 'id' ) ); ?>>

				<option value="" <?php selected( true, empty( $field['value'] ) ); ?>><?php
					printf( '― %1$s ―', esc_html( $args['option_none_label'] ) );
				?></option>

				<?php $this->post_options( $field ); ?>

			</select>

		</span>

	<?php }

}
