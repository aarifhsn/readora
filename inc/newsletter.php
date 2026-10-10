<?php
/**
 * Newsletter block output — Readora
 *
 * Renders the newsletter CTA block after single posts.
 * Called via: readora_newsletter_block()
 *
 * Provider modes (set in Customizer → Theme Options → Newsletter):
 *   embed   — user pastes full embed code from any provider
 *   builtin — simple form, stores emails in WordPress via AJAX
 *
 * @package Readora
 * @since   1.0.0
 */

if (!defined('ABSPATH'))
    exit;

function readora_newsletter_block()
{

    // Respect show/hide toggle
    if (!get_theme_mod('readora_newsletter_show', true)) {
        return;
    }

    $eyebrow = get_theme_mod('readora_newsletter_eyebrow', __('Stay Updated', 'readora'));
    $heading = get_theme_mod('readora_newsletter_heading', __('Enjoyed this article?', 'readora'));
    $sub = get_theme_mod('readora_newsletter_subheading', __('Get the best stories delivered straight to your inbox. No spam, ever.', 'readora'));
    $note = get_theme_mod('readora_newsletter_note_text', __('No spam. Unsubscribe any time.', 'readora'));
    $provider = get_theme_mod('readora_newsletter_provider', 'embed');
    $embed_code = get_theme_mod('readora_newsletter_embed', '');
    ?>

    <div class="newsletter-block tm-newsletter">

        <?php if ($eyebrow): ?>
            <p class="tm-kicker"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($heading): ?>
            <h2 class="tm-newsletter__title"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($sub): ?>
            <p class="tm-newsletter__text"><?php echo esc_html($sub); ?></p>
        <?php endif; ?>

        <?php if ('embed' === $provider && !empty($embed_code)): ?>

            <!-- Provider embed code — sanitized on save in customizer.php -->
            <div class="tm-newsletter__embed">
                <?php echo $embed_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>

        <?php elseif ('embed' === $provider && empty($embed_code) && is_customize_preview()): ?>

            <!-- Shown only in Customizer preview when no embed code is set yet -->
            <div class="tm-newsletter__hint">
                <?php esc_html_e('Go to Customize → Theme Options → Newsletter and paste your embed code.', 'readora'); ?>
            </div>

        <?php else: ?>

            <!-- Built-in form — submitted via AJAX to ajax-handlers.php -->
            <form class="tm-newsletter__form readora-newsletter-form" method="post" novalidate>

                <?php wp_nonce_field('readora_newsletter_subscribe', 'newsletter_nonce'); ?>
                <input type="hidden" name="action" value="readora_newsletter_subscribe">

                <label for="newsletter-email-builtin" class="screen-reader-text">
                    <?php esc_html_e('Email address', 'readora'); ?>
                </label>

                <input type="email" id="newsletter-email-builtin" name="email" class="tm-newsletter__input"
                    placeholder="<?php esc_attr_e('your@email.com', 'readora'); ?>" required autocomplete="email">

                <button type="submit" class="tm-newsletter__btn">
                    <?php esc_html_e('Subscribe', 'readora'); ?>
                </button>

            </form>

        <?php endif; ?>

        <?php if ($note): ?>
            <p class="tm-newsletter__note"><?php echo esc_html($note); ?></p>
        <?php endif; ?>

    </div>

    <?php
}
