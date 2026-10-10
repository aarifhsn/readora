<?php
/**
 * Search results template
 *
 * @package Readora
 * @since   1.0.0
 */

get_header();
readora_breadcrumbs();
?>

<main id="main-content" class="tm-main">
	<div class="tm-container">

		<header class="tm-archive-head">
			<p class="tm-kicker"><?php esc_html_e('Search', 'readora'); ?></p>
			<h1 class="tm-archive-head__title">
				<?php printf(
					/* translators: %s: search query */
					esc_html__('Results for: %s', 'readora'),
					'<span class="tm-archive-head__query">' . esc_html(get_search_query()) . '</span>'
				); ?>
			</h1>
			<?php if (have_posts()): ?>
				<p class="tm-archive-head__desc">
					<?php printf(
						esc_html(_n('%d result found', '%d results found', (int) $wp_query->found_posts, 'readora')),
						(int) $wp_query->found_posts
					); ?>
				</p>
			<?php endif; ?>
			<div class="tm-archive-head__search"><?php get_search_form(); ?></div>
		</header>

		<div class="tm-layout tm-layout--sidebar">
			<div class="tm-primary" id="primary">

				<?php if (have_posts()): ?>
					<div class="tm-grid tm-grid--list has-sidebar">
						<?php while (have_posts()):
							the_post();
							get_template_part('template-parts/post/card', 'list');
						endwhile; ?>
					</div>
					<?php readora_pagination();

				else: ?>
					<div class="tm-empty">
						<h2 class="tm-empty__title"><?php esc_html_e('No results found', 'readora'); ?></h2>
						<p class="tm-empty__text">
							<?php printf(
								esc_html__('No articles matched "%s". Try different keywords or browse categories below.', 'readora'),
								'<strong>' . esc_html(get_search_query()) . '</strong>'
							); ?>
						</p>
						<?php get_search_form(); ?>
						<ul class="tm-empty__cats">
							<?php wp_list_categories(array(
								'title_li' => '',
								'orderby' => 'count',
								'order' => 'DESC',
								'number' => 6,
							)); ?>
						</ul>
					</div>
				<?php endif; ?>

			</div>

			<?php get_sidebar(); ?>
		</div>

	</div>
</main>

<?php get_footer(); ?>
