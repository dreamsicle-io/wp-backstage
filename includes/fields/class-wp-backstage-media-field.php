<?php
/**
 * WP Backstage Media Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Media Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Media_Field extends WP_Backstage_Field {

	/**
	 * Default Args
	 *
	 * @since  0.0.1
	 * @var    array  $default_args  An array of default media field arguments.
	 */
	protected array $default_args = array(
		'type'     => '',
		'multiple' => false,
		'attach'   => false,
	);

	/**
	 * Schema
	 *
	 * @since 4.0.0
	 * @var array $schema The REST API schema definition.
	 */
	protected array $schema = array(
		'type'  => 'array',
		'items' => array(
			'type' => 'integer',
		),
	);

	/**
	 * Init
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function init(): void {
		add_action( 'wp_ajax_wp_backstage_render_media', array( $this, 'ajax_render_media' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_media_mixin_overrides_script' ), 20 );

		parent::init();
	}

	/**
	 * Add REST API Link
	 *
	 * @since 3.4.0
	 * @param WP_REST_Response $response The response object to manipulate.
	 * @param array            $field An array of field arguments.
	 * @param mixed            $value The field's value.
	 * @return WP_REST_Response The augmented response object.
	 */
	public function add_rest_api_link( WP_REST_Response $response, array $field = array(), $value = null ): WP_REST_Response {
		$attachment_ids = is_array( $value ) ? array_map( 'absint', $value ) : array();
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id > 0 ) {
				$post_type_obj = get_post_type_object( 'attachment' );
				$response->add_link(
					$this->get_rest_api_link_key( $field ),
					rest_url(
						sprintf(
							'/%1$s/%2$s/%3$d',
							$post_type_obj->rest_namespace,
							$post_type_obj->rest_base,
							$attachment_id
						)
					),
					array(
						'embeddable' => true,
					)
				);
			}
		}
		return $response;
	}

	/**
	 * Ajax Render Media
	 *
	 * This method is responsible for providing the ajax response for the media uploader
	 * preview.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public function ajax_render_media() {

		// phpcs:ignore WordPress.Security.NonceVerification
		$posted_values = wp_unslash( $_POST );

		$attachment_ids = ( isset( $posted_values['attachment_ids'] ) && is_array( $posted_values['attachment_ids'] ) ) ? $posted_values['attachment_ids'] : array();
		$is_multiple    = ( isset( $posted_values['attachment_ids'] ) && ( $posted_values['is_multiple'] === 'true' ) );

		foreach ( $attachment_ids as $attachment_id ) {
			$this->render_media_item( $attachment_id, $is_multiple );
		}

		wp_die();
	}

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
	 */
	protected function render_media_item( $attachment_id = 0, $is_multiple = false ) {

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
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_media_mixin_overrides_script() { ?>

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
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The unsantized value.
	 * @return array The santizied value.
	 */
	public function sanitize( array $field = array(), $value = null ) {
		if ( is_string( $value ) && ! empty( $value ) ) {
			$value = explode( ',', $value );
		}
		return is_array( $value ) ? array_map( 'absint', $value ) : array();
	}

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {
		$thumbnail_size  = 20;
		$thumbnail_style = 'height:' . $thumbnail_size . 'px;width:auto;display:inline-block;border:1px solid #e1e1e1;';
		foreach ( $value as $attachment_id ) {
			echo wp_get_attachment_image(
				absint( $attachment_id ),
				'thumbnail',
				true,
				array(
					'style' => $thumbnail_style,
					'title' => get_the_title( $attachment_id ),
				)
			);
		}
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_media_field_style">

			.wp-backstage-media-uploader {
				display: block;
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
				width: 115px;
				height: 115px;
				margin: 0 12px 12px 0;
				float: left;
				color: #3c434a;
				background: #f0f0f1;
				font-size: 12px;
				box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.10), inset 0 0 0 1px rgba(0, 0, 0, 0.5);
				cursor: move;
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
	 * Inline Script
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_script(): void { ?>

		<script id="wp_backstage_media_field_script">

			(function($) {

				function renderMedia(uploader = null, attachmentIDs = []) {
					const isMultiple = uploader.wpBackstage.isMultiple;
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
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('wp-backstage-field--type-media')) {
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
					const isMultiple = uploader.wpBackstage.isMultiple;
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
					const isMultiple = uploader.wpBackstage.isMultiple;
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
					const isMultiple = uploader.wpBackstage.isMultiple;
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
					const isMultiple = uploader.wpBackstage.isMultiple;
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
					addButton.removeEventListener('click', handleAddButtonClick);
					addToButton.removeEventListener('click', handleAddToButtonClick);
					replaceButton.removeEventListener('click', handleReplaceButtonClick);
					removeButton.removeEventListener('click', handleRemoveButtonClick);
					tryAgainButton.removeEventListener('click', handleTryAgainButtonClick);
					hideLoader(uploader);
					hideError(uploader);
					showButtons(uploader);
					removeClones(uploader);
					delete uploader.wpBackstage;
				}

				function destroyAll(container = document) {
					const uploaders = container.querySelectorAll('.wp-backstage-field--type-media');
					uploaders.forEach(function(uploader) {
						destroy(uploader);
					});
				}

				function initPreview(uploader = null) {
					const isMultiple = uploader.wpBackstage.isMultiple;
					const attachmentIDs = getInputValue(uploader);
					if (attachmentIDs.length > 0) {
						appendClones(uploader, attachmentIDs);
					}
					if (isMultiple) {
						initSortable(uploader);
					}
				}

				function init(uploader = null) {
					const fieldId = uploader.getAttribute('data-field-id');
					const input = uploader.querySelector('#' + fieldId);
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
					uploader.wpBackstage = {
						isMultiple: isMultiple,
						modal: modal,
						ui: {
							input: input,
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

					initLabels(uploader);
				}

				function initLabels(uploader = null) {
					const fieldId = uploader.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.addEventListener('click', handleLabelClick);
					});
				}

				function destroyLabels(uploader = null) {
					const fieldId = uploader.getAttribute('data-field-id');
					const labels = document.querySelectorAll('label[for="' + fieldId + '"]');
					labels.forEach(function(label) {
						label.removeEventListener('click', handleLabelClick);
					});
				}

				function handleLabelClick(e = null) {
					e.preventDefault();
					const fieldId = e.target.getAttribute('for');
					const uploader = getUploaderById(fieldId);
					focus(uploader);
				}

				function focus(uploader = null) {
					const addButton = uploader.wpBackstage.ui.addButton;
					const addToButton = uploader.wpBackstage.ui.addToButton;
					const replaceButton = uploader.wpBackstage.ui.replaceButton;
					if (addButton && ! addButton.disabled) {
						addButton.focus();
					} else if (addToButton && ! addToButton.disabled) {
						addToButton.focus();
					} else if (replaceButton && ! replaceButton.disabled) {
						replaceButton.focus();
					}
				}

				function getUploaderById(fieldId = '') {
					return document.querySelector('.wp-backstage-field--type-media[data-field-id="' + fieldId + '"]');
				}

				function initAll(container = document) {
					const uploaders = container.querySelectorAll('.wp-backstage-field--type-media');
					uploaders.forEach(function(uploader) {
						init(uploader);
					});
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
					removeClones(uploader);
					if (uploader.wpBackstage.modal.state()) {
						uploader.wpBackstage.modal.state().reset();
					}
				}

				function resetAll(container = document) {
					const uploaders = container.querySelectorAll('.wp-backstage-field--type-media');
					uploaders.forEach(function(uploader) {
						reset(uploader);
					});
				}

				window.wpBackstage.fields.mediaUploader = {
					initAll: initAll,
					init: init,
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

		$args = $this->get_args( $field );

		// Prepare uploader labels.
		$single_modal_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Set %1$s', 'media field - modal single button', 'wp_backstage' ),
			$field['label']
		);
		$multiple_modal_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Add to %1$s', 'media field - modal multiple button', 'wp_backstage' ),
			$field['label']
		);
		$add_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Add %1$s', 'media field - add button', 'wp_backstage' ),
			$field['label']
		);
		$add_to_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Add to %1$s', 'media field - add to button', 'wp_backstage' ),
			$field['label']
		);
		$replace_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Replace %1$s', 'media field - replace button', 'wp_backstage' ),
			$field['label']
		);
		$remove_button_text = sprintf(
			/* translators: 1: field label */
			_x( 'Remove %1$s', 'media field - remove button', 'wp_backstage' ),
			$field['label']
		);
		$loader_text           = _x( 'Loading preview...', 'media field - loader', 'wp_backstage' );
		$error_text            = _x( 'There was an error rendering the preview.', 'media field - error', 'wp_backstage' );
		$try_again_button_text = _x( 'Try again', 'media field - try again button', 'wp_backstage' ) ?>

		<span 
		class="<?php $this->root_class( $field, array( 'wp-backstage-media-uploader' ) ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>"
		data-media-uploader-multiple="<?php echo $args['multiple'] ? 'true' : 'false'; ?>"
		data-media-uploader-type="<?php echo esc_attr( $args['type'] ); ?>"
		data-media-uploader-title="<?php echo esc_attr( $field['label'] ); ?>"
		data-media-uploader-button="<?php echo esc_attr( $args['multiple'] ? $multiple_modal_button_text : $single_modal_button_text ); ?>">

			<input 
			type="text" 
			id="<?php $this->element_id( $field ); ?>" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			value="<?php echo is_array( $field['value'] ) ? esc_attr( implode( ',', $field['value'] ) ) : esc_attr( $field['value'] ); ?>"
			style="display:none;"
			<?php $this->input_attrs( $field, array( 'type', 'id', 'name', 'value', 'style' ) ); ?> />

			<span 
			class="wp-backstage-media-uploader__preview"
			id="<?php $this->element_id( $field, 'preview' ); ?>">

				<span 
				id="<?php $this->element_id( $field, 'error' ); ?>"
				class="wp-backstage-media-uploader__error notice inline notice-error">
					<span><?php echo esc_html( $error_text ); ?></span>
					<button 
					type="button"
					id="<?php $this->element_id( $field, 'button_try_again' ); ?>" 
					class="wp-backstage-media-uploader__try-again button-link"><?php
						echo esc_html( $try_again_button_text );
					?></button>
				</span>

				<span 
				class="wp-backstage-media-uploader__preview-list"
				id="<?php $this->element_id( $field, 'preview_list' ); ?>">

				</span>
			</span>

			<span
			class="wp-backstage-media-uploader__buttons" 
			id="<?php $this->element_id( $field, 'buttons' ); ?>">

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--add button" 
				id="<?php $this->element_id( $field, 'button_add' ); ?>"
				type="button"
				style="vertical-align:middle;"><?php
					echo esc_html( $add_button_text );
				?></button>

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--add-to button" 
				id="<?php $this->element_id( $field, 'button_add_to' ); ?>"
				type="button"
				disabled
				style="vertical-align:middle;display:none;"><?php
					echo esc_html( $add_to_button_text );
				?></button>

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--replace button" 
				id="<?php $this->element_id( $field, 'button_replace' ); ?>"
				type="button"
				disabled
				style="vertical-align:middle;display:none;"><?php
					echo esc_html( $replace_button_text );
				?></button>

				<button 
				class="wp-backstage-media-uploader__button wp-backstage-media-uploader__button--remove button-link" 
				id="<?php $this->element_id( $field, 'button_remove' ); ?>"
				type="button" 
				disabled
				style="vertical-align:middle;display:none;"><?php
					echo esc_html( $remove_button_text );
				?></button>

			</span>

			<span 
			id="<?php $this->element_id( $field, 'loader' ); ?>"
			class="wp-backstage-media-uploader__loader">
				<img 
				src="/wp-admin/images/spinner.gif" 
				alt="<?php echo esc_attr( $loader_text ); ?>" />
				&nbsp;
				<span><?php echo esc_html( $loader_text ); ?></span>
			</span>

		</span>

	<?php }
}
