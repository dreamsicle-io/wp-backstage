<?php
/**
 * WP Backstage
 *
 * @since       2.0.0
 * @since       3.0.0  linted and formatted with phpcs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage
 *
 * @since       2.0.0
 */
class WP_Backstage {

	/**
	 * Fields
	 *
	 * @since 4.0.0
	 * @var WP_Backstage_Field[] $fields An array of field classes.
	 */
	protected array $fields = array();

	/**
	 * KSES Description
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  4.0.0
	 * @var    array  $kses_description  KSES configuration for descriptions.
	 */
	protected array $kses_description = array(
		'span'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'a'      => array(
			'id'     => true,
			'class'  => true,
			'style'  => true,
			'href'   => true,
			'title'  => true,
			'target' => true,
			'rel'    => true,
		),
		'em'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strong' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'u'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'code'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'i'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'br'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sub'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sup'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strike' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
	);

	/**
	 * KSES Label
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  4.0.0
	 * @var    array  $kses_label  KSES configuration for label tags.
	 */
	protected array $kses_label = array(
		'span'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'em'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strong' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'u'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'code'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'i'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'br'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sub'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sup'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strike' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
	);

	/**
	 * KSES Title
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  4.0.0
	 * @var    array  $kses_title  KSES configuration for titles.
	 */
	protected array $kses_title = array(
		'span'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'a'      => array(
			'id'     => true,
			'class'  => true,
			'style'  => true,
			'href'   => true,
			'title'  => true,
			'target' => true,
			'rel'    => true,
		),
		'em'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strong' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'u'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'code'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'i'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'br'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sub'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sup'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strike' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
	);

	/**
	 * KSES List Item
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  4.0.0
	 * @var    array  $kses_list_item  KSES configuration for list items.
	 */
	protected array $kses_list_item = array(
		'span'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'a'      => array(
			'id'     => true,
			'class'  => true,
			'style'  => true,
			'href'   => true,
			'title'  => true,
			'target' => true,
			'rel'    => true,
		),
		'em'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strong' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'u'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'code'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'i'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'br'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sub'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sup'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strike' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
	);

	/**
	 * KSES Button
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  4.0.0
	 * @var    array  $kses_button  KSES configuration for buttons and links.
	 */
	protected array $kses_button = array(
		'span'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'em'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strong' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'u'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'code'   => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'i'      => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'br'     => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sub'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'sup'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
		'strike' => array(
			'id'    => true,
			'class' => true,
			'style' => true,
		),
	);

	/**
	 * Construct
	 *
	 * @since 2.0.0
	 * @since 3.7.0 Removes plugin dependencies.
	 * @since 4.0.0 Removes error construction and refactors setting of global instance.
	 */
	public function __construct() {
		global $wp_backstage;
		$wp_backstage = $this;
	}

