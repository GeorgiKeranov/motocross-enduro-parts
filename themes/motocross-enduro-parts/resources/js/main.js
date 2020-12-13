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
$('.section-search-parts--alt .section__filter-mobile').on('click', function(e) {
	e.preventDefault();

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

let isLoading = false;

if ($('.post-type-archive-product').length) {
	let $form = $('.js-form-get-products-ajax');
	if ($form.length) {
		$form.on('submit', function(e) {
			e.preventDefault();

			getProductsWithAjax();
		});
	}

	let $categoriesDesktop = $('.js-category-desktop-get-products-ajax a');	
	if ($categoriesDesktop.length) {
		$categoriesDesktop.on('click', function(e) {
			e.preventDefault();

			if (isLoading) {
				return;
			}

			let $this = $(this);
			let $li = $this.parent();

			if ($li.hasClass('current-cat')) {
				return;
			}

			let $currentCat = $('.js-category-desktop-get-products-ajax .current-cat');
			if ($currentCat.length) {
				$currentCat.removeClass('current-cat');
			}

			$li.addClass('current-cat');

			getProductsWithAjax();
		});
	}

	let $paginationPages = $('.products-wrapper').on('click', '.js-pagination-get-products-ajax a', function(e) {
			e.preventDefault();

			let $this = $(this);
			let page = $this.attr('href');

			getProductsWithAjax(page);
	});
	
	let $mobileFilter = $('.js-mobile-filter');
	if ($mobileFilter.length) {
		$mobileFilter.on('click', function(e) {
			e.preventDefault();
			
			let $openMobileFilterButton = $('.section-search-parts--alt .section__filter-mobile');
			if ($openMobileFilterButton.length) {
				$openMobileFilterButton.click();
			}

			getProductsWithAjax();
		});
	}

	let $buttonRemoveAllFiltersMobile = $('.js-mobile-remove-all-filters');
	if ($buttonRemoveAllFiltersMobile.length) {
		$buttonRemoveAllFiltersMobile.on('click', function(e) {
			e.preventDefault();
			
			clearAllFilters();

			let $openMobileFilterButton = $('.section-search-parts--alt .section__filter-mobile');
			if ($openMobileFilterButton.length) {
				$openMobileFilterButton.click();
			}

			getProductsWithAjax();
		});
	}

	let $buttonRemoveAllFilters = $('.section-search-parts--alt .btn-remove-all-filters');
	if ($buttonRemoveAllFilters.length) {
		$buttonRemoveAllFilters.on('click', function(e) {
			e.preventDefault();
			
			clearAllFilters();

			getProductsWithAjax();
		});
	}

	let $selectOrder = $('.woocommerce-ordering select');
	if ($selectOrder.length) {
		$selectOrder.on('change', function(e) {
			e.stopPropagation();

			getProductsWithAjax();
		})
	}
}

function getProductsWithAjax(page = 1) {
	if (isLoading) {
		return;
	}

	isLoading = true;

	let $productsWrapper = $('.products-wrapper');
	
	let $form = $('.js-form-get-products-ajax');
	let $categoriesDesktop = $('.js-category-desktop-get-products-ajax');	
	let $categoriesMobile = $('.js-category-mobile-get-products-ajax');
	let $selectOrder = $('.woocommerce-ordering select');

	$('html, body').animate({
		scrollTop: 0
	}, 300);

	$productsWrapper.empty();
	$productsWrapper.addClass('products-wrapper__loading');

	let url = $form.data('ajax-url');

	// Add all fields from the form
	let formData = $form.serializeArray();
	
	// Add ajax action name
	formData.push({name: 'action', value: 'get_products_html'});

	// Add category if it is selected
	if ($categoriesDesktop.length && $categoriesDesktop.is(':visible')) {
		let selectedCategory = $categoriesDesktop.find('.current-cat a').data('category-id');

		if (selectedCategory != '') {
			formData.push({name: 'category', value: selectedCategory });
		}
	} else if ($categoriesMobile.length) {
		let selectedCategory = $categoriesMobile.val();

		if (selectedCategory != '') {
			formData.push({name: 'category', value: selectedCategory });
		}
	}
	
	if ($selectOrder.length) {
		let selectedOrderBy = $selectOrder.val();

		formData.push({name: 'orderby', value: selectedOrderBy });
	}

	if (page > 1) {
		formData.push({name: 'page', value: page });
	}

	$.ajax({
	    type: 'GET',
	    url: url,
	    data: $.param(formData),
	    success: function(result) {
	    	if (result['success']) {
	    		let responseHtml = $(result['data']).html();

	    		$productsWrapper.removeClass('products-wrapper__loading');
	    		$productsWrapper.append(responseHtml);
	    	}
	    },
	    error: function(msg) {
	    	$productsWrapper.removeClass('products-wrapper__loading');

	    	console.log(msg);
	    },
	    complete: function() {
			isLoading = false;
	    }
	});
}

function clearAllFilters() {
	let $searchField = $('.section-search-parts--alt form input[name="search"]');
	if ($searchField.length) {
		$searchField.val('');
	}

	let $motorcycleMakeSelect = $('.form-compatible-motorcycle .compatible-motorcycle-make');
	if ($motorcycleMakeSelect.length) {
		let firstOptionValue = $motorcycleMakeSelect.find('option:first').val();
		$motorcycleMakeSelect.val(firstOptionValue).change();
	}

	let $selectOrder = $('.woocommerce-ordering select');
	if ($selectOrder.length) {
		let firstOptionValue = $selectOrder.find('option:first').val();
		$selectOrder.val(firstOptionValue);	
	}

	let $categoryAll = $('.js-category-desktop-get-products-ajax li:first-child');
	if ( $categoryAll.length && !$categoryAll.hasClass('current-cat') ) {
		let $currentCat = $('.js-category-desktop-get-products-ajax .current-cat');
		if ($currentCat.length) {
			$currentCat.removeClass('current-cat');
		}

		$categoryAll.addClass('current-cat');
	}

	let $categorySelectMobile = $('.widget_product_categories_widget select');
	if ($categorySelectMobile.length) {
		let firstOptionValue = $categorySelectMobile.find('option:first').val();
		$categorySelectMobile.val(firstOptionValue);	
	}
}
