<?php
/**
 * 404 template
 *
 * @package Readora
 * @since   1.0.0
 */

get_header();
?>

<main id="main-content" class="tm-main">
	<div class="tm-container">

		<div class="tm-empty tm-empty--404">
			<p class="tm-kicker">404</p>
			<h1 class="tm-empty__title"><?php esc_html_e('Page Not Found', 'readora'); ?></h1>
			<p class="tm-empty__text">
				<?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'readora'); ?>
			</p>
			<?php get_search_form(); ?>
			<a class="tm-btn tm-btn--ghost" href="<?php echo esc_url(home_url('/')); ?>">
				<?php esc_html_e('← Back to Homepage', 'readora'); ?>
			</a>
		</div>

		<!-- Recent posts fallback -->
		<?php
		$recent = new WP_Query(array(
			'posts_per_page' => 3,
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows' => true,
		));

		if ($recent->have_posts()): ?>
			<section class="tm-more">
				<div class="tm-section-head">
					<h2><?php esc_html_e('Recent Articles', 'readora'); ?></h2>
				</div>
				<div class="tm-grid tm-grid--grid-3">
					<?php while ($recent->have_posts()):
						$recent->the_post();
						get_template_part('template-parts/post/card');
					endwhile;
					wp_reset_postdata(); ?>
				</div>
			</section>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
