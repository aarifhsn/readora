<?php
/**
 * Theme Customizer — Readora
 *
 * @package Readora
 * @since   1.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}


/* =============================================================
   REGISTER CUSTOMIZER PANELS, SECTIONS, SETTINGS, CONTROLS
   ============================================================= */

function readora_customize_register(WP_Customize_Manager $wp_customize)
{

	// -----------------------------------------------------------
	// PANEL: Theme Options
	// -----------------------------------------------------------
	$wp_customize->add_panel('readora_options', array(
		'title' => esc_html__('Theme Options', 'readora'),
		'description' => esc_html__('Customise colours, social links, layout and typography.', 'readora'),
		'priority' => 130,
	));


	// -----------------------------------------------------------
	// SECTION 1: Colors
	// -----------------------------------------------------------
	$wp_customize->add_section('readora_colors', array(
		'title' => esc_html__('Colors', 'readora'),
		'panel' => 'readora_options',
		'priority' => 10,
	));

	// Accent color
	// transport => 'refresh' because postMessage requires a live JS file.
	// A customizer-preview.js is provided for postMessage upgrades later.
	$wp_customize->add_setting('readora_accent_color', array(
		'default' => '#e63946',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'refresh',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'readora_accent_color',
		array(
			'label' => esc_html__('Accent / Brand Color', 'readora'),
			'description' => esc_html__('Used for category labels, buttons, links, and highlights. Click Publish to see changes.', 'readora'),
			'section' => 'readora_colors',
		)
	));


	// -----------------------------------------------------------
	// SECTION 2: Social Links
	// -----------------------------------------------------------
	$wp_customize->add_section('readora_social', array(
		'title' => esc_html__('Social Links', 'readora'),
		'description' => esc_html__('Enter full URLs (https://...). Leave blank to hide the icon.', 'readora'),
		'panel' => 'readora_options',
		'priority' => 20,
	));

	$social_networks = array(
		'twitter' => esc_html__('Twitter / X URL', 'readora'),
		'facebook' => esc_html__('Facebook URL', 'readora'),
		'instagram' => esc_html__('Instagram URL', 'readora'),
		'youtube' => esc_html__('YouTube URL', 'readora'),
		'linkedin' => esc_html__('LinkedIn URL', 'readora'),
	);

	foreach ($social_networks as $id => $label) {
		$wp_customize->add_setting('readora_' . $id . '_url', array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport' => 'refresh',
		));
		$wp_customize->add_control('readora_' . $id . '_url', array(
			'label' => $label,
			'section' => 'readora_social',
			'type' => 'url',
		));
	}


	// -----------------------------------------------------------
	// SECTION 3: Layout
	// -----------------------------------------------------------
	$wp_customize->add_section('readora_layout', array(
		'title' => esc_html__('Layout', 'readora'),
		'panel' => 'readora_options',
		'priority' => 30,
	));

	// Homepage post grid style
	$wp_customize->add_setting('readora_home_layout', array(
		'default' => 'grid-3',
		// FIX: correct sanitize signature — receives ($value, $setting) not ($value, $control)
		'sanitize_callback' => 'readora_sanitize_home_layout',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_home_layout', array(
		'label' => esc_html__('Homepage Post Layout', 'readora'),
		'section' => 'readora_layout',
		'type' => 'select',
		'choices' => array(
			'grid-3' => esc_html__('3-Column Grid (default)', 'readora'),
			'grid-2' => esc_html__('2-Column Grid', 'readora'),
			'list' => esc_html__('List View', 'readora'),
		),
	));

	// Show/hide sidebar on homepage
	$wp_customize->add_setting('readora_home_sidebar', array(
		'default' => true,
		'sanitize_callback' => 'readora_sanitize_checkbox',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_home_sidebar', array(
		'label' => esc_html__('Show sidebar on homepage', 'readora'),
		'section' => 'readora_layout',
		'type' => 'checkbox',
	));

	// Show sidebar on single posts / static pages (off = centered reading column)
	$wp_customize->add_setting('readora_single_sidebar', array(
		'default' => false,
		'sanitize_callback' => 'readora_sanitize_checkbox',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_single_sidebar', array(
		'label' => esc_html__('Show sidebar on single posts', 'readora'),
		'section' => 'readora_layout',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('readora_page_sidebar', array(
		'default' => false,
		'sanitize_callback' => 'readora_sanitize_checkbox',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_page_sidebar', array(
		'label' => esc_html__('Show sidebar on static pages', 'readora'),
		'section' => 'readora_layout',
		'type' => 'checkbox',
	));

	// Show/hide breaking news bar
	$wp_customize->add_setting('readora_show_breaking_bar', array(
		'default' => true,
		'sanitize_callback' => 'readora_sanitize_checkbox',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_show_breaking_bar', array(
		'label' => esc_html__('Show breaking news bar', 'readora'),
		'section' => 'readora_layout',
		'type' => 'checkbox',
	));


	// -----------------------------------------------------------
	// SECTION 4: Typography
	// -----------------------------------------------------------
	$wp_customize->add_section('readora_typography', array(
		'title' => esc_html__('Typography', 'readora'),
		'panel' => 'readora_options',
		'priority' => 40,
	));

	$wp_customize->add_setting('readora_body_font_size', array(
		'default' => 16,
		'sanitize_callback' => 'readora_sanitize_font_size',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_body_font_size', array(
		'label' => esc_html__('Body Font Size (px)', 'readora'),
		'description' => esc_html__('Recommended: 14-20px. Current value shows after Publish.', 'readora'),
		'section' => 'readora_typography',
		'type' => 'range',
		'input_attrs' => array(
			'min' => 14,
			'max' => 20,
			'step' => 1,
		),
	));


	// -----------------------------------------------------------
	// SECTION 5: Footer
	// -----------------------------------------------------------
	$wp_customize->add_section('readora_footer_section', array(
		'title' => esc_html__('Footer', 'readora'),
		'panel' => 'readora_options',
		'priority' => 50,
	));

	$wp_customize->add_setting('readora_footer_credit', array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_footer_credit', array(
		'label' => esc_html__('Custom Footer Copyright Text', 'readora'),
		'description' => esc_html__('Replaces the default "© Year Name" text. Leave blank for default. HTML allowed.', 'readora'),
		'section' => 'readora_footer_section',
		'type' => 'textarea',
	));


	// -----------------------------------------------------------
	// SELECTIVE REFRESH for core settings
	// -----------------------------------------------------------
	$wp_customize->selective_refresh->add_partial('blogname', array(
		'selector' => '.tm-brand__text',
		'render_callback' => function () {
			bloginfo('name');
		},
	));

	$wp_customize->selective_refresh->add_partial('blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => function () {
			bloginfo('description');
		},
	));

	// Selective refresh for footer copyright
	$wp_customize->selective_refresh->add_partial('readora_footer_credit', array(
		'selector' => '.footer-bottom__copy',
		'render_callback' => 'readora_footer_credit_output',
		'container_inclusive' => false,
	));

	// ════════════════════════════════════════════════════════════════════════
