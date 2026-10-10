<?php

if (!defined('ABSPATH'))
    exit;




// ============================================================
// COMMENT WALKER
// ============================================================

if (!class_exists('Readora_Comment_Walker')):

    class Readora_Comment_Walker extends Walker_Comment
    {

        protected function comment($comment, $depth, $args)
        { // phpcs:ignore
            $GLOBALS['comment'] = $comment; // phpcs:ignore
            ?>
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-item', $comment); ?>>
                <article class="comment-body">
                    <div class="comment-meta">
                        <div class="comment-avatar">
                            <?php echo get_avatar($comment, 44, '', '', array('class' => '')); ?>
                        </div>
                        <div>
                            <p class="comment-author-name">
                                <?php comment_author_link($comment); ?>
                            </p>
                            <time class="comment-time" datetime="<?php comment_date('c'); ?>">
                                <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                                    <?php
                                    printf(
                                        esc_html_x('%1$s at %2$s', 'comment date and time', 'readora'),
                                        esc_html(get_comment_date('', $comment)),
                                        esc_html(get_comment_time())
                                    );
                                    ?>
                                </a>
                            </time>
                        </div>
                    </div>
                    <?php if ('0' === $comment->comment_approved): ?>
                        <p class="comment-awaiting-moderation">
                            <?php esc_html_e('Your comment is awaiting moderation.', 'readora'); ?>
                        </p>
                    <?php endif; ?>
                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div>
                    <footer class="comment-footer">
                        <?php
                        comment_reply_link(array_merge($args, array(
                            'add_below' => 'comment',
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                            'before' => '<span class="comment-reply">',
                            'after' => '</span>',
                        )));
                        ?>
                    </footer>
                </article>
                <?php
        }

        protected function ping($comment, $depth, $args)
        { // phpcs:ignore
            $GLOBALS['comment'] = $comment; // phpcs:ignore
            ?>
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('', $comment); ?>>
                <article class="comment-body comment-body--ping">
                    <p class="comment-author-name">
                        <?php esc_html_e('Pingback:', 'readora'); ?>
                        <?php comment_author_link($comment); ?>
                    </p>
                </article>
                <?php
        }
    }

endif;


// ============================================================
// COMMENT FORM
// ============================================================

function readora_comment_form_args($args)
{
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $html_req = $req ? ' required aria-required="true"' : '';

    $args['comment_notes_before'] = '';
    $args['comment_notes_after'] = '';
    $args['title_reply'] = esc_html__('Leave a Comment', 'readora');
    $args['label_submit'] = esc_html__('Post Comment', 'readora');
    $args['class_submit'] = 'submit';
    $args['class_form'] = 'comment-form';
    $args['id_submit'] = 'submit-comment';

    $args['fields'] = array(
        'author' => sprintf(
            '<div class="comment-form-field"><label for="author">%s%s</label><input id="author" name="author" type="text" value="%s" maxlength="245" autocomplete="name"%s /></div>',
            esc_html__('Name', 'readora'),
            $req ? ' <span class="required" aria-hidden="true">*</span>' : '',
            esc_attr($commenter['comment_author']),
            $html_req
        ),
        'email' => sprintf(
            '<div class="comment-form-field"><label for="email">%s%s</label><input id="email" name="email" type="email" value="%s" maxlength="100" autocomplete="email"%s /></div>',
            esc_html__('Email', 'readora'),
            $req ? ' <span class="required" aria-hidden="true">*</span>' : '',
            esc_attr($commenter['comment_author_email']),
            $html_req
        ),
        'url' => sprintf(
            '<div class="comment-form-field"><label for="url">%s</label><input id="url" name="url" type="url" value="%s" maxlength="200" autocomplete="url" /></div>',
            esc_html__('Website', 'readora'),
            esc_attr($commenter['comment_author_url'])
        ),
    );

    $args['comment_field'] = sprintf(
        '<div class="comment-form-field"><label for="comment">%s <span class="required" aria-hidden="true">*</span></label><textarea id="comment" name="comment" rows="6" required aria-required="true"></textarea></div>',
        esc_html__('Comment', 'readora')
    );

    return $args;
}
add_filter('comment_form_defaults', 'readora_comment_form_args');
