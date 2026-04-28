<?php
/**
 * The admin-specific functionality of the SnapAI plugin.
 *
 * @link       https://snapai.example.com
 * @since      1.0.0
 * @package    SnapAI
 * @subpackage SnapAI/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The admin-side controller class.
 */
class Snap_AI_Admin {

	/**
	 * The name of this plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Enqueue the admin-specific CSS for the SnapAI admin page.
	 *
	 * @since 1.0.0
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_styles( $hook ) {
		if ( ! $this->is_snapai_admin_page( $hook ) ) {
			return;
		}

		wp_enqueue_style(
			'snapai-admin-styles',
			SNAPAI_URL . 'admin/css/snap-ai-admin.css',
			array(),
			$this->version
		);
	}

	/**
	 * Enqueue the admin-specific JS for the SnapAI admin page.
	 *
	 * @since 1.0.0
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_scripts( $hook ) {
		if ( ! $this->is_snapai_admin_page( $hook ) ) {
			return;
		}

		wp_enqueue_script(
			'snapai-admin-script',
			SNAPAI_URL . 'admin/js/snap-ai-admin.js',
			array( 'jquery' ),
			$this->version,
			true
		);

		wp_localize_script(
			'snapai-admin-script',
			'SnapAIAdmin',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'snapai_admin_action' ),
			)
		);
	}

	/**
	 * Add a submenu item "SnapAI Generator" under the Media menu.
	 *
	 * @since 1.0.0
	 */
	public function add_plugin_admin_menu() {
		add_media_page(
			__( 'SnapAI Generator', SNAPAI_TEXT_DOMAIN ),
			__( 'SnapAI Generator', SNAPAI_TEXT_DOMAIN ),
			'upload_files',
			'snap-ai-generator',
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Display the SnapAI Generator admin UI.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page() {
		if ( ! current_user_can( 'upload_files' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', SNAPAI_TEXT_DOMAIN ) );
		}

		include_once SNAPAI_DIR . 'admin/partials/snap-ai-admin-display.php';
	}

	/**
	 * Adds a "Generate with SnapAI" button to the WordPress post editor (Classic/Gutenberg).
	 *
	 * @since 1.0.0
	 */
	public function add_media_button() {
		if ( ! current_user_can( 'upload_files' ) ) {
			return;
		}

		$url = admin_url( 'upload.php?page=snap-ai-generator' );
		echo '<a href="' . esc_url( $url ) . '" target="_blank" class="button button-secondary" style="margin-left:4px;">';
		echo '<span class="dashicons dashicons-format-image" style="vertical-align:middle;"></span> ';
		echo esc_html__( 'Generate with SnapAI', SNAPAI_TEXT_DOMAIN );
		echo '</a>';
	}

	/**
	 * (Optional) Enqueue Gutenberg block editor JS to add the SnapAI button.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_gutenberg_assets() {
		if ( ! current_user_can( 'upload_files' ) ) {
			return;
		}

		wp_enqueue_script(
			'snapai-gutenberg-js',
			SNAPAI_URL . 'admin/js/snap-ai-gutenberg.js',
			array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components' ),
			$this->version,
			true
		);

		wp_localize_script(
			'snapai-gutenberg-js',
			'SnapAIGutenberg',
			array(
				'admin_url' => admin_url( 'upload.php?page=snap-ai-generator' ),
				'nonce'     => wp_create_nonce( 'snapai_admin_action' ),
			)
		);
	}

	/**
	 * Handles AJAX request to generate an image and save to media library (placeholder).
	 *
	 * @since 1.0.0
	 */
	public function ajax_generate_image() {
		check_admin_referer( 'snapai_admin_action', 'security' );

		if ( ! current_user_can( 'upload_files' ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Permission denied.', SNAPAI_TEXT_DOMAIN ),
				)
			);
			wp_die();
		}

		// Placeholder functionality
		wp_send_json_success( array( 'message' => __( 'AJAX handler is not implemented yet.', SNAPAI_TEXT_DOMAIN ) ) );
		wp_die();
	}

	/**
	 * Helper: Determines if we are on the SnapAI plugin admin page.
	 *
	 * @since 1.0.0
	 * @param  string $hook The current page hook suffix.
	 * @return bool
	 */
	private function is_snapai_admin_page( $hook ) {
		return ( 'media_page_snap-ai-generator' === $hook );
	}
}
```

**Usage notes**:
- All "snapai" URLs/constants presume your main plugin file defines `SNAPAI_URL` and `SNAPAI_DIR`.
- Add to your plugin loader, e.g.:
    ```php
    $snapai_admin = new Snap_AI_Admin( 'snap-ai', SNAPAI_VERSION );
    // Hook up:
    add_action( 'admin_menu', [ $snapai_admin, 'add_plugin_admin_menu' ] );
    add_action( 'admin_enqueue_scripts', [ $snapai_admin, 'enqueue_styles' ] );
    add_action( 'admin_enqueue_scripts', [ $snapai_admin, 'enqueue_scripts' ] );
    add_action( 'media_buttons', [ $snapai_admin, 'add_media_button' ] );
    add_action( 'enqueue_block_editor_assets', [ $snapai_admin, 'enqueue_gutenberg_assets' ] );
    add_action( 'wp_ajax_snap_ai_generate_image', [ $snapai_admin, 'ajax_generate_image' ] );
    ```
- The Gutenberg button and partials are referenced and should be added as files when you modularize your plugin.
- All methods are fully documented and security-checked.
