<?php
/**
 * WP Backstage
 *
 * @package     wp_backstage
 * @subpackage  includes
 */

/**
 * WP Backstage
 *
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Setup {

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
		add_action( 'admin_print_styles', array( $this, 'inline_editor_style' ), 10 );
		add_action( 'admin_print_styles', array( $this, 'inline_code_editor_style' ), 10 );
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
	 * @since   1.1.0
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
	 * @since   1.1.0
	 * @return  void
	 */
	public function inline_global_script() { ?>
		<script id="wp_backstage_global_script">
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
	 * @todo    Set selection when the uploader modal is opened.
	 *
	 * @link    https://codex.wordpress.org/Javascript_Reference/wp.media wp.media
	 * @link    https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://jqueryui.com/sortable/ jQuery UI Sortable
	 * @link    https://jqueryui.com/ jQuery UI
	 * 
	 * @since   0.0.1
	 * @since   1.1.0  Added methods to global `wpBackstage` object.
	 * @return  void  
	 */
	public function inline_media_uploader_script() { ?>

		<script 
		id="wp_backstage_media_uploader_script"
		type="text/javascript">

			(function($) {

				function init(uploader = null) {
					
					if (! uploader) { 
						return; 
					}
						
					const fieldId = uploader.getAttribute('data-media-uploader-id');
					const input = uploader.querySelector('#' + fieldId);
					const legend = uploader.querySelector('#' + fieldId + '_legend');
					const labels = document.querySelectorAll('[for="' + fieldId + '"]');
					const setButton = uploader.querySelector('#' + fieldId + '_button_set');
					const addButton = uploader.querySelector('#' + fieldId + '_button_add');
					const removeButton = uploader.querySelector('#' + fieldId + '_button_remove');
					const preview = uploader.querySelector('#' + fieldId + '_preview');
					const previewTemplate = uploader.querySelector('[data-media-uploader-template]');
					const initialClones = uploader.querySelectorAll('[data-media-uploader-clone]');
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

					function handleOpen(e = null) {
						modal.open();
					}
					function handleRemove(e = null) {
						e.preventDefault();
						removeClones();
						resetField();
					}
					function handleModalOpen() {
						// TO-DO: Set selection when opened.
						/* const ids = input.value ? input.value.split(',').map(function(id) { return parseInt(id); }) : [];
						const selection = modal.state().get('selection');
						if (! isMultiple) {
							selection.add(wp.media.attachment(ids[0]));
						} else {
							for (var i = 0; i < ids.length; i++) {
								selection.add(wp.media.attachment(ids[i]));
							}
						} */
					}
					function handleSelect() {
						const selection = modal.state().get('selection').toJSON();
						if (selection && (selection.length > 0)) {
							var saveIds = (input.value && isMultiple) ? input.value.split(',').map(function(id) { return parseInt(id); }) : [];
							if (! isMultiple) {
								removeClones();
							}
							for (var i = 0; i < selection.length; i++) {
								const attachment = selection[i];
								const attachmentId = parseInt(attachment.id, 10);
								saveIds.push(attachmentId);
								preview.appendChild(getClone(attachment));
							}
							setField(saveIds.join(','));
							if (isMultiple) {
								refreshSorting();
							}
						}
					}
					function getClone(attachment = null) {
						const clone = previewTemplate.cloneNode(true);
						const cloneImg = clone.querySelector('img');
						const orientationContainer = clone.querySelector('.attachment-preview');
						const filename = clone.querySelector('.filename > div');

						clone.removeAttribute('data-media-uploader-template');
						clone.setAttribute('data-media-uploader-clone', parseInt(attachment.id, 10));
						cloneImg.setAttribute('src', attachment.mime.includes('image') ? attachment.url : attachment.icon);
						clone.style.display = 'block';

						if (attachment.width > attachment.height) {
							orientationContainer.classList.remove('portrait');
							orientationContainer.classList.add('landscape');
						} else {
							orientationContainer.classList.add('portrait');
							orientationContainer.classList.remove('landscape');
						}
						filename.innerHTML = attachment.filename;
						filename.style.display = (attachment.mime.indexOf('image') === -1) ? 'block' : 'none';

						initClone(clone);

						return clone;
					}
					function removeClones() {
						const clones = getClones();
						if (clones && (clones.length > 0)) {
							for (var i = 0; i < clones.length; i++) {
								preview.removeChild(clones[i]);
							}
						}
					}
					function enableButton(button = null) {
						if (button) {
							button.removeAttribute('disabled', true);
							button.style.display = 'inline-block';
						}
					}
					function disableButton(button = null) {
						if (button) {
							button.setAttribute('disabled', true);
							button.style.display = 'none';
						}
					}
					function setField(value = null) {
						input.value = value;
						preview.style.display = 'block';
						disableButton(setButton);
						enableButton(removeButton);
						if (isMultiple) {
							enableButton(addButton);
						}
						$(input).trigger('change');
					}
					function resetField() {
						input.value = '';
						preview.style.display = 'none';
						enableButton(setButton);
						disableButton(removeButton);
						if (isMultiple) {
							disableButton(addButton);
						}
						$(input).trigger('change');
					}
					function initSorting() {
						$(preview).sortable({
							items: '[data-media-uploader-clone]', 
							stop: handleSortStop,  
						});
					}
					function refreshSorting() {
						$(preview).sortable('refresh');
					}
					function handleSortStop(e = null, ui = null) {
						const { item } = ui;
						if (item[0].classList.contains('attachment')) {
							const clones = getClones();
							const saveIds = [];
							if (clones && (clones.length > 0)) {
								for (var i = 0; i < clones.length; i++) {
									const attachmentId = parseInt(clones[i].getAttribute('data-media-uploader-clone'), 10);
									saveIds.push(attachmentId);
								}
							}
							setField(saveIds.join(','));
						}
					}
					function handleCloneMouseEnter(e = null) {
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.classList.add('selected');
							e.target.classList.add('details');
						}
					}
					function handleCloneMouseLeave(e = null) {
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.classList.remove('selected');
							e.target.classList.remove('details');
						}
					}
					function handleCloneClick(e = null) {
						e.preventDefault();
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.focus();
						} else {
							getParentClone(e.target).focus();
						}
					}
					function handleCheckClick(e = null) {
						e.preventDefault();
						const clone = getParentClone(e.target);
						const attachmentId = parseInt(clone.getAttribute('data-media-uploader-clone'), 10);
						var values = input.value ? input.value.split(',').map(function(id) { return parseInt(id, 10); }) : [];
						const valuesIndex = values.indexOf(attachmentId);
						if (valuesIndex !== -1) {
							const removed = values.splice(valuesIndex, 1);
						}
						preview.removeChild(clone);
						if (values.length > 0) {
							setField(values.join(','));
						} else {
							resetField();
						}
					}
					function initClone(clone = null) {
						if (clone) {
							const check = clone.querySelector('.check');
							clone.addEventListener('mouseenter', handleCloneMouseEnter);
							clone.addEventListener('mouseleave', handleCloneMouseLeave);
							clone.addEventListener('click', handleCloneClick);
							check.addEventListener('click', handleCheckClick);
						}
					}
					function getClones() {
						return preview.querySelectorAll('[data-media-uploader-clone]');
					}
					function getParentClone(el = null) {
						while ((el = el.parentElement) && ! el.getAttribute('data-media-uploader-clone'));
						return el;
					}

					modal.on('select', handleSelect);
					modal.on('open', handleModalOpen);
					setButton.addEventListener('click', handleOpen);
					removeButton.addEventListener('click', handleRemove);
					if (legend) {
						legend.addEventListener('click', handleOpen);
					}
					if (labels && (labels.length > 0)) {
						for (var i = 0; i < labels.length; i++) {
							labels[i].addEventListener('click', handleOpen);
						}
					}
					if (initialClones && (initialClones.length > 0)) {
						for (var i = 0; i < initialClones.length; i++) {
							initClone(initialClones[i]);
						}
					}
					if (isMultiple) {
						addButton.addEventListener('click', handleOpen);
						initSorting();
					}
					uploader.mediaUploader = {
						reset: function() {
							removeClones();
							resetField();
						}, 
					};
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
					uploader.mediaUploader.reset();
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
	 * @since   1.1.0  Added methods to global `wpBackstage` object.
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
	 * @since   1.1.0  Added methods to global `wpBackstage` object.
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
	 * @since   1.1.0  Added methods to global `wpBackstage` object.
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
	 * @since   1.1.0  Added methods to global `wpBackstage` object.
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
	 * @link     https://codex.wordpress.org/Javascript_Reference/wp.editor wp.editor
	 * @link     https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link     https://make.wordpress.org/core/2017/05/20/editor-api-changes-in-4-8/ WP Editor API Changes in 4.8
	 * @link     https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link     https://www.tiny.cloud/docs/demo/basic-example/ Tiny MCE Example
	 * 
	 * @since   0.0.1
	 * @since   1.1.0  Added methods to global `wpBackstage` object and fixes shortcode rendering.
	 * @return  void  
	 */
	public function inline_editor_script() { ?>

		<script 
		id="wp_backstage_editor_script"
		type="text/javascript">

			(function($) {

				var saveTimer = null;

				function destroy(editor = null) {
					const fieldId = editor.getAttribute('data-editor-id');
					wp.editor.remove(fieldId);
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
	 * @since   1.1.0
	 * @return  void  
	 */
	public function inline_post_type_script() { ?>

		<script 
		id="wp_backstage_post_type_script"
		type="text/javascript">

			(function($) {

				function handleMetaBoxHandleClick(e = null) {
					var { parentNode } = e.target;
					while (! parentNode.classList.contains('postbox')) {
						parentNode = parentNode.parentNode;
					}
					if (! parentNode.classList.contains('closed')) {
						window.wpBackstage.editor.refreshAll(parentNode);
						window.wpBackstage.codeEditor.refreshAll(parentNode);
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
	 * @since   1.1.0
	 * @return  void  
	 */
	public function inline_nav_menu_item_script() { ?>

		<script 
		id="wp_backstage_nav_menu_item_script"
		type="text/javascript">

			(function($) {

				var navMenuItemHandleTimer = null;

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
					$(document).ajaxSuccess(handleSuccess);
				}

				function handleNavMenuItemHandleClick(e = null) {
					var { parentNode } = e.target;
					if (navMenuItemHandleTimer) {
						clearTimeout(navMenuItemHandleTimer);
					}
					while (! parentNode.classList.contains('menu-item')) {
						parentNode = parentNode.parentNode;
					}
					navMenuItemHandleTimer = setTimeout(function() {
						if (parentNode.classList.contains('menu-item-edit-active')) {
							window.wpBackstage.editor.refreshAll(parentNode);
							window.wpBackstage.codeEditor.refreshAll(parentNode);
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
	 * @since   1.1.0
	 * @return  void  
	 */
	public function inline_nav_menu_item_customizer_script() { ?>

		<script 
		id="wp_backstage_nav_menu_item_customizer_script"
		type="text/javascript">

			(function($) {

				function setControlElementValue(control = null, fieldName = '') {
					const values = control.setting();
					const value = values[fieldName];
					const controlElement = control.elements[fieldName];
					const fieldType = controlElement.element.attr('data-wp-backstage-field-type');
					switch (fieldType) {
						default: 
							const input = controlElement.element.find('[name="menu-item-' + fieldName + '"]');
							input.val(values[fieldName]);
							break;
					}
				}

				function extendControl(control = null) {
					const fields = control.container.find('[data-wp-backstage-field-name]');
					for (var i = 0; i < fields.length; i++) {
						const field = fields[i];
						const fieldName = field.getAttribute('data-wp-backstage-field-name');
						const fieldFound = control.container.find('[data-wp-backstage-field-name="' + fieldName + '"]');
						control.elements[fieldName] = new wp.customize.Element(fieldFound);
						setControlElementValue(control, fieldName);
					}
				}

				function init() {
					wp.customize.control.bind('add', function(control) {
						if (control.extended(wp.customize.Menus.MenuItemControl)) {
							control.deferred.embedded.done(function() {
								extendControl(control);
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
	 * @since   1.1.0
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
	 * @since   1.1.0
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
					var parentNode = input.parentNode;
					while (! parentNode.classList.contains('widget')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode;
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'save-widget') {
							const isNew = Boolean(params.get('add_new'));
							const isDelete = Boolean(params.get('delete_widget'));
							const widget = findWidget(params.get('widget-id'));
							if (isNew) {
								window.wpBackstage.colorPicker.initAll(widget);
								window.wpBackstage.datePicker.initAll(widget);
								window.wpBackstage.address.initAll(widget);
								window.wpBackstage.mediaUploader.initAll(widget);
								window.wpBackstage.codeEditor.initAll(widget);
								window.wpBackstage.editor.initAll(widget);
								initAllWidgetHandles(widget);
							} else if (isDelete) {
								// This is fired when widgets are deleted.
							} else {
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
					var { parentNode } = e.target;
					if (widgetHandleTimer) {
						clearTimeout(widgetHandleTimer);
					}
					while (! parentNode.classList.contains('widget')) {
						parentNode = parentNode.parentNode;
					}
					widgetHandleTimer = setTimeout(function() {
						if (parentNode.classList.contains('open')) {
							window.wpBackstage.editor.refreshAll(parentNode);
							window.wpBackstage.codeEditor.refreshAll(parentNode);
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
	 * @since   1.1.0
	 * @return  void  
	 */
	public function inline_widget_customizer_script() { ?>

		<script 
		id="wp_backstage_widget_customizer_script"
		type="text/javascript">

			(function($) {

				var widgetHandleTimer = null;
				var sectionExpandTimer = null;

				function handleWidgetHandleClick(e = null) {
					console.log(e);
					var { parentNode } = e.target;
					if (widgetHandleTimer) {
						clearTimeout(widgetHandleTimer);
					}
					while (! parentNode.classList.contains('widget')) {
						parentNode = parentNode.parentNode;
					}
					widgetHandleTimer = setTimeout(function() {
						if (parentNode.classList.contains('open')) {
							initOrRefreshAll(parentNode);
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

				function handleSectionExpanded(section = null) {
					initAllWidgetHandles(section.contentContainer[0]);
				}

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

				function init() {
					wp.customize.bind( 'ready', function() {
						wp.customize.section.each( function (section) { 
							if (section.id.startsWith('sidebar-widgets')) {
								section.expanded.bind( function(isExpanding) {
									if (isExpanding) {
										handleSectionExpanded(section);
									}
								});
							}
						});
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
	 * @since   1.1.0
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
