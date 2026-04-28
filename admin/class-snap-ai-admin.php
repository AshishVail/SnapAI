<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Snap_AI_Admin {
    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    public function add_plugin_admin_menu() {
        // यह फंक्शन Media मेनू के अंदर 'SnapAI Generator' नाम का सब-मेनू बनाएगा
        add_media_page(
            'SnapAI Generator',    // ब्राउज़र टैब टाइटल
            'SnapAI Generator',    // मेनू में दिखने वाला नाम
            'upload_files',        // ज़रूरी परमिशन
            'snap-ai-generator',   // URL स्लग
            array( $this, 'display_plugin_admin_page' )
        );
    }

    public function display_plugin_admin_page() {
        ?>
        <div class="wrap">
            <h1>SnapAI Image Generator</h1>
            <p>Welcome to your AI Dashboard!</p>
            <?php 
            $partial = plugin_dir_path( __FILE__ ) . 'partials/snap-ai-admin-display.php';
            if ( file_exists( $partial ) ) {
                include_once $partial;
            } else {
                echo "UI Partial file not found.";
            }
            ?>
        </div>
        <?php
    }
}
