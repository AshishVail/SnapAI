```php
<?php
/**
 * SnapAI API and Media Handler
 *
 * Handles AJAX, Pollinations.ai image generation, and saving images to the Media Library.
 *
 * @package    SnapAI
 * @subpackage Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Snap_AI_API
 *
 * Handles backend AJAX, Pollinations.ai URL generation, and Media Library integration for SnapAI.
 */
class Snap_AI_API {

	/**
	 * Register AJAX actions for image generation and saving.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_ajax_hooks() {
		add_action( 'wp_ajax_snap_ai_generate_image', array( $this, 'ajax_generate_image' ) );
		add_action( 'wp_ajax_snap_ai_save_image', array( $this, 'ajax_save_image' ) );
	}

	/**
	 * Handle AJAX request to generate a Pollinations.ai image URL.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ajax_generate_image() {
		check_ajax_referer( 'snapai_admin_action', 'security' );
		if ( ! current_user_can( 'upload_files' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', SNAPAI_TEXT_DOMAIN ) ) );
		}

		$prompt     = isset( $_POST['prompt'] ) ? sanitize_text_field( wp_unslash( $_POST['prompt'] ) ) : '';
		$aspect     = isset( $_POST['aspect'] ) ? sanitize_text_field( wp_unslash( $_POST['aspect'] ) ) : '1:1';
		$style      = isset( $_POST['style'] ) ? sanitize_text_field( wp_unslash( $_POST['style'] ) ) : 'realistic';

		if ( empty( $prompt ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter a prompt.', SNAPAI_TEXT_DOMAIN ) ) );
		}

		$image_url = $this->generate_ai_image_url( $prompt, $aspect, $style );
		if ( ! $image_url ) {
			wp_send_json_error( array( 'message' => __( 'Failed to generate image URL.', SNAPAI_TEXT_DOMAIN ) ) );
		}

		wp_send_json_success( array(
			'image_url' => esc_url( $image_url ),
			'alt_text'  => $prompt,
		) );
	}

	/**
	 * Generate the Pollinations.ai image URL.
	 *
	 * @since 1.0.0
	 * @param string $prompt      The user prompt for image.
	 * @param string $aspect      Aspect ratio: 1:1, 16:9, 9:16.
	 * @param string $style       Style: realistic, 3d render, anime, etc.
	 * @return string|false       The generated image URL or false on failure.
	 */
	public function generate_ai_image_url( $prompt, $aspect, $style ) {
		$base_url = 'https://image.pollinations.ai/prompt/';

		// Map aspect to Pollinations parameters
		switch ( $aspect ) {
			case '16:9':
				$res = 'w=896-h=504';
				break;
			case '9:16':
				$res = 'w=540-h=960';
				break;
			default:
				$res = 'w=640-h=640';
				break;
		}

		$seed = random_int( 100000, 999999 );
		$full_prompt = "{$prompt}, {$style}, {$res}, seed={$seed}";
		$url = $base_url . rawurlencode( $full_prompt );
		return $url;
	}

	/**
	 * Handle AJAX request to save an image to the WordPress Media Library.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ajax_save_image() {
		check_ajax_referer( 'snapai_admin_action', 'security' );
		if ( ! current_user_can( 'upload_files' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', SNAPAI_TEXT_DOMAIN ) ) );
		}

		$image_url = isset( $_POST['image_url'] ) ? esc_url_raw( wp_unslash( $_POST['image_url'] ) ) : '';
		$alt_text  = isset( $_POST['alt_text'] )  ? sanitize_text_field( wp_unslash( $_POST['alt_text'] ) ) : '';

		if ( empty( $image_url ) ) {
			wp_send_json_error( array( 'message' => __( 'Image URL missing.', SNAPAI_TEXT_DOMAIN ) ) );
		}

		$result = $this->save_image_to_library( $image_url, $alt_text );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( $result );
	}

	/**
	 * Download an image and save it to the Media Library,
	 * setting title/alt text based on prompt.
	 *
	 * @since 1.0.0
	 * @param string $image_url  The image URL to download.
	 * @param string $alt_text   Alt text/title for the image.
	 * @return array|WP_Error    Array with attachment ID and URL, or WP_Error.
	 */
	public function save_image_to_library( $image_url, $alt_text = '' ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$tmp = download_url( $image_url );
		if ( is_wp_error( $tmp ) ) {
			return $tmp;
		}

		$file_array = array();
		$file_array['name'] = 'snapai-' . time() . '.jpg';
		$file_array['tmp_name'] = $tmp;

		// 0 = not attached to any post
		$attachment_id = media_handle_sideload( $file_array, 0, $alt_text );

		// Clean up temp file if there was an error
		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $tmp );
			return $attachment_id;
		}

		if ( $alt_text ) {
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt_text );
			wp_update_post( array(
				'ID' => $attachment_id,
				'post_title' => $alt_text,
			) );
		}

		$img_url = wp_get_attachment_url( $attachment_id );
		return array(
			'attachment_id' => $attachment_id,
			'image_url'     => $img_url,
		);
	}

}
```
Place this file at `includes/class-snap-ai-api.php`.  
- The class is fully documented, strictly OOP, and follows WordPress security and coding standards.
- All AJAX responses are proper and secure.  
- Media Library images are SEO-optimized with title/alt text set from the prompt.
