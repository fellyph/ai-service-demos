<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Generates a unique id for aria-controls.
$unique_id = wp_unique_id( 'p-' );

// Adds the global state.
wp_interactivity_state(
	'interactive-ai-api',
	array(
		'isDark'    => false,
		'darkText'  => esc_html__( 'Switch to Light', 'example-interactive-typescript' ),
		'lightText' => esc_html__( 'Switch to Dark', 'example-interactive-typescript' ),
		'themeText'	=> esc_html__( 'Switch to Dark', 'example-interactive-typescript' ),
	)
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="interactive-ai-api"
	<?php echo wp_interactivity_data_wp_context( array( 'isOpen' => false ) ); ?>
	data-wp-watch="callbacks.logIsOpen"
	data-wp-class--dark-theme="state.isDark"
>
	<button
		data-wp-on--click="actions.toggleTheme"
		data-wp-text="state.themeText"
	></button>

	<button
		data-wp-on--click="actions.toggleOpen"
		data-wp-bind--aria-expanded="context.isOpen"
		aria-controls="<?php echo esc_attr( $unique_id ); ?>"
	>
		<?php esc_html_e( 'Toggle', 'example-interactive-typescript' ); ?>
	</button>

	<p
		id="<?php echo esc_attr( $unique_id ); ?>"
		data-wp-bind--hidden="!context.isOpen"
	>
		<?php
			esc_html_e( 'Example Interactive TypeScript - hello from an interactive block!', 'example-interactive-typescript' );
		?>
	</p>
</div>
