(function($) {
	const htmlCompatibleMotorcycle = 
	`<li>
		<select name="new_compatible_motorcycles[__INDEX__][make]" class="postbox">
			<option value="" default>Марка</option>
			<option value="Honda">Honda</option>
			<option value="Kawasaki">Kawasaki</option>
		</select>
		
		<select name="new_compatible_motorcycles[__INDEX__][model]" class="postbox">
			<option value="" default>Модел</option>
			<option value="crf450r">crf450r</option>
			<option value="kx250f">kx250f</option>
		</select>

		<select name="new_compatible_motorcycles[__INDEX__][year_from]" class="postbox">
			<option value="" default>От Година</option>
			<option value="2000">2000</option>
			<option value="2001">2001</option>
			<option value="2003">2003</option>
			<option value="2004">2004</option>
			<option value="2005">2005</option>
		</select>

		<select name="new_compatible_motorcycles[__INDEX__][year_to]" class="postbox">
			<option value="" default>До Година</option>
			<option value="2000">2000</option>
			<option value="2001">2001</option>
			<option value="2003">2003</option>
			<option value="2004">2004</option>
			<option value="2005">2005</option>
		</select>

		<button class="button button-remove-compatible-motorcycle">Премахни</button>
	</li>`;

	// Add new compatible motorcycles with the add button.
	let $compatibleMotorcycles = $('.compatible-motorcycles');
	let newCompatibleMotorcyclesCount = 0;

	$('.button-add-compatible-motorcycle').on('click', function(e) {
		e.preventDefault();

		let duplicatedRow = htmlCompatibleMotorcycle.replaceAll('__INDEX__', newCompatibleMotorcyclesCount);

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