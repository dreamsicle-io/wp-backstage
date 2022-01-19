<?php 
/*
Plugin Name:  WP Backstage
Plugin URI:   https://github.com/dreamsicle-io/wp-backstage
Description:  Create standardized and deployable WordPress objects like post types with meta boxes and custom fields, taxonomy terms with custom fields, options pages with custom fields and widgets with custom fields; and extend existing WordPress objects like pages, posts, attachments, categories, tags, users and nav menu items.
Version:      2.2.0
Author:       Dreamsicle
Author URI:   https://www.dreamsicle.io
License:      GPLv2
License URI:  LICENSE
Text Domain:  wp_backstage
Domain Path:  /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

define( 'WP_BACKSTAGE', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

require WP_BACKSTAGE . '/includes/class-wp-backstage.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-component.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-post-type.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-taxonomy.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-nav-menu-item.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-user.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-options.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-widget.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-widget-base.php';
require WP_BACKSTAGE . '/examples/tests.php';

add_action( 'plugins_loaded', array( new WP_Backstage, 'init' ), 10 );

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