	/**
	 * Init
	 *
	 * Hook all methods to WordPress.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/add_action/ add_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_styles/ hook: admin_print_styles
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_scripts/ hook: admin_print_scripts
	 * @link    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ hook: admin_enqueue_scripts
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts/ hook: admin_print_footer_scripts
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts-hook_suffix/ hook: admin_print_footer_scripts-{$hook_suffix}
	 * @link    https://developer.wordpress.org/plugins/hooks/actions/ WP Actions
	 * @link    https://developer.wordpress.org/plugins/hooks/filters/ WP Filters
	 *
	 * @since   0.0.1
	 * @since   3.4.0 Adds filter to disable block editor for widgets.
	 * @since   3.7.0 Removes filter to disable block editor for widgets.
	 * @since   3.7.2 Moves code editor inline script to priority 20 to solve customizer "Additional CSS" panel bug.
	 * @since   4.0.0 Removes error checking of the `WP_Backstage` class as it no longer reports errors.
	 */
	public function init() {
		add_action( 'after_setup_theme', array( $this, 'register_field_classes' ), 10 );
		add_action( 'after_setup_theme', array( $this, 'register_init_hook' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_global_style' ), 10 );
		add_action( 'admin_print_scripts', array( $this, 'inline_global_script' ), 10 );
		add_action( 'admin_print_scripts', array( $this, 'inline_rest_api_preview_code_editor_script' ), 20 );
		add_action( 'admin_print_footer_scripts-post.php', array( $this, 'inline_post_type_script' ), 10 );
		add_action( 'admin_print_footer_scripts-post-new.php', array( $this, 'inline_post_type_script' ), 10 );
		add_action( 'admin_print_footer_scripts-edit.php', array( $this, 'inline_post_type_quick_edit_script' ), 10 );
		add_action( 'admin_print_footer_scripts-edit-tags.php', array( $this, 'inline_taxonomy_add_script' ), 10 );
		add_action( 'admin_print_footer_scripts-edit-tags.php', array( $this, 'inline_taxonomy_quick_edit_script' ), 20 );
		add_action( 'admin_print_footer_scripts-term.php', array( $this, 'inline_taxonomy_edit_script' ), 10 );
		add_action( 'admin_print_footer_scripts-nav-menus.php', array( $this, 'inline_nav_menu_item_script' ), 10 );
		add_action( 'admin_print_footer_scripts-profile.php', array( $this, 'inline_user_script' ), 10 );
		add_action( 'admin_print_footer_scripts-user-new.php', array( $this, 'inline_user_script' ), 10 );
		add_action( 'admin_print_footer_scripts-user-edit.php', array( $this, 'inline_user_script' ), 10 );
		add_action( 'admin_print_footer_scripts-index.php', array( $this, 'inline_dashboard_widget_script' ), 10 );
		add_action( 'admin_print_footer_scripts-widgets.php', array( $this, 'inline_widget_script' ), 10 );
		add_action( 'customize_controls_print_styles', array( $this, 'inline_customizer_style' ), 10 );
		add_action( 'customize_controls_print_scripts', array( $this, 'inline_nav_menu_item_customizer_script' ), 10 );
		add_action( 'wp_backstage_options_print_footer_scripts', array( $this, 'inline_options_script' ), 10 );
		add_filter( 'wp_kses_allowed_html', array( $this, 'manage_kses' ), 10, 2 );
	}

	/**
	 * Register Init Hook
	 *
	 * @since 4.0.0
	 */
	public function register_init_hook() {

		/**
		 * Fires when it is safe to initialize WP Backstage components.
		 *
		 * @since 4.0.0
		 */
		do_action( 'wp_backstage_init' );
	}

	/**
	 * Manage KSES
	 *
	 * @since 4.0.0
	 * @param array  $allowed A KSES definition list.
	 * @param string $context The KSES context identifier.
	 * @return array A filtered KSES definition list.
	 */
	public function manage_kses( array $allowed, string $context ): array {
		switch ( $context ) {
			case 'wp_backstage_error_message':
				return $this->kses_description;
			case 'wp_backstage_help_list_item':
				return $this->kses_list_item;
			case 'wp_backstage_field_label':
				return $this->kses_label;
			case 'wp_backstage_field_description':
				return $this->kses_description;
			case 'wp_backstage_filter_label':
				return $this->kses_label;
			case 'wp_backstage_options_page_title':
				return $this->kses_title;
			case 'wp_backstage_options_page_description':
				return $this->kses_description;
			case 'wp_backstage_options_section_description':
				return $this->kses_description;
			case 'wp_backstage_user_field_group_title':
				return $this->kses_title;
			case 'wp_backstage_user_field_group_description':
				return $this->kses_description;
			case 'wp_backstage_button':
				return $this->kses_button;
			case 'wp_backstage_tool_card_title':
				return $this->kses_button;
			case 'wp_backstage_quick_edit_group_title':
				return $this->kses_title;
			case 'wp_backstage_quick_edit_group_description':
				return $this->kses_description;
		}
		return $allowed;
	}

	/**
	 * Register Field Classes
	 *
	 * @since 4.0.0
	 */
	public function register_field_classes() {
		// Register the default field classes.
		$this->register_field_class( 'default', new WP_Backstage_Field() );
		$this->register_field_class( 'address', new WP_Backstage_Address_Field() );
		$this->register_field_class( 'checkbox', new WP_Backstage_Checkbox_Field() );
		$this->register_field_class( 'checkbox_set', new WP_Backstage_Checkbox_Set_Field() );
		$this->register_field_class( 'code', new WP_Backstage_Code_Field() );
		$this->register_field_class( 'color', new WP_Backstage_Color_Field() );
		$this->register_field_class( 'date', new WP_Backstage_Date_Field() );
		$this->register_field_class( 'editor', new WP_Backstage_Editor_Field() );
		$this->register_field_class( 'email', new WP_Backstage_Email_Field() );
		$this->register_field_class( 'media', new WP_Backstage_Media_Field() );
		$this->register_field_class( 'number', new WP_Backstage_Number_Field() );
		$this->register_field_class( 'radio', new WP_Backstage_Radio_Field() );
		$this->register_field_class( 'range', new WP_Backstage_Range_Field() );
		$this->register_field_class( 'select', new WP_Backstage_Select_Field() );
		$this->register_field_class( 'select_posts', new WP_Backstage_Select_Posts_Field() );
		$this->register_field_class( 'select_users', new WP_Backstage_Select_Users_Field() );
		$this->register_field_class( 'tel', new WP_Backstage_Tel_Field() );
		$this->register_field_class( 'textarea', new WP_Backstage_Textarea_Field() );
		$this->register_field_class( 'time', new WP_Backstage_Time_Field() );
		$this->register_field_class( 'url', new WP_Backstage_URL_Field() );

		/**
		 * Fires after the default field classes are registered. This hook should be
		 * used when themes or plugins add their own field classes to WP Backstage.
		 *
		 * @since 4.0.0
		 * @param WP_Backstage $wp_backstage The instance of WP Backstage's main class.
		 */
		do_action( 'wp_backstage_register_field_classes', $this );
	}

	/**
	 * Register Field Class
	 *
	 * @since 4.0.0
	 * @param string             $type The field type identifier.
	 * @param WP_Backstage_Field $instance The field class instance.
	 */
	public function register_field_class( string $type, WP_Backstage_Field $instance ) {
		$instance->init();
		$this->fields[ sanitize_key( $type ) ] = $instance;
	}

	/**
	 * Get Field Classes
	 *
	 * @since 4.0.0
	 * @return array
	 */
	public function get_field_classes(): array {
		return $this->fields;
	}

	/**
	 * Get Field Class
	 *
	 * @since 4.0.0
	 * @param string $type The field type identidier.
	 * @return WP_Backstage_Field
	 */
	public function get_field_class( string $type ): WP_Backstage_Field {
		return isset( $this->fields[ $type ] ) ? $this->fields[ $type ] : $this->fields['default'];
	}

	/**
	 * Inline REST API Preview Code Editor Script
	 *
	 * This method inlines the CodeMirror settings for the RESP API preview, so that
	 * it is available when the REST API preview script needs it.
	 *
	 * @since 3.4.0
	 */
	public function inline_rest_api_preview_code_editor_script() {

		$settings = wp_enqueue_code_editor(
			array(
				'type'       => 'text/json',
				'codemirror' => array(
					'lineWrapping' => false,
					'readOnly'     => true,
				),
			)
		);

		if ( $settings ) {
			wp_add_inline_script(
				'code-editor',
				sprintf(
					'window.wpBackstage.codeSettings.jsonReadOnly = %1$s;',
					wp_json_encode( $settings )
				)
			);
		}
	}

	/**
	 * Inline customizer Style
	 *
	 * Inlines the customizer style.
	 *
	 * @since   2.0.0
	 */
	public function inline_customizer_style() { ?>

		<style 
		id="wp_backstage_customizer_style"
		type="text/css">

			.ui-datepicker {
				z-index: 1000000 !important;
			}

			.wp-picker-clear {
				width: auto !important;
			}

		</style>

	<?php }

	/**
	 * Enqueue Admin Scripts
	 *
	 * Conditionally enqueue required scripts and styles. This handles enqueues
	 * for the media uploader, WP editor, and color picker. This is also responsible
	 * for loading up jQuery UI Core and required jQuery UI widgets like the date
	 * picker and sortable. Finally, this will initialize all code editor instances.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/ wp_enqueue_script()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_style/ wp_enqueue_style()
	 * @link    https://developer.wordpress.org/reference/functions/wp_add_inline_script/ wp_add_inline_script()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_media/ wp_enqueue_media()
	 * @link    https://developer.wordpress.org/reference/functions/did_action/ did_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ hook: admin_enqueue_scripts
	 * @link    https://developer.wordpress.org/themes/basics/including-css-javascript/ Including CSS and Javascript in WP
	 *
	 * @since   0.0.1
	 */
	public function enqueue_admin_scripts() {

		// jQuery.
		if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}
		// jQuery UI.
		if ( ! wp_script_is( 'jquery-ui-core', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-core' );
		}
		if ( ! wp_style_is( 'jquery-ui-theme-base', 'enqueued' ) ) {
			$wp_scripts        = wp_scripts();
			$jquery_ui_version = $wp_scripts->registered['jquery-ui-core']->ver;
			wp_enqueue_style(
				'jquery-ui-theme-base',
				"https://code.jquery.com/ui/{$jquery_ui_version}/themes/base/jquery-ui.min.css",
				array(),
				$jquery_ui_version
			);
		}
		if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
		if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}
		// WP Editor.
		if ( ! did_action( 'wp_enqueue_editor' ) ) {
			wp_enqueue_editor();
		}
		// WP Media.
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		// WP Media Element.
		if ( ! wp_style_is( 'wp-mediaelement', 'enqueued' ) ) {
			wp_enqueue_style( 'wp-mediaelement' );
		}
		if ( ! wp_script_is( 'wp-mediaelement', 'enqueued' ) ) {
			wp_enqueue_script( 'wp-mediaelement' );
		}
		// WP Color Picker.
		if ( ! wp_script_is( 'wp-color-picker', 'enqueued' ) ) {
			wp_enqueue_script( 'wp-color-picker' );
		}
		if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
			wp_enqueue_style( 'wp-color-picker' );
		}
	}

