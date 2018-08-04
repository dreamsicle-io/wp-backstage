<?php

/**
 * WPCPT Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wpcpt_init_default() {

	// WP_CPT::add();

	WP_CPT::add( 'wpcpt_test_post', array(
		'menu_name'      => __( 'Test Posts', 'wpcpt' ), 
		'singular_name'  => __( 'Test Post', 'wpcpt' ), 
		'plural_name'    => __( 'Test Posts', 'wpcpt' ), 
		'description'    => __( 'Testing all fields.', 'wpcpt' ), 
		'singular_base'  => 'test-post', 
		'archive_base'   => 'test-posts', 
		'rest_base'      => 'test-posts', 
		'group_meta_key' => 'wpcpt_test_post_meta',
		'supports'       => array(
			'title', 
			'slug', 
			'author', 
			'editor', 
			'excerpt', 
			'thumbnail', 
			'comments', 
			'trackbacks', 
			'revisions', 
			'custom-fields', 
			'page-attributes', 
		), 
		'meta_boxes'     => array(
			array(
				'id'          => 'wpcpt_test_post_fields', 
				'title'       => __( 'All Fields', 'wpcpt' ), 
				'description' => __( 'These extra meta fields control further details about the test post. <a href="#">Example Link</a>', 'wpcpt' ), 
				'context'     => 'normal', 
				'priority'    => 'high', 
				'fields'      => array(
					array( 
						'type'        => 'text', 
						'name'        => 'wpcpt_text_field', 
						'label'       => __( 'Text', 'wpcpt' ), 
						'description' => __( 'Please enter some text.', 'wpcpt' ), 
						'has_column'  => true, 
						'is_sortable' => true, 
					),
					array( 
						'type'        => 'url', 
						'name'        => 'wpcpt_url_field', 
						'label'       => __( 'URL', 'wpcpt' ), 
						'description' => __( 'Please enter a valid URL.', 'wpcpt' ), 
						'has_column'  => true, 
					),
					array( 
						'type'        => 'email', 
						'name'        => 'wpcpt_email_field', 
						'label'       => __( 'Email', 'wpcpt' ), 
						'description' => __( 'Please enter a valid Email.', 'wpcpt' ), 
						'has_column'  => true, 
					),
					array( 
						'type'        => 'tel', 
						'name'        => 'wpcpt_phone_field', 
						'label'       => __( 'Phone', 'wpcpt' ), 
						'description' => __( 'Please enter a phone number.', 'wpcpt' ), 
						'has_column'  => true, 
					),
					array( 
						'type'        => 'number', 
						'name'        => 'wpcpt_number_field', 
						'label'       => __( 'Number', 'wpcpt' ), 
						'description' => __( 'Please enter a number from 0-100.', 'wpcpt' ), 
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
						'name'        => 'wpcpt_checkbox_field', 
						'label'       => __( 'Checkbox', 'wpcpt' ), 
						'description' => __( 'Toggle the checkbox.', 'wpcpt' ), 
						'has_column'  => true, 
						'is_sortable' => true, 
					),
					array( 
						'type'        => 'textarea', 
						'name'        => 'wpcpt_textarea_field', 
						'label'       => __( 'Textarea', 'wpcpt' ), 
						'description' => __( 'Please enter no more than 240 characters.', 'wpcpt' ), 
						'input_attrs' => array(
							'maxlength' => 240, 
						), 
					),
					array( 
						'type'        => 'select', 
						'name'        => 'wpcpt_select_field', 
						'label'       => __( 'Select', 'wpcpt' ), 
						'description' => __( 'Please select an option.', 'wpcpt' ), 
						'has_column'  => true, 
						'is_sortable' => true, 
						'options'     => array(
							array( 
								'value'     => '', 
								'label'    => __( '&horbar; Select an Option &horbar;', 'wpcpt' )
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
						'name'        => 'wpcpt_radio_field', 
						'label'       => __( 'Radio', 'wpcpt' ), 
						'description' => __( 'Please select an option.', 'wpcpt' ), 
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
						'name'        => 'wpcpt_checkbox_set_field', 
						'label'       => __( 'Checkbox Set', 'wpcpt' ), 
						'description' => __( 'Please select all that apply.', 'wpcpt' ), 
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
				), 
			),
			array(
				'id'          => 'wpcpt_test_post_extras', 
				'title'       => __( 'Extras', 'wpcpt' ), 
				'description' => __( 'These extra meta fields control further details about the test post. <a href="#">Example Link</a>', 'wpcpt' ), 
				'context'     => 'side', 
				'priority'    => 'low', 
				'hidden'      => true, 
				'fields'      => array(), 
			),
		), 
		'taxonomies' => array(
			array(
				'slug'          => 'wpcpt_test_category', 
				'singular_name' => __( 'Test Category', 'wpcpt' ), 
				'plural_name'   => __( 'Test Categories', 'wpcpt' ), 
				'description'   => __( 'This is a test hierarchical taxonomy.', 'wpcpt' ), 
				'public'        => true, 
				'hierarchical'  => true, 
				'with_front'    => false, 
				'archive_base'  => 'test-category', 
				'rest_base'     => 'test-tag', 
			),
			array(
				'slug'          => 'wpcpt_test_tag', 
				'singular_name' => __( 'Test Tag', 'wpcpt' ), 
				'plural_name'   => __( 'Test Tags', 'wpcpt' ), 
				'description'   => __( 'This is a test non-hierarchical taxonomy.', 'wpcpt' ), 
				'public'        => true, 
				'hierarchical'  => false, 
				'with_front'    => false, 
				'archive_base'  => 'test-tag', 
				'rest_base'     => 'test-tags', 
			),
		), 
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init_default', 10 );
