<?php
/**
 * The main template file
 *
 * @package Readora
 * @since   1.0.0
 */

get_header();

$readora_layout = get_theme_mod('readora_home_layout', 'grid-3');
$readora_sidebar = (bool) get_theme_mod('readora_home_sidebar', true);

$readora_layouts = array('grid-3', 'grid-2', 'list');
$readora_layout  = in_array($readora_layout, $readora_layouts, true) ? $readora_layout : 'grid-3';
$grid_class = 'tm-grid tm-grid--' . $readora_layout . ($readora_sidebar ? ' has-sidebar' : '');
?>

<main id="main-content" class="tm-main">
	<div class="tm-container">
		<div class="tm-layout<?php echo $readora_sidebar ? ' tm-layout--sidebar' : ''; ?>">

			<div class="tm-primary" id="primary">
				<?php if (have_posts()):
					$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
					$loop_count = 0;
					?>

					<div class="<?php echo esc_attr($grid_class); ?>">
						<?php while (have_posts()):
							the_post();
							$loop_count++;

							if (1 === $loop_count && 1 === $paged && 'grid-3' === $readora_layout):
								get_template_part('template-parts/post/card', 'featured');
							elseif ('list' === $readora_layout):
								get_template_part('template-parts/post/card', 'list');
							else:
								get_template_part('template-parts/post/card');
							endif;
						endwhile; ?>
					</div>

					<?php readora_pagination();

				else:
					get_template_part('template-parts/content/none');
				endif; ?>
			</div>

			<?php if ($readora_sidebar)
				get_sidebar(); ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
