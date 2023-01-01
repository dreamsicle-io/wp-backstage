<?php
/**
 * WP Backstage
 *
 * @package WPBackstage
 *
 * @wordpress-plugin
 * Plugin Name:       WP Backstage
 * Plugin URI:        https://github.com/dreamsicle-io/wp-backstage
 * Description:       Create standardized and deployable WordPress objects like post types with meta boxes and custom fields, taxonomy terms with custom fields, options pages with custom fields and widgets with custom fields; and extend existing WordPress objects like pages, posts, attachments, categories, tags, users and nav menu items.
 * Version:           3.7.2
 * Requires PHP:      7.4.0
 * Requires at least: 5.8.0
 * Author:            Dreamsicle
 * Author URI:        https://www.dreamsicle.io
 * License:           GPLv2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp_backstage
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
define( 'WP_BACKSTAGE', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

// Require the main class.
require WP_BACKSTAGE . '/includes/class-wp-backstage.php';
// Require component classes.
require WP_BACKSTAGE . '/includes/class-wp-backstage-component.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-post-type.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-taxonomy.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-nav-menu-item.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-user.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-options.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-widget.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-widget-base.php';
// Require field classes.
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-address-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-checkbox-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-checkbox-set-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-code-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-color-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-date-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-editor-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-email-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-media-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-number-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-radio-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-range-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-select-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-select-posts-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-select-users-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-tel-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-textarea-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-time-field.php';
require WP_BACKSTAGE . '/includes/fields/class-wp-backstage-url-field.php';
// Require examples.
require WP_BACKSTAGE . '/examples/tests.php';

// Initialize the main class.
add_action( 'plugins_loaded', array( new WP_Backstage(), 'init' ), 10 );

/**
 * WP Backstage Activation
 *
 * @since   0.0.1
 * @return  void
 */
function wp_backstage_activation() {
	// ensure this runs after post types are initialized.
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
	// ensure this runs after post types are initialized.
	add_action( 'wp_loaded', 'flush_rewrite_rules', 10 );
}

register_deactivation_hook( __FILE__, 'wp_backstage_deactivation' );

/**
 * WP Backstage Uninstall
 *
 * @since   3.2.0
 * @return  void
 */
function wp_backstage_uninstall() {
	// ensure this runs after post types are initialized.
	add_action( 'wp_loaded', 'flush_rewrite_rules', 10 );
}

register_uninstall_hook( __FILE__, 'wp_backstage_uninstall' );
