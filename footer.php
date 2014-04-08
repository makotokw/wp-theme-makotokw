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
<?php if (!is_preview()): ?>
<?php if (WP_THEME_FB_RECOMMEND_BAR === true): ?>
<?php makotokw_facebook_recommendations_bar(); ?>
<?php endif; ?>
<?php endif ?>
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="site-info">
			<div class="copyrights">
				<div class="credit">
					<?php do_action( 'makotokw_credits' ); ?>
				</div>
				<div class="poweredby">
					<?php printf( __( 'Powered by %s', 'makotokw' ),
						'<a href="http://wordpress.org/" title="' . esc_attr( __( 'Semantic Personal Publishing Platform', 'makotokw' ) ).'">WordPress</a>' ) ?>
					<a href="https://github.com/makotokw/wp-theme-makotokw" class="theme">makotokw themne</a>.
				</div>
			</div>
		</div>
	</div>
</footer>
</div><!-- #page -->
<?php wp_footer(); ?>
<?php if (WP_THEME_ITUNES_AFFILIATE_ID != false): ?>
<?php makotokw_itunes_affiliate_script(); ?>
<?php endif ?>
<?php if (WP_THEME_DEBUG): ?>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':38085/livereload.js?snipver=1"></' + 'script>')</script>
<?php endif ?>
</body>
</html>