<?php

/**
 * WPCPT Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wpcpt_init_default() {

	WP_CPT::add( 'shlinkty_pop' );

}

add_action( 'after_setup_theme', 'wpcpt_init_default', 10 );
