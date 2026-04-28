```php
<?php
/**
 * Plugin Name:       SnapAI
 * Plugin URI:        https://nexovent.tech
 * Description:       A high-performance AI Image Generator for WordPress using Pollinations.ai. Generate unlimited featured images and post graphics for free.
 * Version:           1.0.0
 * Author:            SnapAI Team
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       snap-ai
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants.
if ( ! defined( 'SNAPAI_VERSION' ) ) {
	define( 'SNAPAI_VERSION', '1.0.0' );
}
if ( ! defined( 'SNAPAI_DIR_PATH' ) ) {
	define( 'SNAPAI_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'SNAPAI_URL' ) ) {
	define( 'SNAPAI_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Safely include modular PHP files if they exist.
 *
 * @param string $file Relative path from plugin root.
 */
function snapai_safe_require( $file ) {
	$full_path = SNAPAI_DIR_PATH . ltrim( $file, '/\\' );
	if ( file_exists( $full_path ) ) {
		require_once $full_path;
	}
}

/**
 * Load all SnapAI dependencies/components in order.
 */
function snapai_load_dependencies() {
	snapai_safe_require( 'includes/class-snap-ai-loader.php' );
	snapai_safe_require( 'includes/class-snap-ai-api.php' );
	snapai_safe_require( 'admin/class-snap-ai-admin.php' );

	// Register AJAX endpoints only if related classes/methods are available.
	if ( class_exists( 'Snap_AI_API' ) ) {
		$snapai_api = new Snap_AI_API();
		if ( method_exists( $snapai_api, 'register_ajax_hooks' ) ) {
			$snapai_api->register_ajax_hooks();
		}
	}
}
add_action( 'plugins_loaded', 'snapai_load_dependencies' );

/**
 * Add SnapAI Generator submenu under the Media menu.
 */
function snapai_add_media_submenu() {
	add_media_page(
		__( 'SnapAI Generator', 'snap-ai' ),
		__( 'SnapAI Generator', 'snap-ai' ),
		'upload_files',
		'snap-ai-generator',
		'snapai_render_admin_page'
	);
}
add_action( 'admin_menu', 'snapai_add_media_submenu' );

/**
 * Render the SnapAI admin dashboard UI page.
 */
function snapai_render_admin_page() {
	if ( ! current_user_can( 'upload_files' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'snap-ai' ) );
	}
	$ui_partial = SNAPAI_DIR_PATH . 'admin/partials/snap-ai-admin-display.php';
	if ( file_exists( $ui_partial ) ) {
		include $ui_partial;
	} else {
		echo '<div class="notice notice-error"><p>' .
			esc_html__( 'UI partial not found: admin/partials/snap-ai-admin-display.php', 'snap-ai' ) .
			'</p></div>';
	}
}
```
**Notes:**
- ABSPATH check for security.
- Constants use plugin_dir_path and plugin_dir_url for portability.
- Modular files are included only if they exist (`file_exists` to avoid fatal errors).
- All class/function calls check existence before use.
- Menu and UI partial integration are robust.
- All logic is PHP 7.4+ compatible and avoids strict or nullable types.
