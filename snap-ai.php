<?php
/**
 * Plugin Name:       SnapAI
 * Plugin URI:        https://github.com/AshishVail/snapai
 * Description:       A high-performance AI Image Generator for WordPress using Pollinations.ai. Generate unlimited featured images and post graphics for free.
 * Version:           1.0.0
 * Author:            SnapAI Team
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       snap-ai
 */

// Security: Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants
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
 * Main plugin initializer for SnapAI
 */
function snapai_init_plugin() {
	// Explicit dependency paths
	$loader_file   = plugin_dir_path( __FILE__ ) . 'includes/class-snap-ai-loader.php';
	$api_file      = plugin_dir_path( __FILE__ ) . 'includes/class-snap-ai-api.php';
	$admin_file    = plugin_dir_path( __FILE__ ) . 'admin/class-snap-ai-admin.php';

	// If crucial admin dependency does not exist, abort initialization
	if ( ! file_exists( $admin_file ) ) {
		return;
	}

	// Load required files (suppress errors if missing, except admin)
	if ( file_exists( $loader_file ) ) {
		require_once $loader_file;
	}
	if ( file_exists( $api_file ) ) {
		require_once $api_file;
	}
	require_once $admin_file;

	if ( ! class_exists( 'Snap_AI_Final_Version' ) ) {
		/**
		 * Core plugin class - Snap_AI_Final_Version
		 * (All-in-one entry, compatible, OOP-lite)
		 */
		class Snap_AI_Final_Version {

			public function __construct() {
				add_action( 'admin_menu', array( $this, 'add_admin_menu_entry' ) );
				add_action( 'plugins_loaded', array( $this, 'plugin_late_init' ) );
			}

			/**
			 * Add SnapAI Generator submenu under Media
			 */
			public function add_admin_menu_entry() {
				add_media_page(
					__( 'SnapAI Generator', 'snap-ai' ),
					__( 'SnapAI Generator', 'snap-ai' ),
					'upload_files',
					'snap-ai-generator',
					array( $this, 'render_admin_ui' )
				);
			}

			/**
			 * Render the SnapAI admin dashboard UI page, check for UI partial.
			 */
			public function render_admin_ui() {
				if ( ! current_user_can( 'upload_files' ) ) {
					wp_die( esc_html__( 'You do not have permission to access this page.', 'snap-ai' ) );
				}
				$ui_partial = plugin_dir_path( __FILE__ ) . 'admin/partials/snap-ai-admin-display.php';
				if ( file_exists( $ui_partial ) ) {
					include $ui_partial;
				} else {
					echo '<div class="notice notice-error"><p>' .
						esc_html__( 'UI not found: admin/partials/snap-ai-admin-display.php', 'snap-ai' ) .
						'</p></div>';
				}
			}

			/**
			 * Initialize AJAX hooks, admin class, and other plugin setup.
			 */
			public function plugin_late_init() {
				if ( class_exists( 'Snap_AI_API' ) ) {
					$snapai_api = new Snap_AI_API();
					if ( method_exists( $snapai_api, 'register_ajax_hooks' ) ) {
						$snapai_api->register_ajax_hooks();
					}
				}
				// You can instantiate admin class for enqueue hooks here as needed
				if ( class_exists( 'Snap_AI_Admin' ) ) {
					// For enqueueing scripts/styles or registering more complex hooks on admin_init, etc.
					// Example:
					//$snapai_admin = new Snap_AI_Admin( 'snap-ai', SNAPAI_VERSION );
					//add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_styles' ) );
					//add_action( 'admin_enqueue_scripts', array( $snapai_admin, 'enqueue_scripts' ) );
				}
			}
		}
	} // end if class_exists

	// Initialize plugin main class
	new Snap_AI_Final_Version();
}
add_action( 'plugins_loaded', 'snapai_init_plugin' );

/**
 * Plugin activation hook.
 */
function snapai_activate() {
	// Set up options or other tasks if needed
}
register_activation_hook( __FILE__, 'snapai_activate' );
```

**Key Notes:**
- Explicit `require_once` calls with `plugin_dir_path( __FILE__ )` for absolute, reliable pathing.
- Checks for `admin/class-snap-ai-admin.php` before proceeding, preventing fatal errors.
- No nullable or strict return type syntax.
- Everything is compatible with PHP 7.0+ and avoids modern PHP or namespace features.
- Activation hook is outside the class and always references `__FILE__`.
- The main plugin loader class is uniquely named for total compatibility and to avoid collisions.
- No fatal errors if dependencies are missing—plugin fails gracefully.
