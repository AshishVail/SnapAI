```php
<?php
/**
 * Admin functionality for the SnapAI plugin.
 *
 * @package    SnapAI
 * @subpackage Admin
 */

defined( 'ABSPATH' ) || exit;

class Snap_AI_Admin {

	/**
	 * The plugin name.
	 *
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The plugin version.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor.
	 *
	 * @param string $plugin_name The plugin name.
	 * @param string $version     The plugin version.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Enqueue the admin styles for the SnapAI plugin.
	 *
	 * @param string $hook The current admin page.
	 */
	public function enqueue_styles( $hook ) {
		wp_register_style(
			'snapai-admin-style',
			SNAPAI_URL . 'assets/css/snap-ai-admin.css',
			array(),
			$this->version
		);
		wp_enqueue_style( 'snapai-admin-style' );
	}

	/**
	 * Enqueue the admin scripts for the SnapAI plugin.
	 *
	 * @param string $hook The current admin page.
	 */
	public function enqueue_scripts( $hook ) {
		wp_register_script(
			'snapai-admin-script',
			SNAPAI_URL . 'assets/js/snap-ai-admin.js',
			array( 'jquery' ),
			$this->version,
			true
		);
		wp_enqueue_script( 'snapai-admin-script' );

		// Localize variables for AJAX and translatable strings if needed.
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
	 * Add SnapAI Generator admin menu under the Media menu.
	 */
	public function add_plugin_admin_menu() {
		add_media_page(
			__( 'SnapAI Generator', 'snap-ai' ),
			__( 'SnapAI Generator', 'snap-ai' ),
			'upload_files',
			'snap-ai-generator',
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Display the SnapAI admin page.
	 */
	public function display_plugin_admin_page() {
		$partial = SNAPAI_DIR_PATH . 'admin/partials/snap-ai-admin-display.php';
		if ( file_exists( $partial ) ) {
			include $partial;
		} else {
			echo '<div class="notice notice-error"><p>' .
				esc_html__( 'SnapAI admin UI not found.', 'snap-ai' ) .
			'</p></div>';
		}
	}
}
```
This file is **fully compatible with PHP 7.0+,** avoids all modern type/nullable features, and implements the exact methods needed for stable SnapAI admin integration.
