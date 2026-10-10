<?php
/**
 * Comments template
 *
 * @package Readora
 * @since   1.0.0
 */

if (!defined('ABSPATH'))
	exit;

if (post_password_required()): ?>
	<div class="tm-comments-note">
		<p>
			<?php esc_html_e('This post is password protected. Enter the password to view comments.', 'readora'); ?>
		</p>
	</div>
	<?php return;
endif;
?>

<?php if (have_comments()): ?>

	<section class="tm-comments" aria-labelledby="comments-title">

		<h2 class="tm-comments__title" id="comments-title">
			<?php
			$count = (int) get_comments_number();
			printf(
				/* translators: %s: number of comments */
				esc_html(_n('%s Comment', '%s Comments', $count, 'readora')),
				esc_html(number_format_i18n($count))
			);
			?>
		</h2>

		<ol class="comment-list tm-comment-list">
			<?php wp_list_comments(array(
				'walker' => new Readora_Comment_Walker(),
				'style' => 'ol',
				'short_ping' => true,
				'avatar_size' => 44,
			)); ?>
		</ol>

		<!-- Comment pagination -->
		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
			<nav class="tm-comments__nav"
				aria-label="<?php esc_attr_e('Comment navigation', 'readora'); ?>">
				<span><?php previous_comments_link(esc_html__('&larr; Older Comments', 'readora')); ?></span>
				<span><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'readora')); ?></span>
			</nav>
		<?php endif; ?>

	</section>

<?php endif; ?>

<?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
	<p class="tm-comments-note">
		<?php esc_html_e('Comments are closed.', 'readora'); ?>
	</p>
<?php endif; ?>

<!-- Comment form -->
<div class="tm-respond" id="respond">
	<?php comment_form(array(
		'title_reply_before' => '<h2 class="tm-respond__title" id="reply-title">',
		'title_reply_after' => '</h2>',
	)); ?>
</div>
