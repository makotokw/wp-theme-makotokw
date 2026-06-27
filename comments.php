<?php
/**
 * The template for displaying comments
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
if ( post_password_required() ) {
	return;
}

$makotokw_has_comments = have_comments();
?>

<aside id="comments" class="comments<?php echo $makotokw_has_comments ? ' has-comments' : ''; ?>">
	<div class="section-inner">
		<?php if ( $makotokw_has_comments ) : ?>
			<h2 class="section-title">
				<?php
				printf(
					/* translators: %1$s: number of comments */
					_nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'makotokw' ),
					number_format_i18n( get_comments_number() )
				);
				?>
			</h2>

			<ol class="comment-list">
				<?php wp_list_comments( array( 'callback' => 'makotokw_comment' ) ); ?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-above" class="navigation-comment">
					<div class="nav-previous alignleft"><?php previous_comments_link( __( '&larr; Older Comments', 'makotokw' ) ); ?></div>
					<div class="nav-next alignright"><?php next_comments_link( __( 'Newer Comments &rarr;', 'makotokw' ) ); ?></div>
				</nav><!-- #comment-nav-before -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // $makotokw_has_comments ?>

		<div class="comment-form-section">
			<?php comment_form( array( 'format' => 'html5' ) ); ?>
		</div>
	</div>
</aside><!-- #comments -->
