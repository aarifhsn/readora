<?php
if (!defined('ABSPATH'))
    exit;

// ============================================================
// THEME SETUP
// ============================================================

if (!function_exists('readora_setup')):

    function readora_setup()
    {

        load_theme_textdomain('readora', READORA_DIR . '/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        // Editor styles
        add_editor_style('assets/css/editor-style.css');

        add_theme_support('custom-logo', array(
            'height' => 80,
            'width' => 300,
            'flex-width' => true,
            'flex-height' => true,
        ));

        add_theme_support('custom-header', array(
            'width' => 1200,
            'height' => 400,
            'flex-width' => true,
            'flex-height' => true,
            'uploads' => true,
            'header-text' => true,
            'default-image' => '',
            'default-text-color' => '151514',
        ));

        add_theme_support('custom-background', array(
            'default-color' => 'faf9f7',
        ));

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'navigation-widgets',
        ));

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('editor-color-palette', array(
            array('name' => esc_html__('Primary', 'readora'), 'slug' => 'primary', 'color' => '#e63946'),
            array('name' => esc_html__('Dark', 'readora'), 'slug' => 'dark', 'color' => '#151514'),
            array('name' => esc_html__('Muted', 'readora'), 'slug' => 'muted', 'color' => '#6d6c66'),
            array('name' => esc_html__('Light', 'readora'), 'slug' => 'light', 'color' => '#f0eee9'),
        ));

        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('wp-block-styles');

        register_nav_menus(array(
            'main-menu' => esc_html__('Primary Menu', 'readora'),
            'footer-menu' => esc_html__('Footer Menu', 'readora'),
        ));

        set_post_thumbnail_size(800, 450, true);
        add_image_size('readora-card', 600, 338, true);
        add_image_size('readora-featured', 1200, 525, true);
        add_image_size('readora-sidebar', 320, 200, true);
        add_image_size('readora-square', 300, 300, true);

        // Register a simple block pattern
        register_block_pattern(
            'readora/hero-text',
            array(
                'title' => esc_html__('Hero Text', 'readora'),
                'description' => esc_html__('A simple hero text block', 'readora'),
                'content' => '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">Welcome to our site</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Add your description here.</p><!-- /wp:paragraph -->',
                'categories' => array('text'),
            )
        );

        // Register a block style
        register_block_style(
            'core/quote',
            array(
                'name' => 'readora-highlighted',
                'label' => esc_html__('Highlighted', 'readora'),
            )
        );

    }

endif;
add_action('after_setup_theme', 'readora_setup');


// ============================================================
// CONTENT WIDTH
// ============================================================

function readora_content_width()
{
    $GLOBALS['content_width'] = apply_filters('readora_content_width', 720);
}
add_action('after_setup_theme', 'readora_content_width', 0);
