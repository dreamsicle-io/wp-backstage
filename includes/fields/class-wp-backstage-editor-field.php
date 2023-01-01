<?php
/**
 * WP Backstage Editor Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Editor Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Editor_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'textarea_control',
	);

	/**
	 * Default Args
	 *
	 * @since 4.0.0
	 * @var array $default_args The default field-type-specific args.
	 */
	protected array $default_args = array(
		'format_select' => false,
		'media_buttons' => false,
		'kitchen_sink'  => false,
	);

	/**
	 * Init
	 *
	 * @see https://github.com/WordPress/WordPress/blob/master/wp-includes/default-filters.php WordPress Default Filters
	 * @see https://developer.wordpress.org/reference/hooks/the_content/ Filter: the_content
	 * @see https://developer.wordpress.org/reference/hooks/widget_text_content/ Filter: widget_text_content
	 * @see https://developer.wordpress.org/reference/functions/wptexturize/ wptexturize()
	 * @see https://developer.wordpress.org/reference/functions/wpautop/ wpautop()
	 * @see https://developer.wordpress.org/reference/functions/shortcode_unautop/ shortcode_unautop()
	 * @see https://developer.wordpress.org/reference/functions/wp_replace_insecure_home_url/ wp_replace_insecure_home_url()
	 * @see https://developer.wordpress.org/reference/functions/do_shortcode/ do_shortcode()
	 * @see https://developer.wordpress.org/reference/functions/convert_smilies/ convert_smilies()
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function init(): void {
		add_filter( 'wp_backstage_editor_field_render_column', 'wptexturize', 10 );
		add_filter( 'wp_backstage_editor_field_render_column', 'wpautop', 10 );
		add_filter( 'wp_backstage_editor_field_render_column', 'shortcode_unautop', 10 );
		add_filter( 'wp_backstage_editor_field_render_column', 'wp_filter_content_tags', 10 );
		add_filter( 'wp_backstage_editor_field_render_column', 'wp_replace_insecure_home_url', 10 );
		add_filter( 'wp_backstage_editor_field_render_column', 'do_shortcode', 11 );
		add_filter( 'wp_backstage_editor_field_render_column', 'convert_smilies', 20 );

		parent::init();
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		return wp_kses_post( $value );
	}

	/**
	 * Inline Style
	 *
	 * @since   4.0.0
	 * @return  void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_editor_field_style">

			.wp-backstage-field--type-editor {
				display: block;
			}

			.wp-backstage-field--type-editor .mce-toolbar .mce-btn.mce-active, 
			.wp-backstage-field--type-editor .mce-toolbar .mce-btn.mce-active button, 
			.wp-backstage-field--type-editor .mce-toolbar .mce-btn.mce-active i, 
			.wp-backstage-field--type-editor .mce-toolbar .mce-btn.mce-active:hover button, 
			.wp-backstage-field--type-editor .mce-toolbar .mce-btn.mce-active:hover i {
				color: inherit;
			}

			.form-field .wp-backstage-field--type-editor .wp-editor-area {
				border-width: 0;
			}

			#addtag .wp-backstage-field--type-editor .wp-editor-wrap,
			#edittag .wp-backstage-field--type-editor .wp-editor-wrap {
				max-width: 95%;
			}

		</style>

	<?php }

	/**
	 * Inline Script
	 *
	 * @todo Make sure clicking on label focuses the editor.
	 *
	 * @link https://codex.wordpress.org/Javascript_Reference/wp.editor wp.editor
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link https://make.wordpress.org/core/2017/05/20/editor-api-changes-in-4-8/ WP Editor API Changes in 4.8
	 * @link https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link https://www.tiny.cloud/docs/demo/basic-example/ Tiny MCE Example
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_script(): void { ?>

		<script id="wp_backstage_editor_field_script">

			(function($) {

				var saveTimer = null;

				function findParentEditor(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('wp-backstage-field--type-editor')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function destroy(editor = null) {
					if (saveTimer) {
						clearTimeout(saveTimer);
					}
					const fieldId = editor.getAttribute('data-field-id');
					wp.editor.remove(fieldId);
					destroyLabels(editor);
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

				function getAll(container = document) {
					return container.querySelectorAll('.wp-backstage-field--type-editor');
				}

				function isInitialized(editor = null) {
					return Boolean(getTinyMCEInstance(editor));
				}

				function init(editor = null) {
					// the wp tinyMCE editor stays attached to the dom in cases like when the widgets
					// are updated. Therefore we first check if the editor must be destroyed here.
					if (isInitialized(editor)) {
						destroy(editor);
					}

					const fieldId = editor.getAttribute('data-field-id');
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

					wp.editor.initialize(fieldId, settings);

					initLabels(editor);
				}

				function initLabels(editor = null) {
					const fieldId = editor.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.addEventListener('click', handleLabelClick);
					});
				}

				function destroyLabels(editor = null) {
					const fieldId = editor.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.removeEventListener('click', handleLabelClick);
					});
				}

				function handleLabelClick(e = null) {
					e.preventDefault();
					const fieldId = e.target.getAttribute('for');
					const editor = getEditorById(fieldId);
					focus(editor);
				}

				function destroyAll(container = document) {
					const editors = getAll(container);
					editors.forEach(function(editor) {
						destroy(editor);
					});
				}

				function initAll(container = document) {
					const editors = getAll(container);
					editors.forEach(function(editor) {
						init(editor);
					});
				}

				function refresh(editor = null) {
					destroy(editor);
					init(editor);
				}

				function refreshAll(container = document) {
					destroyAll(container);
					initAll(container);
				}

				function getEditorById(fieldId = '') {
					return document.querySelector('.wp-backstage-field--type-editor[data-field-id="' + fieldId + '"]');
				}

				function getTextarea(editor = null) {
					const fieldId = editor.getAttribute('data-field-id');
					return editor.querySelector('#' + fieldId);
				}

				function getTinyMCEInstance(editor = null) {
					const fieldId = editor.getAttribute('data-field-id');
					return tinymce.get(fieldId);
				}

				function focus(editor = null) {
					const tinyMCEInst = getTinyMCEInstance(editor);
					tinyMCEInst.focus();
				}

				window.wpBackstage.fields.editor = {
					initAll: initAll,
					init: init,
					refreshAll: refreshAll,
					refresh: refresh,
				};

			})(jQuery);

		</script>

	<?php }

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {

		// Ensure the value is a string.
		$value = is_string( $value ) ? $value : '';

		/**
		 * Filters the value of the editor field in a similar way that
		 * `the_content` and `widget_text_content` filters do.
		 *
		 * @see https://github.com/WordPress/WordPress/blob/master/wp-includes/default-filters.php WordPress Default Filters
		 * @see https://developer.wordpress.org/reference/hooks/the_content/ Filter: the_content
		 * @see https://developer.wordpress.org/reference/hooks/widget_text_content/ Filter: widget_text_content
		 *
		 * @since 4.0.0
		 * @param string $value The raw value.
		 * @return string The filtered value.
		 */
		$value = apply_filters( 'wp_backstage_editor_field_render_column', $value );

		// Run thru the same kses as post content.
		echo wp_kses_post( $value );
	}

	/**
	 * Render
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void {

		$args = $this->get_args( $field ); ?>

		<span 
		class="<?php $this->root_class( $field ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>"
		data-media-buttons="<?php echo boolval( $args['media_buttons'] ) ? 'true' : 'false'; ?>"
		data-format-select="<?php echo boolval( $args['format_select'] ) ? 'true' : 'false'; ?>"
		data-kitchen-sink="<?php echo boolval( $args['kitchen_sink'] ) ? 'true' : 'false'; ?>">

			<textarea 
			class="wp-editor-area"
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			id="<?php $this->element_id( $field ); ?>" 
			<?php $this->input_attrs( $field, array( 'class', 'name', 'id' ) ); ?>><?php
				echo esc_textarea( $field['value'] );
			?></textarea>

		</span>

	<?php }

}
