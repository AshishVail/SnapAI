<?php
/**
 * Admin Class for SnapAI
 * File Path: admin/class-snap-ai-admin.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Snap_AI_Admin {

    /**
     * Plugin properties
     */
    private $plugin_name;
    private $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register the administration menu for the plugin.
     * This will create a "SnapAI Generator" submenu under the "Media" menu.
     */
    public function add_plugin_admin_menu() {
        add_media_page(
            'SnapAI Image Generator',    // Page Title
            'SnapAI Generator',          // Menu Title
            'upload_files',              // Capability required (Admin/Author)
            'snap-ai-generator',         // Menu Slug
            array( $this, 'display_plugin_admin_page' ) // Callback function
        );
    }

    /**
     * Render the admin page UI.
     */
    public function display_plugin_admin_page() {
        // Check user permissions
        if ( ! current_user_can( 'upload_files' ) ) {
            wp_die( 'You do not have sufficient permissions to access this page.' );
        }

        /**
         * Path to the UI partial file.
         * Ensure the folder name is 'admin' (lowercase) and 'partials' (lowercase).
         */
        $ui_file = plugin_dir_path( __FILE__ ) . 'partials/snap-ai-admin-display.php';

        if ( file_exists( $ui_file ) ) {
            include_once $ui_file;
        } else {
            echo '<div class="wrap"><h1>SnapAI</h1><p>Error: Admin UI partial file not found.</p></div>';
        }
    }

    /**
     * Register and enqueue the stylesheets for the admin area.
     */
    public function enqueue_styles( $hook ) {
        // Load styles only on the specific SnapAI admin page
        if ( 'media_page_snap-ai-generator' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'snap-ai-admin-css',
            plugin_dir_url( __FILE__ ) . 'css/snap-ai-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register and enqueue the JavaScript for the admin area.
     */
    public function enqueue_scripts( $hook ) {
        // Load scripts only on the specific SnapAI admin page
        if ( 'media_page_snap-ai-generator' !== $hook ) {
            return;
        }

        wp_enqueue_script(
            'snap-ai-admin-js',
            plugin_dir_url( __FILE__ ) . 'js/snap-ai-admin.js',
            array( 'jquery' ),
            $this->version,
            true
        );

        // Pass dynamic data (like AJAX URL and Nonce) to the JS file
        wp_localize_script(
            'snap-ai-admin-js',
            'SnapAIAjax',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'snap_ai_secure_nonce' )
            )
        );
    }
}