// SECTION: NEWSLETTER
// ════════════════════════════════════════════════════════════════════════

	$wp_customize->add_section('readora_newsletter', array(
		'title' => esc_html__('Newsletter', 'readora'),
		'description' => esc_html__('Configure the newsletter block that appears after single posts.', 'readora'),
		'panel' => 'readora_options',
	));

	$wp_customize->add_setting('readora_newsletter_show', array(
		'default' => true,
		'sanitize_callback' => 'readora_sanitize_checkbox',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_show', array(
		'label' => esc_html__('Show Newsletter Block', 'readora'),
		'description' => esc_html__('Display the newsletter signup block after single posts.', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('readora_newsletter_eyebrow', array(
		'default' => esc_html__('Stay Updated', 'readora'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_eyebrow', array(
		'label' => esc_html__('Eyebrow Label', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'text',
	));

	$wp_customize->add_setting('readora_newsletter_heading', array(
		'default' => esc_html__('Enjoyed this article?', 'readora'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_heading', array(
		'label' => esc_html__('Heading', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'text',
	));

	$wp_customize->add_setting('readora_newsletter_subheading', array(
		'default' => esc_html__('Get the best stories delivered straight to your inbox. No spam, ever.', 'readora'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_subheading', array(
		'label' => esc_html__('Subheading', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'textarea',
	));

	$wp_customize->add_setting('readora_newsletter_provider', array(
		'default' => 'embed',
		'sanitize_callback' => 'readora_sanitize_select',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_provider', array(
		'label' => esc_html__('Newsletter Provider', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'select',
		'choices' => array(
			'embed' => esc_html__('Custom Embed Code (Mailchimp, ConvertKit, Brevo, any)', 'readora'),
			'builtin' => esc_html__('Built-in Form (stores emails in WordPress)', 'readora'),
		),
	));

	$wp_customize->add_setting('readora_newsletter_embed', array(
		'default' => '',
		'sanitize_callback' => 'readora_sanitize_newsletter_embed',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_embed', array(
		'label' => esc_html__('Embed Code', 'readora'),
		'description' => esc_html__('Paste the full embed code from your provider — Mailchimp, Jotform, ConvertKit, Brevo, or any other. Include all script tags exactly as given.', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'textarea',
		'input_attrs' => array('rows' => 8),
	));

	$wp_customize->add_setting('readora_newsletter_note_text', array(
		'default' => esc_html__('No spam. Unsubscribe any time.', 'readora'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('readora_newsletter_note_text', array(
		'label' => esc_html__('Fine Print / Note Text', 'readora'),
		'section' => 'readora_newsletter',
		'type' => 'text',
	));
}
add_action('customize_register', 'readora_customize_register');


/* =============================================================
   SANITIZATION CALLBACKS
   ============================================================= */

/**
 * Sanitize home layout.
 *
 * @param  string $value
 * @return string
 */
function readora_sanitize_home_layout($value)
{
	$allowed = array('grid-3', 'grid-2', 'list');
	return in_array($value, $allowed, true) ? $value : 'grid-3';
}

/**
 * Sanitize a select field against its control's registered choices.
 *
 * @param  string               $value
 * @param  WP_Customize_Setting $setting
 * @return string
 */
function readora_sanitize_select($value, $setting)
{
	$control = $setting->manager->get_control($setting->id);
	if ($control && isset($control->choices[$value])) {
		return $value;
	}
	return $setting->default;
}

/**
 * Sanitize font size to an integer within the allowed range.
 *
 * @param  mixed $value
 * @return int
 */
function readora_sanitize_font_size($value)
{
	$value = absint($value);
	if ($value < 14)
		return 14;
	if ($value > 20)
		return 20;
	return $value;
}

/**
 * Sanitize a checkbox setting to '1' or '0'.
 *
 * @param  mixed $checked
 * @return bool
 */
function readora_sanitize_checkbox($checked)
{
	return (isset($checked) && true == $checked) ? true : false;
}


/* =============================================================
   FOOTER CREDIT
   ============================================================= */

function readora_footer_credit_output()
{
	$custom = get_theme_mod('readora_footer_credit', '');
	if ($custom) {
		// User has set custom text — output it (wp_kses_post already sanitized on save).
		echo wp_kses_post($custom);
	} else {
		// Default copyright.
		printf(
			/* translators: 1: copyright symbol + year, 2: site name */
			esc_html__('%1$s %2$s. All rights reserved.', 'readora'),
			'&copy; ' . esc_html(gmdate('Y')),
			esc_html(get_bloginfo('name'))
		);
	}
}


/* =============================================================
   CUSTOMIZER INLINE CSS
   ============================================================= */

function readora_customizer_inline_css()
{
	$accent = sanitize_hex_color(get_theme_mod('readora_accent_color', '#e63946'));
	$font_size = readora_sanitize_font_size(get_theme_mod('readora_body_font_size', 16));

	$lines = array();

	// Accent color — update the CSS custom properties so every element
	// that uses var(--color-primary) / var(--color-accent-text) reflects it,
	// in both light and dark mode, with readable text-on-background variants.
	if ($accent && $accent !== '#e63946') {
		$lines[] = ":root { --color-primary: {$accent}; --color-primary-dark: {$accent}; --color-accent-text: {$accent}; }";
		$lines[] = "html.dark-mode { --color-accent-text: {$accent}; }";
		$lines[] = "@supports (color: color-mix(in srgb, red, blue)) { :root { --color-primary-dark: color-mix(in srgb, {$accent} 82%, #000); --color-accent-text: color-mix(in srgb, {$accent} 78%, #000); } html.dark-mode { --color-accent-text: color-mix(in srgb, {$accent} 78%, #fff); } }";
	}

	// Font size — update root font-size which the rem-based scale inherits.
	if ($font_size && $font_size !== 16) {
		$lines[] = "html { font-size: {$font_size}px; }";
	}

	if (empty($lines)) {
		return;
	}

	wp_register_style('readora-customizer-inline', false, array(), READORA_VERSION);
	wp_enqueue_style('readora-customizer-inline');
	wp_add_inline_style('readora-customizer-inline', implode("\n", array_map('wp_strip_all_tags', $lines)));
}
add_action('wp_enqueue_scripts', 'readora_customizer_inline_css', 20);


/* =============================================================
   LIVE PREVIEW JS (postMessage transport)
   Enqueued only inside the Customizer preview iframe.
   The file assets/js/customizer-preview.js handles live updates
   without page reload for accent color and font size.
   ============================================================= */

function readora_customize_preview_js()
{
	wp_enqueue_script(
		'readora-customizer-preview',
		READORA_URI . '/assets/js/customizer-preview.js',
		array('customize-preview'),
		READORA_VERSION,
		true
	);
}
add_action('customize_preview_init', 'readora_customize_preview_js');

/**
 * Enqueue script for Customizer CONTROLS panel (sidebar).
 * Used for UI enhancements like showing range slider values.
 */
function readora_customize_controls_js()
{
	wp_add_inline_script(
		'customize-controls',
		"
        jQuery( document ).ready( function( $ ) {
            // Show live value next to every range slider
            $( document ).on( 'input', 'input[type=\"range\"]', function() {
                var \$input  = $( this );
                var \$badge  = \$input.next( '.tm-range-val' );
                if ( ! \$badge.length ) {
                    \$badge = $( '<span class=\"tm-range-val\" style=\"margin-left:8px;font-weight:600;\"></span>' );
                    \$input.after( \$badge );
                }
                \$badge.text( \$input.val() + 'px' );
            } );

            // Init all range sliders on load
            $( 'input[type=\"range\"]' ).each( function() {
                var \$input = $( this );
                if ( ! \$input.next( '.tm-range-val' ).length ) {
                    \$input.after(
                        '<span class=\"tm-range-val\" style=\"margin-left:8px;font-weight:600;\">'
                        + \$input.val() + 'px</span>'
                    );
                }
            } );
        } );
        "
	);
}
add_action('customize_controls_enqueue_scripts', 'readora_customize_controls_js');

// Sanitize embed code — allows form/embed elements only, blocks <script> for non-admins.
function readora_sanitize_newsletter_embed($value)
{
	// Only administrators can access the Customizer.
	// We trust their input the same way WordPress trusts
	// admins in the Custom HTML widget and theme editor.
	if (current_user_can('unfiltered_html')) {
		return $value;
	}
	// For non-admin roles (shouldn't reach here via Customizer
	// but as a safety net), strip scripts.
	return wp_kses($value, array(
		'form' => array('action' => true, 'method' => true, 'id' => true, 'class' => true, 'target' => true, 'novalidate' => true),
		'input' => array('type' => true, 'name' => true, 'id' => true, 'class' => true, 'value' => true, 'placeholder' => true, 'required' => true, 'autocomplete' => true, 'tabindex' => true, 'aria-hidden' => true),
		'button' => array('type' => true, 'name' => true, 'id' => true, 'class' => true, 'value' => true),
		'label' => array('for' => true, 'class' => true),
		'div' => array('id' => true, 'class' => true, 'style' => true, 'aria-hidden' => true),
		'span' => array('id' => true, 'class' => true, 'style' => true),
		'p' => array('id' => true, 'class' => true, 'style' => true),
		'a' => array('href' => true, 'target' => true, 'rel' => true, 'class' => true, 'title' => true),
		'iframe' => array('id' => true, 'title' => true, 'src' => true, 'frameborder' => true, 'scrolling' => true, 'allowtransparency' => true, 'allow' => true, 'style' => true, 'onload' => true, 'width' => true, 'height' => true),
		'img' => array('src' => true, 'alt' => true, 'style' => true, 'width' => true, 'height' => true, 'class' => true),
		'h2' => array('class' => true),
		'strong' => array(),
		'em' => array(),
		'br' => array(),
		'select' => array('name' => true, 'id' => true, 'class' => true),
		'option' => array('value' => true, 'selected' => true),
		'textarea' => array('name' => true, 'id' => true, 'class' => true, 'rows' => true, 'placeholder' => true),
	));
}

// ============================================================
// HEADER TEXT COLOR
// ============================================================
function readora_header_style()
{
	$header_text_color = get_header_textcolor();

	// 'blank' means the user chose "Hide" — hide site title/tagline.
	if ('blank' === $header_text_color) {
		?>
		<style id="readora-header-text-style">
			.tm-brand__text,
			.tm-brand__link,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		</style>
		<?php
		return;
	}

	// Only output if color differs from the theme default.
	$default_color = get_theme_support('custom-header', 'default-text-color');
	if ($header_text_color === $default_color) {
		return;
	}

	?>
	<style id="readora-header-text-style">
		.tm-brand__text,
		.tm-brand__link,
		.tm-brand__text span,
		.site-description {
			color: #<?php echo sanitize_hex_color_no_hash($header_text_color); ?>;
		}
	</style>
	<?php
}
add_action('wp_head', 'readora_header_style', 10);
