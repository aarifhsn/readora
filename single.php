<?php
/**
 * Single post template
 *
 * @package Readora
 * @since   1.0.0
 */

$readora_single_sidebar = (bool) get_theme_mod('readora_single_sidebar', false);

get_header();
readora_breadcrumbs();
?>

<main id="main-content" class="tm-main">
	<div class="tm-container">
		<div class="tm-layout<?php echo $readora_single_sidebar ? ' tm-layout--sidebar' : ''; ?>">

			<div class="tm-primary" id="primary">
				<?php while (have_posts()):
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('single-article tm-single'); ?> itemscope
						itemtype="https://schema.org/Article">

						<!-- Header -->
						<header class="tm-single__header">
							<?php $cats = get_the_category();
							if (!empty($cats)): ?>
								<a class="tm-kicker" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>">
									<?php echo esc_html($cats[0]->name); ?>
								</a>
							<?php endif; ?>

							<h1 class="tm-single__title" itemprop="headline"><?php the_title(); ?></h1>

							<?php if (has_excerpt()): ?>
								<p class="tm-single__dek"><?php echo esc_html(get_the_excerpt()); ?></p>
							<?php endif; ?>

							<div class="tm-byline">
								<?php echo get_avatar(get_the_author_meta('ID'), 44, '', '', array('class' => 'tm-byline__avatar')); ?>
								<div>
									<a class="tm-byline__name"
										href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
										itemprop="author" itemscope itemtype="https://schema.org/Person">
										<span itemprop="name"><?php the_author(); ?></span>
									</a>
									<div class="tm-meta">
										<time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
											<?php echo esc_html(get_the_date()); ?>
										</time>
										<?php readora_reading_time_html(); ?>
										<?php if (comments_open()): ?>
											<a href="#comments">
												<?php comments_number(
													esc_html__('0 Comments', 'readora'),
													esc_html__('1 Comment', 'readora'),
													esc_html__('% Comments', 'readora')
												); ?>
											</a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</header>

						<!-- Featured image -->
						<?php if (has_post_thumbnail()): ?>
							<figure class="tm-single__hero">
								<?php the_post_thumbnail('readora-featured', array(
									'itemprop' => 'image',
									'loading' => 'eager',
									'fetchpriority' => 'high',
								)); ?>
								<?php $thumb_caption = get_the_post_thumbnail_caption();
								if ($thumb_caption): ?>
									<figcaption><?php echo esc_html($thumb_caption); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endif; ?>

						<!-- Article body -->
						<div class="entry-content" itemprop="articleBody">
							<?php
							the_content(sprintf(
								wp_kses(
									/* translators: %s: post title */
									__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'readora'),
									array('span' => array('class' => array()))
								),
								wp_kses_post(get_the_title())
							));

							wp_link_pages(array(
								'before' => '<nav class="flex items-center gap-2 mt-8 pt-6 border-t text-sm" style="border-color:var(--color-border)" aria-label="' . esc_attr__('Page', 'readora') . '"><span class="font-medium" style="color:var(--color-text-secondary)">' . esc_html__('Pages:', 'readora') . '</span>',
								'after' => '</nav>',
								'link_before' => '<span class="inline-flex items-center justify-center w-8 h-8 rounded border text-sm" style="border-color:var(--color-border)">',
								'link_after' => '</span>',
							));
							?>
						</div>

						<!-- Tags -->
						<?php $tags = get_the_tags();
						if ($tags): ?>
							<div class="tm-tags">
								<span class="tm-tags__label"><?php esc_html_e('Tags:', 'readora'); ?></span>
								<?php foreach ($tags as $tag): ?>
									<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" rel="tag"><?php echo esc_html($tag->name); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Share buttons -->
						<div class="tm-share">
							<span class="tm-share__label">
								<?php esc_html_e('Share:', 'readora'); ?>
							</span>

							<a href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . rawurlencode(get_permalink()) . '&text=' . rawurlencode(get_the_title())); ?>"
								class="tm-share__btn"
								target="_blank" rel="noopener noreferrer"
								aria-label="<?php esc_attr_e('Share on Twitter', 'readora'); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
									fill="currentColor" aria-hidden="true">
									<path
										d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.736-8.849L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
								</svg>
								<?php esc_html_e('Twitter', 'readora'); ?>
							</a>

							<a href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode(get_permalink())); ?>"
								class="tm-share__btn"
								target="_blank" rel="noopener noreferrer"
								aria-label="<?php esc_attr_e('Share on Facebook', 'readora'); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
									fill="currentColor" aria-hidden="true">
									<path
										d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.378 14.192 5 15.115 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z" />
								</svg>
								<?php esc_html_e('Facebook', 'readora'); ?>
							</a>

							<a href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode(get_permalink()) . '&title=' . rawurlencode(get_the_title())); ?>"
								class="tm-share__btn"
								target="_blank" rel="noopener noreferrer"
								aria-label="<?php esc_attr_e('Share on LinkedIn', 'readora'); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
									fill="currentColor" aria-hidden="true">
									<path
										d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z" />
									<circle cx="4" cy="4" r="2" />
								</svg>
								<?php esc_html_e('LinkedIn', 'readora'); ?>
							</a>

							<button
								class="js-copy-link tm-share__btn"
								data-url="<?php echo esc_attr(get_permalink()); ?>"
								aria-label="<?php esc_attr_e('Copy link to clipboard', 'readora'); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
									<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
									<path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
								</svg>
								<?php esc_html_e('Copy Link', 'readora'); ?>
							</button>
						</div>

						<!-- Author bio -->
						<?php $author_bio = get_the_author_meta('description');
						if ($author_bio): ?>
							<div class="tm-author">
								<?php echo get_avatar(get_the_author_meta('ID'), 56, '', '', array('class' => 'tm-author__avatar')); ?>
								<div>
									<span class="tm-author__label"><?php esc_html_e('Written by', 'readora'); ?></span>
									<p class="tm-author__name">
										<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
									</p>
									<p class="tm-author__bio"><?php echo esc_html($author_bio); ?></p>
								</div>
							</div>
						<?php endif; ?>

						<!-- Post nav (prev / next) -->
						<nav class="tm-postnav" aria-label="<?php esc_attr_e('Post navigation', 'readora'); ?>">
							<?php
							$prev_post = get_previous_post();
							$next_post = get_next_post();

							if ($prev_post): ?>
								<a class="tm-postnav__item" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
									<span class="tm-postnav__label"><span aria-hidden="true">&larr;</span> <?php esc_html_e('Previous', 'readora'); ?></span>
									<span class="tm-postnav__title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
								</a>
							<?php else: ?>
								<span></span>
							<?php endif;

							if ($next_post): ?>
								<a class="tm-postnav__item tm-postnav__item--next" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
									<span class="tm-postnav__label"><?php esc_html_e('Next', 'readora'); ?> <span aria-hidden="true">&rarr;</span></span>
									<span class="tm-postnav__title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
								</a>
							<?php endif; ?>
						</nav>

					</article>

					<!-- Newsletter CTA -->
					<?php readora_newsletter_block(); ?>

					<!-- Comments -->
					<div class="tm-single-after" id="comments">
						<?php
						if (comments_open() || get_comments_number()):
							comments_template();
						endif;
						?>
					</div>

				<?php endwhile; ?>
			</div><!-- #primary -->

			<?php if ($readora_single_sidebar) {
				get_sidebar();
			} ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
