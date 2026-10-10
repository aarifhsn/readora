<?php
/**
 * Template part: No content found
 *
 * @package Readora
 * @since   1.0.0
 */
?>

<div class="tm-empty">
	<h1 class="tm-empty__title">
		<?php
		if (is_search()):
			esc_html_e('Nothing matched your search.', 'readora');
		else:
			esc_html_e('Nothing here yet.', 'readora');
		endif;
		?>
	</h1>

	<p class="tm-empty__text">
		<?php
		if (is_search()):
			printf(
				/* translators: %s: search query */
				esc_html__('No results for "%s". Try different keywords or browse our categories.', 'readora'),
				'<strong>' . esc_html(get_search_query()) . '</strong>'
			);
		else:
			esc_html_e('It looks like nothing was found at this location.', 'readora');
		endif;
		?>
	</p>

	<a class="tm-btn" href="<?php echo esc_url(home_url('/')); ?>">
		<?php esc_html_e('← Back to Homepage', 'readora'); ?>
	</a>
</div>
