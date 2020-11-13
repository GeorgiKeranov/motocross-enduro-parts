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

$('.header .header__menu-toggle').on('click', function(e) {
	e.preventDefault();
	
	$('body').toggleClass('menu-active');
});

$('.section-search-parts--alt .section__filter-mobile').on('click', function() {
	const filterMenuExpandedClass = 'section__filter-menu--expanded';
	let $clickedElement = $(this);
	let $filterMenuElement = $clickedElement.siblings('.section__filter-menu');

	$filterMenuElement.toggleClass(filterMenuExpandedClass);

	$('.section-search-parts--alt .section__filter-menu').slideToggle();
});
