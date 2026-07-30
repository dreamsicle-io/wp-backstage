<?php
/**
 * WP Backstage Dashboard Widget
 *
 * @since       4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Dashboard Widget
 *
 * @since 4.0.0
 */
class WP_Backstage_Dashboard_Widget extends WP_Backstage_Component {

	/**
	 * Default Args
	 *
	 * @since  4.0.0
	 * @var    array  $default_args  The default arguments for this instance.
	 */
	protected array $default_args = array(
		'title'       => '',
		'description' => '',
		'help'        => '',
		'context'     => 'normal',
		'priority'    => 'core',
		'fields'      => array(),
	);

	/**
	 * Required Args
	 *
	 * @since  4.0.0
	 * @var    array  $required_args  The required arguments for this instance.
	 */
	protected array $required_args = array(
		'title',
	);

	/**
	 * Add
	 *
	 * @since   4.0.0
	 * @param   string $slug  The instance's unique identifier.
	 * @param   array  $args  An array of arguments for this instance.
	 * @return  WP_Backstage_Dashboard_Widget  A fully constructed instance.
	 */
	public static function add( string $slug, array $args ): WP_Backstage_Dashboard_Widget {

		$component = new WP_Backstage_Dashboard_Widget( $slug, $args );
		$component->init();
		return $component;
	}

	/**
	 * Construct
	 *
	 * @since   4.0.0
	 * @param   string $slug  The instance's unique identifier.
	 * @param   array  $args  An array of arguments.
	 */
	public function __construct( string $slug, array $args ) {

		$this->slug = sanitize_key( $slug );
		$this->set_args( $args );
		$this->screen_id = array( 'dashboard' );
		$this->nonce_key = '_wp_backstage_dashboard_widget_nonce';
		$this->set_errors();

		parent::__construct();
	}

	/**
	 * Set Args
	 *
	 * @since   4.0.0
	 * @param   array $args  An array of arguments.
	 */
	protected function set_args( array $args ) {
		$this->args = wp_parse_args( $args, $this->default_args );
		foreach ( $this->args['fields'] as $i => $field ) {
			$this->args['fields'][ $i ] = wp_parse_args( $field, $this->default_field_args );
		}
	}

	/**
	 * Set Errors
	 *
	 * @todo  Set error when existing registered dashboard widget has same slug.
	 *
	 * @since   4.0.0
	 */
	protected function set_errors() {

		foreach ( $this->required_args as $required_arg ) {

			if ( empty( $this->args[ $required_arg ] ) ) {

				$this->errors[] = new WP_Error(
					'required_dashboard_widget_arg',
					sprintf(
						/* translators: 1: required arg key. */
						_x( '[Dashboard Widget] The %1$s key is required.', 'dashboard widget - required arg error', 'wp_backstage' ),
						'<code>' . $required_arg . '</code>'
					)
				);

			}
		}

		parent::set_errors();
	}

	/**
	 * Init
	 *
	 * @since   4.0.0
	 */
	public function init() {

		add_action( 'wp_dashboard_setup', array( $this, 'save' ), 5 );
		add_action( 'wp_dashboard_setup', array( $this, 'register' ), 10 );
		add_action( 'admin_head', array( $this, 'extend_dashboard_content_help_tab' ), 9999 );

		parent::init();
	}

	/**
	 * Register
	 *
	 * @since   4.0.0
	 */
	public function register() {
		wp_add_dashboard_widget(
			$this->slug,
			$this->args['title'],
			array( $this, 'render' ),
			array( $this, 'render_fields' ),
			$this->get_values(),
			$this->args['context'],
			$this->args['priority']
		);
	}

	/**
	 * Extend Dashboard Content Help Tab.
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
	 *
	 * @since   4.0.0
	 */
	public function extend_dashboard_content_help_tab() {

		$screen = get_current_screen();

		if ( $this->is_screen( 'id', 'dashboard', $screen ) ) {

			$content_help_tab = $screen->get_help_tab( 'help-content' );

			if ( ! empty( $content_help_tab ) ) {
				$help_content = sprintf(
					/* translators: 1: dashboard widget title, 2: dashboard widget help text. */
					_x( '<strong>%1$s</strong> ― %2$s', 'dashboard widget - content help tab description template', 'wp_backstage' ),
					$this->args['title'],
					! empty( $this->args['help'] ) ? $this->args['help'] : $this->args['description'],
				);
				$content_help_tab['content'] .= wp_kses_post( wpautop( $help_content ) );
				$screen->add_help_tab( $content_help_tab );
			}
		}
	}

	/**
	 * Get Values
	 *
	 * @since 4.0.0
	 * @return array The saved dashboard widget instance args.
	 */
	protected function get_values(): array {
		$widgets = get_option( 'dashboard_widget_options' );

		if ( ! is_array( $widgets ) || ! isset( $widgets[ $this->slug ] ) || ! is_array( $widgets[ $this->slug ] ) ) {
			return array();
		}

		return $widgets[ $this->slug ];
	}

	/**
	 * Update Values
	 *
	 * @since 4.0.0
	 * @param array $values The dashboard widget values.
	 */
	protected function update_values( array $values ) {
		$widgets = get_option( 'dashboard_widget_options' );

		if ( ! is_array( $widgets ) ) {
			$widgets = array();
		}

		$widgets[ $this->slug ] = $values;
		update_option( 'dashboard_widget_options', $widgets, false );
	}

