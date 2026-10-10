<?php

if (!defined('ABSPATH'))
    exit;

// ============================================================
// SECURITY
// ============================================================

function readora_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'readora_disable_emojis');


// Generic login error to prevent user enumeration.
function readora_login_error_message()
{
    return esc_html__('Incorrect credentials. Please try again.', 'readora');
}
add_filter('login_errors', 'readora_login_error_message');
