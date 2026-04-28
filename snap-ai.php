<?php
/**
 * Plugin Name:       SnapAI
 * Description:       Generate AI images for your site using Pollinations.ai (Free).
 * Version:           1.0.0
 * Author:            Ashish
 * Text Domain:       snap-ai
 */

// 1. Security: Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 2. Define Plugin Constants
define( 'SNAPAI_VERSION', '1.0.0' );
define( 'SNAPAI_DIR', plugin_dir_path( __FILE__ ) );
define( 'SNAPAI_URL', plugin_dir_url( __FILE__ ) );

/**
 * 3. Initialize the Plugin
 */
function run_snap_ai() {
    
    // Path to the Admin Class
    $admin_class_file = SNAPAI_DIR . 'admin/class-snap-ai-admin.php';

    if ( file_exists( $admin_class_file ) ) {
        require_once $admin_class_file;

        if ( class_exists( 'Snap_AI_Admin' ) ) {
            // Create the instance
            $snapai_admin = new Snap_AI_Admin( 'snap-ai', SNAPAI_VERSION );

            // Hook to add the menu under Media
            add_action( 'admin_menu', array( $snapai_admin, 'add_plugin_admin_menu' ) );

            // Hook to load CSS and JS
            add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_assets' ) );
        }
    }
}

// Start the plugin logic
add_action( 'plugins_loaded', 'run_snap_ai' );

/**
 * 4. Activation/Deactivation
 */
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
