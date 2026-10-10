<?php

if (!defined('ABSPATH'))
    exit;

// ============================================================
// ENQUEUE SCRIPTS AND STYLES
// ============================================================

function readora_dark_mode_inline_script()
{
    wp_register_script('readora-darkmode-init', false, array(), null, false);
    wp_enqueue_script('readora-darkmode-init');
    wp_add_inline_script('readora-darkmode-init', "
        (function () {
            try {
                var saved = localStorage.getItem('readora_dark');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var isDark = saved !== null ? saved === 'true' : prefersDark;
                if (isDark) {
                    document.documentElement.classList.add('dark-mode');
                } else {
                    document.documentElement.classList.add('light-mode');
                }
            } catch (e) {}
        })();
    ");
}
add_action('wp_enqueue_scripts', 'readora_dark_mode_inline_script', 1);

function readora_scripts()
{

    $version = READORA_VERSION;

    // Tailwind first, so style.css can override it.
    wp_enqueue_style(
        'readora-tailwind',
        READORA_URI . '/assets/css/tailwind.output.css',
        array(),
        $version
    );

    // Main CSS — loads after Tailwind so it can override tokens/components.
    wp_enqueue_style(
        'readora-style',
        get_stylesheet_uri(),
        array('readora-tailwind'),
        $version
    );


    // Main JS (vanilla, no jQuery dependency).
    wp_enqueue_script(
        'readora-main',
        READORA_URI . '/assets/js/main.js',
        array(),
        $version,
        array(
            'in_footer' => true,
            'strategy' => 'defer',
        )
    );

    // Inline data for JS.
    wp_localize_script(
        'readora-main',
        'ReadoraData',
        array(
            'ajaxUrl' => esc_url(admin_url('admin-ajax.php')),
            'nonce' => wp_create_nonce('readora_nonce'),
            'homeUrl' => esc_url(home_url('/')),
            'i18n' => array(
                'searchPlaceholder' => esc_html__('Search articles...', 'readora'),
                'darkMode' => esc_html__('Toggle dark mode', 'readora'),
            ),
        )
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'readora_scripts');


// Block editor styles.
function readora_block_editor_styles()
{
    wp_enqueue_style(
        'readora-editor-style',
        READORA_URI . '/assets/css/editor-style.css',
        array(),
        READORA_VERSION
    );
}
add_action('enqueue_block_editor_assets', 'readora_block_editor_styles');
