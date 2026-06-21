<?php
/**
 * Share functions
 *
 * @package makotokw
 */

function makotokw_get_share_permalink() {
	$permalink = get_permalink();
	if ( true === WP_THEME_DEBUG ) {
		$permalink = str_replace( home_url(), WP_THEME_PRODUCTION_URL, $permalink );
	}
	return $permalink;
}

function makotokw_share_buttons() {
	// twitter: https://about.twitter.com/resources/buttons#tweet
	// hatena: http://b.hatena.ne.jp/guide/bbutton
	// pocket: https://getpocket.com/publisher/button
	$title                = get_the_title();
	$permalink            = makotokw_get_share_permalink();
	$permalink_schemeless = preg_replace( '/^https?:\/\//', '', $permalink );
	?>
	<ul class="share-buttons">
		<li class="share-twitter">
			<a rel="nofollow noopener" data-url="<?php echo $permalink; ?>" class="btn-share btn-share-twitter" href="https://x.com/intent/post?text=<?php echo rawurlencode( $title ); ?>&url=<?php echo rawurlencode( $permalink ); ?>&via=<?php echo rawurlencode( WP_THEME_AUTHOR_TWITTER ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by X', 'makotokw' ); ?>">
				<i class="fab fa-x-twitter"></i>
				<span class="share-title"><?php _e( 'X', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-facebook">
			<a rel="nofollow noopener" class="btn-share btn-share-facebook" href="//www.facebook.com/sharer.php?u=<?php echo rawurlencode( $permalink ); ?>&t=<?php echo rawurlencode( $title ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Facebook', 'makotokw' ); ?>">
				<i class="fab fa-facebook-f"></i>
				<span class="share-title"><?php _e( 'Facebook', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-hatena">
			<a rel="nofollow noopener" class="btn-share btn-share-hatena" href="https://b.hatena.ne.jp/entry/<?php echo $permalink_schemeless; ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Hatena', 'makotokw' ); ?>">
				<svg class="share-brand-icon" xmlns="http://www.w3.org/2000/svg" viewBox="100 100 300 300">
					<g>
						<path d="M278.2,258.1q-13.6-15.2-37.8-17c14.4-3.9,24.8-9.6,31.4-17.3s9.8-17.8,9.8-30.7A55,55,0,0,0,275,166a48.8,48.8,0,0,0-19.2-18.6c-7.3-4-16-6.9-26.2-8.6s-28.1-2.4-53.7-2.4H113.6V363.6h64.2q38.7,0,55.8-2.6c11.4-1.8,20.9-4.8,28.6-8.9a52.5,52.5,0,0,0,21.9-21.4c5.1-9.2,7.7-19.9,7.7-32.1C291.8,281.7,287.3,268.2,278.2,258.1Zm-107-71.4h13.3q23.1,0,31,5.2c5.3,3.5,7.9,9.5,7.9,18s-2.9,14-8.5,17.4-16.1,5-31.4,5H171.2V186.7Zm52.8,130.3c-6.1,3.7-16.5,5.5-31.1,5.5H171.2V273h22.6c15,0,25.4,1.9,30.9,5.7s8.4,10.4,8.4,20S230.1,313.4,223.9,317.1Z"></path>
						<path d="M357.6,306.1a28.8,28.8,0,1,0,28.8,28.8A28.8,28.8,0,0,0,357.6,306.1Z"></path>
						<rect x="332.6" y="136.4" width="50" height="151.52"></rect>
					</g>
				</svg>
				<span class="share-title"><?php _e( 'Hatena Bookmark', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-line">
			<a rel="nofollow noopener" class="btn-share btn-share-line" href="https://social-plugins.line.me/lineit/share?url=<?php echo rawurlencode( $permalink ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Line', 'makotokw' ); ?>">
				<svg class="share-brand-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 300">
					<g>
						<path class="fill_1" d="M280.344,206.351 C280.344,206.351 280.354,206.351 280.354,206.351 C247.419,244.375 173.764,290.686 157.006,297.764 C140.251,304.844 142.724,293.258 143.409,289.286 C143.809,286.909 145.648,275.795 145.648,275.795 C146.179,271.773 146.725,265.543 145.139,261.573 C143.374,257.197 136.418,254.902 131.307,253.804 C55.860,243.805 0.004,190.897 0.004,127.748 C0.004,57.307 70.443,-0.006 157.006,-0.006 C243.579,-0.006 314.004,57.307 314.004,127.748 C314.004,155.946 303.108,181.342 280.344,206.351 Z"/>
						<path class="fill_2" d="M253.185,121.872 C257.722,121.872 261.408,125.569 261.408,130.129 C261.408,134.674 257.722,138.381 253.185,138.381
C253.185,138.381 230.249,138.381 230.249,138.381 C230.249,138.381 230.249,153.146 230.249,153.146 C230.249,153.146 253.185,153.146 253.185,153.146 C257.710,153.146 261.408,156.851 261.408,161.398 C261.408,165.960 257.710,169.660 253.185,169.660 C253.185,169.660 222.018,169.660 222.018,169.660 C217.491,169.660 213.795,165.960 213.795,161.398 C213.795,161.398 213.795,130.149 213.795,130.149 C213.795,130.139 213.795,130.139 213.795,130.129 C213.795,130.129 213.795,130.114 213.795,130.109 C213.795,130.109 213.795,98.878 213.795,98.878 C213.795,98.858 213.795,98.850 213.795,98.841 C213.795,94.296 217.486,90.583 222.018,90.583 C222.018,90.583 253.185,90.583 253.185,90.583 C257.722,90.583 261.408,94.296 261.408,98.841 C261.408,103.398 257.722,107.103 253.185,107.103 C253.185,107.103 230.249,107.103 230.249,107.103 C230.249,107.103 230.249,121.872 230.249,121.872 C230.249,121.872 253.185,121.872 253.185,121.872 ZM202.759,161.398 C202.759,164.966 200.503,168.114 197.135,169.236 C196.291,169.521 195.405,169.660 194.526,169.660 C191.956,169.660 189.502,168.431 187.956,166.354 C187.956,166.354 156.012,122.705 156.012,122.705 C156.012,122.705 156.012,161.398 156.012,161.398 C156.012,165.960 152.329,169.660 147.791,169.660 C143.256,169.660 139.565,165.960 139.565,161.398 C139.565,161.398 139.565,98.841 139.565,98.841 C139.565,95.287 141.829,92.142 145.192,91.010 C146.036,90.730 146.915,90.583 147.799,90.583 C150.364,90.583 152.828,91.818 154.366,93.894 C154.366,93.894 186.310,137.559 186.310,137.559 C186.310,137.559 186.310,98.841 186.310,98.841 C186.310,94.296 190.000,90.583 194.536,90.583 C199.073,90.583 202.759,94.296 202.759,98.841 C202.759,98.841 202.759,161.398 202.759,161.398 ZM127.737,161.398 C127.737,165.960 124.051,169.660 119.519,169.660 C114.986,169.660 111.300,165.960 111.300,161.398 C111.300,161.398 111.300,98.841 111.300,98.841 C111.300,94.296 114.986,90.583 119.519,90.583 C124.051,90.583 127.737,94.296 127.737,98.841 C127.737,98.841 127.737,161.398 127.737,161.398 ZM95.507,169.660 C95.507,169.660 64.343,169.660 64.343,169.660 C59.816,169.660 56.127,165.960 56.127,161.398 C56.127,161.398 56.127,98.841 56.127,98.841 C56.127,94.296 59.816,90.583 64.343,90.583 C68.881,90.583 72.564,94.296 72.564,98.841 C72.564,98.841 72.564,153.146 72.564,153.146 C72.564,153.146 95.507,153.146 95.507,153.146 C100.047,153.146 103.728,156.851 103.728,161.398 C103.728,165.960 100.047,169.660 95.507,169.660 Z"/>
					</g>
				</svg>
				<span class="share-title"><?php _e( 'Line', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-pocket">
			<a rel="nofollow noopener" class="btn-share btn-share-pocket" href="https://getpocket.com/save/?url=<?php echo rawurlencode( $permalink ); ?>&title=<?php echo rawurlencode( $title ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Pocket', 'makotokw' ); ?>">
				<i class="fab fa-get-pocket"></i>
				<span class="share-title"><?php _e( 'Pocket', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-url">
			<button class="btn-share btn-share-url" data-clipboard-text="<?php echo $permalink; ?>" data-toast-success="<?php esc_attr_e( 'URL Copied!', 'makotokw' ); ?>" data-toast-error="<?php esc_attr_e( 'Failed to copy URL.', 'makotokw' ); ?>" data-tippy-content="<?php esc_attr_e( 'Copy URL', 'makotokw' ); ?>">
				<i class="fas fa-copy"></i>
				<span class="share-title"><?php _e( 'Copy URL', 'makotokw' ); ?></span>
			</button>
		</li>
	</ul>
	<?php
}

function makotokw_share_this() {
	?>
	<div id="shareThis" class="share-this section-inner" data-url="<?php echo makotokw_get_share_permalink(); ?>">
		<?php makotokw_share_buttons(); ?>
	</div>
	<?php
}
