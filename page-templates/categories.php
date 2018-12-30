<?php
/**
 * @subpackage makotokw
 * Template Name: Categories
 * /categories/
 */

$t_title = get_the_title();
ob_start();
?>
<ul class="list-categories">
	<?php makotokw_list_categories( true ); ?>
</ul>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
include __DIR__ . '/inc/simple-page.php';
