<?php
$current_post_id = get_the_ID();

$compatible_motorcycles = crb_get_product_compatible_motorycles( $current_post_id );
?>

<ul class="compatible-motorcycles">
	<?php foreach ($compatible_motorcycles as $index => $motorcycle) : ?>
		<li data-id="<?php echo $motorcycle->id ?>">
			<input type="hidden" name="existing_compatible_motorcycles[<?php echo $index ?>][id]" value="<?php echo $motorcycle->id ?>">

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][make]" class="postbox">
				<option value="" default>Марка</option>
				<option value="Honda" <?php echo $motorcycle->make === 'Honda' ? 'selected' : '' ?>>Honda</option>
				<option value="Kawasaki" <?php echo $motorcycle->make === 'Kawasaki' ? 'selected' : '' ?>>Kawasaki</option>
			</select>
			
			<select name="existing_compatible_motorcycles[<?php echo $index ?>][model]" class="postbox">
				<option value="" default>Модел</option>
				<option value="crf450r">crf450r</option>
				<option value="kx250f">kx250f</option>
			</select>

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][year_from]" class="postbox">
				<option value="" default>От Година</option>
				<option value="2000">2000</option>
				<option value="2001">2001</option>
				<option value="2003">2003</option>
				<option value="2004">2004</option>
				<option value="2005">2005</option>
			</select>

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][year_to]" class="postbox">
				<option value="" default>До Година</option>
				<option value="2000">2000</option>
				<option value="2001">2001</option>
				<option value="2003">2003</option>
				<option value="2004">2004</option>
				<option value="2005">2005</option>
			</select>

			<button class="button button-remove-compatible-motorcycle">Премахни</button>
		</li>
	<?php endforeach ?>
</ul><!-- /.compatible-motorycles -->

<div class="removed-compatible-motorcycles hidden">
</div><!-- /.removed-compatible-motorcycles -->

<button class="button button-add-compatible-motorcycle">Добави Мотор</button>

<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/add-remove-compatible-motorcycle-row.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
