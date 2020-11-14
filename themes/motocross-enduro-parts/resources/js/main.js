import 'slick-carousel';

const $win = $(window);
const $doc = $(document);

// Your code goes here...
// jQuery.ready is no longer needed

$('.slider-testimonials .slider__slides').slick({
	prevArrow: '<button type="button" class="slick-prev"></button>',
	nextArrow: '<button type="button" class="slick-next"></button>',
	dots: true,
	appendArrows: $('.slider-testimonials .slider__actions'),
	infinite: true,
	autoplay: true,
	autoplaySpeed: 3000,
});

$('.header .header__menu-toggle').on('click', function(e) {
	e.preventDefault();
	
	$('body').toggleClass('menu-active');
});

// Slide down/up the filters by button on shop page in mobile devices.
let isAnimating = false;
$('.section-search-parts--alt .section__filter-mobile').on('click', function() {
	// If at the moment of clicking the button previous annimation is not completed do not do nothing
	if (isAnimating) {
		return;
	}

	isAnimating = true;

	let $filterMenuElement = $(this).siblings('.section__filter-menu');
	const filterMenuExpandedClass = 'section__filter-menu--expanded';

	if (!$filterMenuElement.length) {
		return;
	}

	let $upperFilter = $('.section-search-parts--alt .section__filter-menu');
	let $bottomFilter = $('.woocommerce-columns .woocommerce__sidebar');

	if (!$upperFilter.length || !$bottomFilter.length) {
		return;
	}

	let $firstElementForSlide = $upperFilter;
	let $secondElementForSlide = $bottomFilter;
	
	// In case the filters are expanded we will need to slide up to hide them
	// so we are first hiding the bottom ellement then the top.
	if ($filterMenuElement.hasClass(filterMenuExpandedClass)) {
		$firstElementForSlide = $bottomFilter;
		$secondElementForSlide = $upperFilter;
	}

	$filterMenuElement.toggleClass(filterMenuExpandedClass);

	$firstElementForSlide.slideToggle(200);
	
	// Start sliding after the above animation is almost completed so they are not sliding both at one time.
	setTimeout(function() {
		$secondElementForSlide.slideToggle(200, function() {
			// After all of the animations are completed you can use the button again for slide up/down.
			isAnimating = false;
		});
	}, 100);
});
