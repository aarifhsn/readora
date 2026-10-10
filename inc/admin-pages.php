<?php
if (!defined('ABSPATH'))
    exit;

// Admin subscribers page (only shows when provider = builtin)
function readora_newsletter_admin_menu()
{
    if ('builtin' !== get_theme_mod('readora_newsletter_provider', 'embed'))
        return;
    add_theme_page(
        esc_html__('Newsletter Subscribers', 'readora'),
        esc_html__('Newsletter Subscribers', 'readora'),
        'manage_options',
        'readora-subscribers',
        'readora_newsletter_subscribers_page'
    );
}
add_action('admin_menu', 'readora_newsletter_admin_menu');

function readora_newsletter_subscribers_page()
{
    if (!current_user_can('manage_options'))
        return;
    $subscribers = get_option('readora_newsletter_subscribers', array());
    $export_url = wp_nonce_url(
        add_query_arg(array('page' => 'readora-subscribers', 'export' => 'csv'), admin_url('themes.php')),
        'readora_export_subscribers'
    );
    if (isset($_GET['export']) && 'csv' === $_GET['export']) {
        check_admin_referer('readora_export_subscribers');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=subscribers-' . gmdate('Y-m-d') . '.csv');

        // Build CSV content without fopen/fclose
        $csv = 'Email Address' . "\n";
        foreach ($subscribers as $email) {
            $csv .= esc_html($email) . "\n";
        }

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $csv;
        exit;
    }
    echo '<div class="wrap">
    <h1>' . esc_html__('Newsletter Subscribers', 'readora') . '</h1>';
    if (empty($subscribers)) {
        echo '<p>' . esc_html__('No subscribers yet.', 'readora') . '</p>';
    } else {
        echo '<p>' . sprintf(esc_html__('%d subscriber(s).', 'readora'), count($subscribers)) . ' <a
            href="' . esc_url($export_url) . '" class="button button-primary">' . esc_html__(
            'Export CSV',
            'readora'
        ) . '</a></p>';
        echo '<table class="widefat striped" style="max-width:500px">
        <thead>
            <tr>
                <th>#</th>
                <th>' . esc_html__('Email', 'readora') . '</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($subscribers as $i => $email) {
            echo '<tr>
                <td>' . absint($i + 1) . '</td>
                <td>' . esc_html($email) . '</td>
            </tr>';
        }
        echo '</tbody>
    </table>';
    }
    echo '
</div>';
}
