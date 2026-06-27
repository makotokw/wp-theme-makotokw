<?php
/**
 * @var array $args
 */
$makotokw_title    = isset( $args['title'] ) ? $args['title'] : '';
$makotokw_contents = isset( $args['contents'] ) ? $args['contents'] : '';

get_header();
the_post();
?>
	<article class="post-detailed">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo esc_html( $makotokw_title ); ?></h1>
		</header>
		<div class="entry-content section-inner">
			<?php
			// $makotokw_contents is trusted markup buffered from a page template (see template-archives.php etc.); wp_kses_post would strip required tags/attributes.
			echo $makotokw_contents; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
	</article>
<?php
get_footer();
