<?php
/**
 * Admin Page functions
 *
 * @package makotokw
 */

function makotokw_admin_setup() {
	if ( is_admin() ) {
		add_action( 'admin_print_footer_scripts', 'makotokw_admin_quicktags' );
	}
}
add_action( 'after_setup_theme', 'makotokw_admin_setup' );

/**
 * Custom QTags
 */
function makotokw_admin_quicktags() {
	// https://wordpress.stackexchange.com/questions/37849/add-custom-shortcode-button-to-editor
	/* Add custom Quicktag buttons to the editor WordPress ver. 3.3 and above only
	 *
	 * Params for this are:
	 * - Button HTML ID (required)
	 * - Button display, value="" attribute (required)
	 * - Opening Tag (required)
	 * - Closing Tag (required)
	 * - Access key, accesskey="" attribute for the button (optional)
	 * - Title, title="" attribute (optional)
	 * - Priority/position on bar, 1-9 = first, 11-19 = second, 21-29 = third, etc. (optional)
	 */
	?>
	<script type="text/javascript">
		(function ($) {
			if (typeof(QTags) !== 'undefined') {
				var datetime = (function () {
					var now = new Date(), zeroise;
					zeroise = function (number) {
						var str = number.toString();
						if (str.length < 2)
							str = "0" + str;
						return str;
					};
					return now.getUTCFullYear() + '-' +
						zeroise(now.getUTCMonth() + 1) + '-' +
						zeroise(now.getUTCDate()) + 'T' +
						zeroise(now.getUTCHours()) + ':' +
						zeroise(now.getUTCMinutes()) + ':' +
						zeroise(now.getUTCSeconds()) +
						'+00:00';
				})();

				$.each(['h2', 'h3', 'h4', 'h5', 'p'], function (i, e) {
					QTags.addButton(e, e, '<' + e + '>', '</' + e + '>');
				});
				QTags.addButton('ins_block', 'ins_block', '<ins class="note-ins" datetime="' + datetime + '">', '</ins>');
				QTags.addButton('AA', 'aa', '<span class="aa">', '</span>');
				QTags.addButton('big', 'big', '<span class="big">', '</span>');

				QTags.addButton('figure', 'figure', '<figure>', '<figcaption>Caption</figcaption></figure>');

				$.each(['', 'github', 'qiita', 'evernote'], function (i, t) {
					var cls = (t === '') ? 'enclosure' : 'enclosure-' + t;
					QTags.addButton(cls, cls, '<div class="' + cls + '">', '</div>');
				});
				$.each(['comment', 'ins', 'link'], function (i, t) {
					var cls = 'note-' + t;
					QTags.addButton(cls, cls, '<div class="' + cls + '">', '</div>');
				});

				QTags.addButton('prettyprint', 'prettyprint', '<pre class="prettyprint">', '</pre>');
				QTags.addButton('sh_code', '[code]', '[code autolinks="false" collapse="false" firstline="1" gutter="true" highlight="" htmlscript="false" light="false" padlinenumbers="false" toolbar="true" title="example-filename.php"]', '[/code]');
			}
		})(jQuery);
	</script>
	<?php
}
