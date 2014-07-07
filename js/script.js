(function($){
	var ua = navigator.userAgent,
		isIE = ua.match(/msie/i),
		isIE7 = isIE && ua.match(/msie 7\./i),
		isIE8 = isIE && ua.match(/msie 8\./i);
	if (isIE) {
		if (isIE7) {
			$("html").addClass("ie ie7");
		} else if (isIE8) {
			$("html").addClass("ie ie8");
		} else {
			$("html").addClass("ie");
		}
	}

	var $adminBar = $('#wpadminbar'),
		isAdmin = ( $adminBar.length > 0 );

	function lazyLoadShareCount() {
		var $shareThis = $('#shareThis');
		if ( $shareThis.length > 0 ) {
			$(window).bind('scroll.shareThis load.shareThis', function(){
				if ( $(this).scrollTop() + $(this).height() > $shareThis.offset().top ) {
					var permalink = $shareThis.data('url'), encodedPermalink = encodeURIComponent(permalink);
					if ( isAdmin ) {

					} else {
						$.ajax({url: 'http://urls.api.twitter.com/1/urls/count.json?url=' + encodedPermalink, dataType: 'jsonp'})
							.done(function( data ) {
								if (data && data.count > 0) {
									var $count = $('<a/>').addClass('share-count share-count-link').text(data.count);
									$count.attr({
										'href': 'http://twitter.com/search?q=' + encodedPermalink,
										'target': '_blank'
									});
									$shareThis.find('.share-twitter .share-title').append($count);
								}
							});
						$.ajax({url: 'http://api.b.st-hatena.com/entry.count?url=' + encodedPermalink, dataType: 'jsonp'})
							.done(function( data ) {
								if (data > 0) {
									var $count = $('<span/>').addClass('share-count').text(data);
									$shareThis.find('.share-hatena .share-title').append($count);
								}
							});
						$.ajax({url: 'https://graph.facebook.com/?id=' + encodedPermalink, dataType: 'jsonp'})
							.done(function( data ) {
								if (data && data.shares > 0) {
									var $count = $('<span/>').addClass('share-count').text(data.shares);
									$shareThis.find('.share-facebook .share-title').append($count);
								}
							});
					}
					$(this).unbind('scroll.shareThis load.shareThis');
				}
			});
		}
	}

	$(document).ready(function(){
		if ($.isFunction(prettyPrint)) {
			prettyPrint();
		}
		lazyLoadShareCount();
	});



	$.fn.extend({
		stickyFooter: function(options) {
			var $main = $('#main'), $margin = $('#footerMargin'), $footer = $(this);
			positionFooter();
			$(window)
				.on('sticky', positionFooter)
				.scroll(positionFooter)
				.resize(positionFooter);
			function positionFooter() {
				var windowHeight = $(window).height();
				var docHeight = $(document.body).height() - $margin.height();
				var diff = windowHeight - docHeight;
				if ( isAdmin ) {
					diff -= 32;
				}
				if (diff <= 0) {
					diff = 1;
				}
				$margin.height(diff);
			}
		}
	});
	$('.site-footer').stickyFooter();

})(jQuery);

