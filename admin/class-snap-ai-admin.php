<?php
/**
 * Admin Class for SnapAI
 * Path: admin/class-snap-ai-admin.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Security check
}

class Snap_AI_Admin {

    /**
     * Plugin properties
     */
    private $plugin_name;
    private $version;

    /**
     * Constructor: Initializes name and version
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Add "SnapAI" menu under the Media section
     */
    public function add_plugin_admin_menu() {
        add_media_page(
            'SnapAI Generator',    // Page Title
            'SnapAI',              // Menu Title
            'upload_files',        // Capability
            'snap-ai-generator',   // Menu Slug
            array( $this, 'display_plugin_admin_page' ) // Callback function
        );
    }

    /**
     * Render the Admin Page UI
     */
    public function display_plugin_admin_page() {
        // Ensure only authorized users see this
        if ( ! current_user_can( 'upload_files' ) ) {
            wp_die( 'You do not have permission to access this page.' );
        }

        // Include the UI partial file
        $partial_path = plugin_dir_path( __FILE__ ) . 'partials/snap-ai-admin-display.php';

        if ( file_exists( $partial_path ) ) {
            include_once $partial_path;
        } else {
            echo '<div class="wrap"><h1>SnapAI</h1><p>Error: UI file missing in admin/partials/ folder.</p></div>';
        }
    }

    /**
     * Enqueue CSS styles for the admin page
     */
    public function enqueue_styles( $hook ) {
        // Load only on our plugin page
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
     * Enqueue JS scripts and pass Ajax data
     */
    public function enqueue_scripts( $hook ) {
        // Load only on our plugin page
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

        // Security Nonce and Ajax URL for JavaScript
        wp_localize_script(
            'snap-ai-admin-js',
            'SnapAIAjax',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'snap_ai_nonce' )
            )
        );
    }
}
