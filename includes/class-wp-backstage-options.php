<?php
/**
 * WP Backstage Options
 * 
 * @version     0.0.1
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Options extends WP_Backstage {

	/**
	 * Slug
	 * 
	 * @since 0.0.1
	 */
	public $slug = '';

	/**
	 * Default Args
	 * 
	 * @since 0.0.1
	 */
	public $default_args = array(
		'title'        => '', 
		'menu_title'   => '', 
		'description'  => '', 
		'capability'   => 'manage_options', 
		'sections' => array(), 
	);

	/**
	 * Default Section Args
	 * 
	 * @since 0.0.1
	 */
	public $default_section_args = array(
		'id'          => '', 
		'title'       => '', 
		'description' => '', 
		'fields'      => array(), 
	);

	/**
	 * Required Args
	 * 
	 * @since 0.0.1
	 */
	public $required_args = array();

	/**
	 * Add
	 * 
	 * @since   0.0.1
	 * @param   array   $args 
	 * @return  void 
	 */
	public static function add( $slug = '', $args = array() ) {

		$Options = new WP_Backstage_Options( $slug, $args );

		$Options->init();

	}

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @param   array   $args 
	 * @return  void 
	 */
	function __construct( $slug = '', $args = array() ) {

		$this->default_address_args = array_merge( $this->default_address_args, array(
			'max_width'  => '50em', 
		) );
		$this->default_code_args = array_merge( $this->default_code_args, array(
			'max_width'  => '50em', 
		) );
		$this->slug = sanitize_title_with_dashes( $slug );
		$this->set_args( $args );
		$this->screen_id = sprintf( 'settings_page_%1$s', $this->slug );
		$this->nonce_key = sprintf( '_wp_backstage_options_%1$s_nonce', $this->slug );
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has errors or not. 
	 */
	public function set_args( $args = array() ) {

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['title'] ) ) {

			$this->args['title'] = $this->slug;

		}

		if ( empty( $this->args['menu_title'] ) ) {

			$this->args['menu_title'] = $this->args['title'];

		}

		if ( ! empty( $this->args['sections'] ) ) {
			foreach ( $this->args['sections'] as $section_index => $section ) {
				if ( ! empty( $section['fields'] ) ) {
					foreach ( $section['fields'] as $field_index => $field ) {
						$this->args['sections'][$section_index]['fields'][$field_index]['name'] = sprintf( '%1$s[%2$s]', $this->slug, $field['name'] );
					}
				}
			}
		}

	}

	/**
	 * Set Errors
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function set_errors() {

		if ( empty( $this->slug ) ) {
			
			$this->errors[] = new WP_Error( 'required_options_slug', sprintf( 
				/* translators: 1: post type slug. */
				__( '[options: %1$s] A slug is required when adding a new options page.', 'wp-backstage' ), 
				$this->slug
			) );
		
		} 

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_options_arg', sprintf( 
						/* translators: 1: options slug, 2:required arg key. */
						__( '[options: %1$s] The %2$s key is required.', 'wp-backstage' ), 
						$this->slug,
						'<code>' . $required_arg . '</code>'
					) );

				}

			}

		}

	}

	/**
	 * Init
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function init() {

		if ( $this->has_errors() ) {
			
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			
			return;

		}

		add_action( 'admin_menu', array( $this, 'add_options_page' ), 10 );
		add_action( 'admin_init', array( $this, 'add_settings' ), 10 );
		$this->hook_inline_styles( $this->slug );
		$this->hook_inline_scripts( $this->slug );

		parent::init();

	}

	/**
	 * Add Options Page
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function add_options_page() {

		add_options_page( 
			$this->args['title'], 
			$this->args['menu_title'], 
			$this->args['capability'], 
			$this->slug, 
			array( $this, 'render_page' ) 
		);

	}

	/**
	 * Add Settings
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function add_settings() {

		$sections = $this->get_sections();
		$fields = array();
		$values = get_option( $this->slug );

		register_setting(
			$this->slug, 
			$this->slug, 
			array(
				'description'       => wp_kses( $this->args['description'], $this->kses_p ), 
				'show_in_rest'      => $this->args['show_in_rest'], 
				'sanitize_callback' => array( $this, 'save' ),  
			)
		);

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

						$field = wp_parse_args( $field, $this->default_field_args );
						$field_id = sanitize_title_with_dashes( $field['name'] );
						$field_key = $this->format_field_key( $field['name'] );
						$field['value'] = isset( $values[$field_key] ) ? $values[$field_key] : null;
						$field['show_label'] = false;

						if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
							$field['input_attrs']['class'] = 'regular-text';
						}

						if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
							$field['input_attrs']['rows'] = 5;
							$field['input_attrs']['cols'] = 90;
						}

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
	 * Save
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function save( $data = array() ) {

		$fields = $this->get_fields();

		$values = array();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				$field_key = $this->format_field_key( $field['name'] );

				if ( isset( $data[$field_key] ) ) {

					$value = $this->sanitize_field( $field, $data[$field_key] );

					update_option( $field_key, $value );

					$values[$field_key] = $value;

				} elseif ( in_array( $field['type'], array( 'checkbox', 'checkbox_set', 'radio' ) ) ) {

					$value = ( $field['type'] === 'radio' ) ? '' : false;

					update_option( $field_key, $value );

					$values[$field_key] = $value;

				} 

			}

		}

		return $values;

	}

	public function format_field_key( $name = '' ) {

		$pattern = '/^' . $this->slug . '\[|\]$/';

		return preg_replace( $pattern, '', $name );

	}

	public function render_setting( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'label_for' => '', 
			'class'     => '', 
			'field'     => array(), 
		) );

		do_action( $this->format_field_action( $this->slug, 'before' ), $args['field'] );

		$this->render_field_by_type( $args['field'] );

		do_action( $this->format_field_action( $this->slug, 'after' ), $args['field'] );

	}

	/**
	 * Get Sections By
	 * 
	 * @since   0.0.1
	 * @return  array  the sections if found, or an empty array.
	 */
	public function get_sections_by( $key = '', $value = null, $number = 0 ) {

		$sections = $this->get_sections();
		$result = array();

		if ( ! empty( $key ) && ( is_array( $sections ) && ! empty( $sections ) ) ) {

			$i = 0;

			foreach ( $sections as $section ) {

				if ( isset( $section[$key] ) && ( $section[$key] === $value ) ) {

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
	 * @return  array  the first section if found, or null.
	 */
	public function get_section_by( $key = '', $value = null ) {

		$sections = $this->get_sections_by( $key, $value, 1 );
		$result = null;

		if ( is_array( $sections ) && ! empty( $sections ) ) {

			$result = $sections[0];

		}

		return $result;

	}

	public function render_section_description( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'id'       => '', 
			'title'    => '', 
			'callback' => array(), 
		) );

		if ( ! empty( $args['id'] ) ) {

			$section = $this->get_section_by( 'id', $args['id'] );

			if ( ! empty( $section ) ) { ?>

				<p class="description"><?php

					echo wp_kses( $section['description'], $this->kses_p );

				?></p>

			<?php }

		}

	}

	public function render_page() { ?>

		<div class="wrap">

			<h1><?php 

				echo wp_kses( $this->args['title'], $this->kses_p ); 

			?></h1>

			<?php if ( ! empty( $this->args['description'] ) ) { ?>

				<p class="description"><?php 

					echo wp_kses( $this->args['description'], $this->kses_p ); 

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
	public function get_sections() {

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
	public function get_fields() {

		$sections = $this->get_sections();
		$fields = array();

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

	public function add_admin_head_style_action() {
		
		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		do_action( $this->format_head_style_action( $this->slug ) );
	}

	public function add_admin_footer_script_action() {
		
		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		do_action( $this->format_footer_script_action( $this->slug ) );
	}

}