<?php

/**
 * WPCPT Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wpcpt_init_projects() {

	WP_CPT::add( 'project', array(
		'menu_name'      => __( 'Portfolio', 'wpcpt' ), 
		'singular_name'  => __( 'Project', 'wpcpt' ), 
		'plural_name'    => __( 'Projects', 'wpcpt' ), 
		'description'    => __( 'A portfolio of projects.', 'wpcpt' ), 
		'singular_base'  => 'project', 
		'archive_base'   => 'projects', 
		'rest_base'      => 'projects', 
		'group_meta_key' => 'wpcpt_project_meta',
		'meta_boxes'     => array(
			array(
				'id'          => 'wpcpt_project_details', 
				'title'       => __( 'Project Details', 'wpcpt' ), 
				'description' => __( 'These extra meta fields control further details about the portfolio project. <a href="#">Example Link</a>', 'wpcpt' ), 
				'context'     => 'normal', 
				'priority'    => 'high', 
				'fields'      => array(
					array( 
						'type'        => 'text', 
						'name'        => 'wpcpt_text_field', 
						'label'       => __( 'Text field', 'wpcpt' ), 
						'description' => __( 'Please enter some text.', 'wpcpt' ), 
					),
					array( 
						'type'        => 'number', 
						'name'        => 'wpcpt_number_field', 
						'label'       => __( 'Number field', 'wpcpt' ), 
						'description' => __( 'Please enter a number from 0-100.', 'wpcpt' ), 
						'input_attrs' => array(
							'min'         => 0,
							'max'         => 100,
							'step'        => 1,
						), 
					),
					array( 
						'type'        => 'textarea', 
						'name'        => 'wpcpt_textarea_field', 
						'label'       => __( 'Textarea field', 'wpcpt' ), 
						'description' => __( 'Please enter no more than 240 characters.', 'wpcpt' ), 
						'input_attrs' => array(
							'maxlength' => 240, 
						), 
					),
				), 
			),
		), 
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init_projects', 10 );
