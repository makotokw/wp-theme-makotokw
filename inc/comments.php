<?php
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function makotokw_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$is_trackback = ($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback');
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="comment-author vcard">
				<?php if ( ! $is_trackback ): ?>
					<?php echo get_avatar( $comment, 50 ); ?>
				<?php endif; ?>
				<div class="comment-metadata">
					<?php printf( '<cite class="fn">%1$s %2$s</cite>', ($is_trackback ? '<i class="fa fa-external-link"></i>' : ''), get_comment_author_link() ); ?>
					<?php
					printf(
						'<a class="comment-time" href="%1$s"><time class="time" datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time(),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'makotokw' ), get_comment_date( THEME_DATE_FORMAT ), get_comment_time() )
					); ?>
					<?php edit_comment_link( __( 'Edit', 'makotokw' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' ); ?>
				</div>
			</div>
			<!-- .comment-meta -->
			<div class="comment-content">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'makotokw' ); ?></em>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<?php if ( ! $is_trackback ): ?>
				<div class="reply">
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'depth' => $depth,
								'max_depth' => $args['max_depth'],
							)
						)
					); ?>
				</div><!-- .reply -->
			<?php endif; ?>
		</article>
		<!-- #comment-## -->
	<?php
} // ends check for makotokw_comment()
