<?php

if (!defined('ABSPATH'))
    exit;

// ============================================================
// PAGINATION
// ============================================================

function readora_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $links = paginate_links(array(
        'base' => str_replace(PHP_INT_MAX, '%#%', esc_url(get_pagenum_link(PHP_INT_MAX))),
        'format' => '?paged=%#%',
        'current' => $paged,
        'total' => $wp_query->max_num_pages,
        'type' => 'array',
        'prev_text' => esc_html__('&larr; Prev', 'readora'),
        'next_text' => esc_html__('Next &rarr;', 'readora'),
        'mid_size' => 2,
    ));

    if (!empty($links)) {
        echo '<nav class="pagination" aria-label="' . esc_attr__('Posts navigation', 'readora') . '">';
        foreach ($links as $link) {
            echo wp_kses_post($link);
        }
        echo '</nav>';
    }
}


// ============================================================
// BREADCRUMBS
// ============================================================

function readora_breadcrumbs()
{
    if (is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb navigation', 'readora') . '">';
    echo '<div class="tm-container">';
    echo '<ol class="breadcrumbs__inner" itemscope itemtype="https://schema.org/BreadcrumbList">';

    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a href="' . esc_url(home_url('/')) . '" itemprop="item"><span itemprop="name">' .
        esc_html__('Home', 'readora') . '</span></a>';
    echo '
                    <meta itemprop="position" content="1" />';
    echo '
                </li>';

    $position = 2;

    if (is_category() || is_single()) {
        $cats = get_the_category();
        if (!empty($cats)) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url(get_category_link($cats[0]->term_id)) . '" itemprop="item"><span
                            itemprop="name">' . esc_html($cats[0]->name) . '</span></a>';
            echo '
                    <meta itemprop="position" content="' . esc_attr($position) . '" />';
            echo '
                </li>';
            $position++;
        }
        if (is_single()) {
            echo '<li class="breadcrumbs__current" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem" aria-current="page">';
            echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
            echo '
                    <meta itemprop="position" content="' . esc_attr($position) . '" />';
            echo '
                </li>';
        }
    } elseif (is_page()) {
        echo '<li class="breadcrumbs__current" aria-current="page"><span>' . esc_html(get_the_title()) .
            '</span></li>';
    } elseif (is_archive()) {
        echo '<li class="breadcrumbs__current" aria-current="page"><span>' . esc_html(get_the_archive_title()) .
            '</span></li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumbs__current" aria-current="page">';
        echo '<span>' . sprintf(esc_html__('Search: %s', 'readora'), '<q>' .
            esc_html(get_search_query()) . '</q>') . '</span>';
        echo '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumbs__current" aria-current="page"><span>' . esc_html__(
            '404 Not Found',
            'readora'
        ) . '</span></li>';
    }

    echo '</ol>
        </div>
    </nav>';
}


// ============================================================
// READING TIME
// ============================================================

function readora_reading_time($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(wp_strip_all_tags($content));
    $minutes = max(1, (int) ceil($word_count / 200));

    return sprintf(
        /* translators: %d: number of minutes */
        _n('%d min read', '%d min read', $minutes, 'readora'),
        $minutes
    );
}

function readora_reading_time_html($post_id = null)
{
    printf(
        '<span class="reading-time"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" aria-hidden="true">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
        </svg>%s</span>',
        esc_html(readora_reading_time($post_id))
    );
}


// ============================================================
// POST META HELPERS
// ============================================================

function readora_posted_on()
{
    $time_string = sprintf(
        '<time class="entry-date published" datetime="%1$s">%2$s</time>',
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );
    printf(
        '<span class="post-meta__date"><a href="%s" rel="bookmark">%s</a></span>',
        esc_url(get_permalink()),
        $time_string // phpcs:ignore
    );
}

function readora_posted_by()
{
    printf(
        '<span class="post-meta__author"><a href="%s" rel="author">%s</a></span>',
        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
        esc_html(get_the_author())
    );
}

// ============================================================
// RECENT COMMENTS HELPER
// ============================================================

function readora_get_recent_comments($count = 5)
{
    $query = new WP_Comment_Query(array(
        'number' => absint($count),
        'status' => 'approve',
        'type' => 'comment',
    ));

    $output = array();
    foreach ($query->comments as $comment) {
        $output[] = array(
            'id' => $comment->comment_ID,
            'author' => get_comment_author($comment),
            'avatar' => get_avatar($comment->comment_author_email, 40, '', '', array('class' => '')),
            'excerpt' => wp_trim_words(wp_strip_all_tags($comment->comment_content), 12, '&hellip;'),
            'link' => esc_url(get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID),
            'post' => esc_html(get_the_title($comment->comment_post_ID)),
        );
    }
    return $output;
}


// ============================================================
// SIDEBAR POST HELPERS
// ============================================================

function readora_get_recent_posts($count = 4)
{
    return new WP_Query(array(
        'posts_per_page' => absint($count),
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
        'no_found_rows' => true,
    ));
}

function readora_get_popular_posts($count = 4)
{
    return new WP_Query(array(
        'posts_per_page' => absint($count),
        'post_status' => 'publish',
        'orderby' => 'comment_count',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
        'no_found_rows' => true,
    ));
}



// ============================================================
// EXCERPT
// ============================================================

function readora_excerpt_length($length)
{
    return is_admin() ? $length : 25;
}
add_filter('excerpt_length', 'readora_excerpt_length', 999);

function readora_excerpt_more($more)
{
    if (is_admin()) {
        return $more;
    }
    return '&hellip;';
}
add_filter('excerpt_more', 'readora_excerpt_more');



// ============================================================
// BODY CLASSES
// ============================================================

function readora_body_classes($classes)
{
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }
    if (is_singular() && !is_home()) {
        $classes[] = 'singular';
    }
    if (is_singular('post') && !get_theme_mod('readora_single_sidebar', false)) {
        $classes[] = 'single-no-sidebar';
    }
    if (is_page() && !get_theme_mod('readora_page_sidebar', false)) {
        $classes[] = 'single-no-sidebar';
    }
    return $classes;
}
add_filter('body_class', 'readora_body_classes');
