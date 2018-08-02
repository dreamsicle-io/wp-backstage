<?php

/**
 * WPCPT Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wpcpt_init_default() {

	WP_CPT::add( 'wpcpt_test_post', array(
		'menu_name'      => __( 'Test Posts', 'wpcpt' ), 
		'singular_name'  => __( 'Test Post', 'wpcpt' ), 
		'plural_name'    => __( 'Test Posts', 'wpcpt' ), 
		'description'    => __( 'Testing all fields.', 'wpcpt' ), 
		'singular_base'  => 'test-post', 
		'archive_base'   => 'test-posts', 
		'rest_base'      => 'test-posts', 
		'group_meta_key' => 'wpcpt_test_post_meta',
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
						'is_sortable' => true, 
					),
					array( 
						'type'        => 'email', 
						'name'        => 'wpcpt_email_field', 
						'label'       => __( 'Email', 'wpcpt' ), 
						'description' => __( 'Please enter a valid Email.', 'wpcpt' ), 
						'has_column'  => true, 
						'is_sortable' => true, 
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
						'type'        => 'textarea', 
						'name'        => 'wpcpt_textarea_field', 
						'label'       => __( 'Textarea', 'wpcpt' ), 
						'description' => __( 'Please enter no more than 240 characters.', 'wpcpt' ), 
						'input_attrs' => array(
							'maxlength' => 240, 
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
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init_default', 10 );