	/**
	 * Inline Global Style
	 *
	 * @since   3.1.0
	 */
	public function inline_global_style() { ?>

		<style id="wp_backstage_global_style">

			/* Thumbnail column */
			table.wp-list-table th.column-thumbnail,
			table.wp-list-table td.column-thumbnail {
				text-align: center;
				width: 40px;
			}

			@media screen and (max-width: 783px) {
				table.wp-list-table tr.is-expanded th.column-thumbnail,
				table.wp-list-table tr.is-expanded td.column-thumbnail,
				table.wp-list-table th.column-thumbnail,
				table.wp-list-table td.column-thumbnail {
					display: none !important;
				}
			}

			/* Legends as labels */
			.form-wrap legend {
				display: block;
				padding: 2px 0;
				color: #1d2327;
				font-weight: 400;
				text-shadow: none;
			}

			/* Meta box fields */
			.postbox .wp-backstage-field + .howto {
				margin-top: 0.2em;
			}

			/* Widget fields */
			.widget .wp-backstage-field + .description,
			#widgets-right .widget .wp-backstage-field + .description {
				padding: 0;
				margin: 8px 0 0 0;
				display: block;
			}

			/* Table filters */
			.tablenav .actions input[type="submit"]:first-child {
				display: none;
			}

			/* Fields */
			.wp-backstage-field {
				display: block;
			}

