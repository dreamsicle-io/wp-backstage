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
require WP_BACKSTAGE . '/includes/class-wp-backstage-nav-menu-item.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-user.php';
require WP_BACKSTAGE . '/includes/class-wp-backstage-options.php';
require WP_BACKSTAGE . '/examples/tests.php';

/**
 * Inline Global Script
 *
 * Inlines the script that initializes the global `wpBackstage` JavaScript object.
 * 
 * @since   1.1.0
 * @return  void
 */
function wp_backstage_add_global_script() { ?>
	<script id="wp_backstage_global_script">
		window.wpBackstage = {
			colorPicker: {},
			datePicker: {},
			address: {},
			mediaUploader: {},
			editor: {},
			codeEditor: {
				settings: {},
			},
		};
	</script>
<?php }

add_action( 'admin_enqueue_scripts', 'wp_backstage_add_global_script', 0 );

/**
 * WP Backstage Render Help Tab
 * 
 * Renders the WP Backstage help tab on all screens.
 * See `wp_backstage_add_help_tab`.
 * 
 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
 * @since   1.1.0
 * @return  void
 */
function wp_backstage_render_help_tab() {
	$screen = get_current_screen(); ?>
	<h3><?php esc_html_e( 'Debug', 'wp_backstage' ); ?></h3>
	<p><?php esc_html_e( 'The following is useful debug information for WP Backstage development.', 'wp_backstage' ); ?></p>
	<ul>
		<li>
			<strong><?php esc_html_e( 'Current Screen ID:', 'wp_backstage' ); ?></strong>
			&nbsp;
			<code><?php echo esc_html( $screen->id ); ?></code>
		</li>
	</ul>
<?php }

/**
 * WP Backstage Add Help Tab
 * 
 * Registers the WP Backstage help tab.
 * See `wp_backstage_render_help_tab`.
 * 
 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
 * @link    https://developer.wordpress.org/reference/hooks/current_screen/ Current Screen
 * @since   1.1.0
 * @param   WP_Screen  $screen  an instance of `WP_Screen`.
 * @return  void
 */
function wp_backstage_add_help_tab( $screen = null ) {
	$screen->add_help_tab( array(
		'id'       => 'wp_backstage',
		'title'    => __( 'WP Backstage', 'wp_backstage' ),
		'callback' => 'wp_backstage_render_help_tab',
		'priority' => 50,
	) );
}

add_action( 'current_screen', 'wp_backstage_add_help_tab', 10 );

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
