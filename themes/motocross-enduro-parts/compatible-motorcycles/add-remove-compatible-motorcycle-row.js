(function($) {
	// Add new compatible motorcycles with the add button.
	let newCompatibleMotorcycleHtml = $('.template-element-with-new-compatible-motorcycle').html();
	let $compatibleMotorcycles = $('.compatible-motorcycles');
	let newCompatibleMotorcyclesCount = 0;

	$('.button-add-compatible-motorcycle').on('click', function(e) {
		e.preventDefault();

		let duplicatedRow = newCompatibleMotorcycleHtml.replaceAll('__INDEX__', newCompatibleMotorcyclesCount);

		$compatibleMotorcycles.append(duplicatedRow);

		newCompatibleMotorcyclesCount++;
	});

	// Remove compatible motorcycles with the remove button.
	let $removedCompatibleMotorcycles = $('.removed-compatible-motorcycles');
	let removedCompatibleMotorcyclesCount = 0;

	$compatibleMotorcycles.on('click', '.button-remove-compatible-motorcycle', function(e) {
		e.preventDefault();

		let $li = $(this).parent();
		let id = $li.data('id');

		$li.remove();

		if (id == undefined) {
			return;
		}

		$removedCompatibleMotorcycles.append('<input type="hidden" name="removed_compatible_motorcycles[' + removedCompatibleMotorcyclesCount + ']" value="' + id + '"/>');
		removedCompatibleMotorcyclesCount++;
	});
})(jQuery);