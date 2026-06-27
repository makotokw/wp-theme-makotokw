<?php
/**
 * @package makotokw
 * Template Name: Archive List by Month
 * Template Post Type: page
 * @link /archives/
 */

__( 'Archive List by Month', 'makotokw' );
$makotokw_title = get_the_title();
ob_start();
?>
<section class="archive-page">
	<?php makotokw_inline_archives(); ?>
</section>
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
