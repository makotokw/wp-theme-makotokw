/*global makotokw, jQuery*/
(function($){
	var isAdmin = false,
		ua = navigator.userAgent,
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

	function updateShareCount() {
		var $shareThis = $('#shareThis');
		var permalink = $shareThis.data('url'), encodedPermalink = encodeURIComponent(permalink);
		function toInt(num) {
			var i = parseInt(num);
			return (isNaN(i)) ? 0 : i;
		}
		if (isAdmin) {
			$.ajax({url: 'http://urls.api.twitter.com/1/urls/count.json?url=' + encodedPermalink, dataType: 'jsonp'})
				.done(function (data) {
					if (data) {
						var $count = $('<a/>').addClass('share-count share-count-link').text(toInt(data.count));
						$count.attr({
							'href': 'http://twitter.com/search?q=' + encodedPermalink,
							'target': '_blank'
						});
						$shareThis.find('.share-twitter .btn').append($count);
					}
				});
			$.ajax({url: 'http://api.b.st-hatena.com/entry.count?url=' + encodedPermalink, dataType: 'jsonp'})
				.done(function (data) {
					var $count = $('<span/>').addClass('share-count').text(toInt(data));
					$shareThis.find('.share-hatena .btn').append($count);
				});
			$.ajax({url: 'https://graph.facebook.com/?id=' + encodedPermalink, dataType: 'jsonp'})
				.done(function (data) {
					if (data) {
						var $count = $('<span/>').addClass('share-count').text(toInt(data.shares));
						$shareThis.find('.share-facebook .btn').append($count);
					}
				});

			if (makotokw && makotokw.counter_api && makotokw.counter_api.length > 0) {
				$.ajax({url: makotokw.counter_api + '?url=' + encodedPermalink, dataType: 'jsonp'})
					.done(function (data) {
						if (!data) return;
						var $countPocket = $('<span/>').addClass('share-count').text(toInt(data.pocket));
						$shareThis.find('.share-pocket .btn').append($countPocket);
						var $countGooglePlus = $('<span/>').addClass('share-count').text(toInt(data.google));
						$shareThis.find('.share-googleplus .btn').append($countGooglePlus);
					});
			}

		}
	}

	function lazyLoadShareCount() {
		var $shareThis = $('#shareThis');
		if ( $shareThis.length > 0 && isAdmin) {
			$(window).bind('scroll.shareThis load.shareThis', function() {
				if ( $(this).scrollTop() + $(this).height() > $shareThis.offset().top ) {
					updateShareCount();
					$(this).unbind('scroll.shareThis load.shareThis');
				}
			});
		}
	}

	var $main = $('#main'),
		$footerMargin = $('#footerMargin');

	function stickyFooter() {
		var windowHeight = $(window).height();
		var docHeight = $(document.body).height() - $footerMargin.height();
		var diff = windowHeight - docHeight;
		if ( isAdmin ) {
			diff -= 32;
		}
		if (diff <= 0) {
			diff = 1;
		}
		$footerMargin.height(diff);
	}

	$(window)
		.on('sticky', stickyFooter)
		.scroll(stickyFooter)
		.resize(stickyFooter);


	$('#siteLogo').each(function() {
		if (Modernizr.svg) {
			var $img = $(this),
				id = $img.attr('id'),
				cls = $img.attr('class');

			$.get($img.attr('src'), function (data) {
				var $svg = $(data).find('svg');
				if (typeof id !== 'undefined') {
					$svg.attr('id', id);
				}
				if (typeof cls !== 'undefined') {
					$svg.attr('class', cls + ' replaced-svg');
				}
				// Remove any invalid XML tags as per http://validator.w3.org
				$svg = $svg.removeAttr('xmlns:a');
				$img.replaceWith($svg);
			}, 'xml');
		} else {
			$(this).attr('src', $(this).attr('src').replace(/\.svg/gi, '.png'));
		}
	});

	$(document).ready(function(){
		if ($.isFunction(prettyPrint)) {
			prettyPrint();
		}
		isAdmin = ( $('#wpadminbar').length > 0 );
		lazyLoadShareCount();
		stickyFooter();
	});

})(jQuery);
