<?php
/**
 * Plugin Name:       SnapAI
 * Description:       A lightweight test for SnapAI Image Generator.
 * Version:           1.0.0
 * Author:            Ashish
 * Text Domain:       snap-ai
 */

// Exit if accessed directly for security
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Step 1: Create the Admin Menu
 * This adds a link under the 'Media' section in WordPress.
 */
function snap_ai_setup_menu() {
    add_media_page(
        'SnapAI Generator',      // Page Title
        'SnapAI',                // Menu Title
        'manage_options',        // Capability (Only Admins)
        'snap-ai-test',          // Menu Slug
        'snap_ai_render_page'    // Function that displays the content
    );
}
add_action( 'admin_menu', 'snap_ai_setup_menu' );

/**
 * Step 2: Render the Dashboard Page
 */
function snap_ai_render_page() {
    ?>
    <div class="wrap">
        <h1>SnapAI Dashboard is Working!</h1>
        <p>If you see this page, your plugin foundation is solid.</p>
        <hr>
        <p><strong>Next Step:</strong> We will now add the AI Image logic one file at a time.</p>
    </div>
    <?php
}