			.wp-backstage-field::before,
			.wp-backstage-field::after {
				content: '';
				display: table;
				clear: both;
			}

			/* Menu item fields */
			.menu-item-settings .wp-backstage-field + .description {
				display: block;
				margin-top: 6px;
			}

			/* Dashboard widget fields */
			#dashboard-widgets .postbox .wp-backstage-field + .description {
				display: block;
				margin-top: 6px;
			}

			/* Quick edit */
			.wp-backstage-quick-edit__field {
				display: block;
				margin: .2em 0;
				clear: both;
			}

			.wp-backstage-quick-edit__field .title {
				display: block;
				float: left;
				width: 6em;
				line-height: 2.5;
			}

			.wp-backstage-quick-edit__field .input-text-wrap {
				display: flow-root;
				margin-left: 6em;
			}

			.wp-backstage-quick-edit__field .wp-backstage-field::before,
			.wp-backstage-quick-edit__field .wp-backstage-field::after {
				content: unset;
			}

			/* Options pages */
			@media screen and (max-width: 782px) {
				#wp_backstage_options_page_wrap .form-table {
					table-layout: fixed;
				}
			}

		</style>

	<?php }

	/**
	 * Inline Global Script
	 *
	 * Inlines the script that initializes the global `wpBackstage` JavaScript object.
	 *
	 * @since   2.0.0
	 */
	public function inline_global_script() { ?>

		<script id="wp_backstage_global_script">

			(function() {
				window.wpBackstage = {
					codeSettings: {},
					fields: {},
					initAllFields: function(container = document) {
						for (var key in window.wpBackstage.fields) {
							if (window.wpBackstage.fields[key].initAll && (typeof window.wpBackstage.fields[key].initAll === 'function')) {
								window.wpBackstage.fields[key].initAll(container);
							}
						}
					},
					resetAllFields: function(container = document) {
						for (var key in window.wpBackstage.fields) {
							if (window.wpBackstage.fields[key].resetAll && (typeof window.wpBackstage.fields[key].resetAll === 'function')) {
								window.wpBackstage.fields[key].resetAll(container);
							}
						}
					},
					refreshAllFields: function(container = document) {
						for (var key in window.wpBackstage.fields) {
							if (window.wpBackstage.fields[key].refreshAll && (typeof window.wpBackstage.fields[key].refreshAll === 'function')) {
								window.wpBackstage.fields[key].refreshAll(container);
							}
						}
					},
				};
			}());

		</script>

	<?php }

	/**
	 * Inline Post Type Script
	 *
	 * @since   2.0.0
	 * @since   3.4.0  Adds support for block editor.
	 */
	public function inline_post_type_script() { ?>

		<script id="wp_backstage_post_type_script">

			(function($) {

				var refreshTimer = null;

				function findParentMetaBox(element) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('postbox')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function refreshMetaBox(metaBox) {
					if (refreshTimer) clearTimeout(refreshTimer);
					refreshTimer = setTimeout(function() {
						if (! metaBox.classList.contains('closed')) {
							window.wpBackstage.refreshAllFields(metaBox);
						}
					}, 500);
				}

				function handleMetaBoxHandleClick(e) {
					const metaBox = findParentMetaBox(e.target);
					refreshMetaBox(metaBox);
				}

				function handleMetaBoxSortStop(e, ui) {
					if (ui.item[0] instanceof HTMLElement && ui.item[0].classList.contains('postbox')) {
						const metaBox = ui.item[0];
						refreshMetaBox(metaBox);
					}
				}

				function handleScreenOptionChange(e) {
					const metaBox = document.getElementById(e.target.value);
					refreshMetaBox(metaBox);
				}

				function initMetaBoxSortable(sortable) {
					$(sortable).on('sortstop', handleMetaBoxSortStop);
				}

				function initMetaBox(metaBox) {
					const handle = metaBox.querySelector('.postbox-header');
					handle.addEventListener('click', handleMetaBoxHandleClick);
				}

				function initScreenOption(checkbox) {
					checkbox.addEventListener('change', handleScreenOptionChange);
				}

				function initAllMetaBoxSortables() {
					const metaBoxSortables = document.querySelectorAll('.meta-box-sortables');
					metaBoxSortables.forEach(function(metaBoxSortable) {
						initMetaBoxSortable(metaBoxSortable);
					});
				}

				function initAllMetaBoxes() {
					const metaBoxes = document.querySelectorAll('.postbox');
					metaBoxes.forEach(function(metaBox) {
						initMetaBox(metaBox);
					});
				}

				function initAllScreenOptions() {
					const checkboxes = document.querySelectorAll('#adv-settings .metabox-prefs input[type="checkbox"]');
					checkboxes.forEach(function(checkbox) {
						initScreenOption(checkbox);
					});
				}

				function handleBlockEditorLoad() {
					setTimeout(function() {
						window.wpBackstage.refreshAllFields();
					}, 500); 
				}

				function init() {
					window.wpBackstage.initAllFields();
					initAllMetaBoxes();
					initAllMetaBoxSortables();
					initAllScreenOptions();
					if (window._wpLoadBlockEditor) {
						window._wpLoadBlockEditor.then(handleBlockEditorLoad);
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Post Type Quick Edit Script
	 *
	 * Extends core post quick edit by injecting the WP Backstage quick edit
	 * template after the row is opened and then initializing field scripts for
	 * the hydrated values.
	 *
	 * @since   4.0.0
	 */
	public function inline_post_type_quick_edit_script() { ?>

		<script id="wp_backstage_post_type_quick_edit_script">

			(function($) {

				function setFieldValue(field, value = undefined) {
					const type = field.dataset.fieldType;

					if (window.wpBackstage.fields[type] && (typeof window.wpBackstage.fields[type].setValue === 'function')) {
						window.wpBackstage.fields[type].setValue(field, value);
						return;
					}

					const input = field.querySelector('#' + field.dataset.fieldId);
					const normalizedValue = ((value === undefined) || (value === null)) ? '' : value.toString();

					if (input instanceof HTMLInputElement) {
						if (input.type === 'checkbox') {
							input.checked = Boolean(value);
						} else {
							input.value = normalizedValue;
						}
					} else if (input instanceof HTMLTextAreaElement) {
						input.value = normalizedValue;
					} else if (input instanceof HTMLSelectElement) {
						input.value = normalizedValue || input.options[0].value;
					}
				}

				function init(postId) {
					const editRow = document.getElementById('edit-' + postId);
					const wrapper = editRow.querySelector('.inline-edit-wrapper');
					const submit = editRow.querySelector('.inline-edit-save');

					const dataScript = document.getElementById('wp_backstage_quick_edit_data_' + postId);
					const values = dataScript ? JSON.parse(dataScript.textContent) : {};

					const template = document.getElementById('wp_backstage_post_type_quick_edit_template');
					const idPlaceholder = template.dataset.idPlaceholder;
					const templateContent = template.querySelector('.wp-backstage-quick-edit');
					const templateClone = templateContent.cloneNode(true);
					const templateHTML = templateClone.innerHTML.replaceAll(idPlaceholder, postId);
					templateClone.innerHTML = templateHTML;

					const inserted = wrapper.insertBefore(templateClone, submit);

					const fieldContainers = inserted.querySelectorAll('.wp-backstage-quick-edit__field');
					fieldContainers.forEach(function(container) {
						const fieldName = container.dataset.wpBackstageFieldName;
						const field = container.querySelector('.wp-backstage-field');
						setFieldValue(field, values[fieldName]);
					});

					window.wpBackstage.initAllFields(inserted);
				}

				document.addEventListener('DOMContentLoaded', function() {
					if (window.inlineEditPost) {
						const originalEdit = window.inlineEditPost.edit;
						window.inlineEditPost.edit = function(elementOrId) {
							const result = originalEdit.apply(this, arguments);
							const postId = (typeof elementOrId === 'object') ? this.getId(elementOrId) : elementOrId;
							init(postId);
							return result;
						};
					}
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Nav Menu Item Script
	 *
	 * @since   2.0.0
	 * @since   3.4.1  Only renders the script on the "Edit Menus" page and bails on the "Manage Locations" and "Add New" page.
	 */
	public function inline_nav_menu_item_script() {

		// phpcs:ignore WordPress.Security.NonceVerification
		$params = wp_unslash( $_GET );

		$add_new_screen   = ( isset( $params['menu'] ) && ( 0 === absint( $params['menu'] ) ) ) ? true : false;
		$locations_screen = ( isset( $params['action'] ) && ( 'locations' === $params['action'] ) ) ? true : false;

		// If the screen is the "Manage Locations" or "Add New" screen, bail.
		if ( $add_new_screen || $locations_screen ) {
			return;
		} ?>

		<script id="wp_backstage_nav_menu_item_script">

			(function($) {

				var refreshTimer = null;
				var refreshFieldContainersTimer = null;

				function findParentNavMenuItem(element) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('menu-item')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function handleSuccess(e, request, settings) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-menu-item') {
							initReadyItems();
						}
					}
				}

				function handleNavMenuSortStop(e, ui) {
					const item = ui.item[0];
					if (item.classList.contains('menu-item')) {
						refreshItem(item);
					}
				}

				function initSortable() {
					const sortable = document.getElementById('menu-to-edit');
					$(sortable).on('sortstop', handleNavMenuSortStop);
				}

				function handleScreenOptionChange(e) {
					const fieldContainers = document.querySelectorAll('.menu-item .field-' + e.currentTarget.value);
					refreshFieldContainers(fieldContainers);
				}

				function initScreenOptions() {
					const checkboxes = document.querySelectorAll('#adv-settings .metabox-prefs .hide-column-tog');
					checkboxes.forEach(function(checkbox) {
						checkbox.addEventListener('change', handleScreenOptionChange);
					});
				}

				function refreshItem(item) {
					if (refreshTimer) clearTimeout(refreshTimer);
					refreshTimer = setTimeout(function() {
						if (item.classList.contains('menu-item-edit-active')) {
							window.wpBackstage.refreshAllFields(item);
						}
					}, 500);
				}

				function refreshFieldContainers(fieldContainers) {
					if (refreshFieldContainersTimer) clearTimeout(refreshFieldContainersTimer);
					refreshFieldContainersTimer = setTimeout(function() {
						fieldContainers.forEach(function(fieldContainer) {
							if (! fieldContainer.classList.contains('hidden-field')) {
								window.wpBackstage.refreshAllFields(fieldContainer);
							}
						});
					}, 500);
				}

				function handleItemHandleClick(e) {
					const item = findParentNavMenuItem(e.target);
					refreshItem(item);
				}

				function handleItemMoveLinkClick(e) {
					const item = findParentNavMenuItem(e.target);
					refreshItem(item);
				}

				function initItemHandle(item) {
					const handle = item.querySelector('.menu-item-handle .item-edit');
					handle.addEventListener('click', handleItemHandleClick);
				}

				function initItemMoveLinks(item) {
					const links = item.querySelectorAll('.menus-move');
					links.forEach(function(link) {
						link.addEventListener('click', handleItemMoveLinkClick);
					});
				}

				function initItem(item) {
					window.wpBackstage.initAllFields(item);
					initItemHandle(item);
					initItemMoveLinks(item);
					item.setAttribute('data-wp-backstage-initialized', 'true');
				}

				function initReadyItems() {
					const items = document.querySelectorAll('#menu-to-edit .menu-item:not([data-wp-backstage-initialized="true"])');
					items.forEach(function(item) {
						initItem(item);
					});
				}

				function init() {
					initReadyItems();
					initSortable();
					initScreenOptions();
					$(document).ajaxSuccess(handleSuccess);
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Nav Menu Item Customizer Script
	 *
	 * @link    https://wordpress.stackexchange.com/questions/372493/add-settings-to-menu-items-in-the-customizer  Stack Overflow Discussion on Nav Menu Items in the Customizer
	 * @link    https://gist.github.com/westonruter/7f2b9c18113f0576a72e0aca3ce3dbcb  Customizer Roles Plugin Example by Weston Ruter
	 *
	 * @since   2.0.0
	 * @since   3.5.0 Uses the menu item ID instead of the instance number for dynamic portion of the id/name attributes.
	 */
	public function inline_nav_menu_item_customizer_script() { ?>

		<script id="wp_backstage_nav_menu_item_customizer_script">
			(function($) {

				var expandTimer = null;

				function getFieldValue(field) {
					const type = field.dataset.fieldType;
					if (window.wpBackstage.fields[type] && (typeof window.wpBackstage.fields[type].getValue === 'function')) {
						return window.wpBackstage.fields[type].getValue(field);
					} else {
						const fieldId = field.dataset.fieldId;
						const input = field.querySelector('#' + fieldId);
						if (input instanceof HTMLInputElement) {
							if (input.type === 'checkbox') {
								return input.checked ? input.value : undefined;
							} else {
								return input.value;
							}
						} else if (input instanceof HTMLTextAreaElement) {
							return input.value;
						} else if (input instanceof HTMLSelectElement) {
							return input.value;
						}
					}
					return undefined;
				}

				function setFieldValue(field, value = undefined) {
					const type = field.dataset.fieldType;
					if (window.wpBackstage.fields[type] && (typeof window.wpBackstage.fields[type].setValue === 'function')) {
						window.wpBackstage.fields[type].setValue(field, value);
					} else {
						const fieldId = field.dataset.fieldId;
						const input = field.querySelector('#' + fieldId);
						if (input instanceof HTMLInputElement) {
							if (input.type === 'checkbox') {
								input.checked = Boolean(value);
							} else {
								input.value = value ? value.toString() : '';
							}
						} else if (input instanceof HTMLTextAreaElement) {
							input.value = value ? value.toString() : '';
						} else if (input instanceof HTMLSelectElement) {
							input.value = (value ? value.toString() : '') || input.options[0].value;
						}
					}
				}

				function setControlValues(control) {
					const values = control.setting().meta;
					if (values) {
						for (const fieldName in control.elements) {
							const field = control.elements[fieldName].element[0];
							if ((field instanceof HTMLElement) && field.classList.contains('wp-backstage-field')) {
								setFieldValue(field, values[fieldName]);
							}
						}
					}
				}

				function extendControl(control) {
					const containers = control.container.find('[data-wp-backstage-field-name]');
					containers.each(function() {
						const container = $(this);
						const fieldName = container.attr('data-wp-backstage-field-name');
						const field = container.find('.wp-backstage-field');
						field.on('change input', function() {
							const controlValue = control.setting();
							const fieldValue = getFieldValue(field[0]);
							const newValues = Object.assign(_.clone(controlValue || {}), {
								meta: Object.assign(_.clone(controlValue.meta || {}), {
									[fieldName]: fieldValue,
								}),
							});
							control.setting.set(newValues);
						});
						control.elements[fieldName] = new wp.customize.Element(field);
					});
				}

				function initFields(control) {
					window.wpBackstage.initAllFields(control.container[0]);
				}

				function refreshFields(control) {
					window.wpBackstage.refreshAllFields(control.container[0]);
				}

				function init() {
					wp.customize.control.bind('add', function(control) {
						if (control.extended(wp.customize.Menus.MenuItemControl)) {
							control.deferred.embedded.done(function() {
								extendControl(control);
								setControlValues(control);
								control.expanded.bind(function(isExpanded) {
									if (expandTimer) clearTimeout(expandTimer);
									if (isExpanded) {
										expandTimer = setTimeout(function() {
											if (control.container[0].dataset.wpBackstageInitialized !== 'true') {
												initFields(control);
												control.container[0].dataset.wpBackstageInitialized = 'true';
											} else {
												refreshFields(control);
											}
										}, 500);
									}
								});
							});
						}
					});
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Taxonomy Quick Edit Script
	 *
	 * Extends core taxonomy quick edit by injecting the WP Backstage quick edit
	 * template after the row is opened and then initializing field scripts for
	 * the hydrated values.
	 *
	 * @since   4.0.0
	 */
	public function inline_taxonomy_quick_edit_script() { ?>

		<script id="wp_backstage_taxonomy_quick_edit_script">

			(function($) {

				function setFieldValue(field, value = undefined) {
					const type = field.dataset.fieldType;

					if (window.wpBackstage.fields[type] && (typeof window.wpBackstage.fields[type].setValue === 'function')) {
						window.wpBackstage.fields[type].setValue(field, value);
						return;
					}

					const input = field.querySelector('#' + field.dataset.fieldId);
					const normalizedValue = ((value === undefined) || (value === null)) ? '' : value.toString();

					if (input instanceof HTMLInputElement) {
						if (input.type === 'checkbox') {
							input.checked = Boolean(value);
						} else {
							input.value = normalizedValue;
						}
					} else if (input instanceof HTMLTextAreaElement) {
						input.value = normalizedValue;
					} else if (input instanceof HTMLSelectElement) {
						input.value = normalizedValue || input.options[0].value;
					}
				}

				function init(termId) {
					const editRow = document.getElementById('edit-' + termId);
					const wrapper = editRow.querySelector('.inline-edit-wrapper');
					const submit = editRow.querySelector('.inline-edit-save');
					const dataScript = document.getElementById('wp_backstage_quick_edit_data_' + termId);
					const values = dataScript ? JSON.parse(dataScript.textContent) : {};

					const template = document.getElementById('wp_backstage_taxonomy_quick_edit_template');
					const idPlaceholder = template.dataset.idPlaceholder;
					const templateContent = template.querySelector('.wp-backstage-quick-edit');
					const templateClone = templateContent.cloneNode(true);
					const templateHTML = templateClone.innerHTML.replaceAll(idPlaceholder, termId);
					templateClone.innerHTML = templateHTML;

					const inserted = wrapper.insertBefore(templateClone, submit);

					const fieldContainers = inserted.querySelectorAll('.wp-backstage-quick-edit__field');
					fieldContainers.forEach(function(container) {
						const fieldName = container.dataset.wpBackstageFieldName;
						const field = container.querySelector('.wp-backstage-field');
						setFieldValue(field, values[fieldName]);
					});

					$(inserted).find('input').on('keydown', function(e) {
						if (e.key === 'Enter') {
							e.preventDefault();
							e.stopPropagation();
							return window.inlineEditTax.save(this);
						}
					});

					window.wpBackstage.initAllFields(inserted);
				}

				document.addEventListener('DOMContentLoaded', function() {
					if (window.inlineEditTax) {
						const originalEdit = window.inlineEditTax.edit;
						window.inlineEditTax.edit = function(elementOrId) {
							const result = originalEdit.apply(this, arguments);
							const termId = (typeof elementOrId === 'object') ? this.getId(elementOrId) : elementOrId;
							init(termId);
							return result;
						};
					}
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Taxonomy Add Script
	 *
	 * Initializes taxonomy add-form fields on the collection screen and resets
	 * them after successful AJAX term creation.
	 *
	 * @since   4.0.0
	 */
	public function inline_taxonomy_add_script() { ?>

		<script id="wp_backstage_taxonomy_add_script">

			(function($) {

				function resetForm() {
					const form = document.querySelector('#addtag');
					form.reset();
					window.wpBackstage.resetAllFields(form);
				}

				function handleSuccess(e, request, settings) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-tag') {
							const hasError = ($('wp_error', request.responseXML).length > 0);
							if (! hasError) {
								resetForm();
							}
						}
					}
				}

				function init() {
					const addForm = document.querySelector('#addtag');
					window.wpBackstage.initAllFields(addForm);
					$(document).ajaxSuccess(handleSuccess);
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Taxonomy Edit Script
	 *
	 * Initializes taxonomy edit-form fields on the singular term screen.
	 *
	 * @since   4.0.0
	 */
	public function inline_taxonomy_edit_script() { ?>

		<script id="wp_backstage_taxonomy_edit_script">

			(function($) {

				function init() {
					const editForm = document.querySelector('#edittag');
					window.wpBackstage.initAllFields(editForm);
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Options Script
	 *
	 * @since   2.0.0
	 */
	public function inline_options_script() { ?>

		<script 
		id="wp_backstage_options_script"
		type="text/javascript">

			(function($) {

				function init() {
					window.wpBackstage.initAllFields();
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Dashboard Widget Script
	 *
	 * @since   4.0.0
	 */
	public function inline_dashboard_widget_script() { ?>

		<script id="wp_backstage_dashboard_widget_script">

			(function($) {

				function init() {
					window.wpBackstage.initAllFields();
				}

				function handleWidgetSorted(e, $sortable) {
					const widget = $sortable.item[0];
					if (widget && widget.classList.contains('postbox')) {
						window.wpBackstage.refreshAllFields(widget);
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
					$(document).on('sortstop', handleWidgetSorted);
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Widget Script
	 *
	 * @since   2.0.0
	 * @since   3.7.0 Refactors to use the jQuery events for `widget-added` and `widget-updated` for support accross legacy, customizer, and block editing screens.
	 */
	public function inline_widget_script() { ?>

		<script 
		id="wp_backstage_widget_script"
		type="text/javascript">

			(function($) {

				function findWidget(id) {
					const input = document.querySelector('.widget-id[value="' + id + '"]');
					const widget = findParentWidget(input);
					return widget;
				}

				function findParentWidget(element) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('widget')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function findParentBlock(element) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('wp-block-legacy-widget')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function handleWidgetAdded(e, $widget) {
					const widget = $widget[0];
					setTimeout(function() {
						initWidget(widget);
					}, 500);
				}

				function handleWidgetUpdated(e, $widget) {
					const widget = $widget[0];
					window.wpBackstage.initAllFields(widget);
				}

				function handleWidgetSynced(e, $widget) {
					// This function is fired when the widget is synced via the customizer 
					// in the classic widgets experience only. Currently nothing has to be
					// done here in this instance.
					// console.log('synced', e, $widget);
				}

				function initWidgetBlock(widget) {
					const block = findParentBlock(widget);
					if (block) {
						block.addEventListener('click', handleBlockClick);
					}
				}

				function handleBlockClick(e) {
					const parentWidget = findParentWidget(e.target);
					if (! parentWidget) {
						const block = e.target.classList.contains('wp-block-legacy-widget') ? e.target : findParentBlock(e.target);
						const widget = block.querySelector('.widget');
						window.wpBackstage.refreshAllFields(widget);
					}
				}

				function initWidgetArea(container = document) {
					window.wpBackstage.initAllFields(container);
					initAllWidgetHandles(container);
				}

				function initWidget(widget) {
					window.wpBackstage.initAllFields(widget);
					initAllWidgetHandles(widget);
					initWidgetBlock(widget);
				}

				function handleWidgetHandleClick(e) {
					const widget = findParentWidget(e.target);
					setTimeout(function() {
						if (widget.classList.contains('open')) {
							window.wpBackstage.refreshAllFields(widget);
						}
					}, 500);
				}

				function initWidgetHandle(handle) {
					handle.addEventListener('click', handleWidgetHandleClick);
				}

				function initAllWidgetHandles(container = document) {
					const widgetHandles = container.querySelectorAll('.widget-top');
					widgetHandles.forEach(function(widgetHandle) {
						initWidgetHandle(widgetHandle);
					});
				}

				function handleWidgetSorted(e, $sortable) {
					const $widget = $sortable.item.find('.widget.open');
					if ($widget && $widget[0]) {
						const widget = $widget[0];
						window.wpBackstage.refreshAllFields(widget);
					}
				}

				function initActiveWidgetsArea() {
					const container = document.getElementById('widgets-right');
					if (container) {
						initWidgetArea(container);
					}
				}

				function initInactiveWidgetsArea() {
					const container = document.getElementById('wp_inactive_widgets');
					if (container) {
						initWidgetArea(container);
					}
				}

				function initWidgetAccessibility() {
					const container = document.querySelector('.editwidget');
					if (container) {
						initWidgetArea(container);
					}
				}

				function init() {
					initActiveWidgetsArea();
					initInactiveWidgetsArea();
					initWidgetAccessibility();
					$(document).on('widget-added', handleWidgetAdded);
					$(document).on('widget-updated', handleWidgetUpdated);
					$(document).on('widget-synced', handleWidgetSynced);
					$(document).on('sortstop', handleWidgetSorted);
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline User Script
	 *
	 * @since   2.0.0
	 */
	public function inline_user_script() { ?>

		<script id="wp_backstage_user_script">

			(function($) {

				function init() {
					window.wpBackstage.initAllFields();
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }
}
