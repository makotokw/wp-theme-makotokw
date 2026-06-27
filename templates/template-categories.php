<?php
/**
 * @package makotokw
 * Template Name: Categories
 * Template Post Type: page
 * @link /categories/
 */

__( 'Categories', 'makotokw' );
$makotokw_title = get_the_title();
ob_start();
?>
<ul class="list-categories">
	<?php makotokw_list_categories(); ?>
</ul>
<?php
$makotokw_contents = ob_get_contents();
ob_end_clean();
get_template_part(
	'templates/inc/simple-page',
	null,
	array(
		'title'    => $makotokw_title,
		'contents' => $makotokw_contents,
	)
);
