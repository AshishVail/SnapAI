```javascript
/**
 * snap-ai-admin.js
 * Handles AJAX image generation and workflow for SnapAI WordPress plugin.
 */

jQuery(document).ready(function ($) {
	/**
	 * Show a WordPress-style admin notice (alert replacement).
	 * @param {string} message
	 */
	function snapAIShowNotice(message) {
		let $container = $('.snap-ai-admin-container');
		let $notice = $('<div class="notice notice-error is-dismissible"><p></p></div>');
		$notice.find('p').text(message);
		$container.prepend($notice);
		$notice.on('click', '.notice-dismiss', function () {
			$notice.remove();
		});
	}

	let generatedImageURL = '';
	let generatedAltText = '';

	$('#snap-ai-generate-btn').on('click', function (e) {
		e.preventDefault();
		// Gather values
		const prompt = $('#snap-ai-prompt').val().trim();
		const aspect = $('#snap-ai-aspect').val();
		const style  = $('#snap-ai-style').val();
		const nonce  = $('#snapai_admin_nonce').val();

		// Validation
		if (!prompt) {
			snapAIShowNotice(snapAIAdminVars.prompt_required || 'Please enter a description for your image.');
			return;
		}

		// UI: Loading state
		$(this).prop('disabled', true);
		$('#snap-ai-loading').show();
		$('#snap-ai-preview-area').hide();
		$('#snap-ai-generated-image').attr('src', '').hide();
		$('#snap-ai-save-btn, #snap-ai-download-btn').hide();
		generatedImageURL = '';
		generatedAltText = '';

		// AJAX call to generate the image
		$.ajax({
			method: 'POST',
			url: SnapAIAdmin.ajax_url,
			dataType: 'json',
			data: {
				action: 'snap_ai_generate_image',
				security: nonce,
				prompt: prompt,
				aspect: aspect,
				style: style
			}
		})
		.done(function (response) {
			$('#snap-ai-generate-btn').prop('disabled', false);
			$('#snap-ai-loading').hide();

			if (response.success && response.data && response.data.image_url) {
				generatedImageURL = response.data.image_url;
				generatedAltText = response.data.alt_text ? response.data.alt_text : prompt;

				$('#snap-ai-generated-image')
					.attr('src', generatedImageURL)
					.attr('alt', generatedAltText)
					.show();
				$('#snap-ai-preview-area').show();
				$('#snap-ai-save-btn, #snap-ai-download-btn').show();
			} else {
				let msg = response.data && response.data.message ? response.data.message : (snapAIAdminVars.error_occurred || 'An error occurred while generating the image.');
				snapAIShowNotice(msg);
				$('#snap-ai-preview-area').hide();
			}
		})
		.fail(function (xhr) {
			$('#snap-ai-generate-btn').prop('disabled', false);
			$('#snap-ai-loading').hide();

			let msg = snapAIAdminVars.error_occurred || 'An error occurred while generating the image.';
			if (xhr && xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
				msg = xhr.responseJSON.data.message;
			}
			snapAIShowNotice(msg);
		});
	});

	// Download button
	$('#snap-ai-download-btn').on('click', function () {
		if (!generatedImageURL) {
			return;
		}
		const a = document.createElement('a');
		a.href = generatedImageURL;
		a.download = 'snapai-image.jpg';
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
	});

	// Save to Media Library button
	$('#snap-ai-save-btn').on('click', function (e) {
		e.preventDefault();
		const nonce = $('#snapai_admin_nonce').val();
		if (!generatedImageURL) {
			snapAIShowNotice(snapAIAdminVars.generate_first || 'Please generate an image before saving.');
			return;
		}

		$(this).prop('disabled', true).text(snapAIAdminVars.saving || 'Saving...');
		$('#snap-ai-download-btn').prop('disabled', true);

		$.ajax({
			method: 'POST',
			url: SnapAIAdmin.ajax_url,
			dataType: 'json',
			data: {
				action: 'snap_ai_save_image',
				security: nonce,
				image_url: generatedImageURL,
				alt_text: generatedAltText
			}
		})
		.done(function (response) {
			$('#snap-ai-save-btn').prop('disabled', false).text(snapAIAdminVars.save_to_library || 'Save to Media Library');
			$('#snap-ai-download-btn').prop('disabled', false);

			if (response.success) {
				snapAIShowNotice(snapAIAdminVars.saved_success || 'Image saved to Media Library!');
			} else {
				let msg = response.data && response.data.message ? response.data.message : (snapAIAdminVars.save_failed || 'Failed to save image.');
				snapAIShowNotice(msg);
			}
		})
		.fail(function (xhr) {
			$('#snap-ai-save-btn').prop('disabled', false).text(snapAIAdminVars.save_to_library || 'Save to Media Library');
			$('#snap-ai-download-btn').prop('disabled', false);

			let msg = snapAIAdminVars.save_failed || 'Failed to save image.';
			if (xhr && xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
				msg = xhr.responseJSON.data.message;
			}
			snapAIShowNotice(msg);
		});
	});
});
```

**Notes:**
- The JS expects that `SnapAIAdmin` and optionally `snapAIAdminVars` (with extra strings like `prompt_required`) are localized in your PHP.
- Add a WordPress AJAX handler for `snap_ai_save_image` to save the image in your plugin.
- Button and loading states follow WP admin style.
- All selectors match your form layout.
