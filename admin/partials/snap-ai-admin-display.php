<?php
/**
 * Admin Page Partial: SnapAI Generator UI
 * Path: admin/partials/snap-ai-admin-display.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<div class="wrap">
    <h1 class="wp-heading-inline">SnapAI Image Generator</h1>
    <hr class="wp-header-end">

    <div id="snapai-main-container" style="margin-top: 20px; max-width: 800px;">
        
        <div class="card" style="padding: 20px; margin-bottom: 20px;">
            <h2>Create Your Image</h2>
            <p>Enter a detailed prompt below. Choose your preferred style and aspect ratio to generate a high-quality AI image.</p>
        </div>

        <div class="card" style="padding: 20px;">
            <form id="snap-ai-form">
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="snap-ai-prompt">Image Description</label>
                            </th>
                            <td>
                                <textarea id="snap-ai-prompt" name="prompt" rows="4" class="large-text" placeholder="e.g. A futuristic robot drinking coffee in a neon-lit cafe, cinematic lighting, 8k..."></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="snap-ai-aspect">Aspect Ratio</label>
                            </th>
                            <td>
                                <select id="snap-ai-aspect" name="aspect">
                                    <option value="1:1">Square (1:1)</option>
                                    <option value="16:9">Landscape (16:9)</option>
                                    <option value="9:16">Portrait (9:16)</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="snap-ai-style">Art Style</label>
                            </th>
                            <td>
                                <select id="snap-ai-style" name="style">
                                    <option value="realistic">Realistic Photography</option>
                                    <option value="anime">Anime / Manga</option>
                                    <option value="cyberpunk">Cyberpunk</option>
                                    <option value="3d-render">3D Render</option>
                                    <option value="oil-painting">Oil Painting</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="submit">
                    <button type="button" id="snap-ai-generate-btn" class="button button-primary button-large">Generate Image</button>
                    <span id="snap-ai-loader" style="display: none; margin-left: 10px; vertical-align: middle;">
                        <span class="spinner is-active" style="float: none;"></span>
                        Generating...
                    </span>
                </p>
            </form>
        </div>

        <div id="snap-ai-preview-container" class="card" style="display: none; margin-top: 30px; padding: 20px; text-align: center;">
            <h3>Generated Preview</h3>
            <div id="snap-ai-image-wrapper" style="margin-bottom: 20px;">
                <img id="snap-ai-result-img" src="" style="max-width: 100%; height: auto; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            </div>
            <button type="button" id="snap-ai-save-media" class="button button-secondary">Save to Media Library</button>
        </div>

    </div>
</div>
