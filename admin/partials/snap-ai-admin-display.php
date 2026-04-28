```php
<?php
/**
 * Admin Page Partial: SnapAI Generator UI
 *
 * @package    SnapAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="wrap snap-ai-admin-container">
	<h2><?php esc_html_e( 'SnapAI - Free Image Generator', SNAPAI_TEXT_DOMAIN ); ?></h2>
	<p class="description"><?php esc_html_e( 'Describe the image you want, choose a style, and let SnapAI generate AI-powered visuals for your site. Unlimited, copyright-free images via Pollinations.ai!', SNAPAI_TEXT_DOMAIN ); ?></p>

	<form id="snap-ai-generator-form" method="post" action="#" onsubmit="return false;" style="max-width: 600px;">

		<?php wp_nonce_field( 'snapai_admin_action', 'snapai_admin_nonce' ); ?>

		<div class="card" style="padding:24px 24px 12px 24px; margin-bottom: 16px;">
			<label for="snap-ai-prompt"><strong><?php esc_html_e( 'Describe Your Image', SNAPAI_TEXT_DOMAIN ); ?></strong></label>
			<textarea id="snap-ai-prompt" class="regular-text" rows="3" style="width:100%;min-height:80px;" placeholder="<?php esc_attr_e( 'e.g. surreal mountain landscape, sunrise, vivid colors', SNAPAI_TEXT_DOMAIN ); ?>"></textarea>
		</div>

		<div style="display: flex; gap: 16px; margin-bottom: 16px;">
			<div>
				<label for="snap-ai-aspect"><?php esc_html_e( 'Aspect Ratio', SNAPAI_TEXT_DOMAIN ); ?></label><br>
				<select id="snap-ai-aspect" class="regular-text">
					<option value="1:1"><?php esc_html_e( 'Square (1:1)', SNAPAI_TEXT_DOMAIN ); ?></option>
					<option value="16:9"><?php esc_html_e( 'Landscape (16:9)', SNAPAI_TEXT_DOMAIN ); ?></option>
					<option value="9:16"><?php esc_html_e( 'Portrait (9:16)', SNAPAI_TEXT_DOMAIN ); ?></option>
				</select>
			</div>
			<div>
				<label for="snap-ai-style"><?php esc_html_e( 'Image Style', SNAPAI_TEXT_DOMAIN ); ?></label><br>
				<select id="snap-ai-style" class="regular-text">
					<option value="realistic"><?php esc_html_e( 'Realistic', SNAPAI_TEXT_DOMAIN ); ?></option>
					<option value="3d render"><?php esc_html_e( '3D Render', SNAPAI_TEXT_DOMAIN ); ?></option>
					<option value="anime"><?php esc_html_e( 'Anime', SNAPAI_TEXT_DOMAIN ); ?></option>
					<option value="cyberpunk"><?php esc_html_e( 'Cyberpunk', SNAPAI_TEXT_DOMAIN ); ?></option>
					<option value="oil painting"><?php esc_html_e( 'Oil Painting', SNAPAI_TEXT_DOMAIN ); ?></option>
				</select>
			</div>
		</div>

		<button type="button" class="button button-primary button-large" style="margin-bottom:16px;" id="snap-ai-generate-btn">
			<?php esc_html_e( 'Generate Magic Image', SNAPAI_TEXT_DOMAIN ); ?>
		</button>

		<span id="snap-ai-loading" style="display:none;vertical-align:middle;margin-left:10px;">
			<span class="spinner is-active" style="float:none;margin:0;"></span>
			<?php esc_html_e( 'Generating... please wait.', SNAPAI_TEXT_DOMAIN ); ?>
		</span>
	</form>

	<div id="snap-ai-preview-area" class="card" style="display:none; margin-top:24px; max-width: 600px; padding: 20px; text-align:center;">
		<h3><?php esc_html_e( 'Preview', SNAPAI_TEXT_DOMAIN ); ?></h3>
		<img id="snap-ai-generated-image" src="" alt="" style="max-width:100%;height:auto;display:block;margin:auto;box-shadow:0 2px 8px rgba(0,0,0,0.07);margin-bottom:16px;">
		<div style="margin-top:12px;">
			<button type="button" id="snap-ai-save-btn" class="button button-primary" style="display:none;">
				<?php esc_html_e( 'Save to Media Library', SNAPAI_TEXT_DOMAIN ); ?>
			</button>
			<button type="button" id="snap-ai-download-btn" class="button" style="display:none;margin-left:8px;">
				<?php esc_html_e( 'Download', SNAPAI_TEXT_DOMAIN ); ?>
			</button>
		</div>
	</div>
</div>
```

**Instructions & Features**:
- This file is secure, native-looking, clean, and ready for AJAX integration.
- The preview/image controls are hidden by default (shown via JS after generation).
- All interactive elements use WordPress admin classes for excellent native feel.
- Nonce is included for secure requests.
- Inline styles are minimal and only for layout clarity—integrate/override in your CSS if needed.
