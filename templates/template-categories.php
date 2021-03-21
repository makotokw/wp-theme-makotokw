<?php
/**
 * @package makotokw
 * Template Name: Categories
 * Template Post Type: page
 * @link /categories/
 */
__( 'Categories', 'makotokw' );
$t_title = get_the_title();
ob_start();
?>
<ul class="list-categories">
	<?php makotokw_list_categories(); ?>
</ul>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
require __DIR__ . '/inc/simple-page.php';
