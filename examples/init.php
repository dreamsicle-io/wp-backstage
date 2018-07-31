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
		'hierarchical'  => true, 
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init', 10 );
