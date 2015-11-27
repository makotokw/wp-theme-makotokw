<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package makotokw
 */
?>
		<div id="footerMargin"></div>
		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<div class="site-info">
					<div class="copyrights">
						<div class="credit">
							<?php do_action( 'makotokw_credits' ); ?>
						</div>
						<div class="poweredby">
							<?php
							printf(
								__( 'Powered by %s', 'makotokw' ),
								'<a href="http://wordpress.org/" title="' . esc_attr( __( 'Semantic Personal Publishing Platform', 'makotokw' ) ) . '">WordPress</a>'
							) ?><i class="fa fa-heart"></i><a href="https://github.com/makotokw/wp-theme-makotokw">makotokw theme<i class="fa fa-github-alt"></i></a>.
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div><!-- #page -->
	<?php wp_footer(); ?>
	<?php if ( false != WP_THEME_ITUNES_AFFILIATE_ID ) : ?>
		<?php makotokw_itunes_affiliate_script(); ?>
	<?php endif ?>
</body>
</html>
