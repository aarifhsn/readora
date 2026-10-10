<?php
/**
 * The Footer template
 *
 * @package Readora
 * @since   1.0.0
 */
?>

<footer id="site-footer" role="contentinfo" class="mt-16 pt-16 pb-0 transition-colors duration-300"
	style="background-color:var(--footer-bg);color:var(--footer-text)">

	<div class="tm-container">

		<!-- Footer grid: brand + 3 link columns -->
		<div class="grid grid-cols-1 gap-10 mb-12 md:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr]">

			<!-- ── Brand column ─────────────────────────────────────────── -->
			<div>
				<?php if (has_custom_logo()):
					the_custom_logo();
				else: ?>
					<p class="text-xl font-bold mb-3 transition-colors duration-300"
						style="font-family:var(--font-serif);color:var(--footer-text-heading)">
						<?php
						$name = get_bloginfo('name');
						$parts = explode(' ', trim($name), 2);
						echo esc_html($parts[0]);
						if (!empty($parts[1])) {
							echo '<span style="color:var(--color-primary)">' . esc_html($parts[1]) . '</span>';
						}
						?>
					</p>
				<?php endif; ?>

				<?php $desc = get_bloginfo('description', 'display'); ?>
				<?php if ($desc): ?>
					<p class="text-sm leading-relaxed mb-5 max-w-[30ch] transition-colors duration-300"
						style="color:var(--footer-text-muted)">
						<?php echo esc_html($desc); ?>
					</p>
				<?php endif; ?>

				<!-- Social icons -->
				<div class="flex gap-2 flex-wrap">
					<?php
					$social_links = array(
						'twitter' => array(
							'url' => get_theme_mod('readora_twitter_url', ''),
							'label' => esc_html__('Follow on Twitter / X', 'readora'),
							'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.736-8.849L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
						),
						'facebook' => array(
							'url' => get_theme_mod('readora_facebook_url', ''),
							'label' => esc_html__('Like on Facebook', 'readora'),
							'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.378 14.192 5 15.115 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z"/></svg>',
						),
						'instagram' => array(
							'url' => get_theme_mod('readora_instagram_url', ''),
							'label' => esc_html__('Follow on Instagram', 'readora'),
							'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
						),
						'linkedin' => array(
							'url' => get_theme_mod('readora_linkedin_url', ''),
							'label' => esc_html__('Connect on LinkedIn', 'readora'),
							'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2zM4 3a2 2 0 1 1 .001 3.999A2 2 0 0 1 4 3z"/></svg>',
						),
						'youtube' => array(
							'url' => get_theme_mod('readora_youtube_url', ''),
							'label' => esc_html__('Watch on YouTube', 'readora'),
							'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
						),
						'rss' => array(
							'url' => get_feed_link(),
							'label' => esc_html__('Subscribe to RSS feed', 'readora'),
							'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg>',
						),
					);

					foreach ($social_links as $social):
						if (!empty($social['url'])):
							printf(
								'<a href="%s" aria-label="%s" rel="noopener noreferrer" target="_blank" class="footer-social-icon flex items-center justify-center w-[38px] h-[38px] rounded-lg transition-all duration-150" style="background-color:var(--footer-bg-surface);color:var(--footer-text)">%s</a>',
								esc_url($social['url']),
								esc_attr($social['label']),
								$social['icon'] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							);
						endif;
					endforeach;
					?>
				</div>
			</div>

			<!-- ── Explore column ───────────────────────────────────────── -->
			<div>
				<h3 class="text-sm font-bold uppercase tracking-[.07em] mb-5 transition-colors duration-300"
					style="color:var(--footer-text-heading)">
					<?php esc_html_e('Explore', 'readora'); ?>
				</h3>
				<?php
				$footer_cats = get_categories(array(
					'orderby' => 'count',
					'order' => 'DESC',
					'number' => 7,
					'hide_empty' => true,
				));
				if (!empty($footer_cats)):
					echo '<ul class="flex flex-col gap-3">';
					foreach ($footer_cats as $cat):
						printf(
							'<li><a href="%s" class="footer-link text-sm transition-colors duration-150" style="color:var(--footer-link)">%s</a></li>',
							esc_url(get_category_link($cat->term_id)),
							esc_html($cat->name)
						);
					endforeach;
					echo '</ul>';
				endif;
				?>
			</div>

			<!-- ── Quick Links column ───────────────────────────────────── -->
			<div>
				<h3 class="text-sm font-bold uppercase tracking-[.07em] mb-5 transition-colors duration-300"
					style="color:var(--footer-text-heading)">
					<?php esc_html_e('Quick Links', 'readora'); ?>
				</h3>
				<?php
				wp_nav_menu(array(
					'theme_location' => 'footer-menu',
					'container' => false,
					'fallback_cb' => '__return_false',
					'depth' => 1,
					'menu_class' => 'tm-footer-menu',
				));
				?>
			</div>

			<!-- ── Optional footer widget ───────────────────────────────── -->
			<?php if (is_active_sidebar('footer-1')): ?>
				<div><?php dynamic_sidebar('footer-1'); ?></div>
			<?php endif; ?>

		</div><!-- /footer grid -->

		<!-- ── Footer bottom bar ────────────────────────────────────────── -->
		<div class="flex items-center justify-between flex-wrap gap-4 border-t py-6 transition-colors duration-300"
			style="border-color:var(--footer-border)">

			<p class="text-sm transition-colors duration-300" style="color:var(--footer-text-muted)">
				<?php readora_footer_credit_output(); ?>
			</p>

			<nav class="flex gap-4" aria-label="<?php esc_attr_e('Footer legal links', 'readora'); ?>">
				<?php
				$privacy_url = get_privacy_policy_url();
				if ($privacy_url):
					printf(
						'<a href="%s" class="footer-link text-sm transition-colors duration-150" style="color:var(--footer-link)">%s</a>',
						esc_url($privacy_url),
						esc_html__('Privacy Policy', 'readora')
					);
				endif;
				?>
				<a href="<?php echo esc_url(get_feed_link()); ?>"
					class="footer-link text-sm transition-colors duration-150" style="color:var(--footer-link)">
					<?php esc_html_e('RSS Feed', 'readora'); ?>
				</a>
			</nav>

		</div>

	</div><!-- .tm-container -->
</footer>

<!-- Back to top -->
<button
	class="back-to-top fixed bottom-8 right-8 flex items-center justify-center w-11 h-11 rounded-full border-none cursor-pointer z-[100] shadow-lg transition-all duration-150 hover:-translate-y-0.5"
	id="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'readora'); ?>"
	style="background:var(--color-primary);color:#fff" hidden>
	<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
		stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
		<polyline points="18 15 12 9 6 15" />
	</svg>
</button>

<?php wp_footer(); ?>
</body>

</html>
