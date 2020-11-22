<?php
$current_post_id = get_the_ID();

$motorcycle_types = crb_get_all_motorcycle_types();
$compatible_motorcycles = crb_get_product_compatible_motorycles( $current_post_id );
?>

<ul class="compatible-motorcycles">
	<?php foreach ( $compatible_motorcycles as $index => $motorcycle ) :
		$selected_make = '';
		$selected_model = '';
		$selected_year_from = '';
		$selected_year_to = ''; ?>

		<li data-id="<?php echo $motorcycle->id ?>">
			<input type="hidden" name="existing_compatible_motorcycles[<?php echo $index ?>][id]" value="<?php echo esc_html( $motorcycle->id ) ?>">

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][make]" class="postbox compatible-motorcycle-make">
				<option value="" default>Марка</option>
				
				<?php foreach ( $motorcycle_types as $make => $model ) :
					if ( $motorcycle->make == $make ) {
						$selected_make = $make;
					} ?>

					<option value="<?php echo esc_html( $make ) ?>"<?php echo $selected_make == $make ? ' selected' : '' ?>><?php echo esc_html( $make ) ?></option>
				<?php endforeach ?>
			</select>
			
			<select name="existing_compatible_motorcycles[<?php echo $index ?>][model]" class="postbox compatible-motorcycle-model">
				<option value="" default>Модел</option>

				<?php foreach ( $motorcycle_types[$selected_make] as $model => $years ) :
					if ( $motorcycle->model == $model ) {
						$selected_model = $model;
					} ?>
					
					<option value="<?php echo esc_html( $model ) ?>"<?php echo $selected_model == $model ? ' selected' : '' ?>><?php echo esc_html( $model ) ?></option>
				<?php endforeach ?>
			</select>

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][year_from]" class="postbox compatible-motorcycle-year-from">
				<option value="" default>От Година</option>

				<?php 
				$year_from = $motorcycle_types[$selected_make][$selected_model]['first_production_year'];
				$year_to = $motorcycle_types[$selected_make][$selected_model]['last_production_year'];

				for ( $year_counter = $year_from; $year_counter <= $year_to; $year_counter++ ) :
					if ( $motorcycle->year_from == $year_counter ) {
						$selected_year_from = $year_counter;
					} ?>

					<option value="<?php echo $year_counter ?>"<?php echo $selected_year_from == $year_counter ? ' selected' : '' ?>><?php echo $year_counter ?></option>
				<?php endfor ?>
			</select>

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][year_to]" class="postbox compatible-motorcycle-year-to">
				<option value="" default>До Година</option>

				<?php 
				$year_to = $motorcycle_types[$selected_make][$selected_model]['last_production_year'];

				for ( $year_counter = $selected_year_from; $year_counter <= $year_to; $year_counter++ ) :
					$selected_year_to = $motorcycle->year_to == $year_counter; ?>

					<option value="<?php echo $year_counter ?>"<?php echo $selected_year_to == $year_counter ? ' selected' : '' ?>><?php echo $year_counter ?></option>
				<?php endfor ?>
			</select>

			<button class="button button-remove-compatible-motorcycle">Премахни</button>
		</li>
	<?php endforeach; ?>
</ul><!-- /.compatible-motorycles -->

<div class="removed-compatible-motorcycles hidden">
</div><!-- /.removed-compatible-motorcycles -->

<div class="template-element-with-new-compatible-motorcycle hidden">
	<li>
		<select name="new_compatible_motorcycles[__INDEX__][make]" class="postbox compatible-motorcycle-make">
			<option value="" default>Марка</option>

			<?php foreach ( $motorcycle_types as $make => $model ) : ?>
				<option value="<?php echo esc_html( $make ) ?>"><?php echo esc_html( $make ) ?></option>
			<?php endforeach ?>
		</select>
		
		<select name="new_compatible_motorcycles[__INDEX__][model]" class="postbox compatible-motorcycle-model" disabled>
			<option value="" default>Модел</option>
		</select>

		<select name="new_compatible_motorcycles[__INDEX__][year_from]" class="postbox compatible-motorcycle-year-from" disabled>
			<option value="" default>От Година</option>
		</select>

		<select name="new_compatible_motorcycles[__INDEX__][year_to]" class="postbox compatible-motorcycle-year-to" disabled>
			<option value="" default>До Година</option>
		</select>

		<button class="button button-remove-compatible-motorcycle">Премахни</button>
	</li>
</div><!-- /.template-element-with-new-compatible-motorcycle -->

<button class="button button-add-compatible-motorcycle">Добави Мотор</button>

<script type="text/javascript">
	let jsonMotorcyclesTypes = <?php echo json_encode( $motorcycle_types ); ?>;
</script>

<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/add-remove-compatible-motorcycle-row.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
