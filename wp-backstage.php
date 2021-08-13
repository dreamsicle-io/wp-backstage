<?php 
/*
Plugin Name:  WP Backstage
Plugin URI:   https://github.com/dreamsicle-io/wp-backstage
Description:  Create standardized and deployable WordPress objects like post types with meta boxes and custom fields, taxonomy terms with custom fields, and custom user, option, and theme setting fields.
Version:      1.1.0
Author:       Dreamsicle
Author URI:   https://www.dreamsicle.io
License:      GPLv2
License URI:  LICENSE
Text Domain:  wp_backstage
Domain Path:  /languages
*/

define( 'WP_BACKSTAGE', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

require WP_BACKSTAGE . '/includes/class-wp-backstage.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-post-type.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-taxonomy.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-user.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-options.php';

// if ( apply_filters( 'wp_backstage_tests_enabled', false ) ) {
	require WP_BACKSTAGE . '/examples/tests.php';
// }

/**
 * WP Backstage Activation
 * 
 * @since   0.0.1
 * @return  void
 */
function wp_backstage_activation() {
	// ensure this runs after post types are initialized
	add_action( 'wp_loaded', 'flush_rewrite_rules', 10 );
}

register_activation_hook( __FILE__, 'wp_backstage_activation' );

/**
 * WP Backstage Deactivation
 * 
 * @since   0.0.1
 * @return  void
 */
function wp_backstage_deactivation() {
	// ensure this runs after post types are initialized
	add_action( 'wp_loaded', 'flush_rewrite_rules', 10 );
}

register_deactivation_hook( __FILE__, 'wp_backstage_deactivation' );
