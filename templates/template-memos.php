<?php
/**
 * @package makotokw
 * Template Name: Memos
 * Template Post Type: page
 * @link /memo/
 */

__( 'Memos', 'makotokw' );
$makotokw_title = get_the_title();
ob_start();
?>
	<ul class="memo-list">
		<?php
		wp_list_pages(
			array(
				'title_li' => false,
				'child_of' => WP_THEME_MEMO_POST_ID,
			)
		);
		?>
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
