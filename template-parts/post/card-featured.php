<?php
/**
 * Template part: Featured / lead post card
 *
 * Used for the first post on the homepage when the layout is 3-Column Grid.
 *
 * @package Readora
 * @since   1.0.0
 */
?>

<article <?php post_class('tm-card tm-card--lead'); ?>>

	<?php if (has_post_thumbnail()): ?>
		<a class="tm-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail('readora-card', array('loading' => 'eager', 'fetchpriority' => 'high')); ?>
		</a>
	<?php endif; ?>

	<div class="tm-card__body">
		<?php $cats = get_the_category();
		if (!empty($cats)): ?>
			<a class="tm-kicker" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>">
				<?php echo esc_html($cats[0]->name); ?>
			</a>
		<?php endif; ?>

		<h2 class="tm-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<p class="tm-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>

		<div class="tm-meta">
			<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
				<?php echo esc_html(get_the_author()); ?>
			</a>
			<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
			<?php readora_reading_time_html(); ?>
		</div>
	</div>
</article>
