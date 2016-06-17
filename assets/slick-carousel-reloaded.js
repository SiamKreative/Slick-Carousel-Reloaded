(function ($) {
	"use strict";

	var selector = $('.wpscr_slider');
	var condition = $.fn.slick && selector.length && typeof wpscr !== 'undefined' && wpscr !== null;
	if (condition) {

		selector.each(function (index, el) {

			// Get slider parameters based on its ID
			var id = $(el).data('id');
			var optionsDynamic = wpscr.sliders[id];
			var options = {
				slide: '.wpscr_slide'
			};

			// Merge base options with dynamic options
			$.extend(options, optionsDynamic);

			// Initialiaze the slider
			$(el).slick(options);

		});

	}

}(jQuery));