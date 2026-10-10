<?php
/**
 * The Header template
 *
 * @package Readora
 * @since   1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preload" href="<?php echo esc_url(READORA_URI . '/assets/fonts/inter-400.woff2'); ?>" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?php echo esc_url(READORA_URI . '/assets/fonts/playfair-display-700.woff2'); ?>" as="font" type="font/woff2" crossorigin>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a class="skip-link screen-reader-text" href="#main-content">
		<?php esc_html_e('Skip to content', 'readora'); ?>
	</a>

	<?php /* Search overlay — starts hidden; JS removes [hidden] then adds .is-open */ ?>
	<div class="search-overlay fixed inset-0 hidden z-[300] backdrop-blur-sm" id="search-overlay" role="dialog"
		aria-modal="true" aria-label="<?php esc_attr_e('Search', 'readora'); ?>" style="background:rgba(0,0,0,.6)">

		<div class="search-overlay__box relative w-[min(640px,90vw)] mt-[15vh] mx-auto rounded-2xl p-6 shadow-2xl"
			style="background:var(--color-bg-surface)">

			<?php get_search_form(); ?>

			<p class="mt-3 text-center text-xs" style="color:var(--color-text-muted)">
				<?php esc_html_e('Press Escape to close', 'readora'); ?>
			</p>
		</div>

		<button
			class="fixed top-4 right-4 flex items-center justify-center w-10 h-10 rounded-lg border-none cursor-pointer text-2xl leading-none transition-colors duration-150"
			id="search-overlay-close" aria-label="<?php esc_attr_e('Close search', 'readora'); ?>"
			style="background:rgba(255,255,255,.15);color:#fff">
			&#x2715;
		</button>
	</div>

	<header class="site-header tm-header" id="site-header">
		<div class="tm-container">
			<div class="tm-header__inner">

				<!-- Branding -->
				<div class="tm-brand">
					<?php if (has_custom_logo()):
						the_custom_logo();
					else: ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="tm-brand__link">
							<span class="tm-brand__text">
								<?php
								$name  = get_bloginfo('name');
								$parts = explode(' ', trim($name), 2);
								echo esc_html($parts[0]);
								if (!empty($parts[1])) {
									echo '<span>' . esc_html($parts[1]) . '</span>';
								}
								?>
							</span>
						</a>
					<?php endif; ?>
				</div>

				<!-- Primary desktop nav -->
				<nav class="tm-nav primary-nav" id="primary-nav"
					aria-label="<?php esc_attr_e('Primary menu', 'readora'); ?>">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'main-menu',
						'menu_id' => 'primary-menu',
						'container' => false,
						'fallback_cb' => false,
						'depth' => 0,
						'menu_class' => 'tm-nav__list',
						'link_before' => '',
						'link_after' => '',
						'before' => '',
						'after' => '',
					));
					?>
				</nav>

				<!-- Header actions -->
				<div class="tm-header__actions">

					<!-- Search toggle -->
					<button class="tm-icon-btn" id="search-toggle" type="button"
						aria-label="<?php esc_attr_e('Open search', 'readora'); ?>" aria-expanded="false"
						aria-controls="search-overlay">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
							stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
							aria-hidden="true" focusable="false">
							<circle cx="11" cy="11" r="8" />
							<line x1="21" y1="21" x2="16.65" y2="16.65" />
						</svg>
					</button>

					<!-- Dark mode toggle -->
					<button class="dark-mode-toggle tm-icon-btn" id="dark-mode-toggle" type="button"
						aria-label="<?php esc_attr_e('Toggle dark mode', 'readora'); ?>" aria-pressed="false">
						<svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
							viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
							stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<circle cx="12" cy="12" r="5" />
							<line x1="12" y1="1" x2="12" y2="3" />
							<line x1="12" y1="21" x2="12" y2="23" />
							<line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
							<line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
							<line x1="1" y1="12" x2="3" y2="12" />
							<line x1="21" y1="12" x2="23" y2="12" />
							<line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
							<line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
						</svg>
						<svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
							viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
							stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
						</svg>
					</button>

					<!-- Mobile menu toggle -->
					<button class="tm-icon-btn tm-menu-btn" id="menu-toggle" type="button"
						aria-label="<?php esc_attr_e('Open navigation menu', 'readora'); ?>" aria-expanded="false"
						aria-controls="mobile-nav">
						<span class="tm-burger" aria-hidden="true"><span></span><span></span><span></span></span>
					</button>

				</div><!-- header actions -->
			</div>
		</div>

		<!-- Mobile nav drawer -->
		<nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e('Mobile menu', 'readora'); ?>" hidden>
			<?php
			wp_nav_menu(array(
				'theme_location' => 'main-menu',
				'menu_id' => 'mobile-menu',
				'container' => false,
				'fallback_cb' => false,
				'depth' => 0,
			));
			?>
		</nav>

	</header>

	<?php /* Custom header image */ ?>
	<?php if (get_header_image()): ?>
		<div class="w-full overflow-hidden max-h-[400px]" style="background:var(--color-bg-subtle)">
			<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
				<img src="<?php header_image(); ?>" width="<?php echo absint(get_custom_header()->width); ?>"
					height="<?php echo absint(get_custom_header()->height); ?>"
					alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="w-full h-auto object-cover" loading="lazy">
			</a>
		</div>
	<?php endif; ?>

	<?php
	/* Breaking news ticker */
	$readora_breaking = get_theme_mod('readora_show_breaking_bar', true);
	$readora_breaking = (true === $readora_breaking || '1' === $readora_breaking || 1 === $readora_breaking);

	$readora_latest = new WP_Query(array(
		'posts_per_page' => 5,
		'post_status' => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows' => true,
		'fields' => 'ids',
	));

	if ($readora_latest->have_posts() && $readora_breaking): ?>
		<div class="tm-ticker" role="complementary"
			aria-label="<?php esc_attr_e('Latest stories', 'readora'); ?>">
			<div class="tm-container">
				<div class="tm-ticker__inner">
					<span class="tm-ticker__label"><?php esc_html_e('Latest', 'readora'); ?></span>
					<div class="tm-ticker__track">
						<span class="breaking-bar__ticker-inner"><?php
						for ($i = 0; $i < 2; $i++) {
							echo $i ? '<span aria-hidden="true">' : '<span>';
							foreach ($readora_latest->posts as $post_id) {
								printf(
									'<a href="%s"%s>%s</a>',
									esc_url(get_permalink($post_id)),
									$i ? ' tabindex="-1"' : '',
									esc_html(get_the_title($post_id))
								);
							}
							echo '</span>';
						}
						wp_reset_postdata();
						?></span>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if (is_singular('post')): ?>
		<div class="reading-progress" id="reading-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"
			aria-valuenow="0" aria-label="<?php esc_attr_e('Article reading progress', 'readora'); ?>">
		</div>
	<?php endif; ?>
