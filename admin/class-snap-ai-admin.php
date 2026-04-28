<?php
/**
 * Admin Logic for SnapAI
 * File Path: admin/class-snap-ai-admin.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Security check
}

class Snap_AI_Admin {

    private $plugin_name;
    private $version;

    /**
     * Constructor
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * 1. Register the Dashboard Menu
     * This adds "SnapAI Generator" under the 'Media' menu.
     */
    public function add_plugin_admin_menu() {
        add_media_page(
            'SnapAI Image Generator', // Page Title
            'SnapAI Generator',       // Menu Title
            'upload_files',           // Capability (Admins/Authors)
            'snap-ai-generator',      // Menu Slug
            array( $this, 'display_plugin_admin_page' ) // Function to show UI
        );
    }

    /**
     * 2. Load the UI from Partial File
     */
    public function display_plugin_admin_page() {
        // Security check for permissions
        if ( ! current_user_can( 'upload_files' ) ) {
            wp_die( 'You do not have sufficient permissions to access this page.' );
        }

        // Define path to the UI file
        $ui_partial = plugin_dir_path( __FILE__ ) . 'partials/snap-ai-admin-display.php';

        if ( file_exists( $ui_partial ) ) {
            include_once $ui_partial;
        } else {
            // Fallback if file is missing
            echo '<div class="wrap"><h1>SnapAI</h1><p>Error: UI file not found in admin/partials/ folder.</p></div>';
        }
    }

    /**
     * 3. (Optional) Enqueue CSS/JS
     * Only loaded on our plugin page
     */
    public function enqueue_assets( $hook ) {
        if ( 'media_page_snap-ai-generator' !== $hook ) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style( 'snap-ai-admin-css', plugin_dir_url( __FILE__ ) . 'css/snap-ai-admin.css', array(), $this->version );
        
        // Enqueue JS
        wp_enqueue_script( 'snap-ai-admin-js', plugin_dir_url( __FILE__ ) . 'js/snap-ai-admin.js', array( 'jquery' ), $this->version, true );
    }
}
