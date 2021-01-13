import 'slick-carousel';

const $win = $(window);
const $doc = $(document);

// Your code goes here...
// jQuery.ready is no longer needed

$('.slider-testimonials .slider__slides').slick({
	prevArrow: '<button type="button" class="slick-prev">🡸</button>',
	nextArrow: '<button type="button" class="slick-next">🡺</button>',
	dots: true,
	appendArrows: $('.slider-testimonials .slider__actions'),
	infinite: true,
	autoplay: true,
	autoplaySpeed: 4000,
	pauseOnHover: false
});

$('.slider-promo-products .slider__slides').slick({
	prevArrow: '<button type="button" class="slick-prev">🡸</button>',
	nextArrow: '<button type="button" class="slick-next">🡺</button>',
	dots: true,
	infinite: true,
	autoplay: true,
	autoplaySpeed: 2000,
	slidesToShow: 4,
	slidesToScroll: 1,
	pauseOnHover: false,
	responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 900,
		  settings: {
			slidesToShow: 2,
		  }
		}
	]
});

$('.header .header__menu-toggle').on('click', function(e) {
	e.preventDefault();
	
	$('body').toggleClass('menu-active');
});

const winH = $win.height();
//Check if element is visible
$('.section-fade').each(function() {
    const $element = $(this);

    $win.on('scroll load', function() {
        if ($element.offset().top <= $doc.scrollTop() + winH) {
            setTimeout(function() {
                $element.addClass('visible');
            }, 1);
        } else {
            $element.removeClass('visible');
        }
    });
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
		let page = $form.attr('action');
		let formData = getFormDataShopPage();
		
		let $currentPage = $('.js-pagination-get-products-ajax .current');
		if ($currentPage.length) {
			let currentPage = parseInt($currentPage.text());

			if (currentPage > 1) {
				formData.push({name: 'page', value: currentPage});
			}
		}

		history.replaceState({
			page: 'shop-page',
			formData: formData
		}, '');

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

let $singleProductPage = $('.woocommerce.single-product');
if ($singleProductPage.length) {
	let $mobileFilter = $('.js-mobile-filter');
	if ($mobileFilter.length) {
		$mobileFilter.on('click', function(e) {
			e.preventDefault();

			goToProductsPage();
		});
	}
}

function getProductsWithAjax(page = 1) {
	if (isLoading) {
		return;
	}

	isLoading = true;

	let $productsWrapper = $('.products-wrapper');
	let $form = $('.js-form-get-products-ajax');
	
	let url = $form.data('ajax-url');
	let formData = getFormDataShopPage(page);

	let $openMobileFilterButton = $('.section-search-parts--alt .section__filter-mobile');
	let $mobileFilters = $('.js-form-get-products-ajax .section__filter-menu--expanded')
	if ($mobileFilters.is(':visible')) {
		$openMobileFilterButton.click();
	}

	$productsWrapper.empty();
	$productsWrapper.addClass('products-wrapper__loading')

	// Add browser history for the back button because we use ajax
	changeUrlBasedOnData(formData);

	// Add ajax action name
	formData.push({name: 'action', value: 'get_products_html'});

	$('html, body').animate({
		scrollTop: 0
	}, 300);

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

function goToProductsPage() {
	let $form = $('.js-form-get-products-ajax');
	let goToUrl = $form.attr('action');
	
	let formData = getFormDataShopPage(1);
	let getParams = $.param(formData);

	if (getParams !== '') {
		goToUrl += '?' + getParams;
	}

	window.location.href = goToUrl;
}


function getProductsFromPreviousPage(formData) {
	isLoading = true;

	let $productsWrapper = $('.products-wrapper');
	let $form = $('.js-form-get-products-ajax');
	
	let url = $form.data('ajax-url');

	$productsWrapper.empty();
	$productsWrapper.addClass('products-wrapper__loading')

	let $openMobileFilterButton = $('.section-search-parts--alt .section__filter-mobile');
	let $mobileFilters = $('.js-form-get-products-ajax .section__filter-menu--expanded')
	if ($mobileFilters.is(':visible')) {
		$openMobileFilterButton.click();
	}

	// Add ajax action name
	formData.push({name: 'action', value: 'get_products_html'});

	$('html, body').animate({
		scrollTop: 0
	}, 300);

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

function getFormDataShopPage(page) {
	let $form = $('.js-form-get-products-ajax');
	let $categoriesDesktop = $('.js-category-desktop-get-products-ajax');
	let $categoriesMobile = $('.js-category-mobile-get-products-ajax');
	let $selectOrder = $('.woocommerce-ordering select');

	// Add all fields from the form
	let formDataTemp = $form.serializeArray();
	let formData = [];

	for (let index in formDataTemp) {
		if (formDataTemp[index] !== undefined && formDataTemp[index].value !== '') {
			formData.push({name: formDataTemp[index].name, value: formDataTemp[index].value});
		}
	}

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

	return formData;
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
	if ($categoryAll.length && !$categoryAll.hasClass('current-cat')) {
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

function setUserInputByFormData(formData) {
	if (typeof formData !== 'object' || formData === null) {
		clearAllFilters();
		return;
	}

	let formNames = formData.map(data => data.name);
	let formValues = formData.map(data => data.value);

	let $searchField = $('.form-search input[name="search"]');
	let $makeField = $('.form-compatible-motorcycle select[name="motorcycle_make"]');
	let $modelField = $('.form-compatible-motorcycle select[name="motorcycle_model"]');
	let $yearField = $('.form-compatible-motorcycle select[name="motorcycle_year"]');

	if (formNames.includes('search')) {
		$searchField.val(formValues[formNames.indexOf('search')]);
	} else {
		$searchField.val('');
	}

	if (formNames.includes('motorcycle_make')) {
		$makeField.val(formValues[formNames.indexOf('motorcycle_make')]).change();
	} else {
		$makeField.val('').change();
	}

	if (formNames.includes('motorcycle_model')) {
		$modelField.val(formValues[formNames.indexOf('motorcycle_model')]).change();
	} else {
		$modelField.val('').change();
	}

	if (formNames.includes('motorcycle_year')) {
		$yearField.val(formValues[formNames.indexOf('motorcycle_year')]).change();
	} else {
		$yearField.val('').change();
	}

	let $selectOrder = $('.woocommerce-ordering select');
	if (formNames.includes('orderby')) {
		$selectOrder.val(formValues[formNames.indexOf('orderby')]);
	} else {
		$selectOrder.val('');
	}

	let $categoriesDesktop = $('.js-category-desktop-get-products-ajax');
	let $categoriesMobile = $('.js-category-mobile-get-products-ajax');
	if (formNames.includes('category')) {
		let categoryId = formValues[formNames.indexOf('category')];

		// Categories Desktop
		let $currentCat = $categoriesDesktop.find('.current-cat');
		if ($currentCat.length) {
			$currentCat.removeClass('current-cat');
		}

		let $selectedCategory = $categoriesDesktop.find('[data-category-id="' + categoryId + '"]');
		if ($selectedCategory.length) {
			$selectedCategory.closest('li').addClass('current-cat');
		}

		// Categories Mobile
		$categoriesMobile.val(categoryId);
	} else {
		// Categories Desktop
		let $currentCat = $categoriesDesktop.find('.current-cat');
		if ($currentCat.length) {
			$currentCat.removeClass('current-cat');
		}

		let $categoryAll = $('.js-category-desktop-get-products-ajax li:first-child');
		if ($categoryAll.length) {
			$categoryAll.addClass('current-cat');
		}

		// Categories Mobile
		$categoriesMobile.val('');
	}

	let page = 1;

	let $currentPage = $('.js-pagination-get-products-ajax .current');
	if ($currentPage.length) {
		let currentPage = parseInt($currentPage.text());

		if (currentPage > 1) {
			page = currentPage;
		}
	}
}

function changeUrlBasedOnData(formData) {
	let $form = $('.js-form-get-products-ajax');
	if (!$form.length) {
		return;
	}

	let page = $form.attr('action');

	if (page.slice(-1) !== '/') {
		page += '/';
	}

	if (typeof formData === 'object' && formData !== null) {
		let params = $.param(formData);

		page += '?' + params;
	}

	history.pushState({
		page: 'shop-page',
		formData: formData
	}, '', page);
}

window.onpopstate = function(event) {
	let state = event.state;

	if (typeof state === 'object' && state !== null && state.page === 'shop-page') {
		let formData = state.formData;

		setUserInputByFormData(formData);
		getProductsFromPreviousPage(formData);
	}
}

$('.nav a').click(function(e) {
  e.preventDefault();

  let linkUrl = $(this).attr('href');

  setTimeout(function() {
	window.location = linkUrl
  }, 300);
});
