(function($) {
	if (typeof jsonMotorcyclesTypes === undefined) {
		return;
	}

	const defaultOptionHtml = '<option value="" default>__VALUE__</option>';
	const optionHtml = '<option value="__VALUE__">__VALUE__</option>';

	let $compatibleMotorcycles = $('.compatible-motorcycles');

	$compatibleMotorcycles.on('change', '.compatible-motorcycle-make', function() {
		let $this = $(this);
		let $li = $this.closest('li');

		let selectedMake = $this.val();

		disableAndClearOptionsForTheLastNSelects($li, 3);

		if (selectedMake === '') {
			return;
		}

		$model = $li.find('.compatible-motorcycle-model');

		// Fill model select with the options associated to the selected make
		for (model in jsonMotorcyclesTypes[selectedMake]) {
			let newOptionHtml = optionHtml.replaceAll('__VALUE__', model);
			$model.append(newOptionHtml);
		}

		// Enable the model select to be used
		$model.removeAttr('disabled');
	});

	$compatibleMotorcycles.on('change', '.compatible-motorcycle-model', function() {
		let $this = $(this);
		let $li = $this.closest('li');

		let selectedMake = $li.find('.compatible-motorcycle-make').val();
		let selectedModel = $this.val();

		disableAndClearOptionsForTheLastNSelects($li, 2);

		if (selectedModel === '') {
			return;
		}

		$yearFrom = $li.find('.compatible-motorcycle-year-from');

		// Fill year-from select with the production years
		let yearFrom = jsonMotorcyclesTypes[selectedMake][selectedModel]['first_production_year'];
		let yearTo = jsonMotorcyclesTypes[selectedMake][selectedModel]['last_production_year'];
		
		for (let yearsCounter = yearFrom; yearsCounter<=yearTo; yearsCounter++) {
			let newOptionHtml = optionHtml.replaceAll('__VALUE__', yearsCounter);
			$yearFrom.append(newOptionHtml);	
		}

		// Enable the yearFrom select to be used
		$yearFrom.removeAttr('disabled');
	});

	$compatibleMotorcycles.on('change', '.compatible-motorcycle-year-from', function() {
		let $this = $(this);
		let $li = $this.closest('li');

		let selectedMake = $li.find('.compatible-motorcycle-make').val();
		let selectedModel = $li.find('.compatible-motorcycle-model').val();
		let selectedYearFrom = $this.val();

		disableAndClearOptionsForTheLastNSelects($li, 1);

		if (selectedYearFrom === '') {
			return;
		}

		$yearTo = $li.find('.compatible-motorcycle-year-to');

		// Fill year-to select with the production years that are bigger than the year-from selected value
		let yearTo = jsonMotorcyclesTypes[selectedMake][selectedModel]['last_production_year'];
		
		for (let yearsCounter = selectedYearFrom; yearsCounter<=yearTo; yearsCounter++) {
			let newOptionHtml = optionHtml.replaceAll('__VALUE__', yearsCounter);
			$yearTo.append(newOptionHtml);	
		}

		// Enable the yearFrom select to be used
		$yearTo.removeAttr('disabled');
	});

	function disableAndClearOptionsForTheLastNSelects($wrapper, lastNSelects) {
		let $lastNSelects = $wrapper.find('select').slice(-lastNSelects);

		if (!$lastNSelects.length) {
			return;
		}

		$lastNSelects.each(function() {
			// Disable the current select
			$(this).attr('disabled', 'true');

			// Clear all options from the select except the first one that is default
			$(this).find('option').not(':first').remove();
		});
	}
})(jQuery);