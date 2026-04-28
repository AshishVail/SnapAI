<?php
/**
 * Plugin Name:       SnapAI
 * Description:       A professional AI Image Generator using Pollinations.ai.
 * Version:           1.0.0
 * Author:            Ashish
 * Text Domain:       snap-ai
 */

// Exit if accessed directly for security
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Plugin Constants
 */
define( 'SNAPAI_VERSION', '1.0.0' );
define( 'SNAPAI_DIR', plugin_dir_path( __FILE__ ) );
define( 'SNAPAI_URL', plugin_dir_url( __FILE__ ) );

/**
 * Initialize the Plugin
 * This function loads the admin class and hooks it into WordPress.
 */
function run_snap_ai_plugin() {
    
    // Path to the admin class file
    $admin_file = SNAPAI_DIR . 'admin/class-snap-ai-admin.php';

    // Verify if the file exists before including to prevent Fatal Errors
    if ( file_exists( $admin_file ) ) {
        require_once $admin_file;

        // Verify if the class exists inside that file
        if ( class_exists( 'Snap_AI_Admin' ) ) {
            $snapai_admin = new Snap_AI_Admin( 'snap-ai', SNAPAI_VERSION );

            // Hook: Register the Submenu under 'Media'
            add_action( 'admin_menu', array( $snapai_admin, 'add_plugin_admin_menu' ) );

            // Hook: Load Admin Assets (CSS/JS)
            add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_scripts' ) );
        }
    }
}

// Start the plugin after all other plugins are loaded
add_action( 'plugins_loaded', 'run_snap_ai_plugin' );

/**
 * Activation Hook
 */
function snap_ai_activation() {
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'snap_ai_activation' );

/**
 * Deactivation Hook
 */
function snap_ai_deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'snap_ai_deactivate' );
