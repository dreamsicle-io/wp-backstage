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
 * WP Backstage Init
 *
 * Initialize tests for all objects and field types. This also serves
 * as a working example. This function is run at the `after_setup_theme` hook.
 *
 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/ add_theme_support()
 * @link  https://developer.wordpress.org/reference/functions/get_theme_support/ get_theme_support()
 *
 * @since   0.0.1
 * @since   2.0.0  Added ability to turn tests on and off using `theme_support`.
 * @return  void
 */
function wp_backstage_init() {

	if ( ! get_theme_support( 'wp-backstage', 'tests-enabled' ) ) {
		return;
	}

	$all_fields = array(
		array(
			'type'        => 'text',
			'name'        => 'wp_backstage_text_field',
			'label'       => __( 'Text', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some text.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'is_sortable' => true,
		),
		array(
			'type'        => 'url',
			'name'        => 'wp_backstage_url_field',
			'label'       => __( 'URL', 'wp_backstage_examples' ),
			'description' => __( 'Please enter a valid URL.', 'wp_backstage_examples' ),
			'has_column'  => true,
		),
		array(
			'type'        => 'email',
			'name'        => 'wp_backstage_email_field',
			'label'       => __( 'Email', 'wp_backstage_examples' ),
			'description' => __( 'Please enter a valid Email.', 'wp_backstage_examples' ),
			'has_column'  => true,
		),
		array(
			'type'        => 'tel',
			'name'        => 'wp_backstage_phone_field',
			'label'       => __( 'Phone', 'wp_backstage_examples' ),
			'description' => __( 'Please enter a phone number.', 'wp_backstage_examples' ),
			'has_column'  => true,
		),
		array(
			'type'        => 'number',
			'name'        => 'wp_backstage_number_field',
			'label'       => __( 'Number', 'wp_backstage_examples' ),
			'description' => __( 'Please enter a number from 0-100.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'is_sortable' => true,
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		array(
			'type'        => 'checkbox',
			'name'        => 'wp_backstage_checkbox_field',
			'label'       => __( 'Checkbox', 'wp_backstage_examples' ),
			'description' => __( 'Toggle the checkbox.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'is_sortable' => true,
		),
		array(
			'type'        => 'textarea',
			'name'        => 'wp_backstage_textarea_field',
			'label'       => __( 'Textarea', 'wp_backstage_examples' ),
			'description' => __( 'Please enter no more than 240 characters.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'input_attrs' => array(
				'maxlength' => 240,
			),
		),
		array(
			'type'          => 'select',
			'name'          => 'wp_backstage_select_field',
			'label'         => __( 'Select', 'wp_backstage_examples' ),
			'description'   => __( 'Please select an option.', 'wp_backstage_examples' ),
			'has_column'    => true,
			'is_sortable'   => true,
			'is_filterable' => true,
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
					'value'    => 'option_3',
					'label'    => __( 'Option 3', 'wp_backstage_examples' ),
					'disabled' => true,
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
			'description'   => __( 'Please select an option.', 'wp_backstage_examples' ),
			'has_column'    => true,
			'is_sortable'   => true,
			'is_filterable' => true,
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
					'value'    => 'option_3',
					'label'    => __( 'Option 3', 'wp_backstage_examples' ),
					'disabled' => true,
				),
				array(
					'value' => 'option_4',
					'label' => __( 'Option 4', 'wp_backstage_examples' ),
				),
			),
		),
		array(
			'type'        => 'checkbox_set',
			'name'        => 'wp_backstage_checkbox_set_field',
			'label'       => __( 'Checkbox Set', 'wp_backstage_examples' ),
			'description' => __( 'Please select all that apply.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'options'     => array(
				array(
					'value' => 'option_1',
					'label' => __( 'Option 1', 'wp_backstage_examples' ),
				),
				array(
					'value' => 'option_2',
					'label' => __( 'Option 2', 'wp_backstage_examples' ),
				),
				array(
					'value'    => 'option_3',
					'label'    => __( 'Option 3', 'wp_backstage_examples' ),
					'disabled' => true,
				),
				array(
					'value' => 'option_4',
					'label' => __( 'Option 4', 'wp_backstage_examples' ),
				),
			),
		),
		array(
			'type'        => 'media',
			'name'        => 'wp_backstage_media_field',
			'label'       => __( 'Any Media', 'wp_backstage_examples' ),
			'description' => __( 'Please select or upload any kind of media.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'attach' => true,
			),
		),
		array(
			'type'        => 'media',
			'name'        => 'wp_backstage_image_field',
			'label'       => __( 'Image', 'wp_backstage_examples' ),
			'description' => __( 'Please select or upload an image.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'type'   => 'image',
				'attach' => true,
			),
		),
		array(
			'type'        => 'media',
			'name'        => 'wp_backstage_gallery_field',
			'label'       => __( 'Gallery', 'wp_backstage_examples' ),
			'description' => __( 'Please select or upload multiple images.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'type'     => 'image',
				'multiple' => true,
				'attach'   => true,
			),
		),
		array(
			'type'        => 'media',
			'name'        => 'wp_backstage_video_field',
			'label'       => __( 'Video', 'wp_backstage_examples' ),
			'description' => __( 'Please select or upload a video.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'type'   => 'video',
				'attach' => true,
			),
		),
		array(
			'type'        => 'media',
			'name'        => 'wp_backstage_audio_field',
			'label'       => __( 'Audio', 'wp_backstage_examples' ),
			'description' => __( 'Please select or upload audio.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'type'   => 'audio',
				'attach' => true,
			),
		),
		array(
			'type'        => 'media',
			'name'        => 'wp_backstage_application_field',
			'label'       => __( 'Documents', 'wp_backstage_examples' ),
			'description' => __( 'Please select or upload documents.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'multiple' => true,
				'type'     => 'application',
				'attach'   => true,
			),
		),
		array(
			'type'        => 'date',
			'name'        => 'wp_backstage_datepicker_field',
			'label'       => __( 'Date', 'wp_backstage_examples' ),
			'description' => __( 'Please select a date.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'is_sortable' => true,
			'args'        => array(
				'format' => 'yy-mm-dd',
			),
		),
		array(
			'type'        => 'time',
			'name'        => 'wp_backstage_time_field',
			'label'       => __( 'Time', 'wp_backstage_examples' ),
			'description' => __( 'Please set a time.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'is_sortable' => true,
		),
		array(
			'type'        => 'color',
			'name'        => 'wp_backstage_color_field',
			'label'       => __( 'Color', 'wp_backstage_examples' ),
			'description' => __( 'Please select a color.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'palettes' => true,
			),
		),
		array(
			'type'        => 'color',
			'name'        => 'wp_backstage_color_palette_field',
			'label'       => __( 'Color with Custom Palettes', 'wp_backstage_examples' ),
			'description' => __( 'Please select a color.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'palettes' => array( '#ffffff', '#000000', '#67b0ff', '#ff9900' ),
			),
		),
		array(
			'type'        => 'color',
			'name'        => 'wp_backstage_color_nopalettes_field',
			'label'       => __( 'Color with No Palletes', 'wp_backstage_examples' ),
			'description' => __( 'Please select a color.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'palettes' => false,
			),
		),
		array(
			'type'        => 'color',
			'name'        => 'wp_backstage_color_hsl_field',
			'label'       => __( 'Color with HSL mode', 'wp_backstage_examples' ),
			'description' => __( 'Please select a color.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'mode' => 'hsl',
			),
		),
		array(
			'type'        => 'code',
			'name'        => 'wp_backstage_html_field',
			'label'       => __( 'Code (HTML)', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some code.', 'wp_backstage_examples' ),
			'has_column'  => true,
		),
		array(
			'type'        => 'code',
			'name'        => 'wp_backstage_php_field',
			'label'       => __( 'Code (CSS)', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some code.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'mime' => 'text/css',
			),
		),
		array(
			'type'        => 'code',
			'name'        => 'wp_backstage_js_field',
			'label'       => __( 'Code (JavaScript)', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some code.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'mime' => 'text/javascript',
			),
		),
		array(
			'type'        => 'editor',
			'name'        => 'wp_backstage_editor_field',
			'label'       => __( 'Editor', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some content.', 'wp_backstage_examples' ),
			'has_column'  => true,
		),
		array(
			'type'        => 'editor',
			'name'        => 'wp_backstage_editor_field_format_select',
			'label'       => __( 'Editor with Format Select', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some content.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'format_select' => true,
			),
		),
		array(
			'type'        => 'editor',
			'name'        => 'wp_backstage_editor_field_media',
			'label'       => __( 'Editor with Media Buttons', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some content.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'media_buttons' => true,
				'format_select' => true,
			),
		),
		array(
			'type'        => 'editor',
			'name'        => 'wp_backstage_editor_field_kitchen_sink',
			'label'       => __( 'Editor with Kitchen Sink', 'wp_backstage_examples' ),
			'description' => __( 'Please enter some content.', 'wp_backstage_examples' ),
			'has_column'  => true,
			'args'        => array(
				'media_buttons' => true,
				'format_select' => true,
				'kitchen_sink'  => true,
			),
		),
		array(
			'type'        => 'address',
			'name'        => 'wp_backstage_address_field',
			'label'       => __( 'Address', 'wp_backstage_examples' ),
			'description' => __( 'Please enter an address.', 'wp_backstage_examples' ),
			'has_column'  => true,
		),
		array(
			'type'          => 'select_posts',
			'name'          => 'wp_backstage_select_page_field',
			'label'         => __( 'Page', 'wp_backstage_examples' ),
			'description'   => __( 'Please select a page.', 'wp_backstage_examples' ),
			'has_column'    => true,
			'is_filterable' => true,
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
			'description'   => __( 'Please select a post.', 'wp_backstage_examples' ),
			'has_column'    => true,
			'is_filterable' => true,
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
			'description'   => __( 'Please select a user.', 'wp_backstage_examples' ),
			'has_column'    => true,
			'is_filterable' => true,
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

	WP_Backstage_Post_Type::add(
		'wp_backstage_page',
		array(
			'menu_name'     => __( 'Test Pages', 'wp_backstage_examples' ),
			'singular_name' => __( 'Test Page', 'wp_backstage_examples' ),
			'plural_name'   => __( 'Test Pages', 'wp_backstage_examples' ),
			'description'   => __( 'This is a test hierarchical post type.', 'wp_backstage_examples' ),
			'singular_base' => 'test-page',
			'archive_base'  => 'test-pages',
			'rest_base'     => 'test-pages',
			'hierarchical'  => true,
			'glance_item'   => true,
			'meta_boxes'    => array(
				array(
					'id'          => 'wp_backstage_page_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the test page. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'normal',
					'priority'    => 'high',
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_page_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the test page. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'side',
					'priority'    => 'low',
					'hidden'      => true,
				),
			),
		)
	);

	WP_Backstage_Post_Type::add(
		'wp_backstage_post',
		array(
			'menu_name'     => __( 'Test Posts', 'wp_backstage_examples' ),
			'singular_name' => __( 'Test Post', 'wp_backstage_examples' ),
			'plural_name'   => __( 'Test Posts', 'wp_backstage_examples' ),
			'description'   => __( 'This is a test non-hierarchical post type.', 'wp_backstage_examples' ),
			'singular_base' => 'test-post',
			'archive_base'  => 'test-posts',
			'rest_base'     => 'test-posts',
			'taxonomies'    => array( 'category', 'post_tag' ),
			'glance_item'   => true,
			'meta_boxes'    => array(
				array(
					'id'          => 'wp_backstage_post_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the test post. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'normal',
					'priority'    => 'high',
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_post_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the test post. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'side',
					'priority'    => 'low',
					'hidden'      => true,
				),
			),
		)
	);

	WP_Backstage_Post_Type::modify(
		'post',
		array(
			'meta_boxes' => array(
				array(
					'id'          => 'wp_backstage_default_post_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the default post. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'normal',
					'priority'    => 'high',
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_default_post_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the default post. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'side',
					'priority'    => 'low',
					'hidden'      => true,
				),
			),
		)
	);

	WP_Backstage_Post_Type::modify(
		'page',
		array(
			'meta_boxes' => array(
				array(
					'id'          => 'wp_backstage_default_page_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the default page. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'normal',
					'priority'    => 'high',
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_default_page_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the default page. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'side',
					'priority'    => 'low',
					'hidden'      => true,
				),
			),
		)
	);

	WP_Backstage_Post_Type::modify(
		'attachment',
		array(
			'meta_boxes' => array(
				array(
					'id'          => 'wp_backstage_default_attachment_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the default attachment. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'normal',
					'priority'    => 'high',
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_default_attachment_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the default attachment. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'context'     => 'side',
					'priority'    => 'low',
					'hidden'      => true,
				),
			),
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
			'rest_base'     => 'test-tag',
			'post_types'    => array( 'wp_backstage_page', 'wp_backstage_post' ),
			'fields'        => $all_fields,
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
			'fields'        => $all_fields,
		)
	);

	WP_Backstage_Taxonomy::modify(
		'category',
		array(
			'fields' => $all_fields,
		)
	);

	WP_Backstage_Taxonomy::modify(
		'post_tag',
		array(
			'fields' => $all_fields,
		)
	);

	WP_Backstage_Nav_Menu_Item::modify(
		array(
			'fields' => $all_fields,
		)
	);

	WP_Backstage_User::modify(
		array(
			'field_groups' => array(
				array(
					'id'          => 'wp_backstage_user_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the user. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_user_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further details about the user. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
				),
			),
		)
	);

	WP_Backstage_Options::add(
		'wp_backstage_options',
		array(
			'title'        => __( 'Test Options', 'wp_backstage_examples' ),
			'menu_title'   => __( 'Test Options', 'wp_backstage_examples' ),
			'description'  => __( 'A test custom options page containing all field types.', 'wp_backstage_examples' ),
			'show_in_rest' => true,
			'sections'     => array(
				array(
					'id'          => 'wp_backstage_options_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further options. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_options_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further options. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
				),
			),
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
			'sections'     => array(
				array(
					'id'          => 'wp_backstage_theme_options_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further theme options. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					// phpcs:ignore Squiz.PHP.CommentedOutCode
					// 'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_theme_options_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further theme options. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
				),
			),
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
			'sections'     => array(
				array(
					'id'          => 'wp_backstage_tool_options_fields',
					'title'       => __( 'All Fields', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further tool options. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
					// phpcs:ignore Squiz.PHP.CommentedOutCode
					// 'fields'      => $all_fields,
				),
				array(
					'id'          => 'wp_backstage_tool_options_extras',
					'title'       => __( 'Extras', 'wp_backstage_examples' ),
					'description' => __( 'These extra meta fields control further tool options. <a href="#">Example Link</a>', 'wp_backstage_examples' ),
				),
			),
		)
	);

	WP_Backstage_Widget::add(
		'wp_backstage_widget',
		array(
			'title'       => __( 'Test Widget', 'wp_backstage_examples' ),
			'description' => __( 'A test custom widget containing all field types.', 'wp_backstage_examples' ),
			'fields'      => $all_fields,
		)
	);

}

add_action( 'after_setup_theme', 'wp_backstage_init', 10 );
