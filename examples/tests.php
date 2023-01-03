<?php
/**
 * WP Backstage Tests
 *
 * @since       0.0.1
 * @since       3.0.0 linted and formatted with phpcs
 * @package     WPBackstage
 * @subpackage  Examples
 */

 // phpcs:disable WordPress.WP.I18n.TextDomainMismatch

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Get Test Fields
 *
 * @since 4.0.0
 * @param array  $types The types of fields find, leave empty for all types.
 * @param string $name_suffix A suffix to append to each field name.
 * @return array An array of field argument arrays.
 */
function wp_backstage_get_test_fields( array $types = array(), string $name_suffix = '' ): array {
	$fields = array(
		array(
			'type'         => 'text',
			'name'         => 'wp_backstage_text_field',
			'label'        => __( 'Text', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'PEenter some text.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Text field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'url',
			'name'         => 'wp_backstage_url_field',
			'label'        => __( 'URL', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter a valid URL.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the URL field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'email',
			'name'         => 'wp_backstage_email_field',
			'label'        => __( 'Email', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter a valid Email.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Email field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'tel',
			'name'         => 'wp_backstage_phone_field',
			'label'        => __( 'Phone', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter a phone number.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Phone field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'password',
			'name'         => 'wp_backstage_password_field',
			'label'        => __( 'Password', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some text.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Password field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'number',
			'name'         => 'wp_backstage_number_field',
			'label'        => __( 'Number', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter a number from 0-100.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Number field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
			'input_attrs'  => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		array(
			'type'         => 'range',
			'name'         => 'wp_backstage_range_field',
			'label'        => __( 'Range', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select a number from 1-10.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Range field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
			'input_attrs'  => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 1,
			),
		),
		array(
			'type'         => 'checkbox',
			'name'         => 'wp_backstage_checkbox_field',
			'label'        => __( 'Checkbox', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Toggle the checkbox.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Checkbox field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'textarea',
			'name'         => 'wp_backstage_textarea_field',
			'label'        => __( 'Textarea', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter no more than 240 characters.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Textarea field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'input_attrs'  => array(
				'maxlength' => 240,
			),
		),
		array(
			'type'          => 'select',
			'name'          => 'wp_backstage_select_field',
			'label'         => __( 'Select', 'wp_backstage_examples' ),
			'description'   => wp_backstage_get_test_description( __( 'Select an option.', 'wp_backstage_examples' ) ),
			'help'          => wp_backstage_get_test_description( __( 'This is the help description for the Select field.', 'wp_backstage_examples' ) ),
			'has_column'    => true,
			'is_sortable'   => true,
			'is_filterable' => true,
			'show_in_rest'  => true,
			'options'       => array(
				array(
					'value' => '',
					'label' => __( '― Select an Option ―', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_1',
					'label' => __( 'Option 1', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_2',
					'label' => __( 'Option 2', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_3',
					'label' => __( 'Option 3', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_4',
					'label' => __( 'Option 4', 'wp_backstage_examples' ),
				),
			),
		),
		array(
			'type'          => 'radio',
			'name'          => 'wp_backstage_radio_field',
			'label'         => __( 'Radio', 'wp_backstage_examples' ),
			'description'   => wp_backstage_get_test_description( __( 'Select an option.', 'wp_backstage_examples' ) ),
			'help'          => wp_backstage_get_test_description( __( 'This is the help description for the Radio field.', 'wp_backstage_examples' ) ),
			'has_column'    => true,
			'is_sortable'   => true,
			'is_filterable' => true,
			'show_in_rest'  => true,
			'options'       => array(
				array(
					'value' => 'option_1',
					'label' => __( 'Option 1', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_2',
					'label' => __( 'Option 2', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_3',
					'label' => __( 'Option 3', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_4',
					'label' => __( 'Option 4', 'wp_backstage_examples' ),
				),
			),
		),
		array(
			'type'         => 'checkbox_set',
			'name'         => 'wp_backstage_checkbox_set_field',
			'label'        => __( 'Checkbox Set', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select all that apply.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Checkbox Set field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'options'      => array(
				array(
					'value' => 'option_1',
					'label' => __( 'Option 1', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_2',
					'label' => __( 'Option 2', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_3',
					'label' => __( 'Option 3', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_4',
					'label' => __( 'Option 4', 'wp_backstage_examples' ),
				),
			),
		),
		array(
			'type'         => 'media',
			'name'         => 'wp_backstage_media_field',
			'label'        => __( 'Any Media', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select or upload any kind of media.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Any Media field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'attach' => true,
			),
		),
		array(
			'type'         => 'media',
			'name'         => 'wp_backstage_image_field',
			'label'        => __( 'Image', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select or upload an image.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Image field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'type'   => 'image',
				'attach' => true,
			),
		),
		array(
			'type'         => 'media',
			'name'         => 'wp_backstage_gallery_field',
			'label'        => __( 'Gallery', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select or upload multiple images.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Gallery field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'type'     => 'image',
				'multiple' => true,
				'attach'   => true,
			),
		),
		array(
			'type'         => 'media',
			'name'         => 'wp_backstage_video_field',
			'label'        => __( 'Video', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select or upload a video.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Video field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'type'   => 'video',
				'attach' => true,
			),
		),
		array(
			'type'         => 'media',
			'name'         => 'wp_backstage_audio_field',
			'label'        => __( 'Audio', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select or upload audio.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Audio field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'type'   => 'audio',
				'attach' => true,
			),
		),
		array(
			'type'         => 'media',
			'name'         => 'wp_backstage_application_field',
			'label'        => __( 'Documents', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select or upload documents.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Documents field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'multiple' => true,
				'type'     => 'application',
				'attach'   => true,
			),
		),
		array(
			'type'         => 'date',
			'name'         => 'wp_backstage_datepicker_field',
			'label'        => __( 'Date', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select a date.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Date field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'time',
			'name'         => 'wp_backstage_time_field',
			'label'        => __( 'Time', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Set a time.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Time field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'is_sortable'  => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'color',
			'name'         => 'wp_backstage_color_field',
			'label'        => __( 'Color', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select a color.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Color field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'palettes' => true,
			),
		),
		array(
			'type'         => 'color',
			'name'         => 'wp_backstage_color_palette_field',
			'label'        => __( 'Color with Custom Palettes', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select a color.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Color with Custom Palettes field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'palettes' => array( '#ffffff', '#000000', '#67b0ff', '#ff9900' ),
			),
		),
		array(
			'type'         => 'color',
			'name'         => 'wp_backstage_color_nopalettes_field',
			'label'        => __( 'Color with No Palettes', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select a color.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Color with No Palettes field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'palettes' => false,
			),
		),
		array(
			'type'         => 'color',
			'name'         => 'wp_backstage_color_hsl_field',
			'label'        => __( 'Color with HSL Mode', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Select a color.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Color with HSL Mode field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'mode' => 'hsl',
			),
		),
		array(
			'type'         => 'code',
			'name'         => 'wp_backstage_php_field',
			'label'        => __( 'Code (PHP)', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some code.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Code (PHP) field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'language' => 'php',
			),
		),
		array(
			'type'         => 'code',
			'name'         => 'wp_backstage_html_field',
			'label'        => __( 'Code (HTML)', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some code.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Code (HTML) field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'code',
			'name'         => 'wp_backstage_css_field',
			'label'        => __( 'Code (CSS)', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some code.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Code (CSS) field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'language' => 'css',
			),
		),
		array(
			'type'         => 'code',
			'name'         => 'wp_backstage_js_field',
			'label'        => __( 'Code (JavaScript)', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some code.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Code (JavaScript) field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'language' => 'javascript',
			),
		),
		array(
			'type'         => 'code',
			'name'         => 'wp_backstage_json_field',
			'label'        => __( 'Code (JSON)', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some code.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Code (JSON) field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'language' => 'json',
			),
		),
		array(
			'type'         => 'editor',
			'name'         => 'wp_backstage_editor_field',
			'label'        => __( 'Editor', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some content.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Editor field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
		),
		array(
			'type'         => 'editor',
			'name'         => 'wp_backstage_editor_field_format_select',
			'label'        => __( 'Editor with Format Select', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some content.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Editor with Format Select field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'format_select' => true,
			),
		),
		array(
			'type'         => 'editor',
			'name'         => 'wp_backstage_editor_field_media',
			'label'        => __( 'Editor with Media Buttons', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some content.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Editor with Media Buttons field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'media_buttons' => true,
				'format_select' => true,
			),
		),
		array(
			'type'         => 'editor',
			'name'         => 'wp_backstage_editor_field_kitchen_sink',
			'label'        => __( 'Editor with Kitchen Sink', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter some content.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Editor with Kitchen Sink field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
			'args'         => array(
				'media_buttons' => true,
				'format_select' => true,
				'kitchen_sink'  => true,
			),
		),
		array(
			'type'         => 'address',
			'name'         => 'wp_backstage_address_field',
			'label'        => __( 'Address', 'wp_backstage_examples' ),
			'description'  => wp_backstage_get_test_description( __( 'Enter an address.', 'wp_backstage_examples' ) ),
			'help'         => wp_backstage_get_test_description( __( 'This is the help description for the Address field.', 'wp_backstage_examples' ) ),
			'has_column'   => true,
			'show_in_rest' => true,
		),
		array(
			'type'          => 'select_posts',
			'name'          => 'wp_backstage_select_page_field',
			'label'         => __( 'Page', 'wp_backstage_examples' ),
			'description'   => wp_backstage_get_test_description( __( 'Select a page.', 'wp_backstage_examples' ) ),
			'help'          => wp_backstage_get_test_description( __( 'This is the help description for the Page field.', 'wp_backstage_examples' ) ),
			'has_column'    => true,
			'is_filterable' => true,
			'show_in_rest'  => true,
			'args'          => array(
				'option_none_label' => __( 'Select a page', 'wp_backstage_examples' ),
				'query'             => array(
					'post_type' => 'page',
					'orderby'   => 'title',
					'order'     => 'ASC',
				),
			),
		),
		array(
			'type'          => 'select_posts',
			'name'          => 'wp_backstage_select_post_field',
			'label'         => __( 'Post', 'wp_backstage_examples' ),
			'description'   => wp_backstage_get_test_description( __( 'Select a post.', 'wp_backstage_examples' ) ),
			'help'          => wp_backstage_get_test_description( __( 'This is the help description for the Post field.', 'wp_backstage_examples' ) ),
			'has_column'    => true,
			'is_filterable' => true,
			'show_in_rest'  => true,
			'args'          => array(
				'option_none_label' => __( 'Select a post', 'wp_backstage_examples' ),
				'query'             => array(
					'post_type' => 'post',
					'orderby'   => 'date',
					'order'     => 'DESC',
				),
			),
		),
		array(
			'type'          => 'select_users',
			'name'          => 'wp_backstage_select_user_field',
			'label'         => __( 'User', 'wp_backstage_examples' ),
			'description'   => wp_backstage_get_test_description( __( 'Select a user.', 'wp_backstage_examples' ) ),
			'help'          => wp_backstage_get_test_description( __( 'This is the help description for the User field.', 'wp_backstage_examples' ) ),
			'has_column'    => true,
			'is_filterable' => true,
			'show_in_rest'  => true,
			'args'          => array(
				'option_none_label' => __( 'Select a user', 'wp_backstage_examples' ),
				'query'             => array(
					'post_type' => 'post',
					'orderby'   => 'date',
					'order'     => 'DESC',
				),
			),
		),
	);

	if ( ! empty( $types ) ) {
		$fields = array_filter(
			$fields,
			function( array $field = array() ) use ( $types ) {
				return in_array( $field['type'], $types );
			}
		);
	}

	if ( ! empty( $name_suffix ) ) {
		$fields = array_map(
			function( array $field = array() ) use ( $name_suffix ) {
				$field['name'] = sprintf( '%1$s_%2$s', $field['name'], $name_suffix );
				return $field;
			},
			$fields
		);
	}

	return $fields;
}

/**
 * WP Backstage Get Test Description
 *
 * @since 4.0.0
 * @param string $text Text to prepend to the test description.
 * @return string A text description.
 */
function wp_backstage_get_test_description( $text = '' ) {
	return sprintf(
		'%1$s%2$s',
		! empty( $text ) ? "{$text} " : '',
		__( 'Descriptions support some HTML markup like <strong>bold</strong>, <em>italic</em>, <sub>sub</sub>, <sup>sup</sup>, <u>underlines</u>, <strike>strikes</strike>, <code>code</code>, <a href="#">links</a>, and <span style="font-weight:bold;font-family:serif;color:orange;">more</span>.', 'wp_backstage_examples' )
	);
}

/**
 * WP Backstage Get Test Field Groups
 *
 * @since 4.0.0
 * @param string $field_name_suffix A suffix to append to each field name.
 * @return array An array of meta box argument arrays.
 */
function wp_backstage_get_test_field_groups( string $field_name_suffix = '' ): array {
	$field_groups = array(
		array(
			'id'          => 'wp_backstage_general_fields',
			'title'       => __( 'General Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test general controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the General Fields.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'text', 'url', 'email', 'tel', 'password', 'checkbox', 'textarea' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_numeric_fields',
			'title'       => __( 'Numeric Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test numeric controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Numeric Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'number', 'range' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_numeric_fields',
			'title'       => __( 'Numeric Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test numeric controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Numeric Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'number', 'range' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_selectable_fields',
			'title'       => __( 'Selectable Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test selectable controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Selectable Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'select', 'radio', 'checkbox_set' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_datetime_fields',
			'title'       => __( 'Date/Time Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test date/time controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Date/Time Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'date', 'time' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_color_fields',
			'title'       => __( 'Color Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test color controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Color Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'color' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_lookup_fields',
			'title'       => __( 'Lookup Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test lookup controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Lookup Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'select_posts', 'select_users' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_media_fields',
			'title'       => __( 'Media Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test media controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Media Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'media' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_editor_fields',
			'title'       => __( 'Editor Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test editor controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Editor Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'editor' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_code_fields',
			'title'       => __( 'Code Fields', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'These fields test code controls.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Editor Fields field group.', 'wp_backstage_examples' ) ),
			'fields'      => wp_backstage_get_test_fields( array( 'code' ), $field_name_suffix ),
		),
		array(
			'id'          => 'wp_backstage_empty',
			'title'       => __( 'Empty', 'wp_backstage_examples' ),
			'description' => wp_backstage_get_test_description( __( 'This tests an empty field group.', 'wp_backstage_examples' ) ),
			'help'        => wp_backstage_get_test_description( __( 'This is the help description for the Empty field group.', 'wp_backstage_examples' ) ),
		),
	);

	return $field_groups;
}

/**
 * WP Backstage Init Tests
 *
 * Initialize tests for all objects and field types.
 * This also serves as a working example.
 *
 * @since   0.0.1
 * @since   2.0.0  Added ability to turn tests on and off using `theme_support`.
 * @return  void
 */
function wp_backstage_init_tests(): void {

	WP_Backstage_Post_Type::add(
		'wp_backstage_page',
		array(
			'menu_name'       => __( 'Test Pages', 'wp_backstage_examples' ),
			'singular_name'   => __( 'Test Page', 'wp_backstage_examples' ),
			'plural_name'     => __( 'Test Pages', 'wp_backstage_examples' ),
			'description'     => __( 'This is a test hierarchical post type.', 'wp_backstage_examples' ),
			'singular_base'   => 'test-page',
			'archive_base'    => 'test-pages',
			'rest_base'       => 'test-pages',
			'hierarchical'    => true,
			'glance_item'     => true,
			'capability_type' => 'page',
			'meta_boxes'      => wp_backstage_get_test_field_groups(),
		)
	);

	WP_Backstage_Post_Type::add(
		'wp_backstage_post',
		array(
			'menu_name'       => __( 'Test Posts', 'wp_backstage_examples' ),
			'singular_name'   => __( 'Test Post', 'wp_backstage_examples' ),
			'plural_name'     => __( 'Test Posts', 'wp_backstage_examples' ),
			'description'     => __( 'This is a test non-hierarchical post type.', 'wp_backstage_examples' ),
			'singular_base'   => 'test-post',
			'archive_base'    => 'test-posts',
			'rest_base'       => 'test-posts',
			'taxonomies'      => array( 'category', 'post_tag' ),
			'glance_item'     => true,
			'capability_type' => 'post',
			'meta_boxes'      => wp_backstage_get_test_field_groups(),
		)
	);

	WP_Backstage_Post_Type::add(
		'wp_backstage_blank',
		array(
			'menu_name'       => __( 'Blank Posts', 'wp_backstage_examples' ),
			'singular_name'   => __( 'Blank Post', 'wp_backstage_examples' ),
			'plural_name'     => __( 'Blank Posts', 'wp_backstage_examples' ),
			'description'     => __( 'This is a post type with minimal core support.', 'wp_backstage_examples' ),
			'singular_base'   => 'blank-post',
			'archive_base'    => 'blank-posts',
			'rest_base'       => 'blank-posts',
			'hierarchical'    => false,
			'glance_item'     => true,
			'capability_type' => 'post',
			'supports'        => array(
				'title',
				'custom-fields',
			),
			'meta_boxes'      => wp_backstage_get_test_field_groups(),
		),
	);

	WP_Backstage_Post_Type::modify(
		'post',
		array(
			'meta_boxes' => wp_backstage_get_test_field_groups(),
		)
	);

	WP_Backstage_Post_Type::modify(
		'page',
		array(
			'meta_boxes' => wp_backstage_get_test_field_groups(),
		)
	);

	WP_Backstage_Post_Type::modify(
		'attachment',
		array(
			'meta_boxes' => wp_backstage_get_test_field_groups(),
		)
	);

	WP_Backstage_Taxonomy::add(
		'wp_backstage_cat',
		array(
			'singular_name' => __( 'Test Category', 'wp_backstage_examples' ),
			'plural_name'   => __( 'Test Categories', 'wp_backstage_examples' ),
			'description'   => __( 'This is a test hierarchical taxonomy.', 'wp_backstage_examples' ),
			'public'        => true,
			'hierarchical'  => true,
			'with_front'    => false,
			'archive_base'  => 'test-category',
			'rest_base'     => 'test-categories',
			'post_types'    => array( 'wp_backstage_page', 'wp_backstage_post' ),
			'fields'        => wp_backstage_get_test_fields(),
		)
	);

	WP_Backstage_Taxonomy::add(
		'wp_backstage_tag',
		array(
			'singular_name' => __( 'Test Tag', 'wp_backstage_examples' ),
			'plural_name'   => __( 'Test Tags', 'wp_backstage_examples' ),
			'description'   => __( 'This is a test non-hierarchical taxonomy.', 'wp_backstage_examples' ),
			'public'        => true,
			'hierarchical'  => false,
			'with_front'    => false,
			'archive_base'  => 'test-tag',
			'rest_base'     => 'test-tags',
			'post_types'    => array( 'wp_backstage_page', 'wp_backstage_post' ),
			'fields'        => wp_backstage_get_test_fields(),
		)
	);

	WP_Backstage_Taxonomy::modify(
		'category',
		array(
			'fields' => wp_backstage_get_test_fields(),
		)
	);

	WP_Backstage_Taxonomy::modify(
		'post_tag',
		array(
			'fields' => wp_backstage_get_test_fields(),
		)
	);

	WP_Backstage_Nav_Menu_Item::modify(
		array(
			'fields' => wp_backstage_get_test_fields(),
		)
	);

	WP_Backstage_User::modify(
		array(
			'field_groups' => array(
				array(
					'id'          => 'wp_backstage_user_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the user.', 'wp_backstage_examples' ),
					'fields'      => wp_backstage_get_test_fields(),
				),
				array(
					'id'          => 'wp_backstage_user_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the user.', 'wp_backstage_examples' ),
				),
			),
		)
	);

	WP_Backstage_Options::add(
		'wp_backstage_options',
		array(
			'title'       => __( 'Test Options', 'wp_backstage_examples' ),
			'menu_title'  => __( 'Test Options', 'wp_backstage_examples' ),
			'description' => __( 'A test custom options page containing all field types.', 'wp_backstage_examples' ),
			'sections'    => wp_backstage_get_test_field_groups(),
		)
	);

	WP_Backstage_Options::add(
		'wp_backstage_theme_options',
		array(
			'type'         => 'theme',
			'title'        => __( 'Test Theme Options', 'wp_backstage_examples' ),
			'menu_title'   => __( 'Test Theme Options', 'wp_backstage_examples' ),
			'description'  => __( 'A test custom theme options page containing all field types.', 'wp_backstage_examples' ),
			'show_in_rest' => true,
			'sections'     => wp_backstage_get_test_field_groups( 'theme' ),
		)
	);

	WP_Backstage_Options::add(
		'wp_backstage_tool',
		array(
			'type'         => 'tools',
			'title'        => __( 'Test Tool', 'wp_backstage_examples' ),
			'menu_title'   => __( 'Test Tool', 'wp_backstage_examples' ),
			'description'  => __( 'A test custom tool options page containing all field types.', 'wp_backstage_examples' ),
			'show_in_rest' => true,
			'sections'     => wp_backstage_get_test_field_groups( 'tools' ),
		)
	);

	WP_Backstage_Widget::add(
		'wp_backstage_widget',
		array(
			'title'       => __( 'Test Widget', 'wp_backstage_examples' ),
			'description' => __( 'A test custom widget containing all field types.', 'wp_backstage_examples' ),
			'fields'      => wp_backstage_get_test_fields(),
		)
	);

}

add_action( 'wp_backstage_init', 'wp_backstage_init_tests', 10 );

/**
 * WP Backstage Test Widget
 *
 * @since 3.7.0
 * @param array $args The widget arguments.
 * @param array $instance The widget's saved instance settings.
 * @return void
 */
function wp_backstage_test_widget( array $args = array(), array $instance = array() ): void { ?>
	<textarea readonly rows="20" style="display:block;margin:0;white-space:pre;max-width:100%;max-height:400px;overflow:auto;font-size:10px;background-color:rgba(0, 0, 0, 0.05);padding:4px 8px;box-sizing:border-box;min-width:0;"><?php
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions
		print_r( $instance );
	?></textarea>
<?php }

add_action( 'wp_backstage_widget_output_wp_backstage_widget', 'wp_backstage_test_widget', 10, 2 );
