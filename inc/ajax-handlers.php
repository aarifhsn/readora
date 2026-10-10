<?php
if (!defined('ABSPATH'))
    exit;

// AJAX handler for built-in form
function readora_newsletter_subscribe()
{
    check_ajax_referer('readora_newsletter_subscribe', 'newsletter_nonce');
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    if (!is_email($email)) {
        wp_send_json_error(array('message' => esc_html__('Please enter a valid email address.', 'readora')));
    }
    $subscribers = get_option('readora_newsletter_subscribers', array());
    if (in_array($email, $subscribers, true)) {
        wp_send_json_success(array('message' => esc_html__('You are already subscribed!', 'readora')));
    }
    $subscribers[] = $email;
    update_option('readora_newsletter_subscribers', $subscribers, false);
    wp_send_json_success(array('message' => esc_html__('Thank you for subscribing!', 'readora')));
}
add_action('wp_ajax_readora_newsletter_subscribe', 'readora_newsletter_subscribe');
add_action('wp_ajax_nopriv_readora_newsletter_subscribe', 'readora_newsletter_subscribe');
