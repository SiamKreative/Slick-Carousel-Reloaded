(function ($) {
	"use strict";

	console.log(wpscr.options);

	$('.wpscr_slider').each(function (index, el) {
		// Initialiaze the slider
		$(el).slick({
			slide: '.wpscr_slide',
			dots: wpscr.options.dots,
			infinite: wpscr.options.infinite,
			arrows: wpscr.options.arrows,
			speed: wpscr.options.speed,
			autoplay: wpscr.options.autoplay,
			fade: wpscr.options.fade,
			autoplaySpeed: wpscr.options.autoplaySpeed,
			slidesToShow: wpscr.options.slidesToShow,
			slidesToScroll: wpscr.options.slidesToScroll,
			adaptiveHeight: wpscr.options.adaptiveHeight,
			lazyLoad: wpscr.options.lazyLoad
		});
	});

}(jQuery));