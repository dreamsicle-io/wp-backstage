<?php

/**
 * WP Backstage Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wp_backstage_init() {

	$all_fields = array(
		array( 
			'type'        => 'text', 
			'name'        => 'wp_backstage_text_field', 
			'label'       => __( 'Text', 'wp_backstage' ), 
			'description' => __( 'Please enter some text.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
		),
		array( 
			'type'        => 'url', 
			'name'        => 'wp_backstage_url_field', 
			'label'       => __( 'URL', 'wp_backstage' ), 
			'description' => __( 'Please enter a valid URL.', 'wp_backstage' ), 
			'has_column'  => true, 
		),
		array( 
			'type'        => 'email', 
			'name'        => 'wp_backstage_email_field', 
			'label'       => __( 'Email', 'wp_backstage' ), 
			'description' => __( 'Please enter a valid Email.', 'wp_backstage' ), 
			'has_column'  => true, 
		),
		array( 
			'type'        => 'tel', 
			'name'        => 'wp_backstage_phone_field', 
			'label'       => __( 'Phone', 'wp_backstage' ), 
			'description' => __( 'Please enter a phone number.', 'wp_backstage' ), 
			'has_column'  => true, 
		),
		array( 
			'type'        => 'number', 
			'name'        => 'wp_backstage_number_field', 
			'label'       => __( 'Number', 'wp_backstage' ), 
			'description' => __( 'Please enter a number from 0-100.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
			'input_attrs' => array(
				'min'         => 0,
				'max'         => 100,
				'step'        => 1,
			), 
		),
		array( 
			'type'        => 'checkbox', 
			'name'        => 'wp_backstage_checkbox_field', 
			'label'       => __( 'Checkbox', 'wp_backstage' ), 
			'description' => __( 'Toggle the checkbox.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
		),
		array( 
			'type'        => 'textarea', 
			'name'        => 'wp_backstage_textarea_field', 
			'label'       => __( 'Textarea', 'wp_backstage' ), 
			'description' => __( 'Please enter no more than 240 characters.', 'wp_backstage' ), 
			'input_attrs' => array(
				'maxlength' => 240, 
			), 
		),
		array( 
			'type'        => 'select', 
			'name'        => 'wp_backstage_select_field', 
			'label'       => __( 'Select', 'wp_backstage' ), 
			'description' => __( 'Please select an option.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
			'options'     => array(
				array( 
					'value'     => '', 
					'label'    => __( '&horbar; Select an Option &horbar;', 'wp_backstage' )
				),
				array( 
					'value'     => 'option_1', 
					'label'    => __( 'Option 1'), 
				),
				array( 
					'value'     => 'option_2', 
					'label'    => __( 'Option 2'), 
				),
				array( 
					'value'     => 'option_3', 
					'label'    => __( 'Option 3'), 
					'disabled' => true, 
				),
				array( 
					'value'     => 'option_4', 
					'label'    => __( 'Option 4'), 
				),
			), 
		),
		array( 
			'type'        => 'radio', 
			'name'        => 'wp_backstage_radio_field', 
			'label'       => __( 'Radio', 'wp_backstage' ), 
			'description' => __( 'Please select an option.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
			'options'     => array(
				array( 
					'value'     => 'option_1', 
					'label'    => __( 'Option 1'), 
				),
				array( 
					'value'     => 'option_2', 
					'label'    => __( 'Option 2'), 
				),
				array( 
					'value'     => 'option_3', 
					'label'    => __( 'Option 3'), 
					'disabled' => true, 
				),
				array( 
					'value'     => 'option_4', 
					'label'    => __( 'Option 4'), 
				),
			), 
		),
		array( 
			'type'        => 'checkbox_set', 
			'name'        => 'wp_backstage_checkbox_set_field', 
			'label'       => __( 'Checkbox Set', 'wp_backstage' ), 
			'description' => __( 'Please select all that apply.', 'wp_backstage' ), 
			'has_column'  => true, 
			'options'     => array(
				array( 
					'value'     => 'option_1', 
					'label'    => __( 'Option 1'), 
				),
				array( 
					'value'     => 'option_2', 
					'label'    => __( 'Option 2'), 
				),
				array( 
					'value'     => 'option_3', 
					'label'    => __( 'Option 3'), 
					'disabled' => true, 
				),
				array( 
					'value'     => 'option_4', 
					'label'    => __( 'Option 4'), 
				),
			), 
		),
		array( 
			'type'        => 'media', 
			'name'        => 'wp_backstage_image_field', 
			'label'       => __( 'Image', 'wp_backstage' ), 
			'description' => __( 'Please select or upload an image.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'attach' => true, 
			), 
		),
		array( 
			'type'        => 'media', 
			'name'        => 'wp_backstage_gallery_field', 
			'label'       => __( 'Gallery', 'wp_backstage' ), 
			'description' => __( 'Please select or upload multiple images.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'multiple' => true, 
				'attach'   => true, 
			), 
		),
		array( 
			'type'        => 'media', 
			'name'        => 'wp_backstage_video_field', 
			'label'       => __( 'Video', 'wp_backstage' ), 
			'description' => __( 'Please select or upload a video.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'type'   => 'video',
				'attach' => true,  
			), 
		),
		array( 
			'type'        => 'media', 
			'name'        => 'wp_backstage_application_field', 
			'label'       => __( 'Documents', 'wp_backstage' ), 
			'description' => __( 'Please select or upload documents.', 'wp_backstage' ), 
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
			'label'       => __( 'Date', 'wp_backstage' ), 
			'description' => __( 'Please select a date.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
			'args'        => array(
				'format' => 'yy-mm-dd', 
			), 
		),
		array( 
			'type'        => 'time', 
			'name'        => 'wp_backstage_time_field', 
			'label'       => __( 'Time', 'wp_backstage' ), 
			'description' => __( 'Please set a time.', 'wp_backstage' ), 
			'has_column'  => true, 
			'is_sortable' => true, 
		),
		array( 
			'type'        => 'color', 
			'name'        => 'wp_backstage_color_field', 
			'label'       => __( 'Color', 'wp_backstage' ), 
			'description' => __( 'Please select a color.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'palettes' => true, 
			),
		),
		array( 
			'type'        => 'color', 
			'name'        => 'wp_backstage_color_palette_field', 
			'label'       => __( 'Color with Custom Palettes', 'wp_backstage' ), 
			'description' => __( 'Please select a color.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'palettes' => array( '#ffffff', '#000000', '#67b0ff', '#ff9900' ), 
			),
		),
		array( 
			'type'        => 'color', 
			'name'        => 'wp_backstage_color_nopalettes_field', 
			'label'       => __( 'Color with No Palletes', 'wp_backstage' ), 
			'description' => __( 'Please select a color.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'palettes' => false, 
			),
		),
		array( 
			'type'        => 'color', 
			'name'        => 'wp_backstage_color_hsl_field', 
			'label'       => __( 'Color with HSL mode', 'wp_backstage' ), 
			'description' => __( 'Please select a color.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'mode' => 'hsl', 
			),
		),
		array( 
			'type'        => 'code', 
			'name'        => 'wp_backstage_html_field', 
			'label'       => __( 'Code (HTML)', 'wp_backstage' ), 
			'description' => __( 'Please enter some code.', 'wp_backstage' ), 
			'has_column'  => true, 
		),
		array( 
			'type'        => 'code', 
			'name'        => 'wp_backstage_php_field', 
			'label'       => __( 'Code (CSS)', 'wp_backstage' ), 
			'description' => __( 'Please enter some code.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'mime' => 'text/css', 
			),
		),
		array( 
			'type'        => 'code', 
			'name'        => 'wp_backstage_js_field', 
			'label'       => __( 'Code (JavaScript)', 'wp_backstage' ), 
			'description' => __( 'Please enter some code.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'mime' => 'text/javascript', 
			),
		),
		array( 
			'type'        => 'editor', 
			'name'        => 'wp_backstage_editor_field', 
			'label'       => __( 'Editor', 'wp_backstage' ), 
			'description' => __( 'Please enter some content.', 'wp_backstage' ), 
			'has_column'  => true, 
		),
		array( 
			'type'        => 'editor', 
			'name'        => 'wp_backstage_editor_field_format_select', 
			'label'       => __( 'Editor with Format Select', 'wp_backstage' ), 
			'description' => __( 'Please enter some content.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'format_select' => true,
			), 
		),
		array( 
			'type'        => 'editor', 
			'name'        => 'wp_backstage_editor_field_media', 
			'label'       => __( 'Editor with Media Buttons', 'wp_backstage' ), 
			'description' => __( 'Please enter some content.', 'wp_backstage' ), 
			'has_column'  => true, 
			'args'        => array(
				'media_buttons' => true,
				'format_select' => true, 
			), 
		),
		array( 
			'type'        => 'editor', 
			'name'        => 'wp_backstage_editor_field_kitchen_sink', 
			'label'       => __( 'Editor with Kitchen Sink', 'wp_backstage' ), 
			'description' => __( 'Please enter some content.', 'wp_backstage' ), 
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
			'label'       => __( 'Address', 'wp_backstage' ), 
			'description' => __( 'Please enter an address.', 'wp_backstage' ), 
			'has_column'  => true, 
		),
	);

	WP_Backstage_Post_Type::add( 'wp_backstage_page', array(
		'menu_name'      => __( 'Test Pages', 'wp_backstage' ), 
		'singular_name'  => __( 'Test Page', 'wp_backstage' ), 
		'plural_name'    => __( 'Test Pages', 'wp_backstage' ), 
		'description'    => __( 'This is a test hierarchical post type.', 'wp_backstage' ), 
		'singular_base'  => 'test-page', 
		'archive_base'   => 'test-pages', 
		'rest_base'      => 'test-pages', 
		'group_meta_key' => 'wp_backstage_page_meta',
		'hierarchical'   => true, 
		'glance_item'    => true, 
		'meta_boxes'     => array(
			array(
				'id'          => 'wp_backstage_page_fields', 
				'title'       => __( 'All Fields', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further details about the test page. <a href="#">Example Link</a>', 'wp_backstage' ), 
				'context'     => 'normal', 
				'priority'    => 'high', 
				'fields'      => $all_fields, 
			),
			array(
				'id'          => 'wp_backstage_page_extras', 
				'title'       => __( 'Extras', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further details about the test page. <a href="#">Example Link</a>', 'wp_backstage' ), 
				'context'     => 'side', 
				'priority'    => 'low', 
				'hidden'      => true, 
			),
		), 
	) );

	WP_Backstage_Post_Type::add( 'wp_backstage_post', array(
		'menu_name'      => __( 'Test Posts', 'wp_backstage' ), 
		'singular_name'  => __( 'Test Post', 'wp_backstage' ), 
		'plural_name'    => __( 'Test Posts', 'wp_backstage' ), 
		'description'    => __( 'This is a test non-hierarchical post type.', 'wp_backstage' ), 
		'singular_base'  => 'test-post', 
		'archive_base'   => 'test-posts', 
		'rest_base'      => 'test-posts', 
		'group_meta_key' => 'wp_backstage_post_meta',
		'taxonomies'     => array( 'category', 'post_tag' ), 
		'glance_item'    => true, 
		'meta_boxes'     => array(
			array(
				'id'          => 'wp_backstage_post_fields', 
				'title'       => __( 'All Fields', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further details about the test post. <a href="#">Example Link</a>', 'wp_backstage' ), 
				'context'     => 'normal', 
				'priority'    => 'high', 
				'fields'      => $all_fields, 
			),
			array(
				'id'          => 'wp_backstage_post_extras', 
				'title'       => __( 'Extras', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further details about the test post. <a href="#">Example Link</a>', 'wp_backstage' ), 
				'context'     => 'side', 
				'priority'    => 'low', 
				'hidden'      => true, 
			),
		), 
	) );

	WP_Backstage_Taxonomy::add( 'wp_backstage_cat', array( 
		'singular_name'  => __( 'Test Category', 'wp_backstage' ), 
		'plural_name'    => __( 'Test Categories', 'wp_backstage' ), 
		'description'    => __( 'This is a test hierarchical taxonomy.', 'wp_backstage' ), 
		'public'         => true, 
		'hierarchical'   => true, 
		'with_front'     => false, 
		'archive_base'   => 'test-category', 
		'rest_base'      => 'test-tag', 
		'post_types'     => array( 'wp_backstage_page', 'wp_backstage_post' ), 
		'fields'         => $all_fields, 
		'group_meta_key' => 'wp_backstage_cat_meta', 
	) );

	WP_Backstage_Taxonomy::add( 'wp_backstage_tag', array( 
		'singular_name'  => __( 'Test Tag', 'wp_backstage' ), 
		'plural_name'    => __( 'Test Tags', 'wp_backstage' ), 
		'description'    => __( 'This is a test non-hierarchical taxonomy.', 'wp_backstage' ), 
		'public'         => true, 
		'hierarchical'   => false, 
		'with_front'     => false, 
		'archive_base'   => 'test-tag', 
		'rest_base'      => 'test-tags', 
		'post_types'     => array( 'wp_backstage_page', 'wp_backstage_post' ), 
		'fields'         => $all_fields, 
		'group_meta_key' => 'wp_backstage_tag_meta', 
	) );

	WP_Backstage_User::modify( array( 
		'field_groups' => array(
			array(
				'id'          => 'wp_backstage_user_fields', 
				'title'       => __( 'All Fields', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further details about the user. <a href="#">Example Link</a>', 'wp_backstage' ), 
				'fields'      => $all_fields, 
			),
			array(
				'id'          => 'wp_backstage_user_extras', 
				'title'       => __( 'Extras', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further details about the user. <a href="#">Example Link</a>', 'wp_backstage' ), 
			),
		), 
	) );

	WP_Backstage_Options::add( 'wp_backstage_options', array( 
		'title'             => __( 'Test Options', 'wp_backstage' ), 
		'menu_title'        => __( 'Test Options', 'wp_backstage' ), 
		'description'       => __( 'A test custom options page containing all field types.', 'wp_backstage' ), 
		'show_in_rest'      => true, 
		'group_options_key' => 'wp_backstage_options', 
		'sections' => array(
			array(
				'id'          => 'wp_backstage_options_fields', 
				'title'       => __( 'All Fields', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further options. <a href="#">Example Link</a>', 'wp_backstage' ), 
				'fields'      => $all_fields, 
			),
			array(
				'id'          => 'wp_backstage_options_extras', 
				'title'       => __( 'Extras', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further options. <a href="#">Example Link</a>', 'wp_backstage' ), 
			),
		), 
	) );

	WP_Backstage_Options::add( 'wp_backstage_theme_options', array( 
		'type'              => 'theme', 
		'title'             => __( 'Test Theme Options', 'wp_backstage' ), 
		'menu_title'        => __( 'Test Theme Options', 'wp_backstage' ), 
		'description'       => __( 'A test custom theme options page containing all field types.', 'wp_backstage' ), 
		'show_in_rest'      => true, 
		'group_options_key' => 'wp_backstage_theme_options', 
		'sections' => array(
			array(
				'id'          => 'wp_backstage_theme_options_fields', 
				'title'       => __( 'All Fields', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further theme options. <a href="#">Example Link</a>', 'wp_backstage' ), 
				// 'fields'      => $all_fields, 
			),
			array(
				'id'          => 'wp_backstage_theme_options_extras', 
				'title'       => __( 'Extras', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further theme options. <a href="#">Example Link</a>', 'wp_backstage' ), 
			),
		), 
	) );

	WP_Backstage_Options::add( 'wp_backstage_tool', array( 
		'type'              => 'tools', 
		'title'             => __( 'Test Tool', 'wp_backstage' ), 
		'menu_title'        => __( 'Test Tool', 'wp_backstage' ), 
		'description'       => __( 'A test custom tool options page containing all field types.', 'wp_backstage' ), 
		'show_in_rest'      => true, 
		'group_options_key' => 'wp_backstage_tool', 
		'sections' => array(
			array(
				'id'          => 'wp_backstage_tool_options_fields', 
				'title'       => __( 'All Fields', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further tool options. <a href="#">Example Link</a>', 'wp_backstage' ), 
				// 'fields'      => $all_fields, 
			),
			array(
				'id'          => 'wp_backstage_tool_options_extras', 
				'title'       => __( 'Extras', 'wp_backstage' ), 
				'description' => __( 'These extra meta fields control further tool options. <a href="#">Example Link</a>', 'wp_backstage' ), 
			),
		), 
	) );

}

add_action( 'after_setup_theme', 'wp_backstage_init', 10 );
