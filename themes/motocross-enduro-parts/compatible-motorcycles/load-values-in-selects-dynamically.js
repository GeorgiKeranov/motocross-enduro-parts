(function($) {
	if (typeof jsonMotorcyclesTypes === undefined ) {
		return;
	}

	let $compatibleMotorcycles = $('.compatible-motorcycles');

	$compatibleMotorcycles.on('change', '.compatible-motorcycle-make', function() {
		let $this = $(this);
		let selectedMake = $this.val();


	});
})(jQuery);