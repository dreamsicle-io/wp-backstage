<?php
/**
 * WP Backstage Options
 *
 * @since       0.0.1
 * @since       3.0.0  linted and formatted with phpcs
 * @package     WPBackstage
 * @subpackage  Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Options
 *
 * @since       0.0.1
 */
class WP_Backstage_Options extends WP_Backstage_Component {

	/**
	 * Default Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_args  An array of default arguments for this instance.
	 */
	protected $default_args = array(
		'type'        => 'settings', // settings, theme, tools.
		'title'       => '',
		'menu_title'  => '',
		'description' => '',
		'capability'  => 'manage_options',
		'sections'    => array(),
	);

	/**
	 * Default Section Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_section_args  An array of default section arguments.
	 */
	protected $default_section_args = array(
		'id'          => '',
		'title'       => '',
		'description' => '',
		'fields'      => array(),
	);

	/**
	 * Required Args
	 *
	 * @since  0.0.1
	 * @var    array  $required_args  An array of required argument keys.
	 */
	protected $required_args = array(
		'type',
	);

	/**
	 * Registered
	 *
	 * @since  0.0.1
	 * @var    array  $registered  An array of already-registered option keys.
	 */
	protected static $registered = array();

	/**
	 * Add
	 *
	 * @since   0.0.1
	 * @param   string $slug The slug of this component's instance.
	 * @param   array  $args The args array for this component's instance.
	 * @return  WP_Backstage_Options  A fully constructed `WP_Backstage_Options` instance.
	 */
	public static function add( $slug = '', $args = array() ) {

		$component = new WP_Backstage_Options( $slug, $args );
		$component->init();
		return $component;

	}

	/**
	 * Construct
	 *
	 * @since   0.0.1
	 * @param   string $slug The slug of this component's instance.
	 * @param   array  $args The args needed to construct this component's instance.
	 * @return  void
	 */
	public function __construct( $slug = '', $args = array() ) {

		$this->default_address_args = array_merge(
			$this->default_address_args,
			array(
				'max_width' => '50em',
			)
		);
		$this->default_code_args    = array_merge(
			$this->default_code_args,
			array(
				'max_width' => '50em',
			)
		);
		$this->default_editor_args  = array_merge(
			$this->default_editor_args,
			array(
				'max_width' => '50em',
			)
		);
		$this->slug                 = sanitize_key( $slug );
		$this->set_args( $args );
		$this->screen_id = array(
			sprintf( 'settings_page_%1$s', $this->slug ),
			sprintf( 'appearance_page_%1$s', $this->slug ),
			sprintf( 'tools_page_%1$s', $this->slug ),
		);
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 *
	 * @since   0.0.1
	 * @param array $args The incoming args for this component's instance.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['title'] ) ) {

			$this->args['title'] = $this->slug;

		}

