<?php
/**
 * WP Backstage Code Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Code Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Code_Field extends WP_Backstage_Field {

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
	 * @var array $default_args An array of default code field arguments.
	 */
	protected array $default_args = array(
		'language' => 'html',
	);

	/**
	 * Mime Types
	 *
	 * @since 4.0.0
	 * @var array $mime_types A map of language mime types.
	 */
	protected array $mime_types = array(
		'php'        => 'application/x-httpd-php',
		'html'       => 'text/html',
		'css'        => 'text/css',
		'javascript' => 'text/javascript',
		'json'       => 'application/json',
	);

	/**
	 * Init
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function init(): void {
		add_action( 'admin_print_scripts', array( $this, 'enqueue_settings' ), 20 );

		parent::init();
	}

	/**
	 * Enqueue Settings
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function enqueue_settings() {
		foreach ( $this->mime_types as $language => $mime_type ) {
			$settings = wp_enqueue_code_editor(
				array(
					'type'       => $mime_type,
					'codemirror' => array(
						'lineWrapping' => false,
					),
				)
			);
			if ( $settings ) {
				wp_add_inline_script(
					'code-editor',
					sprintf(
						'window.wpBackstage.codeSettings.%1$s = %2$s;',
						sanitize_key( $language ),
						wp_json_encode( $settings )
					)
				);
			}
		}
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return string The santizied value.
	 */
	public function sanitize( $value = null ) {
		return is_string( $value ) ? $value : '';
	}

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void { ?>
		<textrea readonly><?php echo esc_textarea( $value ); ?></textrea>
	<?php }

	/**
	 * Inline Code Editor Style
	 *
	 * @since   4.0.0
	 * @return  void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_code_field_style">

			.wp-backstage-field--type-code {
				display: block;
			}

			.wp-backstage-field--type-code .CodeMirror {
				border: 1px solid #dcdcde;
			}

			#addtag .wp-backstage-field--type-code .CodeMirror,
			#edittag .wp-backstage-field--type-code .CodeMirror {
				max-width: 95%;
			}

		</style>

	<?php }

	/**
	 * Inline Script
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_script(): void { ?>

		<script id="wp_backstage_code_field_script">

			(function($) {

				var saveTimer = null;

				function init(codeEditor = null) {
					const fieldId = codeEditor.getAttribute('data-field-id');
					const textarea = codeEditor.querySelector('#' + fieldId);
					const settingsKey = codeEditor.getAttribute('data-code-editor-language');
					const settings = window.wpBackstage.codeSettings[settingsKey];

					wp.codeEditor.initialize(fieldId, settings);

					const codeMirrorInst = getCodeMirrorInstance(codeEditor);

					codeMirrorInst.on('change', function(instance, changes) {
						if (saveTimer) {
							clearTimeout(saveTimer);
						}
						saveTimer = setTimeout(function() {
							instance.save();
							$(textarea).trigger('change');
						}, 500);
					});

					initLabels(codeEditor);
				}

				function getAll(container = document) {
					return container.querySelectorAll('.wp-backstage-field--type-code');
				}

				function initLabels(codeEditor = null) {
					const fieldId = codeEditor.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.addEventListener('click', handleLabelClick);
					});
				}

				function destroyLabels(codeEditor = null) {
					const fieldId = codeEditor.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.removeEventListener('click', handleLabelClick);
					});
				}

				function destroy(codeEditor = null) {
					const codeMirrorInst = getCodeMirrorInstance(codeEditor);
					codeMirrorInst.toTextArea();
					destroyLabels(codeEditor);
				}

				function destroyAll(container = document) {
					const codeEditors = getAll(container);
					codeEditors.forEach(function(codeEditor) {
						destroy(codeEditor);
					});
				}

				function handleLabelClick(e = null) {
					e.preventDefault();
					const fieldId = e.target.getAttribute('for');
					const codeEditor = getCodeEditorById(fieldId);
					focus(codeEditor);
				}

				function getCodeMirrorInstance(codeEditor = null) {
					const codeMirrorEl = codeEditor.querySelector('.CodeMirror');
					return codeMirrorEl.CodeMirror;
				}

				function refresh(codeEditor = null) {
					const codeMirrorInst = getCodeMirrorInstance(codeEditor);
					codeMirrorInst.refresh();
				}

				function initAll(container = document) {
					const codeEditors = getAll(container);
					codeEditors.forEach(function(codeEditor) {
						init(codeEditor);
					});
				}

				function refreshAll(container = document) {
					const codeEditors = getAll(container);
					codeEditors.forEach(function(codeEditor) {
						refresh(codeEditor);
					});
				}

				function reset(codeEditor = null) {
					const codeMirrorInst = getCodeMirrorInstance(codeEditor);
					const textarea = codeMirrorInst.getTextArea();
					codeMirrorInst.setValue(textarea.defaultValue);
					codeMirrorInst.clearHistory();
				}

				function resetAll(container = document) {
					const codeEditors = getAll(container);
					codeEditors.forEach(function(codeEditor) {
						reset(codeEditor);
					});
				}

				function focus(codeEditor = null) {
					const codeMirrorInst = getCodeMirrorInstance(codeEditor);
					codeMirrorInst.focus();
				} 

				function getCodeEditorById(fieldId = '') {
					return document.querySelector('.wp-backstage-field--type-code[data-field-id="' + fieldId + '"]');
				}

				window.wpBackstage.fields.codeEditor = {
					initAll: initAll,
					init: init,
					refreshAll: refreshAll,
					refresh: refresh,
					resetAll: resetAll,
					reset: reset,
				};

			})(jQuery);

		</script>

	<?php }

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
		data-code-editor-language="<?php echo esc_attr( $args['language'] ); ?>">

			<textarea 
			name="<?php echo esc_attr( $field['name'] ); ?>"
			id="<?php $this->element_id( $field ); ?>"
			class="code"
			<?php $this->input_attrs( $field, array( 'name', 'id', 'class' ) ); ?>><?php
				echo esc_textarea( $field['value'] );
			?></textarea>

		</span>

	<?php }

}
