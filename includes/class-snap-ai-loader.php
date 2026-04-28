```php
<?php
/**
 * Registers and executes all hooks for the SnapAI plugin.
 *
 * @package    SnapAI
 * @subpackage Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Snap_AI_Loader
 *
 * Orchestrates WordPress actions and filters for SnapAI plugin.
 */
class Snap_AI_Loader {

	/**
	 * The array of actions to be registered with WordPress.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $actions = array();

	/**
	 * The array of filters to be registered with WordPress.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $filters = array();

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// No initialization required.
	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since 1.0.0
	 * @param string   $hook         The name of the WordPress action.
	 * @param object   $component    The instance of the object on which the callback is fired.
	 * @param string   $callback     The callback method name on the component.
	 * @param int      $priority     The priority at which to execute the callback.
	 * @param int      $accepted_args The number of accepted arguments.
	 * @return void
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since 1.0.0
	 * @param string   $hook         The name of the WordPress filter.
	 * @param object   $component    The instance of the object on which the callback is fired.
	 * @param string   $callback     The callback method name on the component.
	 * @param int      $priority     The priority at which to execute the callback.
	 * @param int      $accepted_args The number of accepted arguments.
	 * @return void
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a hook (action or filter) to the appropriate collection.
	 *
	 * @since 1.0.0
	 * @param array  &$hooks       The collection of hooks (actions/filters).
	 * @param string $hook         The name of the WordPress hook.
	 * @param object $component    The instance of the object on which the callback is fired.
	 * @param string $callback     The callback method name.
	 * @param int    $priority     Priority (default: 10).
	 * @param int    $accepted_args Number of accepted args (default: 1).
	 * @return void
	 */
	private function add( &$hooks, $hook, $component, $callback, $priority, $accepted_args ) {
		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);
	}

	/**
	 * Register the actions and filters with WordPress.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function run() {
		foreach ( $this->filters as $hook ) {
			add_filter(
				$hook['hook'],
				array( $hook['component'], $hook['callback'] ),
				$hook['priority'],
				$hook['accepted_args']
			);
		}

		foreach ( $this->actions as $hook ) {
			add_action(
				$hook['hook'],
				array( $hook['component'], $hook['callback'] ),
				$hook['priority'],
				$hook['accepted_args']
			);
		}
	}
}
```
This class should be saved as `includes/class-snap-ai-loader.php`, is strict OOP, secure, WordPress standards–compliant, and fully documented.
