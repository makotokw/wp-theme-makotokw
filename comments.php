<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to makotokw_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package makotokw
 */
?>

<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required())
	return;

?>

<aside id="comments" class="section section-default section-comment">

	<?php // You can start editing here -- including this comment! ?>

	<?php if (have_comments()) : ?>

		<h2 class="section-title section-comments-title">
			<?php
			printf(_nx('1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'makotokw'),
				number_format_i18n(get_comments_number()));
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(array('callback' => 'makotokw_comment'));
			?>
		</ol><!-- .comment-list -->

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="navigation-comment" role="navigation">
				<h1 class="screen-reader-text"><?php _e('Comment navigation', 'makotokw'); ?></h1>

				<div
					class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'makotokw')); ?></div>
				<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'makotokw')); ?></div>
			</nav><!-- #comment-nav-before -->
		<?php endif; // check for comment navigation ?>


		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.' , 'makotokw' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(array('format' => 'html5')); ?>

</aside><!-- #comments -->
