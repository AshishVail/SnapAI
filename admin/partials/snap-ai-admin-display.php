<?php
/**
 * Admin Page Partial: SnapAI Generator UI
 * Save this file as: admin/partials/snap-ai-admin-display.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">
	<h1 style="margin-bottom: 20px;">SnapAI - Free Image Generator</h1>
	<p>Describe the image you want, choose a style, and let AI generate it for you.</p>

	<div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; max-width: 600px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
		
		<div style="margin-bottom: 15px;">
			<label style="display: block; font-weight: bold; margin-bottom: 5px;">Describe Your Image</label>
			<textarea id="snap-ai-prompt" style="width: 100%; min-height: 100px;" placeholder="e.g. A futuristic city with flying cars, sunset, cinematic lighting"></textarea>
		</div>

		<div style="display: flex; gap: 20px; margin-bottom: 20px;">
			<div style="flex: 1;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Aspect Ratio</label>
				<select id="snap-ai-aspect" style="width: 100%;">
					<option value="1:1">Square (1:1)</option>
					<option value="16:9">Landscape (16:9)</option>
					<option value="9:16">Portrait (9:16)</option>
				</select>
			</div>
			<div style="flex: 1;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Style</label>
				<select id="snap-ai-style" style="width: 100%;">
					<option value="realistic">Realistic</option>
					<option value="3d-render">3D Render</option>
					<option value="anime">Anime</option>
					<option value="cyberpunk">Cyberpunk</option>
				</select>
			</div>
		</div>

		<button type="button" id="snap-ai-generate-btn" class="button button-primary button-large">
			Generate Magic Image
		</button>

		<span id="snap-ai-loader" style="display: none; margin-left: 10px; vertical-align: middle;">
			<span class="spinner is-active" style="float: none;"></span> Generating...
		</span>
	</div>

	<div id="snap-ai-preview-area" style="display: none; margin-top: 30px; max-width: 600px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; text-align: center;">
		<h3>Preview</h3>
		<img id="snap-ai-generated-image" src="" style="max-width: 100%; height: auto; border-radius: 4px;">
		<div style="margin-top: 15px;">
			<button id="snap-ai-save-btn" class="button button-primary">Save to Media Library</button>
		</div>
	</div>
</div>
