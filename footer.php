<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package makotokw
 */
?>
</div><!-- #main -->
<?php if (!is_preview()): ?>
<?php if (WP_THEME_FB_RECOMMEND_BAR === true): ?>
<?php makotokw_facebook_recommendations_bar(); ?>
<?php endif; ?>
<?php endif ?>
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-info">
		<?php wp_nav_menu(
			array(
				'theme_location' => 'site-info',
				'depth' => 1,
				'container_class' => 'navi',
				'link_before' => '',
				'link_after' => '',
			))
		; ?>
		<span class="credit">
			<?php do_action( 'makotokw_credits' ); ?>
		</span>
		<span class="poweredby">
			<?php printf( __( 'Powered by %s', 'makotokw' ),
				'<a href="http://wordpress.org/" title="' . esc_attr( __( 'Semantic Personal Publishing Platform', 'makotokw' ) ).'">WordPress</a>' ) ?>
			<a href="https://github.com/makotokw/wp-theme-makotokw" class="theme">makotokw</a> theme.
		</span>
	</div>
</footer>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>