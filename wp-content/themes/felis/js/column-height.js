(function($) {
	$.fn.equalHeight = function() {
		var group = this;
		$(window).bind('resize', function() {
			var tallest = 0;
			$(group).height('auto').each(function() {
				tallest = Math.max(tallest, $(this).height());
			}).height(tallest);
		}).trigger('resize');
	};
})(jQuery);

jQuery(window).load(function($) {
	jQuery("div.item-holder1").equalHeight();
	jQuery("div.small-post .inner").equalHeight();
	jQuery("div.slide-wrapper div.item-holder").equalHeight();
	jQuery("div#works2 div.item-holder").equalHeight();
});
