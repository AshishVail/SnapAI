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
 * 3. Load Admin Functionality
 * We only load the admin class if we are in the WordPress dashboard.
 */
function snap_ai_init() {
    
    // Check if the Admin Class file exists
    $admin_class_path = SNAPAI_DIR . 'admin/class-snap-ai-admin.php';

    if ( file_exists( $admin_class_path ) ) {
        require_once $admin_class_path;

        // Initialize the Admin Class
        if ( class_exists( 'Snap_AI_Admin' ) ) {
            $snapai_admin = new Snap_AI_Admin( 'snap-ai', SNAPAI_VERSION );

            // Hook: Add Menu
            add_action( 'admin_menu', array( $snapai_admin, 'add_plugin_admin_menu' ) );

            // Hook: Load CSS/JS for Admin
            add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_scripts' ) );
        }
    }
}

// Run the initialization on plugins_loaded hook
add_action( 'plugins_loaded', 'snap_ai_init' );

/**
 * 4. Activation Hook
 */
function snap_ai_activate() {
    // Clear rewrite rules or set default options if needed
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'snap_ai_activate' );

/**
 * 5. Deactivation Hook
 */
function snap_ai_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'snap_ai_deactivate' );
