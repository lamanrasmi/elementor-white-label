<?php
/**
 * Plugin Name:       Elementor White Label Branding
 * Plugin URI:        http://wordpress.org/plugins/white-label-branding-elementor/
 * Description:       White Label Branding for Elementor Page Builder
 * Version:           1.0.2
 * Author:            Ozan Canakli
 * Author URI:        http://www.ozanwp.com
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl.html
 * Text Domain:       el-wl-branding
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Defines
define( 'ELEMENTOR_WL_BRANDING_VER', '1.0.2' );
define( 'ELEMENTOR_WL_BRANDING_DIR', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_WL_BRANDING_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

// Classes
require_once ELEMENTOR_WL_BRANDING_DIR . '/includes/class-white-label-branding-elementor.php';

// Actions
add_action( 'plugins_loaded',                                     'Elementor_WL_Branding::load_plugin_textdomain' );
add_action( 'admin_menu',                                         'Elementor_WL_Branding::add_menu', 900 );
add_action( 'plugins_loaded',                                     'Elementor_WL_Branding::init_hooks' );
add_action( 'elementor/editor/before_enqueue_scripts',            'Elementor_WL_Branding::branding_styles' );
add_action( 'admin_enqueue_scripts',                              'Elementor_WL_Branding::elwl_enqueue_color_picker' );
add_action( 'admin_init',                                         'Elementor_WL_Branding::elwl_activation_redirect' );

// Hooks
register_activation_hook( __FILE__,                               'Elementor_WL_Branding::ewl_plugin_activation' );

// Filters
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'Elementor_WL_Branding::ewl_plugin_actions_links' );


/**
 * Check elementor installed and activated
 *
 * @since 1.0.0
 */
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
	add_action('admin_notices', 'admin_notice_missing_main_plugin');
	return;
}
function admin_notice_missing_main_plugin() {

	$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
		esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'el-wl-branding' ),
		'<strong>' . esc_html__( 'Elementor White Label Branding', 'el-wl-branding' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor Page Builder', 'el-wl-branding' ) . '</strong>'
	);

	printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

}