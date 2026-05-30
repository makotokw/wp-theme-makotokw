<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the id=main div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makotokw
 */

?>
	</main><!-- .site-content -->
	<?php get_sidebar(); ?>
</div><!-- .site-main -->
<footer class="site-footer" role="contentinfo">
	<div class="section-inner">
		<div class="footer-navs">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'footer-menu',
					'container_class' => 'site-footer-help-nav',
					'link_before'     => '',
					'link_after'      => '',
					'fallback_cb'     => false,
				)
			);
			?>
		</div>
		<div class="footer-credits">
			<span class="copyright">&copy; <?php echo gmdate( 'Y' ); ?>&nbsp;<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span>
			<?php
				$makotokw_wp_theme   = wp_get_theme();
				$makotokw_theme_name = $makotokw_wp_theme->display( 'Name' );
				$makotokw_powered_by = sprintf(
					/* translators: %s: WordPress link */
					__( 'Powered by %s', 'makotokw' ),
					'<a href="https://wordpress.org/" title="' . esc_attr( __( 'Semantic Personal Publishing Platform', 'makotokw' ) ) . '">WordPress</a>'
				);
				?>
			<span class="powered-by">
				<?php echo $makotokw_powered_by; ?><img class="emoji" alt="❤" src="https://s.w.org/images/core/emoji/72x72/2764.png" width="10" height="10"><a href="https://github.com/makotokw/wp-theme-makotokw/tree/<?php echo $makotokw_theme_name; ?>">Theme <i class="fab fa-github"></i></a> by <a href="https://makotokw.com">makoto_kw</a>
			</span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
