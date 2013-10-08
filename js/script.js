(function($){
	if ($.browser.msie) {
		if(parseInt($.browser.version) == 8) {
			$("html").addClass("ie ie8");
		} else if(parseInt($.browser.version) == 7) {
			$("html").addClass("ie ie7");
		} else {
			$("html").addClass("ie");
		}
	}
	$(document).ready(function(){
		prettyPrint();
	});
})(jQuery);