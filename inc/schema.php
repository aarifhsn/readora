<?php

if (!defined('ABSPATH'))
    exit;

// ============================================================
// SCHEMA.ORG — ARTICLE (single posts)
// ============================================================

function readora_article_schema()
{
    if (!is_singular('post')) {
        return;
    }

    $post = get_queried_object();
    $author_id = $post->post_author;

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => esc_html(get_the_title()),
        'datePublished' => esc_html(get_the_date('c')),
        'dateModified' => esc_html(get_the_modified_date('c')),
        'author' => array(
            '@type' => 'Person',
            'name' => esc_html(get_the_author_meta('display_name', $author_id)),
            'url' => esc_url(get_author_posts_url($author_id)),
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => esc_html(get_bloginfo('name')),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => esc_url(get_site_icon_url(60)),
            ),
        ),
        'description' => esc_html(wp_trim_words(get_the_excerpt(), 30, '')),
    );

    $thumbnail_id = get_post_thumbnail_id();
    if ($thumbnail_id) {
        $thumb_src = wp_get_attachment_image_src($thumbnail_id, 'readora-featured');
        if ($thumb_src) {
            $schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => esc_url($thumb_src[0]),
                'width' => absint($thumb_src[1]),
                'height' => absint($thumb_src[2]),
            );
        }
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'readora_article_schema');


// ============================================================
// OPEN GRAPH META TAGS
// ============================================================

function readora_og_tags()
{
    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION')) {
        return;
    }

    if (is_singular()) {
        // CORRECT — escape at output, not just at save
        $title = esc_attr(wp_strip_all_tags(get_the_title()));
        $description = esc_attr(wp_strip_all_tags(wp_trim_words(get_the_excerpt(), 30, '')));
        $url = esc_url(get_permalink());
        $site_name = esc_attr(get_bloginfo('name'));

        // Use printf with pre-escaped vars — never echo raw
        printf('<meta property="og:type"        content="article">' . "\n");
        printf('<meta property="og:title"       content="%s">' . "\n", $title);
        printf('<meta property="og:description" content="%s">' . "\n", $description);
        printf('<meta property="og:url"         content="%s">' . "\n", $url);
        printf('<meta property="og:site_name"   content="%s">' . "\n", $site_name);

        if (has_post_thumbnail()) {
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'readora-featured');
            if ($thumb) {
                printf('<meta property="og:image"        content="%s">' . "\n", esc_url($thumb[0]));
                printf('<meta property="og:image:width"  content="%d">' . "\n", absint($thumb[1]));
                printf('<meta property="og:image:height" content="%d">' . "\n", absint($thumb[2]));
            }
        }

        printf('<meta name="twitter:card"        content="summary_large_image">' . "\n");
        printf('<meta name="twitter:title"       content="%s">' . "\n", $title);
        printf('<meta name="twitter:description" content="%s">' . "\n", $description);

    } elseif (is_front_page() || is_home()) {
        printf('<meta property="og:type"        content="website">' . "\n");
        printf('<meta property="og:title"       content="%s">' . "\n", esc_attr(get_bloginfo('name')));
        printf('<meta property="og:description" content="%s">' . "\n", esc_attr(get_bloginfo('description')));
        printf('<meta property="og:url"         content="%s">' . "\n", esc_url(home_url('/')));
    }
}

add_action('wp_head', 'readora_og_tags');
