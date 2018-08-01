<?php

/**
 * Require the class
 */
require get_stylesheet_directory() . '/includes/wp-cpt-factory/class-wp-cpt.php';

/**
 * WPCPT Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wpcpt_init() {

	WP_CPT::add( 'project', array(
		'menu_name'     => __( 'Portfolio', 'wpcpt' ), 
		'singular_name' => __( 'Project', 'wpcpt' ), 
		'plural_name'   => __( 'Projects', 'wpcpt' ), 
		'description'   => __( 'A portfolio of projects.', 'wpcpt' ), 
		'singular_base' => 'project', 
		'archive_base'  => 'projects', 
		'rest_base'     => 'projects', 
		'meta_boxes'    => array(
			array(
				'id'        => 'wpcpt_project_details', 
				'title'     => __( 'Project Details', 'wpcpt' ), 
				'context'   => 'normal', 
				'priority'  => 'high', 
				'fields'    => array(
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
				), 
			),
		), 
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init', 10 );
