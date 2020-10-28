import 'slick-carousel';

const $win = $(window);
const $doc = $(document);

// Your code goes here...
// jQuery.ready is no longer needed

$('.slider-testimonials .slider__slides').slick({
	prevArrow: '<button type="button" class="slick-prev"></button>',
	nextArrow: '<button type="button" class="slick-next"></button>',
	dots: true,
	appendArrows: $( '.slider-testimonials .slider__actions' ),
	infinite: true,
	autoplay: true,
	autoplaySpeed: 3000,
});
