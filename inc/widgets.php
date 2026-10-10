<?php
/**
 * Widget area registration — Readora
 *
 * @package Readora
 */

if (!defined('ABSPATH'))
    exit;

function readora_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'readora'),
        'id'            => 'sidebar-main',
        'description'   => esc_html__('Widgets added here appear in the sidebar on the homepage, archives, and search results.', 'readora'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer', 'readora'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Widgets added here appear in the footer, alongside the Quick Links menu.', 'readora'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'readora_widgets_init');