		if ( empty( $this->args['menu_title'] ) ) {

			$this->args['menu_title'] = $this->args['title'];

		}

	}

	/**
	 * Set Errors
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	protected function set_errors() {

		if ( empty( $this->slug ) ) {

			$this->errors[] = new WP_Error(
				'required_options_slug',
				sprintf(
					/* translators: 1: options page slug. */
					_x( '[Options: %1$s] A slug is required when adding a new options page.', 'options - required slug error', 'wp_backstage' ),
					$this->slug
				)
			);

		}

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[ $required_arg ] ) ) {

					$this->errors[] = new WP_Error(
						'required_options_arg',
						sprintf(
							/* translators: 1: options page slug, 2:required arg key. */
							_x( '[Options: %1$s] The %2$s key is required.', 'options - required arg error', 'wp_backstage' ),
							$this->slug,
							'<code>' . $required_arg . '</code>'
						)
					);

				}
			}
		}

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				if ( in_array( $field['name'], self::$registered ) ) {

					$this->errors[] = new WP_Error(
						'duplicate_options_key',
						sprintf(
							/* translators: 1: options page slug, 2: setting key. */
							_x( '[Options: %1$s] There is already an option with the %2$s key.', 'options - setting exists error', 'wp_backstage' ),
							$this->slug,
							'<code>' . $field['name'] . '</code>'
						)
					);

				} else {

					self::$registered[] = $field['name'];

				}
			}
		}

	}

	/**
	 * Hook Script Action
	 *
	 * There is no general options page action for printing footer scripts.
	 * This hook allows WP Backstage to know if this is a settings page added
	 * by the plugin and gives a simple place to hook the options script from
	 * the `WP_Backstage` setup class.
	 *
	 * @since  2.0.0
	 * @return void
	 */
	public function hook_script_action() {

		if ( ! did_action( 'wp_backstage_options_print_footer_scripts' ) ) {

			/**
			 * Fires at the bottom of options page scripts rendered by the plugin.
			 *
			 * @since 0.0.1
			 *
			 * @param string $slug The slug of the current options page.
			 */
			do_action( 'wp_backstage_options_print_footer_scripts', $this->slug );
		}
	}

	/**
	 * Init
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Added `hook_script_action` actions to all types of options pages.
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

		add_action( 'admin_menu', array( $this, 'add_page' ), 10 );
		add_action( 'admin_init', array( $this, 'add_settings' ), 10 );
		add_action( 'tool_box', array( $this, 'add_tool_card' ), 10 );
		add_action( "admin_print_footer_scripts-settings_page_{$this->slug}", array( $this, 'hook_script_action' ), 10 );
		add_action( "admin_print_footer_scripts-appearance_page_{$this->slug}", array( $this, 'hook_script_action' ), 10 );
		add_action( "admin_print_footer_scripts-tools_page_{$this->slug}", array( $this, 'hook_script_action' ), 10 );

		parent::init();

	}

	/**
	 * Add Tool Card
	 *
	 * This function adds the tool card when this component is of type `tools`.
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public function add_tool_card() {

		if ( $this->args['type'] === 'tools' ) {

			$link_url   = add_query_arg( array( 'page' => $this->slug ), admin_url( '/tools.php' ) );
			$link_title = _x( 'Go to tool', 'options - tool card link', 'wp_backstage' ); ?>

			<div class="card">

				<?php if ( ! empty( $this->args['title'] ) ) { ?>

					<h2 class="title">

						<a 
						href="<?php echo esc_url( $link_url ); ?>"
						title="<?php echo esc_attr( $link_title ); ?>"
						style="text-decoration:none;"><?php

							echo esc_html( $this->args['title'] );

						?></a>

					</h2>

				<?php } ?>

				<?php if ( ! empty( $this->args['description'] ) ) {

					echo wp_kses_post( wpautop( $this->args['description'] ) );

				} ?>

			</div>

		<?php }

	}

	/**
	 * Add Page
	 *
	 * Adds the page according to the `type` argument. If `type` is set to
	 * `theme`, `add_theme_page()` will be used. If `type` is set to `tools`,
	 * `add_management_page()` will be used. If `type` is set to `settings`
	 * (default), `add_options_page()` will be used.
	 *
	 * @link    https://codex.wordpress.org/Function_Reference/add_theme_page add_theme_page()
	 * @link    https://codex.wordpress.org/Function_Reference/add_management_page add_management_page()
	 * @link    https://codex.wordpress.org/Function_Reference/add_options_page add_options_page()
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	public function add_page() {

		switch ( $this->args['type'] ) {
			case 'theme':
				add_theme_page(
					$this->args['title'],
					$this->args['menu_title'],
					$this->args['capability'],
					$this->slug,
					array( $this, 'render_page' )
				);
				break;
			case 'tools':
				add_management_page(
					$this->args['title'],
					$this->args['menu_title'],
					$this->args['capability'],
					$this->slug,
					array( $this, 'render_page' )
				);
				break;
			default:
				add_options_page(
					$this->args['title'],
					$this->args['menu_title'],
					$this->args['capability'],
					$this->slug,
					array( $this, 'render_page' )
				);
				break;
		}
	}

	/**
	 * Add Settings
	 *
	 * @todo  Maybe make per field rest option?
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	public function add_settings() {

		$sections = $this->get_sections();

		if ( is_array( $sections ) && ! empty( $sections ) ) {

			foreach ( $sections as $section ) {

				add_settings_section(
					$section['id'],
					$section['title'],
					array( $this, 'render_section_description' ),
					$this->slug
				);

				if ( is_array( $section['fields'] ) && ! empty( $section['fields'] ) ) {

					foreach ( $section['fields'] as $field ) {

						$field               = wp_parse_args( $field, $this->default_field_args );
						$field_id            = sanitize_key( $field['name'] );
						$field['value']      = get_option( $field['name'] );
						$field['show_label'] = false;
						$input_class         = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

						if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
							$field['input_attrs']['class'] = sprintf( 'regular-text %1$s', $input_class );
						}

						if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
							$default_rows                 = ( $field['type'] === 'editor' ) ? 15 : 5;
							$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
							$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : 90;
						}

						register_setting(
							$this->slug,
							$field['name'],
							array(
								'description'       => wp_kses( $field['description'], WP_Backstage::$kses_p ),
								'show_in_rest'      => $this->args['show_in_rest'],
								'sanitize_callback' => array( $this, $this->get_sanitize_callback( $field ) ),
							)
						);

						add_settings_field(
							$field['name'],
							$field['label'],
							array( $this, 'render_setting' ),
							$this->slug,
							$section['id'],
							array(
								'label_for' => ! in_array( $field['type'], $this->remove_label_for_fields ) ? $field_id : false,
								'class'     => '',
								'field'     => $field,
							)
						);

					}
				}
			}
		}

	}

	/**
	 * Render Setting
	 *
	 * This method is responsible for rendering a singular setting.
	 *
	 * @since 0.0.1
	 * @param array $args The args for this singular setting.
	 * @return void
	 */
	public function render_setting( $args = array() ) {

		$args = wp_parse_args(
			$args,
			array(
				'label_for' => '',
				'class'     => '',
				'field'     => array(),
			)
		);

		/**
		 * Filters the field arguments just before the field is rendered.
		 *
		 * @since 0.0.1
		 *
		 * @param array $field an array of field arguments.
		 */
		$field = apply_filters( "wp_backstage_{$this->slug}_field_args", $args['field'] );

		/**
		 * Fires before the settings field is rendered.
		 *
		 * @since 0.0.1
		 *
		 * @param array $field an array of field arguments.
		 */
		do_action( "wp_backstage_{$this->slug}_field_before", $field );

		$this->render_field_by_type( $field );

		/**
		 * Fires after the settings field is rendered.
		 *
		 * @since 0.0.1
		 *
		 * @param array $field an array of field arguments.
		 */
		do_action( "wp_backstage_{$this->slug}_field_after", $field );

	}

	/**
	 * Get Sections By
	 *
	 * @since   0.0.1
	 * @param string $key The section key to run the search against.
	 * @param mixed  $value The value of the set key to run the search against.
	 * @param int    $number The max number of sections to find.
	 * @return array  the sections if found, or an empty array.
	 */
	protected function get_sections_by( $key = '', $value = null, $number = 0 ) {

		$sections = $this->get_sections();
		$result   = array();

		if ( ! empty( $key ) && ( is_array( $sections ) && ! empty( $sections ) ) ) {

			$i = 0;

			foreach ( $sections as $section ) {

				if ( isset( $section[ $key ] ) && ( $section[ $key ] === $value ) ) {

					$result[] = $section;

					if ( ( $number > 0 ) && ( $number === ( $i + 1 ) ) ) {
						break;
					}

					$i++;

				}
			}
		}

		return $result;

	}

	/**
	 * Get Section By
	 *
	 * @since   0.0.1
	 * @param string $key The section key to run the search against.
	 * @param mixed  $value The value of the set key to run the search against.
	 * @return array the first section if found, or null.
	 */
	protected function get_section_by( $key = '', $value = null ) {

		$sections = $this->get_sections_by( $key, $value, 1 );
		$result   = null;

		if ( is_array( $sections ) && ! empty( $sections ) ) {

			$result = $sections[0];

		}

		return $result;

	}

	/**
	 * Render Section Description
	 *
	 * @since 0.0.1
	 * @param array $args An array of section args.
	 * @return void
	 */
	public function render_section_description( $args = array() ) {

		$args = wp_parse_args(
			$args,
			array(
				'id'       => '',
				'title'    => '',
				'callback' => array(),
			)
		);

		if ( ! empty( $args['id'] ) ) {

			$section = $this->get_section_by( 'id', $args['id'] );

			if ( ! empty( $section ) ) { ?>

				<p class="description"><?php

					echo wp_kses( $section['description'], WP_Backstage::$kses_p );

				?></p>

			<?php }
		}

	}

	/**
	 * Render Page
	 *
	 * This method is responsible for rendering the entire page including the wrapper,
	 * form, submit button and all settings fields.
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public function render_page() { ?>

		<div class="wrap">

			<h1><?php

				echo wp_kses( $this->args['title'], WP_Backstage::$kses_p );

			?></h1>

			<?php if ( ! empty( $this->args['description'] ) ) { ?>

				<p class="description"><?php

					echo wp_kses( $this->args['description'], WP_Backstage::$kses_p );

				?></p>

			<?php } ?>

			<form method="POST" action="options.php"> <?php

				settings_fields( $this->slug );

				do_settings_sections( $this->slug );

				submit_button();

			?></form>

		</div>

	<?php }

	/**
	 * Get Meta Boxes
	 *
	 * @since   0.0.1
	 * @return  array
	 */
	protected function get_sections() {

		$sections = array();

		if ( is_array( $this->args['sections'] ) && ! empty( $this->args['sections'] ) ) {

			foreach ( $this->args['sections'] as $section ) {

				$sections[] = wp_parse_args( $section, $this->default_section_args );

			}
		}

		return $sections;

	}

	/**
	 * Get Fields
	 *
	 * @since   0.0.1
	 * @return  array
	 */
	protected function get_fields() {

		$sections = $this->get_sections();
		$fields   = array();

		if ( is_array( $sections ) && ! empty( $sections ) ) {

			foreach ( $sections as $section ) {

				if ( is_array( $section['fields'] ) && ! empty( $section['fields'] ) ) {

					foreach ( $section['fields'] as $field ) {

						$fields[] = wp_parse_args( $field, $this->default_field_args );

					}
				}
			}
		}

		return $fields;

	}

}
