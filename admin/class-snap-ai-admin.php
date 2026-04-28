<?php
/**
 * Admin logic for SnapAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Snap_AI_Admin {

	/**
	 * Constructor to set basic properties
	 */
	public function __construct() {
		// Currently empty to avoid errors
	}

	/**
	 * Adds the menu under 'Media'
	 */
	public function add_plugin_admin_menu() {
		add_media_page(
			'SnapAI Generator', 
			'SnapAI',           
			'upload_files',     
			'snap-ai-generator', 
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Content of the Admin Page
	 */
	public function display_plugin_admin_page() {
		if ( ! current_user_can( 'upload_files' ) ) {
			wp_die( 'You do not have permission to access this page.' );
		}

		echo '<div class="wrap">';
		echo '<h1>SnapAI Generator</h1>';
		echo '<p>The admin class is successfully loaded!</p>';
		echo '<p>Next, we will connect the CSS and JS files.</p>';
		echo '</div>';
	}
}
