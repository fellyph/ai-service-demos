<?php
/**
 * Plugin Name:       Example Interactive TypeScript
 * Description:       An interactive block with the Interactivity API using TypeScript.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       example-interactive-typescript
 * Requires Plugins:  ai-services
 *
 * @package           interactive-ai-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function interactive_ai_api_example_interactive_typescript_block_init() {
	register_block_type_from_metadata( __DIR__ . '/build' );
}
add_action( 'init', 'interactive_ai_api_example_interactive_typescript_block_init' );
