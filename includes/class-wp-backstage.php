<?php
/**
 * WP Backstage
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
	protected $fields = array();

	/**
	 * KSES Description
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  4.0.0
	 * @var    array  $kses_description  KSES configuration for descriptions.
	 */
	protected $kses_description = array(
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
	protected $kses_label = array(
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
	protected $kses_title = array(
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
	protected $kses_list_item = array(
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
	protected $kses_button = array(
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
	 * @return void
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
	 * @return  void
	 */
	public function init() {
		add_action( 'after_setup_theme', array( $this, 'register_field_classes' ), 10 );
		add_action( 'after_setup_theme', array( $this, 'register_init_hook' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_global_style' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_thumbnail_column_style' ), 10 );
		add_action( 'admin_print_scripts', array( $this, 'inline_global_script' ), 10 );
		add_action( 'admin_print_scripts', array( $this, 'inline_rest_api_preview_code_editor_script' ), 20 );
		add_action( 'admin_print_footer_scripts-post.php', array( $this, 'inline_post_type_script' ), 10 );
		add_action( 'admin_print_footer_scripts-post-new.php', array( $this, 'inline_post_type_script' ), 10 );
		add_action( 'admin_print_footer_scripts-edit-tags.php', array( $this, 'inline_taxonomy_script' ), 10 );
		add_action( 'admin_print_footer_scripts-term.php', array( $this, 'inline_taxonomy_script' ), 10 );
		add_action( 'admin_print_footer_scripts-nav-menus.php', array( $this, 'inline_nav_menu_item_script' ), 10 );
		add_action( 'admin_print_footer_scripts-profile.php', array( $this, 'inline_user_script' ), 10 );
		add_action( 'admin_print_footer_scripts-user-new.php', array( $this, 'inline_user_script' ), 10 );
		add_action( 'admin_print_footer_scripts-user-edit.php', array( $this, 'inline_user_script' ), 10 );
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
	 * @return void
	 */
	public function register_init_hook() {

		/**
		 * Fires when it is safe to initialize WP Backstage components.
		 *
		 * @since 4.0.0
		 * @return void
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
	public function manage_kses( array $allowed = array(), string $context = '' ) {
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
		}
		return $allowed;
	}

	/**
	 * Register Field Classes
	 *
	 * @since 4.0.0
	 * @return void
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
	 * @return void
	 */
	public function register_field_class( $type, $instance ) {
		$instance->init();
		$this->fields[ sanitize_key( $type ) ] = $instance;
	}

	/**
	 * Get Field Classes
	 *
	 * @since 4.0.0
	 * @return WP_Backstage_Field[]
	 */
	public function get_field_classes() {
		return $this->fields;
	}

	/**
	 * Get Field Class
	 *
	 * @since 4.0.0
	 * @param string $type The field type identidier.
	 * @return WP_Backstage_Field
	 */
	public function get_field_class( $type ) {
		return isset( $this->fields[ $type ] ) ? $this->fields[ $type ] : $this->fields['default'];
	}

	/**
	 * Inline REST API Preview Code Editor Script
	 *
	 * This method inlines the CodeMirror settings for the RESP API preview, so that
	 * it is available when the REST API preview script needs it.
	 *
	 * @since 3.4.0
	 * @return void
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
	 * Inline Media Uploader Style
	 *
	 * Inlines the media uploader field style.
	 *
	 * @since   2.0.0
	 * @since   3.3.0 Adds styles for new media uploader preview rendering.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_media_uploader_style() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Media_Field::inline_style()' ); ?>

		<style 
		id="wp_backstage_media_uploader_style"
		type="text/css">

			.wp-backstage-media-uploader {
				display: block;
			}

			.wp-backstage-media-uploader__legend {
				cursor: pointer;
				padding: 2px 0;
				font-size: inherit;
				display: inline-block;
				width: auto;
			}

			.wp-backstage-media-uploader__buttons {
				display: block;
				position: relative;
			}

			.wp-backstage-media-uploader__button {
				margin: 0 8px 0 0 !important;
			}

			.wp-backstage-media-uploader__button--remove {
				background: transparent;
				border: 0;
				cursor: pointer;
				padding: 0;
			}

			.wp-backstage-media-uploader__preview-list {
				list-style: none;
				margin: 0;
				padding: 0;
			}

			.wp-backstage-media-uploader__preview-list::after,
			.wp-backstage-media-uploader__preview-list::before {
				content: '';
				display: table;
				clear: both;
			}

			.wp-backstage-media-uploader__attachment {
				display: block;
				position: relative;
				padding: 0;
				width: 150px;
				height: 150px;
				margin: 0 12px 12px 0;
				float: left;
				color: #3c434a;
				background: #f0f0f1;
				font-size: 12px;
				box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.10), inset 0 0 0 1px rgba(0, 0, 0, 0.5);
				cursor: move;
			}

			#addtag .wp-backstage-media-uploader__attachment,
			.widget .wp-backstage-media-uploader__attachment,
			.menu-item .wp-backstage-media-uploader__attachment {
				width: 115px;
				height: 115px;
			}

			.wp-backstage-media-uploader__attachment > img {
				display: block;
				width: 100%;
				height: 100%;
				object-fit: scale-down;
				margin: 0;
				padding: 0;
				box-shadow: inset 0 0 0 1px #dcdcde;
			}

			.wp-backstage-media-uploader__attachment[data-attachment-type="image"] > img {
				object-fit: contain;
				background-color: #ffffff;
				background-position: 0 0, 10px 10px;
				background-size: 20px 20px;
				background-image:
					linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7),
					linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7);
			}

			.wp-backstage-media-uploader__attachment-filename {
				display: none;
				position: absolute;
				left: 0;
				right: 0;
				bottom: 0;
				overflow: hidden;
				max-height: 100%;
				word-wrap: break-word;
				text-align: center;
				padding: 5px 10px;
				font-weight: 600;
				max-height: calc(100% - 32px);
				background: rgba(255, 255, 255, 0.8);
				box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.15);
				overflow-y: auto;
				box-sizing: border-box;
			}

			.wp-backstage-media-uploader__attachment:not([data-attachment-type="image"]) .wp-backstage-media-uploader__attachment-filename {
				display: block;
			}

			.wp-backstage-media-uploader__attachment-single-file {
				width: 100%;
				height: auto;
				max-width: 500px;
				margin-bottom: 12px;
				display: block;
			}

			.wp-backstage-media-uploader__attachment-single-file::before,
			.wp-backstage-media-uploader__attachment-single-file::after {
				content: '';
				width: 100%;
				display: table;
				clear: both;
			}

			.wp-backstage-media-uploader__attachment-single-file > img {
				max-width: 100px;
				height: auto;
				display: block;
				float: left;
				margin-right: 12px;
			}

			.wp-backstage-media-uploader__attachment-single-file-filename {
				display: block;
				font-weight: 600;
				margin-bottom: 0.125em;
				word-wrap: break-word;
			}

			.wp-backstage-media-uploader__attachment-single-file-meta {
				display: block;
				font-size: 0.875em;
				opacity: 0.75;
			}

			.wp-backstage-media-uploader__attachment-single-image {
				width: 100%;
				height: auto;
				max-width: 350px;
				margin-bottom: 12px;
				display: block;
			}

			.wp-backstage-media-uploader__attachment-single-image > img {
				max-width: 100%;
				height: auto;
				display: block;
				box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.15);
				background-color: #ffffff;
				background-position: 0 0, 10px 10px;
				background-size: 20px 20px;
				background-image:
					linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7),
					linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7);
			}

			.wp-backstage-media-uploader__attachment-single-image[data-attachment-subtype="svg+xml"] > img {
				width: 100%;
			}

			.wp-backstage-media-uploader__attachment-single-video {
				width: 100%;
				height: auto;
				max-width: 500px;
				margin-bottom: 12px;
				display: block;
			}

			.wp-backstage-media-uploader__attachment-single-audio {
				width: 100%;
				height: auto;
				max-width: 500px;
				margin-bottom: 12px;
				display: block;
			}

			.wp-backstage-media-uploader__error {
				display: none;
			}

			.wp-backstage-media-uploader__error > span{
				display: inline-block;
				vertical-align: middle;
				margin: 0.5em 0;
				padding: 2px;
			}

			.wp-backstage-media-uploader__loader {
				display: none;
			}

			.wp-backstage-media-uploader__loader > span {
				display: inline-block;
				vertical-align: middle;
				font-style: italic;
				opacity: 0.75;
				padding: 0.5em 0;
			}

			.wp-backstage-media-uploader__loader > img {
				display: inline-block;
				vertical-align: middle;
			}

			.wp-backstage-media-uploader__try-again {
				line-height: inherit;
			}

		</style>

	<?php }

	/**
	 * Inline Editor Style
	 *
	 * Inlines the editor field style.
	 *
	 * @since   0.0.1
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_editor_style() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Editor_Field::inline_style()' ); ?>

		<style 
		id="wp_backstage_editor_style"
		type="text/css">

			.mce-toolbar .mce-btn.mce-active, 
			.mce-toolbar .mce-btn.mce-active button, 
			.mce-toolbar .mce-btn.mce-active i, 
			.mce-toolbar .mce-btn.mce-active:hover button, 
			.mce-toolbar .mce-btn.mce-active:hover i {
				color: inherit;
			}

			.form-field .wp-editor-area {
				border-width: 0;
			}

		</style>

	<?php }

	/**
	 * Inline customizer Style
	 *
	 * Inlines the customizer style.
	 *
	 * @since   2.0.0
	 * @return  void
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
	 * Inline Code Editor Style
	 *
	 * Inlines the code editor field style.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_code_editor_style() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Code_Field::inline_style()' ); ?>

		<style 
		id="wp_backstage_code_editor_style"
		type="text/css">

			.CodeMirror {
				border: 1px solid #dcdcde;
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
	 * @return  void
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
		if ( ! wp_script_is( 'jquery-ui-theme-base', 'enqueued' ) ) {
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
	 * Inline Media Mixin Overrides Script
	 *
	 * This method is responsible for outputting a script that makes a small override to the native
	 * WordPress `wp.media.mixin.removeAllPlayers()` mixin. By default, WordPress kills all media
	 * elements when one is rendered in the WordPress media modal, with no way to ignore that behavior.
	 * The side effect of this is that media elements in the WP Admin are killed when selecting an audio
	 * or video attachment in the media uploader. Because WP Backstage uses WordPress media elements on
	 * audio and video previews in the media uploader fields, it is necessary to provide a way to ignore
	 * these in this function. This function was copied from `/wp-includes/js/media-audiovideo.js`, and
	 * adds a simple check for a `wp-mediaelement-keep` class to ignore removal.
	 *
	 * @since 3.3.0
	 * @return void
	 * @deprecated 4.0.0
	 */
	public function inline_media_mixin_overrides_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Media_Field::inline_media_mixin_overrides_script()' ); ?>

		<script id="wp_backstage_media_mixin_overrides_script">
			(function() {
				function removeAllPlayersOverride() {
					var p;
					if ( window.mejs && window.mejs.players ) {
						for ( p in window.mejs.players ) {
							window.mejs.players[p].pause();
							playerElement = document.getElementById(p);
							if (playerElement instanceof HTMLElement && ! playerElement.classList.contains('wp-mediaelement-keep')) {
								window.wp.media.mixin.removePlayer( window.mejs.players[p] );
							}
						}
					}
				};
				window.wp.media.mixin.removeAllPlayers = removeAllPlayersOverride;
			})();
		</script>
	<?php }

	/**
	 * Inline Thumbnail Column Style
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	public function inline_thumbnail_column_style() { ?>

		<style id="wp_backstage_thumbnail_column_style">

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

		</style>

	<?php }

	/**
	 * Inline Global Style
	 *
	 * @since   3.1.0
	 * @return  void
	 */
	public function inline_global_style() { ?>

		<style id="wp_backstage_global_style">

			/* legends as labels */
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
			.widget .widget-field-description {
				margin-top: -0.8em;
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
	 * @return  void
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
	 * Inline Media Uploader Script
	 *
	 * Inlines the media uploader script.
	 *
	 * @link    https://codex.wordpress.org/Javascript_Reference/wp.media wp.media
	 * @link    https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://jqueryui.com/sortable/ jQuery UI Sortable
	 * @link    https://jqueryui.com/ jQuery UI
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Full rewrite of the media uploader script.
	 * @since   3.3.0  Renders previews via ajax instead of clone functionality.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_media_uploader_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Media_Field::inline_script()' );?>

		<script 
		id="wp_backstage_media_uploader_script"
		type="text/javascript">

			(function($) {

				function renderMedia(uploader = null, attachmentIDs = []) {
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					hideError(uploader);
					hideButtons(uploader);
					showLoader(uploader);
					$.ajax({
						url: window.ajaxurl,
						type: 'post',
						data: {
							action: 'wp_backstage_render_media',
							attachment_ids: attachmentIDs,
							is_multiple: isMultiple,
						},
						success: function(result) {
							const previewList = uploader.wpBackstage.ui.previewList;
							hideLoader(uploader);
							showButtons(uploader);
							$(previewList).append($(result));	
							if (isMultiple)	{
								initClones(uploader);
								refreshSortable(uploader);
							} else {
								window.wp.mediaelement.initialize();
							}
						},
						error: function() {
							hideLoader(uploader);
							showButtons(uploader);
							showError(uploader);
						},
					});
				}

				function showButtons(uploader = null) {
					const buttons = uploader.wpBackstage.ui.buttons;
					buttons.style.display = 'block';
				}

				function hideButtons(uploader = null) {
					const buttons = uploader.wpBackstage.ui.buttons;
					buttons.style.display = 'none';
				}

				function showLoader(uploader = null) {
					const loader = uploader.wpBackstage.ui.loader;
					loader.style.display = 'inline-block';
				}

				function hideLoader(uploader = null) {
					const loader = uploader.wpBackstage.ui.loader;
					loader.style.display = 'none';
				}

				function showError(uploader = null) {
					const error = uploader.wpBackstage.ui.error;
					error.style.display = 'inline-block';
				}

				function hideError(uploader = null) {
					const error = uploader.wpBackstage.ui.error;
					error.style.display = 'none';
				}

				function findParentUploader(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.hasAttribute('data-media-uploader-id')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function findParentAttachment(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.hasAttribute('data-attachment-id')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function handleLegendClick(e = null) {
					const uploader = findParentUploader(e.target);
					uploader.wpBackstage.modal.open();
				}

				function handleAddButtonClick(e = null) {
					const uploader = findParentUploader(e.target);
					uploader.wpBackstage.modal.open();
				}

				function handleAddToButtonClick(e = null) {
					const uploader = findParentUploader(e.target);
					uploader.wpBackstage.modal.open();
				}

				function handleReplaceButtonClick(e = null) {
					const uploader = findParentUploader(e.target);
					uploader.wpBackstage.modal.open();
				}

				function handleRemoveButtonClick(e = null) {
					const uploader = findParentUploader(e.target);
					reset(uploader);
				}

				function handleTryAgainButtonClick(e = null) {
					const uploader = findParentUploader(e.target);
					const attachmentIDs = getInputValue(uploader);
					if (attachmentIDs.length > 0) {
						appendClones(uploader, attachmentIDs, true);
					}
				}

				function enableButton(button = null) {
					button.removeAttribute('disabled');
					button.style.display = 'inline-block';
				}

				function disableButton(button = null) {
					button.setAttribute('disabled', true);
					button.style.display = 'none';
				}

				function handleSortStop(e = null, ui = null) {
					const previewList = e.target;
					const uploader = findParentUploader(previewList);
					const cloneIDs = getCloneIDs(uploader);
					setInputValue(uploader, cloneIDs);
				}

				function refreshSortable(uploader = null) {
					const previewList = uploader.wpBackstage.ui.previewList;
					$(previewList).sortable('refresh');
				}

				function initSortable(uploader = null) {
					const previewList = uploader.wpBackstage.ui.previewList;
					$(previewList).sortable({
						items: '[data-attachment-id]', 
						stop: handleSortStop,
					});
				}

				function getCloneIDs(uploader = null) {
					const previewList = uploader.wpBackstage.ui.previewList;
					const clones = previewList.querySelectorAll('[data-attachment-id]') || [];
					return Array.from(clones).map(function(clone) {
						return parseInt(clone.getAttribute('data-attachment-id'), 10);
					})
				}

				function handleAttachmentRemoveButtonClick(e = null) {
					e.preventDefault();
					e.stopPropagation();
					const uploader = findParentUploader(e.target);
					const attachment = findParentAttachment(e.target);
					const attachmentID = parseInt(attachment.getAttribute('data-attachment-id'), 10);
					const currentAttachmentIDs = getInputValue(uploader); 
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const newAttachmentIDs = currentAttachmentIDs.filter(function(currentAttachmentID) {
						return (currentAttachmentID !== attachmentID);
					});
					setInputValue(uploader, newAttachmentIDs);
					removeClone(uploader, attachmentID);
					if (newAttachmentIDs.length < 1) {
						reset(uploader);
					}
					if (isMultiple) {
						refreshSortable(uploader);
					}
				}

				function initClones(uploader = null) {
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const previewList = uploader.wpBackstage.ui.previewList;
					const clones = previewList.querySelectorAll('[data-attachment-id]') || [];
					return Array.from(clones).map(function(clone) {
						if (! clone.hasAttribute('data-wp-backstage-initialized')) {
							const removeButton = clone.querySelector('.wp-backstage-media-uploader__attachment-remove');
							removeButton.addEventListener('click', handleAttachmentRemoveButtonClick);
							clone.setAttribute('data-wp-backstage-initialized', true);
						}
					});
				}

				function appendClones(uploader = null, attachmentIDs = [], replace = false) {
					const previewList = uploader.wpBackstage.ui.previewList;
					const template = uploader.wpBackstage.ui.template;
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const cloneIDs = getCloneIDs(uploader);
					const size = isMultiple ? 'thumbnail' : 'medium';
					if (replace) {
						removeClones(uploader);
					}
					if ( isMultiple ) {
						attachmentIDs = attachmentIDs.filter(function(attachmentID) {
							return ! cloneIDs.includes(attachmentID);
						});
					}

					renderMedia(uploader, attachmentIDs);
				}

				function removeClone(uploader = null, attachmentID = 0) {
					const previewList = uploader.wpBackstage.ui.previewList;
					const clone = previewList.querySelector('[data-attachment-id="' + attachmentID + '"]');
					if (clone) {
						previewList.removeChild(clone);
					}
				}

				function removeClones(uploader = null) {
					const previewList = uploader.wpBackstage.ui.previewList;
					previewList.innerHTML = '';
				}

				function setInputValue(uploader = null, attachmentIDs = []) {
					const input = uploader.wpBackstage.ui.input;
					input.value = attachmentIDs.join(',');
					$(input).trigger('change');
				}

				function getInputValue(uploader = null) {
					const input = uploader.wpBackstage.ui.input;
					return ! input.value ? [] : input.value.split(',').map(function(value) { 
						return parseInt(value, 10); 
					})
				}

				function concatAttachmentIDs(uploader = null, attachmentIDs = []) {
					const currentAttachmentIDs = getInputValue(uploader); 
					const newAttachmentIDs = attachmentIDs.filter(function(attachmentID) {
						return ! currentAttachmentIDs.includes(attachmentID);
					});
					return currentAttachmentIDs.concat(newAttachmentIDs);
				}

				function handleModalSelect(uploader = null) {
					const addButton = uploader.wpBackstage.ui.addButton;
					const addToButton = uploader.wpBackstage.ui.addToButton;
					const replaceButton = uploader.wpBackstage.ui.replaceButton;
					const removeButton = uploader.wpBackstage.ui.removeButton;
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const attachments = uploader.wpBackstage.modal.state().get('selection').toJSON();
					const newAttachmentIDs = attachments.map(function(attachment) {
						return attachment.id;
					});
					const attachmentIDs = isMultiple ? concatAttachmentIDs(uploader, newAttachmentIDs) : newAttachmentIDs;
					setInputValue(uploader, attachmentIDs);
					appendClones(uploader, attachmentIDs, ! isMultiple);
					disableButton(addButton);
					enableButton(removeButton);
					if (isMultiple) {
						enableButton(addToButton);
						disableButton(replaceButton);
					} else {
						disableButton(addToButton);
						enableButton(replaceButton);
					}
				}

				function destroy(uploader = null) {
					const addButton = uploader.wpBackstage.ui.addButton;
					const addToButton = uploader.wpBackstage.ui.addToButton;
					const replaceButton = uploader.wpBackstage.ui.replaceButton;
					const removeButton = uploader.wpBackstage.ui.removeButton;
					const tryAgainButton = uploader.wpBackstage.ui.tryAgainButton;
					const legend = uploader.wpBackstage.ui.legend;
					addButton.removeEventListener('click', handleAddButtonClick);
					addToButton.removeEventListener('click', handleAddToButtonClick);
					replaceButton.removeEventListener('click', handleReplaceButtonClick);
					removeButton.removeEventListener('click', handleRemoveButtonClick);
					tryAgainButton.removeEventListener('click', handleTryAgainButtonClick);
					hideLoader(uploader);
					hideError(uploader);
					showButtons(uploader);
					removeClones(uploader);
					if (legend) {
						legend.removeEventListener('click', handleLegendClick);
					}
					delete uploader.wpBackstage;
				}

				function destroyAll(container = null) {
					container = container || document;
					const uploaders = container.querySelectorAll('[data-media-uploader-id]');
					if (uploaders && (uploaders.length > 0)) {
						for (var i = 0; i < uploaders.length; i++) {
							destroy(uploaders[i]);
						}
					}
				}

				function initPreview(uploader = null) {
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const attachmentIDs = getInputValue(uploader);
					if (attachmentIDs.length > 0) {
						appendClones(uploader, attachmentIDs);
					}
					if (isMultiple) {
						initSortable(uploader);
					}
				}

				function init(uploader = null) {
					const fieldId = uploader.getAttribute('data-media-uploader-id');
					const input = uploader.querySelector('#' + fieldId);
					const legend = uploader.querySelector('#' + fieldId + '_legend');
					const buttons = uploader.querySelector('#' + fieldId + '_buttons');
					const addButton = uploader.querySelector('#' + fieldId + '_button_add');
					const addToButton = uploader.querySelector('#' + fieldId + '_button_add_to');
					const replaceButton = uploader.querySelector('#' + fieldId + '_button_replace');
					const removeButton = uploader.querySelector('#' + fieldId + '_button_remove');
					const preview = uploader.querySelector('#' + fieldId + '_preview');
					const previewList = uploader.querySelector('#' + fieldId + '_preview_list');
					const loader = uploader.querySelector('#' + fieldId + '_loader');
					const error = uploader.querySelector('#' + fieldId + '_error');
					const tryAgainButton = uploader.querySelector('#' + fieldId + '_button_try_again');
					const title = uploader.getAttribute('data-media-uploader-title');
					const buttonText = uploader.getAttribute('data-media-uploader-button');
					const type = uploader.getAttribute('data-media-uploader-type');
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const modal = wp.media({
						title: title,
						multiple: isMultiple, 
						library: { type: type || '' }, 
						button: { text: buttonText },
						frame: 'select', 
					});
					modal.on('select', function() {
						handleModalSelect(uploader);
					});
					addButton.addEventListener('click', handleAddButtonClick);
					addToButton.addEventListener('click', handleAddToButtonClick);
					replaceButton.addEventListener('click', handleReplaceButtonClick);
					removeButton.addEventListener('click', handleRemoveButtonClick);
					tryAgainButton.addEventListener('click', handleTryAgainButtonClick);
					if (legend) {
						legend.addEventListener('click', handleLegendClick);
					}
					uploader.wpBackstage = {
						modal: modal,
						ui: {
							input: input,
							legend: legend,
							buttons: buttons,
							addButton: addButton,
							addToButton: addToButton,
							replaceButton: replaceButton,
							removeButton: removeButton,
							preview: preview,
							previewList: previewList,
							loader: loader,
							error: error,
							tryAgainButton: tryAgainButton,
						},
					};
					initPreview(uploader);
					if (input.value) {
						disableButton(addButton);
						enableButton(removeButton);
						if (isMultiple) {
							enableButton(addToButton);
							disableButton(replaceButton);
						} else {
							disableButton(addToButton);
							enableButton(replaceButton);
						}
					} else {
						enableButton(addButton);
						disableButton(addToButton);
						disableButton(replaceButton);
						disableButton(removeButton);
					}
				}

				function initAll(container = null) {
					container = container || document;
					const uploaders = container.querySelectorAll('[data-media-uploader-id]');
					if (uploaders && (uploaders.length > 0)) {
						for (var i = 0; i < uploaders.length; i++) {
							init(uploaders[i]);
						}
					}
				}
				function reset(uploader = null) {
					const addButton = uploader.wpBackstage.ui.addButton;
					const addToButton = uploader.wpBackstage.ui.addToButton;
					const replaceButton = uploader.wpBackstage.ui.replaceButton;
					const removeButton = uploader.wpBackstage.ui.removeButton;
					hideLoader(uploader);
					hideError(uploader);
					showButtons(uploader);
					enableButton(addButton);
					disableButton(addToButton);
					disableButton(replaceButton);
					disableButton(removeButton);
					setInputValue(uploader, []);
					removeClones(uploader);
					if (uploader.wpBackstage.modal.state()) {
						uploader.wpBackstage.modal.state().reset();
					}
				}
				function resetAll(container = null) {
					container = container || document;
					const uploaders = container.querySelectorAll('[data-media-uploader-id]');
					if (uploaders && (uploaders.length > 0)) {
						for (var i = 0; i < uploaders.length; i++) {
							reset(uploaders[i]);
						}
					}
				}

				window.wpBackstage.mediaUploader = Object.assign(window.wpBackstage.mediaUploader, {
					initAll: initAll,
					init: init,
					destroy: destroy,
					destroyAll: destroyAll,
					resetAll: resetAll,
					reset: reset,
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Date picker Script
	 *
	 * Inlines the date picker script.
	 *
	 * @link    https://jqueryui.com/datepicker/ jQuery UI Datepicker
	 * @link    https://jqueryui.com/ jQuery UI
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP Javascript Reference
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Added methods to global `wpBackstage` object.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_date_picker_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Date_Field::inline_script()' ); ?>

		<script 
		id="wp_backstage_date_picker_script"
		type="text/javascript">

			(function($) {

				function init(datePicker = null) {

					if (! datePicker) { 
						return;
					}

					const fieldId = datePicker.getAttribute('data-date-picker-id');
					const format = datePicker.getAttribute('data-date-picker-format');
					const input = datePicker.querySelector('#' + fieldId);

					$(input).datepicker({
						dateFormat: format || 'yy-mm-dd', 
					});
				}

				function initAll(container = null) {
					container = container || document;
					const datePickers = container.querySelectorAll('[data-date-picker-id]');
					if (datePickers && (datePickers.length > 0)) {
						for (var i = 0; i < datePickers.length; i++) {
							init(datePickers[i]);
						}
					}
				}

				window.wpBackstage.datePicker = Object.assign(window.wpBackstage.datePicker, {
					initAll: initAll,
					init: init,
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Colorpicker Script
	 *
	 * Inlines the color picker script.
	 *
	 * @link    http://automattic.github.io/Iris/ Iris
	 * @link    https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ New Color Picker in WP 3.5
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Added methods to global `wpBackstage` object.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_color_picker_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Color_Field::inline_script()' ); ?>

		<script 
		id="wp_backstage_color_picker_script"
		type="text/javascript">

			(function($) {

				var saveTimer = null;

				function handleChange(e = null, ui = null) {
					if (saveTimer) {
						clearTimeout(saveTimer);
					}
					saveTimer = setTimeout(function() {
						$(e.target).trigger('change');
					}, 500);
				}

				function init(colorPicker = null) {

					if (! colorPicker) { 
						return;
					}

					const fieldId = colorPicker.getAttribute('data-color-picker-id');
					const input = colorPicker.querySelector('#' + fieldId);
					const labels = document.querySelectorAll('[for="' + fieldId + '"]');
					const mode = colorPicker.getAttribute('data-color-picker-mode');
					var palettes = colorPicker.getAttribute('data-color-picker-palettes');
					palettes = palettes.startsWith('#') ? palettes.split(',') : (palettes === 'true');

					function handleLabelClick(e) {
						e.preventDefault();
						resultButton = colorPicker.querySelector('.wp-color-result');
						if (resultButton) {
							resultButton.focus();
						}
					}

					const options = {
						defaultColor: false, // bool, string.
						palettes: palettes, // bool, [].
						change: handleChange,
						clear: handleChange,
					};
					// Add seperately to ensure default WP setting 
					// is respected if no mode is set.
					if (mode) {
						options.mode = mode; // string (hsl, hsv).
					}

					$(input).wpColorPicker(options);
					if (labels && (labels.length > 0)) {
						for (var i = 0; i < labels.length; i++) {
							labels[i].addEventListener('click', handleLabelClick);
						}
					}
				}

				function initAll(container = null) {
					container = container || document;
					const colorPickers = container.querySelectorAll('[data-color-picker-id]');
					if (colorPickers && (colorPickers.length > 0)) {
						for (var i = 0; i < colorPickers.length; i++) {
							init(colorPickers[i]);
						}
					}
				}
				function reset(colorPicker = null) {
					const resetButton = colorPicker.querySelector('.wp-picker-clear, .wp-picker-default');
					resetButton.click();
				}
				function resetAll(container = null) {
					container = container || document;
					const colorPickers = container.querySelectorAll('[data-color-picker-id]');
					if (colorPickers && (colorPickers.length > 0)) {
						for (var i = 0; i < colorPickers.length; i++) {
							reset(colorPickers[i]);
						}
					}
				}

				window.wpBackstage.colorPicker = Object.assign(window.wpBackstage.colorPicker, {
					initAll: initAll,
					init: init,
					resetAll: resetAll,
					reset: reset,
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Code Editor Script
	 *
	 * Inlines the code editor script. All of the initializer functions fire at window load,
	 * to ensure that all CodeMirror instances have finished initializing first.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_code_editor/ wp_enqueue_code_editor()
	 * @link    https://make.wordpress.org/core/tag/codemirror/ CodeMirror in WP
	 * @link    https://codemirror.net/ CodeMirror
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP Javascript Reference
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Added methods to global `wpBackstage` object.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_code_editor_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Code_Field::inline_script()' ); ?>

		<script 
		id="wp_backstage_code_editor_script"
		type="text/javascript">

			(function($) {

				var saveTimer = null;

				function init(codeEditor = null) {
					const fieldId = codeEditor.getAttribute('data-code-editor-id');
					const textarea = codeEditor.querySelector('#' + fieldId);
					const settingsKey = codeEditor.getAttribute('data-code-editor-settings');
					const labels = document.querySelectorAll('[for="' + fieldId + '"]');
					const settings = window.wpBackstage.codeEditor.settings[settingsKey];
					wp.codeEditor.initialize(fieldId, settings);
					const codeMirrorEl = codeEditor.querySelector('.CodeMirror');
					const CodeMirrorInst = codeMirrorEl.CodeMirror;

					function handleLabelClick(e = null) {
						CodeMirrorInst.focus();
					}

					CodeMirrorInst.on('change', function(instance, changes) {
						if (saveTimer) {
							clearTimeout(saveTimer);
						}
						saveTimer = setTimeout(function() {
							instance.save();
							$(textarea).trigger('change');
						}, 500);
					});
					if (labels && (labels.length > 0)) {
						for (var i = 0; i < labels.length; i++) {
							labels[i].addEventListener('click', handleLabelClick);
						}
					}
				}

				function refresh(codeEditor = null) {
					const codeMirrorEl = codeEditor.querySelector('.CodeMirror');
					const CodeMirrorInst = codeMirrorEl.CodeMirror;
					CodeMirrorInst.refresh();
				}

				function initAll(container = null) {
					container = container || document;
					const codeEditors = container.querySelectorAll('[data-code-editor-id]');
					if (codeEditors && (codeEditors.length > 0)) {
						for (var i = 0; i < codeEditors.length; i++) {
							init(codeEditors[i]);
						}
					}
				}

				function refreshAll(container = null) {
					container = container || document;
					const codeEditors = container.querySelectorAll('[data-code-editor-id]');
					if (codeEditors && (codeEditors.length > 0)) {
						for (var i = 0; i < codeEditors.length; i++) {
							refresh(codeEditors[i]);
						}
					}
				}

				function reset(codeEditor = null) {
					const codeMirrorEl = codeEditor.querySelector('.CodeMirror');
					const CodeMirrorInst = codeMirrorEl.CodeMirror;
					const textarea = CodeMirrorInst.getTextArea();
					CodeMirrorInst.setValue(textarea.value);
					CodeMirrorInst.clearHistory();
				}

				function resetAll(container = null) {
					container = container || document;
					const codeEditors = container.querySelectorAll('[data-code-editor-id]');
					if (codeEditors && (codeEditors.length > 0)) {
						for (var i = 0; i < codeEditors.length; i++) {
							reset(codeEditors[i]);
						}
					}
				}

				window.wpBackstage.codeEditor = Object.assign(window.wpBackstage.codeEditor, {
					initAll: initAll,
					init: init,
					refreshAll: refreshAll,
					refresh: refresh,
					resetAll: resetAll,
					reset: reset,
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Address Script
	 *
	 * Inlines the address script.
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Added methods to global `wpBackstage` object.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_address_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Address_Field::inline_script()' ); ?>

		<script 
		id="wp_backstage_address_script"
		type="text/javascript">

			(function($) {

				function init(address = null) {

					if (! address) { 
						return;
					}

					const fieldId = address.getAttribute('data-address-id');
					const countrySelect = address.querySelector('#' + fieldId + '_country');
					const stateContainer = address.querySelector('#' + fieldId + '_state_container');
					const usStateContainer = address.querySelector('#' + fieldId + '_us_state_container');

					function enableField(field = null) {
						const control = field.querySelector('input, textarea, select');
						control.removeAttribute('disabled');
						field.style.display = 'block';
					}
					function disableField(field = null) {
						const control = field.querySelector('input, textarea, select');
						control.setAttribute('disabled', true);
						field.style.display = 'none';
					}
					function toggleByCountry(value = '') {
						if (value === 'US') {
							enableField(usStateContainer)
							disableField(stateContainer);
						} else {
							enableField(stateContainer)
							disableField(usStateContainer);
						}
					}
					function handleCountryChange(e = null) {
						toggleByCountry(e.target.value);
					}

					toggleByCountry(countrySelect.value);
					countrySelect.addEventListener('change', handleCountryChange);
				}

				function initAll(container = null) {
					container = container || document;
					const addresses = container.querySelectorAll('[data-address-id]');
					if (addresses && (addresses.length > 0)) {
						for (var i = 0; i < addresses.length; i++) {
							init(addresses[i]);
						}
					}
				}

				window.wpBackstage.address = Object.assign(window.wpBackstage.address, {
					initAll: initAll,
					init: init,
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Editor Script
	 *
	 * Inlines the editor script.
	 *
	 * @todo     Make sure clicking on label focuses the editor.
	 *
	 * @link     https://codex.wordpress.org/Javascript_Reference/wp.editor wp.editor
	 * @link     https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link     https://make.wordpress.org/core/2017/05/20/editor-api-changes-in-4-8/ WP Editor API Changes in 4.8
	 * @link     https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link     https://www.tiny.cloud/docs/demo/basic-example/ Tiny MCE Example
	 *
	 * @since   0.0.1
	 * @since   2.0.0  Added methods to global `wpBackstage` object and fixes shortcode rendering.
	 * @return  void
	 * @deprecated 4.0.0
	 */
	public function inline_editor_script() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Editor_Field::inline_script()' ); ?>

		<script 
		id="wp_backstage_editor_script"
		type="text/javascript">

			(function($) {

				var saveTimer = null;

				function findParentEditor(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.hasAttribute('data-editor-id')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function destroy(editor = null) {
					if (saveTimer) {
						clearTimeout(saveTimer);
					}
					const fieldId = editor.getAttribute('data-editor-id');
					const label = editor.querySelector('#' + fieldId + '_label');
					if (label) {
						label.removeEventListener('click', handleLabelClick);
					}
					wp.editor.remove(fieldId);
				}

				function handleLabelClick(e = null) {
					// TODO: Figure out why tiny MCE is only focusing the last editor on the page,
					// regardless of the ID passed.
					// const editor = findParentEditor(e.target);
					// const fieldId = editor.getAttribute('data-editor-id');
					// tinyMCE.execCommand('mceFocus', false, fieldId);
				}

				function handleSetup(wpEditor = null) {
					wpEditor.on('change', function(e) {
						if (saveTimer) {
							clearTimeout(saveTimer);
						}
						saveTimer = setTimeout(function() {
							wpEditor.save();
							$(wpEditor.targetElm).trigger('change');
						}, 500);
					});
				}

				function init(editor = null) {
					const fieldId = editor.getAttribute('data-editor-id');
					const label = editor.querySelector('#' + fieldId + '_label');
					const mediaButtons = (editor.getAttribute('data-media-buttons') === 'true');
					const formatSelect = (editor.getAttribute('data-format-select') === 'true');
					const kitchenSink = (editor.getAttribute('data-kitchen-sink') === 'true');

					const settings = {
						mediaButtons: mediaButtons, 
						quicktags: true, 
						tinymce: {
							wpautop: true, 
							// The following phpcs:ignore line does not prevent phpcs from
							// warning and fixing the `wordpress` tinymce plugin which is 
							// required. Currently the only way to solve this issue is to
							// ignore the entire rule from the phpcs.xml file.
							// phpcs:ignore WordPress.WP.CapitalPDangit
							plugins: 'charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview', 
							toolbar1: 'bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link',
							setup: handleSetup,
						}, 
					};

					if (formatSelect) {
						settings.tinymce.toolbar1 = 'formatselect,' + settings.tinymce.toolbar1;
					}
					if (kitchenSink) {
						settings.tinymce.toolbar1 = settings.tinymce.toolbar1 + ',wp_adv';
						settings.tinymce.toolbar2 = 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help';
					}
					if (label) {
						label.addEventListener('click', handleLabelClick);
					}

					wp.editor.initialize(fieldId, settings);
				}
				function destroyAll(container = null) {
					container = container || document;
					const editors = container.querySelectorAll('[data-editor-id]');
					if (editors && (editors.length > 0)) {
						for (var i = 0; i < editors.length; i++) {
							destroy(editors[i]);
						}
					}
				}
				function initAll(container = null) {
					container = container || document;
					const editors = container.querySelectorAll('[data-editor-id]');
					if (editors && (editors.length > 0)) {
						for (var i = 0; i < editors.length; i++) {
							init(editors[i]);
						}
					}
				}
				function refresh(editor = null) {
					destroy(editor);
					init(editor);
				}
				function refreshAll(container = null) {
					container = container || document;
					destroyAll(container);
					initAll(container);
				}

				function reset(editor = null) {
					const fieldId = editor.getAttribute('data-editor-id');
					const textarea = editor.querySelector('#' + fieldId);
					textarea.value== textarea.defaultValue;
				}
				function resetAll(container = null) {
					container = container || document;
					const editors = container.querySelectorAll('[data-editor-id]');
					if (editors && (editors.length > 0)) {
						for (var i = 0; i < editors.length; i++) {
							reset(editors[i]);
						}
					}
				}

				window.wpBackstage.editor = Object.assign(window.wpBackstage.editor, {
					initAll: initAll,
					init: init,
					refreshAll: refreshAll,
					refresh: refresh,
					resetAll: resetAll,
					reset: reset,
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Post Type Script
	 *
	 * @since   2.0.0
	 * @since   3.4.0  Adds support for block editor.
	 * @return  void
	 */
	public function inline_post_type_script() { ?>

		<script id="wp_backstage_post_type_script">

			(function($) {

				var refreshTimer = null;

				function findParentMetaBox(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('postbox')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function refreshMetaBox(metaBox = null) {
					if (refreshTimer) clearTimeout(refreshTimer);
					refreshTimer = setTimeout(function() {
						if (! metaBox.classList.contains('closed')) {
							window.wpBackstage.refreshAllFields(metaBox);
						}
					}, 500);
				}

				function handleMetaBoxHandleClick(e = null) {
					const metaBox = findParentMetaBox(e.target);
					refreshMetaBox(metaBox);
				}

				function handleMetaBoxSortStop(e = null, ui = null) {
					if (ui.item[0] instanceof HTMLElement && ui.item[0].classList.contains('postbox')) {
						const metaBox = ui.item[0];
						refreshMetaBox(metaBox);
					}
				}

				function handleScreenOptionChange(e = null) {
					const metaBox = document.getElementById(e.target.value);
					refreshMetaBox(metaBox);
				}

				function initMetaBoxSortable(sortable = null) {
					$(sortable).on('sortstop', handleMetaBoxSortStop);
				}

				function initMetaBox(metaBox = null) {
					const handle = metaBox.querySelector('.postbox-header');
					handle.addEventListener('click', handleMetaBoxHandleClick);
				}

				function initScreenOption(checkbox = null) {
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

				function init() {
					window.wpBackstage.initAllFields();
					initAllMetaBoxes();
					initAllMetaBoxSortables();
					initAllScreenOptions();
					if (window._wpLoadBlockEditor) {
						window._wpLoadBlockEditor.then(handleBlockEditorLoad);
					}
				}

				function handleBlockEditorLoad() {
					setTimeout(function() {
						window.wpBackstage.refreshAllFields();
					}, 500); 
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Nav Menu Item Script
	 *
	 * @since   2.0.0
	 * @since   3.4.1  Only renders the script on the "Edit Menus" page and bails on the "Manage Locations" and "Add New" page.
	 * @return  void
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

				function findParentNavMenuItem(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('menu-item')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-menu-item') {
							initReadyItems();
						}
					}
				}

				function handleNavMenuSortStop(e = null, ui = null) {
					const item = ui.item[0];
					if (item.classList.contains('menu-item')) {
						refreshItem(item);
					}
				}

				function initSortable() {
					const sortable = document.getElementById('menu-to-edit');
					$(sortable).on('sortstop', handleNavMenuSortStop);
				}

				function handleScreenOptionChange(e = null) {
					const fieldContainers = document.querySelectorAll('.menu-item .field-' + e.target.value);
					refreshFieldContainers(fieldContainers);
				}

				function initScreenOptions() {
					const checkboxes = document.querySelectorAll('#adv-settings .metabox-prefs .hide-column-tog');
					checkboxes.forEach(function(checkbox) {
						checkbox.addEventListener('change', handleScreenOptionChange);
					});
				}

				function refreshItem(item = null) {
					if (refreshTimer) clearTimeout(refreshTimer);
					refreshTimer = setTimeout(function() {
						if (item.classList.contains('menu-item-edit-active')) {
							window.wpBackstage.refreshAllFields(item);
						}
					}, 500);
				}

				function refreshFieldContainers(fieldContainers = []) {
					if (refreshFieldContainersTimer) clearTimeout(refreshFieldContainersTimer);
					refreshFieldContainersTimer = setTimeout(function() {
						fieldContainers.forEach(function(fieldContainer) {
							if (! fieldContainer.classList.contains('hidden-field')) {
								window.wpBackstage.refreshAllFields(fieldContainer);
							}
						});
					}, 500);
				}

				function handleItemHandleClick(e = null) {
					const item = findParentNavMenuItem(e.target);
					refreshItem(item);
				}

				function handleItemMoveLinkClick(e = null) {
					const item = findParentNavMenuItem(e.target);
					refreshItem(item);
				}

				function initItemHandle(item = null) {
					const handle = item.querySelector('.menu-item-handle .item-edit');
					handle.addEventListener('click', handleItemHandleClick);
				}

				function initItemMoveLinks(item = null) {
					const links = item.querySelectorAll('.menus-move');
					links.forEach(function(link) {
						link.addEventListener('click', handleItemMoveLinkClick);
					});
				}

				function initItem(item = null) {
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
	 * @return  void
	 */
	public function inline_nav_menu_item_customizer_script_BACKUP() { ?>

		<script 
		id="wp_backstage_nav_menu_item_customizer_script"
		type="text/javascript">

			(function($) {

				var controlExpandTimer = null;

				function setControlElementValue(controlElement = null, value = undefined, menuItemID = 0) {
					const fieldName = controlElement.element.attr('data-wp-backstage-field-name');
					const fieldType = controlElement.element.attr('data-wp-backstage-field-type');
					const elementName = 'menu-item-' + fieldName + '[' + menuItemID + ']';
					switch (fieldType) {
						case 'checkbox': {
							const input = controlElement.element.find('[name="' + elementName + '"]');
							input.attr('checked', Boolean(value));
							break;
						}
						case 'radio': {
							const radios = controlElement.element.find('[name="' + elementName + '"]');
							if (! value && (radios.length > 0)) {
								value = $(radios[0]).val();
							}
							radios.each(function() {
								const radio = $(this);
								radio.attr('checked', (radio.val() === value));
							});
							break;
						}
						case 'checkbox_set': {
							const checkboxes = controlElement.element.find('[name="' + elementName + '[]"]');
							checkboxes.each(function() {
								const checkbox = $(this);
								checkbox.attr('checked', (Array.isArray(value) && value.includes(checkbox.val())));
							});
							break;
						}
						case 'time': {
							const timePieces = (value && ! Array.isArray(value)) ? value.split(':') : value;
							const hourSelect = controlElement.element.find('[name="' + elementName + '[hour]"]');
							const minuteSelect = controlElement.element.find('[name="' + elementName + '[minute]"]');
							const secondSelect = controlElement.element.find('[name="' + elementName + '[second]"]');
							hourSelect.val((timePieces && timePieces[0]) ? timePieces[0] : hourSelect.find('option:first-child').val());
							minuteSelect.val((timePieces && timePieces[1]) ? timePieces[1] : minuteSelect.find('option:first-child').val());
							secondSelect.val((timePieces && timePieces[2]) ? timePieces[2] : secondSelect.find('option:first-child').val());
							break;
						}
						case 'address': {
							const countrySelect = controlElement.element.find('[name="' + elementName + '[country]"]');
							const address1Input = controlElement.element.find('[name="' + elementName + '[address_1]"]');
							const address2Input = controlElement.element.find('[name="' + elementName + '[address_2]"]');
							const cityInput = controlElement.element.find('[name="' + elementName + '[city]"]');
							const stateSelect = controlElement.element.find('select[name="' + elementName + '[state]"]');
							const stateInput = controlElement.element.find('input[name="' + elementName + '[state]"]');
							const zipInput = controlElement.element.find('[name="' + elementName + '[zip]"]');
							countrySelect.val((value && value.country) ? value.country : 'US');
							address1Input.val((value && value.address_1) ? value.address_1 : '');
							address2Input.val((value && value.address_2) ? value.address_2 : '');
							cityInput.val((value && value.city) ? value.city : '');
							stateSelect.val((value && value.state) ? value.state : 'AL');
							stateInput.val((value && value.state) ? value.state : '');
							zipInput.val((value && value.zip) ? value.zip : '');
							break;
						}
						case 'select': {
							const select = controlElement.element.find('[name="' + elementName + '"]');
							select.val(value || select.find('option:first-child').val());
							break;
						}
						case 'select_posts': {
							const select = controlElement.element.find('[name="' + elementName + '"]');
							value = parseInt(value, 10);
							value = value ? value.toString() : undefined;
							select.val(value || select.find('option:first-child').val());
							break;
						}
						case 'select_users': {
							const select = controlElement.element.find('[name="' + elementName + '"]');
							value = parseInt(value, 10);
							value = value ? value.toString() : undefined;
							select.val(value || select.find('option:first-child').val());
							break;
						}
						default: {
							const input = controlElement.element.find('[name="' + elementName + '"]');
							input.val(value);
							break;
						}
					}
				}

				function initControlElementChangeHandler(controlElement = null, setting = null, menuItemID = 0) {
					const fieldName = controlElement.element.attr('data-wp-backstage-field-name');
					const fieldType = controlElement.element.attr('data-wp-backstage-field-type');
					const elementName = 'menu-item-' + fieldName + '[' + menuItemID + ']';
					switch (fieldType) {
						case 'checkbox': {
							const input = controlElement.element.find('[name="' + elementName + '"]');
							input.on('change', function(e) {
								handleSettingChange(setting, fieldName, e.target.checked ? e.target.value : undefined);
							});
							break;
						}
						case 'radio': {
							const radios = controlElement.element.find('[name="' + elementName + '"]');
							radios.each(function() {
								const radio = $(this);
								radio.on('change', function(e) {
									if (e.target.checked) {
										handleSettingChange(setting, fieldName, e.target.value);
									}
								});
							});
							break;
						}
						case 'checkbox_set': {
							const checkboxes = controlElement.element.find('[name="' + elementName + '[]"]');
							checkboxes.each(function() {
								const checkbox = $(this);
								checkbox.on('change', function(e) {
									handleCheckboxSetSettingChange(setting, fieldName, e.target.value, e.target.checked);
								});
							});
							break;
						}
						case 'time': {
							const hourSelect = controlElement.element.find('[name="' + elementName + '[hour]"]');
							const minuteSelect = controlElement.element.find('[name="' + elementName + '[minute]"]');
							const secondSelect = controlElement.element.find('[name="' + elementName + '[second]"]');
							hourSelect.on('change', function(e) {
								handleTimeSettingChange(setting, fieldName, 0, e.target.value);
							});
							minuteSelect.on('change', function(e) {
								handleTimeSettingChange(setting, fieldName, 1, e.target.value);
							});
							secondSelect.on('change', function(e) {
								handleTimeSettingChange(setting, fieldName, 2, e.target.value);
							});
							break;
						}
						case 'address': {
							const countrySelect = controlElement.element.find('[name="' + elementName + '[country]"]');
							const address1Input = controlElement.element.find('[name="' + elementName + '[address_1]"]');
							const address2Input = controlElement.element.find('[name="' + elementName + '[address_2]"]');
							const cityInput = controlElement.element.find('[name="' + elementName + '[city]"]');
							const stateSelect = controlElement.element.find('select[name="' + elementName + '[state]"]');
							const stateInput = controlElement.element.find('input[name="' + elementName + '[state]"]');
							const zipInput = controlElement.element.find('[name="' + elementName + '[zip]"]');
							countrySelect.on('change', function(e) {
								handleAddressSettingChange(setting, fieldName, 'country', e.target.value);
							});
							address1Input.on('change input propertychange paste', function(e) {
								handleAddressSettingChange(setting, fieldName, 'address_1', e.target.value);
							});
							address2Input.on('change input propertychange paste', function(e) {
								handleAddressSettingChange(setting, fieldName, 'address_2', e.target.value);
							});
							cityInput.on('change input propertychange paste', function(e) {
								handleAddressSettingChange(setting, fieldName, 'city', e.target.value);
							});
							stateSelect.on('change', function(e) {
								handleAddressSettingChange(setting, fieldName, 'state', e.target.value);
							});
							stateInput.on('change input propertychange paste', function(e) {
								handleAddressSettingChange(setting, fieldName, 'state', e.target.value);
							});
							zipInput.on('change input propertychange paste', function(e) {
								handleAddressSettingChange(setting, fieldName, 'zip', e.target.value);
							});
							break;
						}
						case 'select': {
							const select = controlElement.element.find('[name="' + elementName + '"]');
							select.on('change', function(e) {
								handleSettingChange(setting, fieldName, e.target.value );
							});
							break;
						}
						case 'select_posts': {
							const select = controlElement.element.find('[name="' + elementName + '"]');
							select.on('change', function(e) {
								handleSettingChange(setting, fieldName, e.target.value );
							});
							break;
						}
						case 'select_users': {
							const select = controlElement.element.find('[name="' + elementName + '"]');
							select.on('change', function(e) {
								handleSettingChange(setting, fieldName, e.target.value );
							});
							break;
						}
						default: {
							const input = controlElement.element.find('[name="' + elementName + '"]');
							input.on('change input propertychange paste', function(e) {
								handleSettingChange(setting, fieldName, e.target.value);
							});
							break;
						}
					}
				}

				function setControlValues(control = null) {
					const values = control.setting();
					const elements = control.wpBackstageElements;
					for (var fieldName in elements) {
						setControlElementValue(elements[fieldName], values[fieldName], control.params.menu_item_id);
					}
				}

				function extendControl(control = null) {
					control.wpBackstageElements = {};
					const fields = control.container.find('[data-wp-backstage-field-name]');
					fields.each(function() {
						const field = $(this);
						const fieldName = field.attr('data-wp-backstage-field-name');
						const fieldFound = control.container.find('[data-wp-backstage-field-name="' + fieldName + '"]');
						control.wpBackstageElements[fieldName] = new wp.customize.Element(fieldFound);
					});
				}

				function initFields(control = null) {
					window.wpBackstage.initAllFields(control.container[0]);
				}

				function handleControlExpanded(control =  null) {
					window.wpBackstage.refreshAllFields(control.container[0]);
				}

				function handleNavMenuSortStop(e = null, ui = null) {
					const item = ui.item[0];
					if (item.classList.contains('menu-item')) {
						window.wpBackstage.editor.refreshAll(item);
						window.wpBackstage.codeEditor.refreshAll(item);
					}
				}

				function handleSectionInitSortables(section = null) {
					section.contentContainer.on('sortstop', handleNavMenuSortStop);
				}

				function handleSettingChange(setting = null, fieldName = '', value = undefined) {
					const currentValues = setting();
					if (currentValues[fieldName] !== value) {
						setting.set(Object.assign(
							{},
							_.clone(currentValues),
							{ [fieldName]: value }
						));
					}
				}

				function handleAddressSettingChange(setting = null, fieldName = '', addressKey = '', value = undefined) {
					const currentValues = setting();
					if (! currentValues[fieldName] || currentValues[fieldName][addressKey] !== value) {
						handleSettingChange(setting, fieldName, Object.assign(
							{},
							_.clone(currentValues[fieldName]),
							{ [addressKey]: value }
						));
					}
				}

				function handleTimeSettingChange(setting = null, fieldName = '', index = 0, value = undefined) {
					const currentValues = setting();
					const timePieces = currentValues[fieldName] ? _.clone(currentValues[fieldName]).split(':') : ['00', '00', '00'];
					if (timePieces[index] !== value) {
						timePieces[index] = value;
						handleSettingChange(setting, fieldName, timePieces.join(':'));
					}
				}

				function handleCheckboxSetSettingChange(setting = null, fieldName = '', value = undefined, checked = false) {
					const currentValues = setting();
					const values = currentValues[fieldName] ? _.clone(currentValues[fieldName]) : [];
					if (checked) {
						values.push(value);
					} else {
						index = values.indexOf(value);
						if (index >= 0) {
							values.splice(index, 1);
						}
					}
					handleSettingChange(setting, fieldName, values);
				}

				function initChangeHandlers(control = null) {
					const elements = control.wpBackstageElements;
					for (var fieldName in elements) {
						initControlElementChangeHandler(elements[fieldName], control.setting, control.params.menu_item_id);
					}
				}

				function handleSectionExpanded(section = null) {
					const openNavMenuItems = section.contentContainer.find('.menu-item-edit-active');
					for (var i = 0; i < openNavMenuItems.length; i++) {
						window.wpBackstage.editor.refreshAll(openNavMenuItems[i]);
						window.wpBackstage.codeEditor.refreshAll(openNavMenuItems[i]);
					}
				}

				function init() {
					wp.customize.bind( 'ready', function() {
						wp.customize.section.each(function(section) { 
							if (section.id.startsWith('nav_menu')) {
								section.expanded.bind(function(isExpanded) {
									if (isExpanded) {
										handleSectionExpanded(section);
									}
								});
								section.deferred.initSortables.done(function() {
									handleSectionInitSortables(section);
								});
							}
						});
					});
					wp.customize.control.bind('add', function(control) {
						if (control.extended(wp.customize.Menus.MenuItemControl)) {
							control.deferred.embedded.done(function() {

								setTimeout(function() {
									extendControl(control);
									setControlValues(control);
									initFields(control);
									initChangeHandlers(control);
								}, 500);

								control.expanded.bind(function(isExpanded) {
									if (controlExpandTimer) {
										clearTimeout(controlExpandTimer);
									}
									controlExpandTimer = setTimeout(function() {
										if (isExpanded) {
											handleControlExpanded(control);
										}
									}, 500);
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
	 * Inline Nav Menu Item Customizer Script
	 *
	 * @link    https://wordpress.stackexchange.com/questions/372493/add-settings-to-menu-items-in-the-customizer  Stack Overflow Discussion on Nav Menu Items in the Customizer
	 * @link    https://gist.github.com/westonruter/7f2b9c18113f0576a72e0aca3ce3dbcb  Customizer Roles Plugin Example by Weston Ruter
	 *
	 * @since   2.0.0
	 * @since   3.5.0 Uses the menu item ID instead of the instance number for dynamic portion of the id/name attributes.
	 * @return  void
	 */
	public function inline_nav_menu_item_customizer_script() { ?>

		<script id="wp_backstage_nav_menu_item_customizer_script">

			(function($) {

				function setControlValues(control = null) {
					const values = control.setting().meta;
					for (var fieldName in control.elements) {
						const field = control.elements[fieldName].element[0];
						if ((field instanceof HTMLElement) && field.classList.contains('wp-backstage-field')) {
							const type = field.dataset.fieldType;
							if (window.wpBackstage.fields[type] && (typeof window.wpBackstage.fields[type].setValue === 'function')) {
								window.wpBackstage.fields[type].setValue(field, values[fieldName]);
							} else {
								const fieldId = field.dataset.fieldId;
								const value = values[fieldName];
								const input = field.querySelector('#' + fieldId);
								if (input instanceof HTMLInputElement) {
									if (input.type === 'checkbox') {
										input.checked = Boolean(value);
									} else {
										input.value = value.toString();
									}
								} else if (input instanceof HTMLTextAreaElement) {
									input.value = value.toString();
								} else if (input instanceof HTMLSelectElement) {
									input.value = value.toString() || input.options[0].value;
								}
							}
						}
					}
				}

				function extendControl(control = null) {
					const containers = control.container.find('[data-wp-backstage-field-name]');
					containers.each(function() {
						const container = $(this);
						const fieldName = container.attr('data-wp-backstage-field-name');
						const field = container.find('.wp-backstage-field');
						control.elements[fieldName] = new wp.customize.Element(field);
					});
				}

				function initFields(control = null) {
					window.wpBackstage.initAllFields(control.container[0]);
				}

				function refreshFields(control =  null) {
					window.wpBackstage.refreshAllFields(control.container[0]);
				}

				function init() {
					wp.customize.control.bind('add', function(control) {
						if (control.extended(wp.customize.Menus.MenuItemControl)) {
							control.deferred.embedded.done(function() {
								extendControl(control);
								setControlValues(control);
								initFields(control);

								control.expanded.bind(function(isExpanded) {
									if (isExpanded) refreshFields(control);
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
	 * Inline Taxonomy Script
	 *
	 * @since   0.0.1
	 * @return  void
	 */
	public function inline_taxonomy_script() { ?>

		<script id="wp_backstage_taxonomy_script">

			(function($) {

				function resetForm() {
					const form = document.querySelector('#addtag');
					form.reset();
					window.wpBackstage.resetAllFields(form);
				}

				function handleSuccess(e = null, request = null, settings = null) {
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
					window.wpBackstage.initAllFields();
					$(document).ajaxSuccess(handleSuccess);
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
	 * @return  void
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
	 * Inline Widget Script
	 *
	 * @since   2.0.0
	 * @since   3.7.0 Refactors to use the jQuery events for `widget-added` and `widget-updated` for support accross legacy, customizer, and block editing screens.
	 * @return  void
	 */
	public function inline_widget_script() { ?>

		<script 
		id="wp_backstage_widget_script"
		type="text/javascript">

			(function($) {

				function findWidget(id = '') {
					const input = document.querySelector('.widget-id[value="' + id + '"]');
					const widget = findParentWidget(input);
					return widget;
				}

				function findParentWidget(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('widget')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function findParentBlock(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('wp-block-legacy-widget')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function handleWidgetAdded(e = null, $widget = null) {
					const widget = $widget[0];
					setTimeout(function() {
						initWidget(widget);
					}, 500);
				}

				function handleWidgetUpdated(e = null, $widget = null) {
					const widget = $widget[0];
					window.wpBackstage.initAllFields(widget);
				}

				function handleWidgetSynced(e = null, $widget = null) {
					// This function is fired when the widget is synced via the customizer 
					// in the classic widgets experience only. Currently nothing has to be
					// done here in this instance.
					// console.log('synced', e, $widget);
				}

				function initWidgetBlock(widget = null) {
					const block = findParentBlock(widget);
					if (block) {
						block.addEventListener('click', handleBlockClick);
					}
				}

				function handleBlockClick(e = null) {
					const parentWidget = findParentWidget(e.target);
					if (! parentWidget) {
						const block = e.target.classList.contains('wp-block-legacy-widget') ? e.target : findParentBlock(e.target);
						const widget = block.querySelector('.widget');
						window.wpBackstage.refreshAllFields(widget);
					}
				}

				function initWidgetArea(container = null) {
					window.wpBackstage.initAllFields(container);
					initAllWidgetHandles(container);
				}

				function initWidget(widget = null) {
					window.wpBackstage.initAllFields(widget);
					initAllWidgetHandles(widget);
					initWidgetBlock(widget);
				}

				function handleWidgetHandleClick(e = null) {
					const widget = findParentWidget(e.target);
					setTimeout(function() {
						if (widget.classList.contains('open')) {
							window.wpBackstage.refreshAllFields(widget);
						}
					}, 500);
				}

				function initWidgetHandle(handle = null) {
					handle.addEventListener('click', handleWidgetHandleClick);
				}

				function initAllWidgetHandles(container = null) {
					container = container || document;
					const widgetHandles = container.querySelectorAll('.widget-top');
					widgetHandles.forEach(function(widgetHandle) {
						initWidgetHandle(widgetHandle);
					});
				}

				function handleWidgetSorted(e = null, $sortable = null) {
					const $widget = $sortable.item.find('.widget.open');
					if ($widget && $widget[0]) {
						const widget = $widget[0];
						window.wpBackstage.editor.refreshAllFields(widget);
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

				function init() {
					initActiveWidgetsArea();
					initInactiveWidgetsArea();
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
	 * @return  void
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

	/**
	 * Render Media Item
	 *
	 * This method is responsible for rendering a single media item for use in the media uploader
	 * field. Taking into account whether the media uploader is rendering multiple items or not,
	 * and then taking into account the mime type of the attachment, render a media element. If
	 *
	 * @since 3.3.0
	 * @param int  $attachment_id The ID of the attachment to render.
	 * @param bool $is_multiple Whether the media uploader allows multiple attachments or not.
	 * @return void
	 * @deprecated 4.0.0
	 */
	public function render_media_item( $attachment_id = 0, $is_multiple = false ) {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Media_Field::render_media_item()' );

		$attachment = wp_prepare_attachment_for_js( absint( $attachment_id ) ); ?>

		<?php if ( $is_multiple ) {

			$remove_label = _x( 'Remove', 'media item - remove', 'wp_backstage' ); ?>

			<span 
			class="wp-backstage-media-uploader__attachment"
			data-attachment-type="<?php echo esc_attr( $attachment['type'] ); ?>"
			data-attachment-subtype="<?php echo esc_attr( $attachment['subtype'] ); ?>"
			data-attachment-id="<?php echo esc_attr( $attachment['id'] ); ?>">
				<button 
				title="<?php echo esc_attr( $remove_label ); ?>"
				type="button" 
				class="wp-backstage-media-uploader__attachment-remove button-link attachment-close media-modal-icon">
					<span class="screen-reader-text"><?php
						echo esc_html( $remove_label );
					?></span>
				</button>
				<?php echo wp_get_attachment_image(
					absint( $attachment['id'] ),
					'thumbnail',
					true,
					array(
						'title' => $attachment['filename'],
					)
				); ?>
				<span class="wp-backstage-media-uploader__attachment-filename">
					<span><?php echo esc_html( $attachment['filename'] ); ?></span>
				</span>
			</span>

		<?php } elseif ( $attachment['type'] === 'video' ) { ?>

			<span 
			class="wp-backstage-media-uploader__attachment-single-video"
			data-attachment-type="<?php echo esc_attr( $attachment['type'] ); ?>"
			data-attachment-subtype="<?php echo esc_attr( $attachment['subtype'] ); ?>"
			data-attachment-id="<?php echo esc_attr( $attachment['id'] ); ?>">
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo wp_video_shortcode(
					array(
						'src'     => esc_url( $attachment['url'] ),
						'preload' => 'metadata',
						'class'   => 'wp-video-shortcode wp-mediaelement-keep',
					),
				); ?>
			</span>

		<?php } elseif ( $attachment['type'] === 'audio' ) { ?>

			<span 
			class="wp-backstage-media-uploader__attachment-single-audio"
			data-attachment-type="<?php echo esc_attr( $attachment['type'] ); ?>"
			data-attachment-subtype="<?php echo esc_attr( $attachment['subtype'] ); ?>"
			data-attachment-id="<?php echo esc_attr( $attachment['id'] ); ?>">
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo wp_audio_shortcode(
					array(
						'src'     => esc_url( $attachment['url'] ),
						'preload' => 'metadata',
						'class'   => 'wp-audio-shortcode wp-mediaelement-keep',
					),
				); ?>
			</span>

		<?php } elseif ( $attachment['type'] === 'image' ) { ?>

			<span 
			class="wp-backstage-media-uploader__attachment-single-image"
			data-attachment-type="<?php echo esc_attr( $attachment['type'] ); ?>"
			data-attachment-subtype="<?php echo esc_attr( $attachment['subtype'] ); ?>"
			data-attachment-id="<?php echo esc_attr( $attachment['id'] ); ?>">

				<?php echo wp_get_attachment_image(
					absint( $attachment['id'] ),
					'medium',
					true,
					array(
						'title' => $attachment['filename'],
					)
				); ?>

			</span>

		<?php } else { ?>

			<span 
			class="wp-backstage-media-uploader__attachment-single-file"
			data-attachment-type="<?php echo esc_attr( $attachment['type'] ); ?>"
			data-attachment-subtype="<?php echo esc_attr( $attachment['subtype'] ); ?>"
			data-attachment-id="<?php echo esc_attr( $attachment['id'] ); ?>">

				<?php echo wp_get_attachment_image(
					absint( $attachment['id'] ),
					'medium',
					true,
					array(
						'title' => $attachment['filename'],
					)
				); ?>

				<span class="wp-backstage-media-uploader__attachment-single-file-filename"><?php
					echo esc_html( $attachment['filename'] );
				?></span>
				<span class="wp-backstage-media-uploader__attachment-single-file-meta"><?php
					printf( '%1$s • %2$s', esc_html( $attachment['mime'] ), esc_html( $attachment['filesizeHumanReadable'] ) );
				?></span>

			</span>

		<?php }

	}

	/**
	 * Ajax Render Media
	 *
	 * This method is responsible for providing the ajax response for the media uploader
	 * preview.
	 *
	 * @since 3.3.0
	 * @return void
	 * @deprecated 4.0.0
	 */
	public function ajax_render_media() {

		_deprecated_function( __METHOD__, '4.0.0', 'WP_Backstage_Media_Field::ajax_render_media()' );

		// phpcs:ignore WordPress.Security.NonceVerification
		$posted_values = wp_unslash( $_POST );

		$attachment_ids = ( isset( $posted_values['attachment_ids'] ) && is_array( $posted_values['attachment_ids'] ) ) ? $posted_values['attachment_ids'] : array();
		$is_multiple    = ( isset( $posted_values['attachment_ids'] ) && ( $posted_values['is_multiple'] === 'true' ) );

		foreach ( $attachment_ids as $attachment_id ) {
			$this->render_media_item( $attachment_id, $is_multiple );
		}

		wp_die();
	}

}
