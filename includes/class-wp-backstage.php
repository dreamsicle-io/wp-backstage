<?php
/**
 * WP Backstage
 *
 * @since       2.0.0
 * @package     wp_backstage
 * @subpackage  includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

/**
 * WP Backstage
 *
 * @since       2.0.0
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage {

	/**
	 * Errors
	 * 
	 * @since  2.0.0
	 * @var    array  $errors  The array of all errors on the instance.
	 */
	protected $errors = array();

	/**
	 * Plugin Dependencies
	 * 
	 * @link   https://developer.wordpress.org/reference/functions/is_plugin_active/  is_plugin_active()
	 * 
	 * @since  2.0.0
	 * @var    array  $errors  The array of all errors on the instance.
	 */
	protected $plugin_dependencies = array();

	

	/**
	 * KSES P
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  0.0.1
	 * @var    array  $kses_p  KSES configuration for paragraph tags.
	 */
	static $kses_p = array(
		'a' => array(
			'class'  => array(), 
			'id'     => array(), 
			'style'  => array(), 
			'href'   => array(),
			'title'  => array(), 
			'target' => array(), 
			'rel'    => array(), 
		),
		'br' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'em' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'strong' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'code' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'i' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
	);

	/**
	 * KSES Label
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @since  0.0.1
	 * @var    array  $kses_label  KSES configuration for label tags.
	 */
	static $kses_label = array(
		'em' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'strong' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'code' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'i' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
	);

	/**
	 * Construct
	 * 
	 * @since   2.0.0
	 * @return  void 
	 */
	public function __construct() {
		$this->plugin_dependencies = array(
			array(
				'key'  => 'classic-editor/classic-editor.php',
				'name' => __( 'Classic Editor', 'wp_backstage' ),
				'url'  => 'https://wordpress.org/plugins/classic-editor/',
			),
			array(
				'key'  => 'classic-widgets/classic-widgets.php',
				'name' => __( 'Classic Widgets', 'wp_backstage' ),
				'url'  => 'https://wordpress.org/plugins/classic-widgets/',
			),
		);
		$this->set_errors();
		$GLOBALS['wp_backstage'] = $this;
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
	 * @return  void 
	 */
	public function init() {

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		add_action( 'current_screen', array( $this, 'add_help_tab' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_editor_style' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_code_editor_style' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_media_uploader_style' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_thumbnail_column_style' ), 10 );
		add_action( 'admin_print_scripts', array( $this, 'inline_global_script' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_media_uploader_script' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_date_picker_script' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_color_picker_script' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_address_script' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_editor_script' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_code_editor_script' ), 10 );
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
		add_action( 'customize_controls_print_scripts', array( $this, 'inline_widget_customizer_script' ), 10 );
		add_action( 'customize_controls_print_scripts', array( $this, 'inline_nav_menu_item_customizer_script' ), 10 );
		add_action( 'wp_backstage_options_print_footer_scripts', array( $this, 'inline_options_script' ), 10 );
	}

	/**
	 * Set Errors
	 * 
	 * @link   https://developer.wordpress.org/reference/functions/is_plugin_active/  is_plugin_active()
	 * 
	 * @since   2.0.0
	 * @return  void 
	 */
	protected function set_errors() {

		if ( is_array( $this->plugin_dependencies ) && ! empty( $this->plugin_dependencies ) ) {

			foreach ( $this->plugin_dependencies as $plugin_dependency ) {

				if ( ! $this->is_plugin_active( $plugin_dependency['key'] ) ) {

					$this->errors[] = new WP_Error( 'plugin_dependency', sprintf( 
						/* translators: 1:required arg key. */
						__( '[WP Backstage Plugin Dependency] The %1$s plugin must be installed and activated.', 'wp-backstage' ), 
						sprintf( 
							'<a href="%1$s">%2$s</a>', 
							esc_url( $plugin_dependency['url'] ), 
							esc_html( $plugin_dependency['name'] ) 
						)
					) );

				}

			}

		}

	}
	
	/**
	 * Is Plugin Active
	 * 
	 * The native is_plugin_active() function in WordPress does not exist 
	 * at the time this class is constructed. This function checks against 
	 * the `active_plugins` option in the database.
	 * 
	 * @link   https://developer.wordpress.org/reference/functions/is_plugin_active/  is_plugin_active()
	 * 
	 * @since   2.0.0
	 * @param   string  $plugin  The plugin file name as `classic-editor/classic-editor.php`.
	 * @return  void 
	 */
	protected function is_plugin_active( $plugin ) {
		$active_plugins = get_option('active_plugins');
		$is_active = false;
		if ( is_array( $active_plugins ) && in_array( $plugin, $active_plugins ) ) {
			$is_active = true;
		}
		return $is_active;
	}

	/**
	 * Has Errors
	 *
	 * A utility method to easily check if the instance has errors or not.
	 * 
	 * @since   2.0.0
	 * @return  bool  Whether the instance has errors or not. 
	 */
	public function has_errors() {
		return is_array( $this->errors ) && ! empty( $this->errors );
	}

	/**
	 * Print Errors
	 *
	 * @link     https://developer.wordpress.org/reference/classes/wp_error/ WP_Error()
	 * 
	 * @since   2.0.0
	 * @return  void 
	 */
	public function print_errors() {

		if ( $this->has_errors() ) {

			foreach ( $this->errors as $error ) {
				
				if ( is_wp_error( $error ) ) {

					$message = sprintf( 
						/* translators: 1: error message. */
						__( 'Error: %1$s', 'wp-backstage' ), 
						$error->get_error_message() 
					); ?>

					<div class="notice notice-error">

						<p><?php 
				
							echo wp_kses( $message, WP_Backstage::$kses_p );

						?></p>

					</div>
				
				<?php }
			
			}

		}

	}

	/**
	 * Render Help Tab
	 * 
	 * Renders the WP Backstage help tab on all screens. See `WP_Backstage::add_help_tab`.
	 * 
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
	 * @since   2.0.0
	 * @return  void
	 */
	function render_help_tab() {
		$screen = get_current_screen(); ?>
		<h3><?php esc_html_e( 'Debug', 'wp_backstage' ); ?></h3>
		<p><?php esc_html_e( 'The following is useful debug information for WP Backstage development.', 'wp_backstage' ); ?></p>
		<p><strong><?php esc_html_e( 'Current Screen', 'wp_backstage' ); ?></strong></p>
		<ul>
			<li>
				<strong><?php esc_html_e( 'Parent Base:', 'wp_backstage' ); ?></strong>
				&nbsp;
				<code><?php echo esc_html( $screen->parent_base ); ?></code>
			</li>
			<li>
				<strong><?php esc_html_e( 'Base:', 'wp_backstage' ); ?></strong>
				&nbsp;
				<code><?php echo esc_html( $screen->base ); ?></code>
			</li>
			<li>
				<strong><?php esc_html_e( 'ID:', 'wp_backstage' ); ?></strong>
				&nbsp;
				<code><?php echo esc_html( $screen->id ); ?></code>
			</li>
		</ul>
	<?php }

	/**
	 * Add Help Tab
	 * 
	 * Registers the WP Backstage help tab. See `WP_Backstage::render_help_tab`.
	 * 
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
	 * @since   2.0.0
	 * @param   WP_Screen  $screen  an instance of `WP_Screen`.
	 * @return  void
	 */
	function add_help_tab( $screen = null ) {
		$screen->add_help_tab( array(
			'id'       => 'wp_backstage',
			'title'    => __( 'WP Backstage', 'wp_backstage' ),
			'callback' => array( $this, 'render_help_tab' ),
			'priority' => 50,
		) );
	}

	/**
	 * Inline Media Uplaoder Style
	 *
	 * Inlines the editor field style.
	 * 
	 * @since   2.0.0
	 * @return  void  
	 */
	public function inline_media_uploader_style() { ?>

		<style 
		id="wp_backstage_media_uploader_style"
		type="text/css">

			.wp-backstage-media-uploader__legend {
				cursor: pointer;
				padding: 2px 0;
				font-size: inherit;
			}

			.wp-backstage-media-uploader__buttons {
				display: block;
				position: relative;
			}

			.wp-backstage-media-uploader__button {
				margin: 0 8px 0 0;
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
				max-width: 100%;
				margin: 0 12px 12px 0;
				float: left;
				background-color: #ffffff;
			}
			
			.wp-backstage-media-uploader__attachment[data-attachment-id="0"] {
				display: none !important;
			}
			
			.wp-backstage-media-uploader__attachment-image {
				display: block;
				width: 100%;
				margin: 0;
				padding: 0;
				background-image:
					linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7),
					linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7);
				background-position: 0 0, 10px 10px;
				box-shadow: inset 0 0 0 1px #dcdcde;
				background-size: 20px 20px;
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
	 */
	public function inline_editor_style() { ?>

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
	 * Inlines the editor field style.
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_customizer_style() { ?>

		<style 
		id="wp_backstage_customizer_style"
		type="text/css">

			.ui-datepicker {
				z-index: 1000000 !important;
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
	 */
	public function inline_code_editor_style() { ?>

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

		// jquery
		if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}
		// jquery ui
		if ( ! wp_script_is( 'jquery-ui-core', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-core' );
		}
		if ( ! wp_script_is( 'jquery-ui-theme-default', 'enqueued' ) ) {
			wp_enqueue_style( 
				'jquery-ui-theme-default', 
				'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', 
				array(), 
				'1.12.1' 
			);
		}
		if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
		if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}
		// editor
		if ( ! did_action( 'wp_enqueue_editor' ) ) {
			wp_enqueue_editor();
		}
		// media
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		// color picker
		if ( ! wp_script_is( 'wp-color-picker', 'enqueued' ) ) {
			wp_enqueue_script( 'wp-color-picker' );
		}
		if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
			wp_enqueue_style( 'wp-color-picker' );
		}

	}

	/**
	 * Inline Thumbnail Column Style
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function inline_thumbnail_column_style() { ?>
		
		<style 
		id="wp_backstage_thumbnail_column_style"
		type="text/css">

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
	 * Inline Global Script
	 *
	 * Inlines the script that initializes the global `wpBackstage` JavaScript object.
	 * 
	 * @since   2.0.0
	 * @return  void
	 */
	public function inline_global_script() { ?>
		<script 
		id="wp_backstage_global_script"
		type="text/javascript">
			window.wpBackstage = {
				colorPicker: {},
				datePicker: {},
				address: {},
				mediaUploader: {},
				editor: {},
				codeEditor: {
					settings: {},
				},
			};
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
	 * @return  void  
	 */
	public function inline_media_uploader_script() { ?>

		<script 
		id="wp_backstage_media_uploader_script"
		type="text/javascript">

			(function($) {

				function findParentUploader(element = null) {
					var parentNode = element.parentNode;
					while (! parentNode.hasAttribute('data-media-uploader-id')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode;
				}

				function findParentAttachment(element = null) {
					var parentNode = element.parentNode;
					while (! parentNode.hasAttribute('data-attachment-id')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode;
				}

				function handleCloneClick(e = null) {
					const uploader = findParentUploader(e.target);
					uploader.wpBackstage.modal.open();
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
					if (newAttachmentIDs.length <= 0) {
						reset(uploader);
					}
					if (isMultiple) {
						refreshSortable(uploader);
					}
				}

				function appendClones(uploader = null, newAttachments = [], replace = false) {
					const previewList = uploader.wpBackstage.ui.previewList;
					const template = uploader.wpBackstage.ui.template;
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const cloneIDs = getCloneIDs(uploader);
					const size = isMultiple ? 'thumbnail' : 'medium';
					const attachments = newAttachments.filter(function(attachment) {
						return ! cloneIDs.includes(attachment.id);
					});
					if (replace) {
						removeClones(uploader);
					}
					for (var i = 0; i < attachments.length; i++) {
						const clone = template.cloneNode(true);
						const image = clone.querySelector('img');
						const caption = clone.querySelector('.wp-backstage-media-uploader__attachment-caption');
						const removeButton = clone.querySelector('.wp-backstage-media-uploader__attachment-remove');
						const url = attachments[i].mime.includes('image') ? attachments[i].sizes[size].url : attachments[i].icon;
						clone.setAttribute('data-attachment-id', attachments[i].id);
						clone.style.cursor = isMultiple ? 'move' : 'pointer';
						image.setAttribute('src', url);
						image.setAttribute('alt', attachments[i].alt);
						image.setAttribute('title', attachments[i].title);
						caption.setAttribute('title', attachments[i].caption);
						removeButton.addEventListener('click', handleAttachmentRemoveButtonClick);
						clone.addEventListener('click', handleCloneClick);
						previewList.appendChild(clone);
					}
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
					appendClones(uploader, attachments, ! isMultiple);
					disableButton(addButton);
					enableButton(removeButton);
					if (isMultiple) {
						enableButton(addToButton);
						disableButton(replaceButton);
						refreshSortable(uploader);
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
					const legend = uploader.wpBackstage.ui.legend;
					addButton.removeEventListener('click', handleAddButtonClick);
					addToButton.removeEventListener('click', handleAddToButtonClick);
					replaceButton.removeEventListener('click', handleReplaceButtonClick);
					removeButton.removeEventListener('click', handleRemoveButtonClick);
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
						const query = wp.media.query({
							order: 'ASC',
							orderby: 'post__in',
							perPage: -1,
							post__in: attachmentIDs,
							query: true,
						});
						query.more().done(function() {
							const attachments = this.models.map(function(model) {
								return model.attributes;
							});
							appendClones(uploader, attachments);
							if (isMultiple) {
								refreshSortable(uploader);
							}
						});
					}
					if (isMultiple) {
						initSortable(uploader);
					}
				}

				function init(uploader = null) {
					const fieldId = uploader.getAttribute('data-media-uploader-id');
					const input = uploader.querySelector('#' + fieldId);
					const legend = uploader.querySelector('#' + fieldId + '_legend');
					const addButton = uploader.querySelector('#' + fieldId + '_button_add');
					const addToButton = uploader.querySelector('#' + fieldId + '_button_add_to');
					const replaceButton = uploader.querySelector('#' + fieldId + '_button_replace');
					const removeButton = uploader.querySelector('#' + fieldId + '_button_remove');
					const preview = uploader.querySelector('#' + fieldId + '_preview');
					const previewList = preview.querySelector('#' + fieldId + '_preview_list');
					const template = preview.querySelector('[data-attachment-id="0"]');
					const title = uploader.getAttribute('data-media-uploader-title');
					const buttonText = uploader.getAttribute('data-media-uploader-button');
					const type = uploader.getAttribute('data-media-uploader-type');
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					const modal = wp.media({
						title: title,
						multiple: isMultiple, 
						library: { type: type || 'image' }, 
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
					if (legend) {
						legend.addEventListener('click', handleLegendClick);
					}
					uploader.wpBackstage = {
						modal: modal,
						ui: {
							input: input,
							legend: legend,
							addButton: addButton,
							addToButton: addToButton,
							replaceButton: replaceButton,
							removeButton: removeButton,
							preview: preview,
							previewList: previewList,
							template: template,
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
	 * Inline Datepicker Script
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
	 */
	public function inline_date_picker_script() { ?>

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
	 */
	public function inline_color_picker_script() { ?>

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
						defaultColor: false, // bool, string
						palettes: palettes, // bool, []
						change: handleChange,
						clear: handleChange,
					};
					// Add seperately to ensure default WP setting 
					// is respected if no mode is set.
					if (mode) {
						options.mode = mode; // string (hsl, hsv)
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
	 */
	public function inline_code_editor_script() { ?>

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
	 */
	public function inline_address_script() { ?>

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
	 */
	public function inline_editor_script() { ?>

		<script 
		id="wp_backstage_editor_script"
		type="text/javascript">

			(function($) {

				var saveTimer = null;

				function findParentEditor(element = null) {
					var parentNode = element.parentNode;
					while (! parentNode.hasAttribute('data-editor-id')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode;
				}

				function destroy(editor = null) {
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

				function handleSetup(e = null, wpEditor = null) {
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
							plugins: 'charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview',
							toolbar1: 'bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link',
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

				document.addEventListener('DOMContentLoaded', function(e) {
					$(document).on( 'tinymce-editor-setup', handleSetup);
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Post Type Script
	 * 
	 * @since   2.0.0
	 * @return  void  
	 */
	public function inline_post_type_script() { ?>

		<script 
		id="wp_backstage_post_type_script"
		type="text/javascript">

			(function($) {

				function findParentMetaBox(element = null) {
					var parentNode = element.parentNode;
					while (! parentNode.classList.contains('postbox')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode
				}

				function handleMetaBoxHandleClick(e = null) {
					const metaBox = findParentMetaBox(e.target);
					if (! metaBox.classList.contains('closed')) {
						window.wpBackstage.editor.refreshAll(metaBox);
						window.wpBackstage.codeEditor.refreshAll(metaBox);
					}
				}

				function handleMetaBoxSortStop(e = null, ui = null) {
					const item = ui.item[0];
					if (item.classList.contains('postbox')) {
						window.wpBackstage.editor.refreshAll(item);
						window.wpBackstage.codeEditor.refreshAll(item);
					}
				}

				function handleScreenOptionChange(e = null) {
					const metaBox = document.getElementById(e.target.value);
					if (metaBox && ! metaBox.classList.contains('closed')) {
						window.wpBackstage.editor.refreshAll(metaBox);
						window.wpBackstage.codeEditor.refreshAll(metaBox);
					}
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
					if (metaBoxSortables && (metaBoxSortables.length > 0)) {
						for (var i = 0; i < metaBoxSortables.length; i++) {
							initMetaBoxSortable(metaBoxSortables[i]);
						}
					}
				}

				function initAllMetaBoxes() {
					const metaBoxes = document.querySelectorAll('.postbox');
					if (metaBoxes && (metaBoxes.length > 0)) {
						for (var i = 0; i < metaBoxes.length; i++) {
							initMetaBox(metaBoxes[i]);
						}
					}
				}

				function initAllScreenOptions() {
					const checkboxes = document.querySelectorAll('.metabox-prefs input[type="checkbox"]');
					if (checkboxes && (checkboxes.length > 0)) {
						for (var i = 0; i < checkboxes.length; i++) {
							initScreenOption(checkboxes[i]);
						}
					}
				}

				function init() {
					window.wpBackstage.colorPicker.initAll();
					window.wpBackstage.datePicker.initAll();
					window.wpBackstage.address.initAll();
					window.wpBackstage.mediaUploader.initAll();
					window.wpBackstage.codeEditor.initAll();
					window.wpBackstage.editor.initAll();
					initAllMetaBoxes();
					initAllMetaBoxSortables();
					initAllScreenOptions();
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
	 * @return  void  
	 */
	public function inline_nav_menu_item_script() { ?>

		<script 
		id="wp_backstage_nav_menu_item_script"
		type="text/javascript">

			(function($) {

				var navMenuItemHandleTimer = null;
				var navMenuItemMoveTimer = null;

				function getInitialItems() {
					const itemList = document.getElementById('menu-to-edit');
					const items = itemList.querySelectorAll('.menu-item');
					return Array.from(items);
				}

				function getNewItems() {
					const itemList = document.getElementById('menu-to-edit');
					const items = itemList.querySelectorAll('.menu-item');
					return Array.from(items).filter(item => ! item.hasAttribute('data-wp-backstage-initialized'));
				}

				function findParentNavMenuItem(element = null) {
					var parentNode = element.parentNode;
					while (! parentNode.classList.contains('menu-item')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode;
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-menu-item') {
							const newItems = getNewItems();
							for (var i = 0; i < newItems.length; i++) {
								const newItem = newItems[i];
								window.wpBackstage.colorPicker.initAll(newItem);
								window.wpBackstage.datePicker.initAll(newItem);
								window.wpBackstage.address.initAll(newItem);
								window.wpBackstage.mediaUploader.initAll(newItem);
								window.wpBackstage.editor.initAll(newItem);
								window.wpBackstage.codeEditor.initAll(newItem);
								initAllNavMenuItemHandles(newItem);
								newItem.setAttribute('data-wp-backstage-initialized', true);
							}
						}
					}
				}

				function handleNavMenuItemMoveLinkClick(e = null) {
					const navMenuItem = findParentNavMenuItem(e.target);
					if (navMenuItemMoveTimer) {
						clearTimeout(navMenuItemMoveTimer);
					}
					navMenuItemMoveTimer = setTimeout(function() {
						if (navMenuItem.classList.contains('menu-item-edit-active')) {
							window.wpBackstage.editor.refreshAll(navMenuItem);
							window.wpBackstage.codeEditor.refreshAll(navMenuItem);
						}
					}, 500);
				}

				function initNavMenuItemMoveLink(link = null) {
					link.addEventListener('click', handleNavMenuItemMoveLinkClick);
				}

				function initAllNavMenuItemMoveLinks(container = null) {
					container = container || document.getElementById('menu-to-edit');
					const navMenuItemMoveLinks = container.querySelectorAll('.menus-move');
					if (navMenuItemMoveLinks && (navMenuItemMoveLinks.length > 0)) {
						for (var i = 0; i < navMenuItemMoveLinks.length; i++) {
							initNavMenuItemMoveLink(navMenuItemMoveLinks[i]);
						}
					}
				}

				function init() {
					const initialItems = getInitialItems();
					for (var i = 0; i < initialItems.length; i++) {
						initialItems[i].setAttribute('data-wp-backstage-initialized', true);
					}
					window.wpBackstage.colorPicker.initAll();
					window.wpBackstage.datePicker.initAll();
					window.wpBackstage.address.initAll();
					window.wpBackstage.mediaUploader.initAll();
					window.wpBackstage.codeEditor.initAll();
					window.wpBackstage.editor.initAll();
					initAllNavMenuItemHandles();
					initNavMenuSortable();
					initAllScreenOptions();
					initAllNavMenuItemMoveLinks();
					$(document).ajaxSuccess(handleSuccess);
				}

				function handleNavMenuItemHandleClick(e = null) {
					const navMenuItem = findParentNavMenuItem(e.target);
					if (navMenuItemHandleTimer) {
						clearTimeout(navMenuItemHandleTimer);
					}
					navMenuItemHandleTimer = setTimeout(function() {
						if (navMenuItem.classList.contains('menu-item-edit-active')) {
							window.wpBackstage.editor.refreshAll(navMenuItem);
							window.wpBackstage.codeEditor.refreshAll(navMenuItem);
						}
					}, 500);
				}

				function handleScreenOptionChange(e = null) {
					const fieldContainers = document.querySelectorAll('[data-wp-backstage-field-name="' + e.target.value + '"]');
					for (var i = 0; i < fieldContainers.length; i++) {
						const fieldContainer = fieldContainers[i];
						if (fieldContainer && ! fieldContainer.classList.contains('hidden-field')) {
							window.wpBackstage.editor.refreshAll(fieldContainer);
							window.wpBackstage.codeEditor.refreshAll(fieldContainer);
						}
					}
				}

				function initNavMenuItemHandle(handle = null) {
					handle.addEventListener('click', handleNavMenuItemHandleClick);
				}
				
				function initAllNavMenuItemHandles(container = null) {
					container = container || document.getElementById('menu-to-edit');
					const navMenuItemHandles = container.querySelectorAll('.menu-item-handle .item-edit');
					if (navMenuItemHandles && (navMenuItemHandles.length > 0)) {
						for (var i = 0; i < navMenuItemHandles.length; i++) {
							initNavMenuItemHandle(navMenuItemHandles[i]);
						}
					}
				}

				function initScreenOption(checkbox = null) {
					checkbox.addEventListener('change', handleScreenOptionChange);
				}

				function handleNavMenuSortStop(e = null, ui = null) {
					const item = ui.item[0];
					if (item.classList.contains('menu-item')) {
						window.wpBackstage.editor.refreshAll(item);
						window.wpBackstage.codeEditor.refreshAll(item);
					}
				}

				function initNavMenuSortable() {
					const sortable = document.getElementById('menu-to-edit');
					$(sortable).on('sortstop', handleNavMenuSortStop);
				}

				function initAllScreenOptions() {
					const checkboxes = document.querySelectorAll('.metabox-prefs input[type="checkbox"]');
					if (checkboxes && (checkboxes.length > 0)) {
						for (var i = 0; i < checkboxes.length; i++) {
							initScreenOption(checkboxes[i]);
						}
					}
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
	 * @return  void  
	 */
	public function inline_nav_menu_item_customizer_script() { ?>

		<script 
		id="wp_backstage_nav_menu_item_customizer_script"
		type="text/javascript">

			(function($) {

				var controlExpandTimer = null;

				function setControlElementValue(controlElement = null, value = undefined) {
					const fieldName = controlElement.element.attr('data-wp-backstage-field-name');
					const fieldType = controlElement.element.attr('data-wp-backstage-field-type');
					switch (fieldType) {
						case 'checkbox': {
							const input = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
							input.attr('checked', Boolean(value));
							break;
						}
						case 'radio': {
							const radios = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
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
							const checkboxes = controlElement.element.find('[name="menu-item-' + fieldName + '[]"]');
							checkboxes.each(function() {
								const checkbox = $(this);
								checkbox.attr('checked', (Array.isArray(value) && value.includes(checkbox.val())));
							});
							break;
						}
						case 'time': {
							const timePieces = (value && ! Array.isArray(value)) ? value.split(':') : value;
							const hourSelect = controlElement.element.find('[name="menu-item-' + fieldName + '[hour]"]');
							const minuteSelect = controlElement.element.find('[name="menu-item-' + fieldName + '[minute]"]');
							const secondSelect = controlElement.element.find('[name="menu-item-' + fieldName + '[second]"]');
							hourSelect.val((timePieces && timePieces[0]) ? timePieces[0] : hourSelect.find('option:first-child').val());
							minuteSelect.val((timePieces && timePieces[1]) ? timePieces[1] : minuteSelect.find('option:first-child').val());
							secondSelect.val((timePieces && timePieces[2]) ? timePieces[2] : secondSelect.find('option:first-child').val());
							break;
						}
						case 'address': {
							const countrySelect = controlElement.element.find('[name="menu-item-' + fieldName + '[country]"]');
							const address1Input = controlElement.element.find('[name="menu-item-' + fieldName + '[address_1]"]');
							const address2Input = controlElement.element.find('[name="menu-item-' + fieldName + '[address_2]"]');
							const cityInput = controlElement.element.find('[name="menu-item-' + fieldName + '[city]"]');
							const stateSelect = controlElement.element.find('select[name="menu-item-' + fieldName + '[state]"]');
							const stateInput = controlElement.element.find('input[name="menu-item-' + fieldName + '[state]"]');
							const zipInput = controlElement.element.find('[name="menu-item-' + fieldName + '[zip]"]');
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
							const select = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
							select.val(value || select.find('option:first-child').val());
							break;
						}
						default: {
							const input = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
							input.val(value);
							break;
						}
					}
				}

				function initControlElementChangeHandler(controlElement = null, setting = null) {
					const fieldName = controlElement.element.attr('data-wp-backstage-field-name');
					const fieldType = controlElement.element.attr('data-wp-backstage-field-type');
					switch (fieldType) {
						case 'checkbox': {
							const input = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
							input.on('change', function(e) {
								handleSettingChange(setting, fieldName, e.target.checked ? e.target.value : undefined);
							});
							break;
						}
						case 'radio': {
							const radios = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
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
							const checkboxes = controlElement.element.find('[name="menu-item-' + fieldName + '[]"]');
							checkboxes.each(function() {
								const checkbox = $(this);
								checkbox.on('change', function(e) {
									handleCheckboxSetSettingChange(setting, fieldName, e.target.value, e.target.checked);
								});
							});
							break;
						}
						case 'time': {
							const hourSelect = controlElement.element.find('[name="menu-item-' + fieldName + '[hour]"]');
							const minuteSelect = controlElement.element.find('[name="menu-item-' + fieldName + '[minute]"]');
							const secondSelect = controlElement.element.find('[name="menu-item-' + fieldName + '[second]"]');
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
							const countrySelect = controlElement.element.find('[name="menu-item-' + fieldName + '[country]"]');
							const address1Input = controlElement.element.find('[name="menu-item-' + fieldName + '[address_1]"]');
							const address2Input = controlElement.element.find('[name="menu-item-' + fieldName + '[address_2]"]');
							const cityInput = controlElement.element.find('[name="menu-item-' + fieldName + '[city]"]');
							const stateSelect = controlElement.element.find('select[name="menu-item-' + fieldName + '[state]"]');
							const stateInput = controlElement.element.find('input[name="menu-item-' + fieldName + '[state]"]');
							const zipInput = controlElement.element.find('[name="menu-item-' + fieldName + '[zip]"]');
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
						default: {
							const input = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
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
						setControlElementValue(elements[fieldName], values[fieldName]);
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
					window.wpBackstage.colorPicker.initAll(control.container[0]);
					window.wpBackstage.datePicker.initAll(control.container[0]);
					window.wpBackstage.address.initAll(control.container[0]);
					window.wpBackstage.mediaUploader.initAll(control.container[0]);
					window.wpBackstage.codeEditor.initAll(control.container[0]);
					window.wpBackstage.editor.initAll(control.container[0]);
				}

				function handleControlExpanded(control =  null) {
					window.wpBackstage.editor.refreshAll(control.container[0]);
					window.wpBackstage.codeEditor.refreshAll(control.container[0]);
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
					if (currentValues[fieldName][addressKey] !== value) {
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
						initControlElementChangeHandler(elements[fieldName], control.setting);
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
	 * Inline Taxonomy Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_taxonomy_script() { ?>

		<script 
		id="wp_backstage_taxonomy_script"
		type="text/javascript">

			(function($) {

				function resetForm() {
					const form = document.querySelector('#addtag');
					form.reset();
					window.wpBackstage.colorPicker.resetAll(form);
					window.wpBackstage.codeEditor.resetAll(form);
					window.wpBackstage.mediaUploader.resetAll(form);
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-tag') {
							resetForm();
						}
					}
				}

				function init() {
					window.wpBackstage.colorPicker.initAll();
					window.wpBackstage.datePicker.initAll();
					window.wpBackstage.address.initAll();
					window.wpBackstage.mediaUploader.initAll();
					window.wpBackstage.codeEditor.initAll();
					window.wpBackstage.editor.initAll();
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
					window.wpBackstage.colorPicker.initAll();
					window.wpBackstage.datePicker.initAll();
					window.wpBackstage.address.initAll();
					window.wpBackstage.mediaUploader.initAll();
					window.wpBackstage.codeEditor.initAll();
					window.wpBackstage.editor.initAll();
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
	 * @return  void  
	 */
	public function inline_widget_script() { ?>

		<script 
		id="wp_backstage_widget_script"
		type="text/javascript">

			(function($) {

				var widgetHandleTimer = null;

				function findWidget(id = '') {
					const input = document.querySelector('.widget-id[value="' + id + '"]');
					const widget = findParentWidget(input);
					return widget;
				}

				function findParentWidget(element = null) {
					var parentNode = element.parentNode;
					while (! parentNode.classList.contains('widget')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode;
				}

				function handleWidgetAdded(widget = null) {
					window.wpBackstage.colorPicker.initAll(widget);
					window.wpBackstage.datePicker.initAll(widget);
					window.wpBackstage.address.initAll(widget);
					window.wpBackstage.mediaUploader.initAll(widget);
					window.wpBackstage.codeEditor.initAll(widget);
					window.wpBackstage.editor.initAll(widget);
					initAllWidgetHandles(widget);
				}

				function handleWidgetUpdated(widget = null) {
					window.wpBackstage.colorPicker.initAll(widget);
					window.wpBackstage.datePicker.initAll(widget);
					window.wpBackstage.address.initAll(widget);
					window.wpBackstage.mediaUploader.initAll(widget);
					window.wpBackstage.codeEditor.initAll(widget);
					// The editor must be destroyed and reinitialized,
					// as something about it is still being attached
					// to the DOM in this case.
					window.wpBackstage.editor.refreshAll(widget);
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'save-widget') {
							const widget = findWidget(params.get('widget-id'));
							if (Boolean(params.get('add_new'))) {
								handleWidgetAdded(widget);
							} else if (Boolean(params.get('delete_widget'))) {
								// This is fired when widgets are deleted.
							} else {
								handleWidgetUpdated(widget);
							}
						} else if (action === 'widgets-order') {
							// This is fired when widgets are reordered.
							// Because WP closes the widget when reordering, 
							// and because WP Backstage refreshes the fields
							// when the widget handle is toggled, nothing needs
							// to be done here currently.
						}
					}
				}

				function handleWidgetHandleClick(e = null) {
					const widget = findParentWidget(e.target);
					if (widgetHandleTimer) {
						clearTimeout(widgetHandleTimer);
					}
					widgetHandleTimer = setTimeout(function() {
						if (widget.classList.contains('open')) {
							window.wpBackstage.editor.refreshAll(widget);
							window.wpBackstage.codeEditor.refreshAll(widget);
						}
					}, 500);
				}

				function initWidgetHandle(handle = null) {
					handle.addEventListener('click', handleWidgetHandleClick);
				}
				
				function initAllWidgetHandles(container = null) {
					container = container || document;
					const widgetHandles = container.querySelectorAll('.widget-top');
					if (widgetHandles && (widgetHandles.length > 0)) {
						for (var i = 0; i < widgetHandles.length; i++) {
							initWidgetHandle(widgetHandles[i]);
						}
					}
				}
				
				function init() {
					const container = document.getElementById('widgets-right');
					window.wpBackstage.colorPicker.initAll(container);
					window.wpBackstage.datePicker.initAll(container);
					window.wpBackstage.address.initAll(container);
					window.wpBackstage.mediaUploader.initAll(container);
					window.wpBackstage.codeEditor.initAll(container);
					window.wpBackstage.editor.initAll(container);
					initAllWidgetHandles(container);
					$(document).ajaxSuccess(handleSuccess);
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Widget Customizer Script
	 * 
	 * @since   2.0.0
	 * @return  void  
	 */
	public function inline_widget_customizer_script() { ?>

		<script 
		id="wp_backstage_widget_customizer_script"
		type="text/javascript">

			(function($) {

				var controlExpandTimer = null;

				function initOrRefreshAll(widget = null) {
					if ( ! widget.hasAttribute('data-wp-backstage-initialized') ) {
						window.wpBackstage.colorPicker.initAll(widget);
						window.wpBackstage.datePicker.initAll(widget);
						window.wpBackstage.address.initAll(widget);
						window.wpBackstage.mediaUploader.initAll(widget);
						window.wpBackstage.codeEditor.initAll(widget);
						window.wpBackstage.editor.initAll(widget);
						widget.setAttribute('data-wp-backstage-initialized', true);
					} else {
						window.wpBackstage.editor.refreshAll(widget);
						window.wpBackstage.codeEditor.refreshAll(widget);
					}
				}

				function handleWidgetsSortStop(e = null, ui = null) {
					const widget = ui.item.find('.widget');
					initOrRefreshAll(widget[0]);
				}

				function handleControlExpanded(control = null) {
					const widget = control.container.find('.widget');
					initOrRefreshAll(widget[0]);
				}

				function initSectionSortables(section = null) {
					section.contentContainer.on('sortstop', handleWidgetsSortStop);
				}

				function init() {
					wp.customize.bind( 'ready', function() {
						wp.customize.section.each( function (section) { 
							if (section.id.startsWith('sidebar-widgets')) {
								section.deferred.embedded.done(function() {
									initSectionSortables(section);
								});
							}
						});
					});
					wp.customize.control.bind('add', function(control) {
						if (control.id.startsWith('widget_wp_backstage_widget')) {
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
						}
					});
				}

				document.addEventListener('DOMContentLoaded', function() {
					init();
				});

			})();

		</script>

	<?php }

	/**
	 * Inline User Script
	 * 
	 * @since   2.0.0
	 * @return  void  
	 */
	public function inline_user_script() { ?>

		<script 
		id="wp_backstage_user_script"
		type="text/javascript">

			(function($) {

				function init() {
					window.wpBackstage.colorPicker.initAll();
					window.wpBackstage.datePicker.initAll();
					window.wpBackstage.address.initAll();
					window.wpBackstage.mediaUploader.initAll();
					window.wpBackstage.codeEditor.initAll();
					window.wpBackstage.editor.initAll();
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

}
