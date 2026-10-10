<?php
/**
 * Archive template
 *
 * @package Readora
 * @since   1.0.0
 */

get_header();
readora_breadcrumbs();
?>

<main id="main-content" class="tm-main">
	<div class="tm-container">

		<!-- Archive header -->
		<header class="tm-archive-head">
			<p class="tm-kicker">
				<?php
				if (is_category())
					esc_html_e('Category', 'readora');
				elseif (is_tag())
					esc_html_e('Tag', 'readora');
				elseif (is_author())
					esc_html_e('Author', 'readora');
				elseif (is_year())
					esc_html_e('Year', 'readora');
				elseif (is_month())
					esc_html_e('Month', 'readora');
				elseif (is_day())
					esc_html_e('Date', 'readora');
				else
					esc_html_e('Archive', 'readora');
				?>
			</p>

			<?php
			add_filter('get_the_archive_title_prefix', '__return_empty_string');
			the_archive_title('<h1 class="tm-archive-head__title">', '</h1>');
			remove_filter('get_the_archive_title_prefix', '__return_empty_string');
			?>

			<?php $archive_desc = get_the_archive_description();
			if ($archive_desc): ?>
				<div class="tm-archive-head__desc">
					<?php echo wp_kses_post($archive_desc); ?>
				</div>
			<?php endif; ?>

			<!-- Author bio on author archives -->
			<?php if (is_author()):
				$author = get_queried_object();
				$author_bio = get_the_author_meta('description', $author->ID);
				if ($author_bio): ?>
					<div class="tm-author">
						<?php echo get_avatar($author->ID, 56, '', '', array('class' => 'tm-author__avatar')); ?>
						<div>
							<p class="tm-author__name"><?php echo esc_html($author->display_name); ?></p>
							<p class="tm-author__bio"><?php echo esc_html($author_bio); ?></p>
						</div>
					</div>
				<?php endif;
			endif; ?>
		</header>

		<div class="tm-layout tm-layout--sidebar">
			<div class="tm-primary" id="primary">
				<?php if (have_posts()): ?>
					<div class="tm-grid tm-grid--grid-3 has-sidebar">
						<?php while (have_posts()):
							the_post();
							get_template_part('template-parts/post/card');
						endwhile; ?>
					</div>
					<?php readora_pagination();
				else:
					get_template_part('template-parts/content/none');
				endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>

	</div>
</main>

<?php get_footer(); ?>
