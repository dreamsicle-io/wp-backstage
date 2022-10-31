<?php
/**
 * WP Backstage Widget
 *
 * @since       2.0.0
 * @since       3.0.0  linted and formatted with phpcs
 * @package     WPBackstage
 * @subpackage  Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Widget
 *
 * @since       2.0.0
 */
class WP_Backstage_Widget extends WP_Backstage_Component {

	/**
	 * Default Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'fields' => array(),
	);

	/**
	 * Required Args
	 *
	 * @since  0.0.1
	 * @var    array  $required_args  The required arguments for this instance. Arguments in this array will throw an error if empty.
	 */
	protected $required_args = array();

	/**
	 * Add
	 *
	 * @since   0.0.1
	 * @param   string $slug  The instance's unique identifier.
	 * @param   array  $args  An array of arguments for this instance.
	 * @return  WP_Backstage_Widget  A fully constructed instance of `WP_Backstage_Widget`.
	 */
	public static function add( $slug = '', $args = array() ) {

		$component = new WP_Backstage_Widget( $slug, $args );
		$component->init();
		return $component;

	}

	/**
	 * Construct
	 *
	 * @since   2.0.0
	 * @param   array $slug  The instance's unique identifier.
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	public function __construct( $slug = '', $args = array() ) {

		$this->slug = sanitize_key( $slug );
		$this->set_args( $args );
		$this->screen_id = array( 'widgets' );
		$this->nonce_key = '_wp_backstage_widget_nonce';
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 *
	 * @since   2.0.0
	 * @param   array $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {
		$this->args = wp_parse_args( $args, $this->default_args );
	}

	/**
	 * Set Errors
	 *
	 * @todo  Set error when existing registered widget has same slug.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	protected function set_errors() {

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[ $required_arg ] ) ) {

					$this->errors[] = new WP_Error(
						'required_widget_arg',
						sprintf(
							/* translators: 1:required arg key. */
							_x( '[widget] The %1$s key is required.', 'widget - required arg error', 'wp_backstage' ),
							'<code>' . $required_arg . '</code>'
						)
					);

				}
			}
		}

	}

	/**
	 * Init
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	public function init() {

		global $wp_backstage;

		if ( $wp_backstage->has_errors() ) {
			return;
		}

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		add_action( 'widgets_init', array( $this, 'register' ), 10 );
		add_action( sprintf( 'wp_backstage_widget_form_%1$s', $this->slug ), array( $this, 'render_fields' ), 10, 3 );
		add_filter( sprintf( 'wp_backstage_widget_save_%1$s', $this->slug ), array( $this, 'save' ), 10, 2 );

		parent::init();

	}

	/**
	 * Register
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	public function register() {
		$widget = new WP_Backstage_Widget_Base( $this->slug, $this->args );
		register_widget( $widget );
	}

	/**
	 * Get Fields
	 *
	 * @since   2.0.0
	 * @return  array  An array of field argument arrays.
	 */
	protected function get_fields() {

		$fields = array();

		if ( is_array( $this->args['fields'] ) && ! empty( $this->args['fields'] ) ) {

			foreach ( $this->args['fields'] as $field ) {

				$fields[] = wp_parse_args( $field, $this->default_field_args );

			}
		}

		return $fields;

	}

	/**
	 * Get Field Name
	 *
	 * Copied from `WP_Widget::get_field_name()` inorder to make `$id_base` and
	 * `$number` pluggable.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_widget/  WP_Widget
	 * @link https://developer.wordpress.org/reference/classes/wp_widget/get_field_name/  WP_Widget::get_field_name()
	 *
	 * @since   2.0.0
	 * @param   array  $field_name  The field name.
	 * @param   string $id_base     The current widget instance id base.
	 * @param   string $number      The current widget instance number.
	 * @return  string
	 */
	public function get_field_name( $field_name = '', $id_base = '', $number = 0 ) {
		$pos = strpos( $field_name, '[' );
		if ( false !== $pos ) {
			// Replace the first occurrence of '[' with ']['.
			$field_name = '[' . substr_replace( $field_name, '][', $pos, strlen( '[' ) );
		} else {
			$field_name = '[' . $field_name . ']';
		}
		return 'widget-' . $id_base . '[' . $number . ']' . $field_name;
	}

	/**
	 * Get Field ID
	 *
	 * Copied from `WP_Widget::get_field_id()` inorder to make `$id_base` and
	 * `$number` pluggable.
	 *
	 * @since   2.0.0
	 * @param   array  $field_name  The field name.
	 * @param   string $id_base     The current widget instance id base.
	 * @param   string $number      The current widget instance number.
	 * @return  string
	 */
	public function get_field_id( $field_name = '', $id_base = '', $number = 0 ) {
		$field_name = str_replace( array( '[]', '[', ']' ), array( '', '-', '' ), $field_name );
		$field_name = trim( $field_name, '-' );

		return 'widget-' . $id_base . '-' . $number . '-' . $field_name;
	}

	/**
	 * Render Fields
	 *
	 * @since   2.0.0
	 * @param   array  $instance  The current widget instance values.
	 * @param   string $id_base   The current widget instance id base.
	 * @param   string $number    The current widget instance number.
	 * @return  void
	 */
	public function render_fields( $instance = array(), $id_base = '', $number = 0 ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				$field_name     = $field['name'];
				$field['name']  = $this->get_field_name( $field_name, $id_base, $number );
				$field['id']    = $this->get_field_id( $field_name, $id_base, $number );
				$field['value'] = isset( $instance[ $field_name ] ) ? $instance[ $field_name ] : null;
				$input_class    = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

				if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows                  = ( $field['type'] === 'textarea' ) ? 6 : 10;
					$default_cols                  = 20;
					$field['input_attrs']['rows']  = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols']  = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $default_cols;
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( $field['type'] === 'code' ) {
					$field['args']['settings_key'] = $field_name;
				}

				$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $instance ); ?>

				<p><?php

					do_action( "wp_backstage_{$this->slug}_field_before", $field, $instance );

					$this->render_field_by_type( $field );

					do_action( "wp_backstage_{$this->slug}_field_after", $field, $instance );

				?></p>

			<?php }
		}

	}

	/**
	 * Save
	 *
	 * @todo    Though its probably not needed, try to check nonce here.
	 *
	 * @since   2.0.0
	 * @param   array $new_instance  The new widget instance values.
	 * @param   array $old_instance  The old widget instance values.
	 * @return  array The new instance args.
	 */
	public function save( $new_instance = array(), $old_instance = array() ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				if ( isset( $new_instance[ $field['name'] ] ) ) {

					$value                          = $this->sanitize_field( $field, $new_instance[ $field['name'] ] );
					$new_instance[ $field['name'] ] = $value;

				} else {

					unset( $new_instance[ $field['name'] ] );

				}
			}
		}

		return $new_instance;

	}

}
