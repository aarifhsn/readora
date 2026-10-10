<?php
/**
 * Static page template
 *
 * @package Readora
 * @since   1.0.0
 */

$readora_page_sidebar = (bool) get_theme_mod('readora_page_sidebar', false);

get_header();
readora_breadcrumbs();
?>

<main id="main-content" class="tm-main">
	<div class="tm-container">
		<div class="tm-layout<?php echo $readora_page_sidebar ? ' tm-layout--sidebar' : ''; ?>">

			<div class="tm-primary" id="primary">
				<?php while (have_posts()):
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('tm-single tm-page'); ?>>

						<header class="tm-single__header">
							<h1 class="tm-single__title"><?php the_title(); ?></h1>
						</header>

						<?php if (has_post_thumbnail()): ?>
							<figure class="tm-single__hero">
								<?php the_post_thumbnail('readora-featured', array(
									'loading' => 'eager',
									'fetchpriority' => 'high',
								)); ?>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php
							the_content();
							wp_link_pages(array(
								'before' => '<nav class="tm-pages"><span>' . esc_html__('Pages:', 'readora') . '</span>',
								'after' => '</nav>',
							));
							?>
						</div>

					</article>

					<?php if (comments_open() || get_comments_number()):
						echo '<div class="tm-single-after" id="comments">';
						comments_template();
						echo '</div>';
					endif; ?>

				<?php endwhile; ?>
			</div>

			<?php if ($readora_page_sidebar) {
				get_sidebar();
			} ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
