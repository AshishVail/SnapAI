<?php
/**
 * Plugin Name:       SnapAI
 * Plugin URI:        https://snapai.example.com
 * Description:       A high-performance AI Image Generator for WordPress using Pollinations.ai. Generate unlimited featured images and post graphics for free.
 * Version:           1.0.0
 * Author:            SnapAI Team
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       snap-ai
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit; // Prevent direct access for security

// Plugin constants
define( 'SNAPAI_VERSION',         '1.0.0' );
define( 'SNAPAI_FILE',            __FILE__ );
define( 'SNAPAI_DIR',             plugin_dir_path( __FILE__ ) );
define( 'SNAPAI_URL',             plugin_dir_url( __FILE__ ) );
define( 'SNAPAI_TEXT_DOMAIN',     'snap-ai' );

/**
 * Main SnapAI class.
 *
 * @since 1.0.0
 */
final class SnapAI {

    /**
     * The single instance of the class.
     *
     * @var SnapAI|null
     */
    private static ?SnapAI $instance = null;

    /**
     * Prevent direct object creation.
     *
     * @since 1.0.0
     */
    private function __construct() {
        // Initialize hooks and plugin logic
        $this->init_hooks();
    }

    /**
     * Prevent object cloning.
     *
     * @since 1.0.0
     */
    private function __clone() {}

    /**
     * Prevent unserializing the singleton instance.
     *
     * @since 1.0.0
     */
    public function __wakeup() {
        throw new \Exception( 'Unserializing instances of this class is forbidden.' );
    }

    /**
     * Get the singleton instance of SnapAI.
     *
     * @return SnapAI
     * @since 1.0.0
     */
    public static function instance(): SnapAI {
        if ( static::$instance === null ) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * Initialize plugin hooks (public/admin).
     *
     * @since 1.0.0
     * @return void
     */
    private function init_hooks(): void {
        // Load plugin text domain for translations
        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

        if ( is_admin() ) {
            $this->admin_hooks();
        } else {
            $this->frontend_hooks();
        }
    }

    /**
     * Load the plugin textdomain for translation.
     *
     * @since 1.0.0
     * @return void
     */
    public function load_textdomain(): void {
        load_plugin_textdomain(
            SNAPAI_TEXT_DOMAIN,
            false,
            dirname( plugin_basename( SNAPAI_FILE ) ) . '/languages/'
        );
    }

    /**
     * Register admin-specific hooks.
     *
     * @since 1.0.0
     * @return void
     */
    private function admin_hooks(): void {
        // Admin menu
        add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );

        // Enqueue admin scripts and styles as needed
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

        // Register the Post Editor button (Gutenberg and Classic)
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );
        add_action( 'media_buttons', [ $this, 'add_classic_editor_button' ], 15 );
    }

    /**
     * Register frontend-specific hooks.
     *
     * @since 1.0.0
     * @return void
     */
    private function frontend_hooks(): void {
        // Place for frontend hooks if required in future
    }

    /**
     * Register the SnapAI admin menu under Media.
     *
     * @since 1.0.0
     * @return void
     */
    public function register_admin_menu(): void {
        add_media_page(
            __( 'SnapAI Image Generator', SNAPAI_TEXT_DOMAIN ),
            __( 'SnapAI', SNAPAI_TEXT_DOMAIN ),
            'upload_files',
            'snap-ai-generator',
            [ $this, 'render_admin_page' ]
        );
    }

    /**
     * Render the SnapAI admin dashboard page.
     *
     * @since 1.0.0
     * @return void
     */
    public function render_admin_page(): void {
        // In a real implementation, this would be split out modularly.
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'SnapAI Image Generator', SNAPAI_TEXT_DOMAIN ); ?></h1>
            <p><?php esc_html_e( 'Generate stunning AI-powered images for your posts and pages. Integration with Pollinations.ai — no API key required!', SNAPAI_TEXT_DOMAIN ); ?></p>
            <!-- UI for image generation will go here in modular code -->
        </div>
        <?php
    }

    /**
     * Enqueue admin-specific assets.
     *
     * @since 1.0.0
     * @return void
     */
    public function enqueue_admin_assets(): void {
        // Register and enqueue CSS/JS for admin dashboard.
        // Placeholder for modular future assets
    }

    /**
     * Enqueue assets for the Gutenberg editor.
     *
     * @since 1.0.0
     * @return void
     */
    public function enqueue_block_editor_assets(): void {
        // Register and enqueue block editor JS/CSS.
        // This is where Gutenberg integration code would go.
    }

    /**
     * Add a button to the Classic Editor for SnapAI.
     *
     * @since 1.0.0
     * @return void
     */
    public function add_classic_editor_button(): void {
        $url = admin_url( 'upload.php?page=snap-ai-generator' );
        echo '<a href="' . esc_url( $url ) . '" class="button" style="padding-left:4px;padding-right:4px;" target="_blank"><span class="dashicons dashicons-format-image" style="vertical-align:middle;"></span> ' . esc_html__( 'Generate AI Image', SNAPAI_TEXT_DOMAIN ) . '</a>';
    }

    /**
     * Placeholder for Pollinations.ai integration.
     *
     * @since 1.0.0
     * @param string $prompt Text prompt to generate image.
     * @return string URL of generated image (to be implemented).
     */
    public function generate_image_via_pollinations( string $prompt ): string {
        // Integration code would go in a modular file or service class.
        return ''; // To be implemented
    }

    /**
     * Save generated image to Media Library with AI alt text.
     *
     * @since 1.0.0
     * @param string $image_url  URL of the generated image.
     * @param string $alt_text   Alt text for accessibility/SEO.
     * @return int|false         Attachment ID on success, false on failure.
     */
    public function save_image_to_media_library( string $image_url, string $alt_text = '' ) {
        // This would contain the logic for media sideload and would be split out modularly.
        return false; // To be implemented
    }
}

/**
 * Plugin activation callback.
 *
 * @since 1.0.0
 * @return void
 */
function snapai_activate(): void {
    // Set default options if needed, e.g.,
    // add_option( 'snapai_option', $default );
}
register_activation_hook( SNAPAI_FILE, 'snapai_activate' );

/**
 * Plugin deactivation callback.
 *
 * @since 1.0.0
 * @return void
 */
function snapai_deactivate(): void {
    // Clean up as necessary; avoid deleting user data.
}
register_deactivation_hook( SNAPAI_FILE, 'snapai_deactivate' );

// Initialize the plugin
add_action( 'plugins_loaded', [ 'SnapAI', 'instance' ] );
```

---

**Key Points:**
- **Security:** Checks for `ABSPATH` to prevent direct access.
- **Constants:** Defines version, file, dir, URL, and text domain.
- **Singleton:** `SnapAI` main class uses Singleton pattern.
- **Activation/Deactivation hooks:** Ready for option initialization/cleanup.
- **Hooks Setup:** Admin and public hooks modularized.
- **Feature Placeholders:** Hooks for Pollinations API integration, media upload, Gutenberg/Classic editor buttons.
- **WPCS & OOP:** Uses strict types, PHPDoc, and WordPress standards.
- **Ready for Modular Expansion:** Key features isolated in methods, ready for moving to dedicated classes.

You can copy this file as `snap-ai.php` into your plugin folder. In future, you should create modular files for the API integration, editor enhancements, asset management, etc. Let me know if you want code for those!
