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
})(jQuery);