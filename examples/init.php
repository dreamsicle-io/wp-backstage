<?php

require get_template_directory() . '/includes/wp-cpt-factory/class-wp-cpt';

function wpcpt_init() {

	WP_CPT::add( array(
		
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init', 10 );
