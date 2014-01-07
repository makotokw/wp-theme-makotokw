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
	$(document).ready(function(){
		prettyPrint();
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
				if ( $('#wpadminbar').length > 0 ) {
					diff -= 28;
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