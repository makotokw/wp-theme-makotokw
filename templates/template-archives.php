<?php
/**
 * @subpackage makotokw
 * Template Name: Archives
 * Template Post Type: page
 * /archives/
 */
$t_title = get_the_title();
ob_start();
?>
<section class="archive-page">
	<?php makotokw_inline_archives(); ?>
</section>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
require __DIR__ . '/inc/simple-page.php';
