(function($) {
	if (typeof jsonMotorcyclesTypes === undefined) {
		return;
	}

	const defaultOptionHtml = '<option value="" default>__VALUE__</option>';
	const optionHtml = '<option value="__VALUE__">__VALUE__</option>';

	let $compatibleMotorcycles = $('.compatible-motorcycles');

	$compatibleMotorcycles.on('change', '.compatible-motorcycle-make', function() {
		let $this = $(this);
		let $parent = $this.parent();
		let countOfSelects = $parent.find('> select').length;

		let selectedMake = $this.val();

		disableAndClearOptionsForTheLastNSelects($parent, countOfSelects - 1);

		if (selectedMake === '') {
			return;
		}

		$model = $parent.find('.compatible-motorcycle-model');

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
		let $parent = $this.parent();
		let countOfSelects = $parent.find('> select').length;

		let selectedMake = $parent.find('.compatible-motorcycle-make').val();
		let selectedModel = $this.val();

		disableAndClearOptionsForTheLastNSelects($parent, countOfSelects - 2);

		if (selectedModel === '') {
			return;
		}

		let yearFrom = jsonMotorcyclesTypes[selectedMake][selectedModel]['first_production_year'];
		let yearTo = jsonMotorcyclesTypes[selectedMake][selectedModel]['last_production_year'];
		
		let $yearsSelect = $parent.find('.compatible-motorcycle-year-from');

		if ( !$yearsSelect.length ) {
			$yearsSelect = $parent.find('.compatible-motorcycle-year');
		}

		// Fill years select with the production years
		for (let yearsCounter = yearFrom; yearsCounter<=yearTo; yearsCounter++) {
			let newOptionHtml = optionHtml.replaceAll('__VALUE__', yearsCounter);
			$yearsSelect.append(newOptionHtml);	
		}

		// Enable the yearFrom select to be used
		$yearsSelect.removeAttr('disabled');
	});

	$compatibleMotorcycles.on('change', '.compatible-motorcycle-year-from', function() {
		let $this = $(this);
		let $parent = $this.parent();
		let countOfSelects = $parent.find('> select').length;

		let selectedMake = $parent.find('.compatible-motorcycle-make').val();
		let selectedModel = $parent.find('.compatible-motorcycle-model').val();
		let selectedYearFrom = $this.val();

		disableAndClearOptionsForTheLastNSelects($parent, countOfSelects - 3);

		if (selectedYearFrom === '') {
			return;
		}

		let $yearsTo = $parent.find('.compatible-motorcycle-year-to');

		// Fill year-to select with the production years that are bigger than the year-from selected value
		let yearTo = jsonMotorcyclesTypes[selectedMake][selectedModel]['last_production_year'];
		
		for (let yearsCounter = selectedYearFrom; yearsCounter<=yearTo; yearsCounter++) {
			let newOptionHtml = optionHtml.replaceAll('__VALUE__', yearsCounter);
			$yearsTo.append(newOptionHtml);	
		}

		// Enable the yearFrom select to be used
		$yearsTo.removeAttr('disabled');
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