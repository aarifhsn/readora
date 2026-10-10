<?php
/**
 * Local font loading — Readora
 * Self-hosts Inter, Playfair Display, JetBrains Mono.
 *
 * @package Readora
 */

if (!defined('ABSPATH'))
    exit;

/**
 * Register @font-face declarations for locally hosted fonts.
 * Font files live in assets/fonts/
 */
function readora_self_hosted_fonts()
{
    wp_enqueue_style(
        'readora-fonts',
        READORA_URI . '/assets/css/fonts.css',
        array(),
        READORA_VERSION
    );
}
add_action('wp_enqueue_scripts', 'readora_self_hosted_fonts', 1);
add_action('enqueue_block_editor_assets', 'readora_self_hosted_fonts');
