```php
<?php
/**
 * The core orchestrator class for the SnapAI plugin.
 *
 * @package    SnapAI
 * @subpackage Includes
 * @author     SnapAI Team
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Snap_AI core plugin class.
 *
 * This class orchestrates plugin setup, dependencies, localization,
 * and hook registration for both admin and frontend.
 */
class Snap_AI {

	/**
	 * Holds the loader that orchestrates the hooks of the plugin.
	 *
	 * @since 1.0.0
	 * @var Snap_AI_Loader
	 */
	private $loader;

	/**
	 * The unique identifier for this plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $version;

	/**
	 * Snap_AI constructor.
	 *
	 * Sets up plugin name and version, loads dependencies, sets locale, and defines admin hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'snap-ai';
		$this->version     = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * This includes the loader, admin, and API classes.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-snap-ai-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-snap-ai-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-snap-ai-api.php';

		$this->loader = new Snap_AI_Loader();
	}

	/**
	 * Define the locale for internationalization.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function set_locale() {
		// Here you would hook textdomain loading if needed.
		// Example:
		// $plugin_i18n = new Snap_AI_i18n();
		// $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Define the admin-specific hooks for the plugin.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Snap_AI_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Optionally, add more admin hooks as the plugin evolves.
	}

	/**
	 * Run the loader to execute all plugin hooks with WordPress.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Get the plugin name.
	 *
	 * @since 1.0.0
	 * @return string Plugin name.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get the plugin loader.
	 *
	 * @since 1.0.0
	 * @return Snap_AI_Loader Loader instance.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Get the plugin version.
	 *
	 * @since 1.0.0
	 * @return string Plugin version.
	 */
	public function get_version() {
		return $this->version;
	}
}
```
This class can be dropped into `includes/class-snap-ai.php` and matches your structural, documentation, and loading requirements.
