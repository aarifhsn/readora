<?php
/**
 * The sidebar template
 *
 * @package Readora
 * @since   1.0.0
 */
?>

<aside class="min-w-0" id="secondary" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'readora'); ?>">
	<div class="sidebar-sticky">

		<!-- Tabbed widget: Recent / Popular / Comments -->
		<div class="sidebar-tabs tm-tabs">

			<!-- Tab nav -->
			<div class="sidebar-tabs__nav" role="tablist" aria-label="<?php esc_attr_e('Post tabs', 'readora'); ?>">
				<button class="sidebar-tabs__btn is-active" id="tab-recent" role="tab" aria-selected="true"
					aria-controls="panel-recent">
					<?php esc_html_e('Recent', 'readora'); ?>
				</button>

				<button class="sidebar-tabs__btn" id="tab-popular" role="tab" aria-selected="false"
					aria-controls="panel-popular">
					<?php esc_html_e('Popular', 'readora'); ?>
				</button>

				<button class="sidebar-tabs__btn" id="tab-comments" role="tab" aria-selected="false"
					aria-controls="panel-comments">
					<?php esc_html_e('Comments', 'readora'); ?>
				</button>
			</div>

			<!-- Recent posts panel -->
			<div class="sidebar-tabs__panel is-active" id="panel-recent" role="tabpanel" aria-labelledby="tab-recent">
				<?php
				$recent_query = readora_get_recent_posts(4);
				if ($recent_query->have_posts()):
					while ($recent_query->have_posts()):
						$recent_query->the_post(); ?>
						<div class="tm-side-item">
							<?php if (has_post_thumbnail()): ?>
								<a class="tm-side-item__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
									<?php the_post_thumbnail('readora-sidebar', array('loading' => 'lazy')); ?>
								</a>
							<?php endif; ?>
							<div class="tm-side-item__text">
								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
							</div>
						</div>
					<?php endwhile;
					wp_reset_postdata();
				else:
					echo '<p class="tm-side-empty">' . esc_html__('No posts found.', 'readora') . '</p>';
				endif; ?>
			</div>

			<!-- Popular posts panel -->
			<div class="sidebar-tabs__panel" id="panel-popular" role="tabpanel" aria-labelledby="tab-popular">
				<?php
				$popular_query = readora_get_popular_posts(4);
				if ($popular_query->have_posts()):
					while ($popular_query->have_posts()):
						$popular_query->the_post(); ?>
						<div class="tm-side-item">
							<?php if (has_post_thumbnail()): ?>
								<a class="tm-side-item__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
									<?php the_post_thumbnail('readora-sidebar', array('loading' => 'lazy')); ?>
								</a>
							<?php endif; ?>
							<div class="tm-side-item__text">
								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<span class="tm-side-item__meta">
									<?php printf(
										esc_html(_n('%d comment', '%d comments', (int) get_comments_number(), 'readora')),
										(int) get_comments_number()
									); ?>
								</span>
							</div>
						</div>
					<?php endwhile;
					wp_reset_postdata();
				else:
					echo '<p class="tm-side-empty">' . esc_html__('No posts found.', 'readora') . '</p>';
				endif; ?>
			</div>

			<!-- Comments panel -->
			<div class="sidebar-tabs__panel" id="panel-comments" role="tabpanel" aria-labelledby="tab-comments">
				<?php
				$recent_comments = readora_get_recent_comments(5);
				if (!empty($recent_comments)):
					foreach ($recent_comments as $c): ?>
						<div class="tm-side-item">
							<div class="tm-side-item__avatar"><?php echo $c['avatar']; // phpcs:ignore ?></div>
							<div class="tm-side-item__text">
								<h4><a href="<?php echo esc_url($c['link']); ?>"><?php echo esc_html($c['author']); ?></a></h4>
								<p><?php echo esc_html($c['excerpt']); ?></p>
							</div>
						</div>
					<?php endforeach;
				else:
					echo '<p class="tm-side-empty">' . esc_html__('No comments yet.', 'readora') . '</p>';
				endif; ?>
			</div>

		</div><!-- tabbed widget -->

		<!-- WordPress dynamic sidebar widgets -->
		<?php if (is_active_sidebar('sidebar-main')): ?>
			<?php dynamic_sidebar('sidebar-main'); ?>
		<?php endif; ?>

	</div><!-- .sidebar-sticky -->
</aside>