	/**
	 * Save
	 *
	 * @since 4.0.0
	 */
	public function save() {

		$post_data = ! empty( $_POST ) ? wp_unslash( $_POST ) : null;

		if ( ! current_user_can( 'edit_dashboard' ) ) {
			return;
		}
		if ( empty( $post_data ) ) {
			return;
		}
		if ( empty( $post_data[ $this->nonce_key ] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $post_data[ $this->nonce_key ], 'edit' ) ) {
			return;
		}

		$values = $post_data[ $this->slug ];

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				if ( isset( $values[ $field['name'] ] ) ) {

					$field_class = $this->get_field_class( $field['type'] );
					$value       = $field_class->sanitize( $values[ $field['name'] ] );

					$values[ $field['name'] ] = $value;

				} else {

					unset( $values[ $field['name'] ] );

				}
			}
		}

		$this->update_values( $values );
	}

	/**
	 * Render
	 *
	 * @since 4.0.0
	 * @param mixed $dashboard The current dashboard object.
	 * @param array $meta_box  The dashboard widget meta box array. Access the saved values through `$meta_box['args']`.
	 */
	public function render( $dashboard, array $meta_box ) {
		/**
		 * Fires when the dashboard widget is rendered.
		 *
		 * @since 4.0.0
		 * @param array $args   The dashboard widget args.
		 * @param array $values The current widget's instance values.
		 */
		do_action( "wp_backstage_dashboard_widget_output_{$this->slug}", $this->args, $meta_box['args'] );
	}

	/**
	 * Render Form Fields
	 *
	 * @since 4.0.0
	 * @param mixed $dashboard The current dashboard object, or an empty string when invoked as a control callback.
	 * @param array $meta_box  The dashboard widget meta box array.
	 */
	public function render_fields( mixed $dashboard, array $meta_box ) {

		$values = $this->get_values();
		$fields = $this->get_fields();

		$this->render_edit_nonce();

		foreach ( $fields as $field ) {

			$field_name     = $field['name'];
			$field['name']  = $this->get_field_name( $field_name );
			$field['id']    = $this->get_field_id( $field_name );
			$field['value'] = isset( $values[ $field_name ] ) ? $values[ $field_name ] : null;

			$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $field, $values );

			$field_class = $this->get_field_class( $field['type'] );

			if ( $field_class->has_tag( 'text_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
			}

			if ( $field_class->has_tag( 'textarea_control' ) ) {
				$field = $this->add_field_input_classes( $field, array( 'widefat' ) );
				$field = $this->set_field_textarea_dimensions( $field, 6, 50 );
			} ?>

			<p><?php

				/**
				 * Fires before the dashboard widget field is rendered.
				 *
				 * @since 4.0.0
				 * @param array $field An array of field arguments.
				 * @param array $values The current widget's instance values`.
				 */
				do_action( "wp_backstage_{$this->slug}_field_before", $field, $values );

				$this->render_field_label( $field );

				$field_class->render( $field );

				$this->render_field_description( $field );

				/**
				 * Fires after the dashboard widget field is rendered.
				 *
				 * @since 4.0.0
				 * @param array $field An array of field arguments.
				 * @param array $values The current widget's instance values`.
				 */
				do_action( "wp_backstage_{$this->slug}_field_after", $field, $values );

			?></p>

		<?php }
	}

	/**
	 * Get Fields
	 *
	 * @since   4.0.0
	 * @return  array  An array of field argument arrays.
	 */
	protected function get_fields(): array {
		return $this->args['fields'];
	}

	/**
	 * Get Field Name
	 *
	 * @since   4.0.0
	 * @param   string $field_name  The field name.
	 * @return  string
	 */
	public function get_field_name( string $field_name ): string {
		$pos = strpos( $field_name, '[' );
		if ( false !== $pos ) {
			$field_name = '[' . substr_replace( $field_name, '][', $pos, strlen( '[' ) );
		} else {
			$field_name = '[' . $field_name . ']';
		}
		return $this->slug . $field_name;
	}

	/**
	 * Get Field ID
	 *
	 * @since   4.0.0
	 * @param   string $field_name  The field name.
	 * @return  string
	 */
	public function get_field_id( string $field_name ): string {
		$field_name = str_replace( array( '[]', '[', ']' ), array( '', '-', '' ), $field_name );
		$field_name = trim( $field_name, '-' );

		return sprintf( 'dashboard-widget-%1$s-%2$s', $this->slug, $field_name );
	}

	/**
	 * Render Field Label
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 */
	protected function render_field_label( array $field ) {

		$field_class = $this->get_field_class( $field['type'] );

		$label = sprintf(
			/* translators: 1: field name. */
			_x( '%1$s:', 'dashboard widget - field label', 'wp_backstage' ),
			$field['label']
		);

		if ( $field_class->has_tag( 'remove_label_for' ) ) { ?>

			<legend class="<?php echo $field_class->has_tag( 'hide_label' ) ? 'screen-reader-text' : ''; ?>"><?php
				echo wp_kses( $label, 'wp_backstage_field_label' );
			?></legend>

		<?php } else { ?>

			<label
			for="<?php $field_class->element_id( $field ); ?>"
			class="<?php echo $field_class->has_tag( 'hide_label' ) ? 'screen-reader-text' : ''; ?>"><?php
				echo wp_kses( $label, 'wp_backstage_field_label' );
			?></label>

		<?php }
	}

	/**
	 * Render Field Description
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 */
	protected function render_field_description( array $field ) {

		if ( ! empty( $field['description'] ) ) {

			$field_class = $this->get_field_class( $field['type'] ); ?>

			<span
			class="description"
			id="<?php $field_class->element_id( $field, 'description' ); ?>"><?php
				$field_class->description( $field );
			?></span>

		<?php }
	}
}
