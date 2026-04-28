<?php
/**
 * Plugin Name:       SnapAI
 * Plugin URI:        https://snapai.example.com
 * Description:       A high-performance AI Image Generator using Pollinations.ai.
 * Version:           1.0.0
 * Author:            SnapAI Team
 * License:           GPLv2 or later
 * Text Domain:       snap-ai
 */

defined( 'ABSPATH' ) || exit;

// Constants
define( 'SNAPAI_VERSION', '1.0.0' );
define( 'SNAPAI_DIR', plugin_dir_path( __FILE__ ) );
define( 'SNAPAI_URL', plugin_dir_url( __FILE__ ) );

/**
 * 1. Load Dependencies (फाइलों को जोड़ना)
 * हमने जो फोल्डर्स बनाए थे, उन्हें यहाँ लोड करना ज़रूरी है।
 */
function snap_ai_load_plugin() {
    // Core Logic
    if ( file_exists( SNAPAI_DIR . 'includes/class-snap-ai-loader.php' ) ) {
        require_once SNAPAI_DIR . 'includes/class-snap-ai-loader.php';
    }
    if ( file_exists( SNAPAI_DIR . 'includes/class-snap-ai-api.php' ) ) {
        require_once SNAPAI_DIR . 'includes/class-snap-ai-api.php';
    }
    
    // Admin Side
    if ( is_admin() ) {
        if ( file_exists( SNAPAI_DIR . 'admin/class-snap-ai-admin.php' ) ) {
            require_once SNAPAI_DIR . 'admin/class-snap-ai-admin.php';
        }
    }
}
add_action( 'plugins_loaded', 'snap_ai_load_plugin', 1 );

/**
 * 2. Main Execution Class
 */
class SnapAI_Final {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
    }

    public function add_menu() {
        add_media_page(
            'SnapAI Generator',
            'SnapAI',
            'upload_files',
            'snap-ai',
            array( $this, 'render_page' )
        );
    }

    public function render_page() {
        // यहाँ हम partials वाली फाइल को लोड करेंगे
        $display_file = SNAPAI_DIR . 'admin/partials/snap-ai-admin-display.php';
        if ( file_exists( $display_file ) ) {
            include_once $display_file;
        } else {
            echo '<div class="wrap"><h1>SnapAI</h1><p>Error: Partial file not found.</p></div>';
        }
    }
}

// प्लगइन शुरू करें
new SnapAI_Final();
