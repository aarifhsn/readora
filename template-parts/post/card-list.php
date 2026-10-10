<?php
/**
 * Template part: List-style post card
 *
 * Used when Customizer layout is set to "List View".
 *
 * @package Readora
 * @since   1.0.0
 */

$categories = get_the_category();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('tm-card tm-card--list'); ?>>

	<?php if (has_post_thumbnail()): ?>
		<a class="tm-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail('readora-card', array('loading' => 'lazy')); ?>
		</a>
	<?php endif; ?>

	<div class="tm-card__body">
		<?php if (!empty($categories)): ?>
			<a class="tm-kicker" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>">
				<?php echo esc_html($categories[0]->name); ?>
			</a>
		<?php endif; ?>

		<h2 class="tm-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p class="tm-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>

		<div class="tm-meta">
			<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
			<?php readora_reading_time_html(); ?>
		</div>
	</div>

</article>
