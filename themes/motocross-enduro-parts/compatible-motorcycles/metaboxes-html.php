<?php
$current_post_id = get_the_ID();

$makes = crb_get_all_motorcycle_makes();
$compatible_motorcycles = crb_get_product_compatible_motorycles( $current_post_id );
?>

<ul class="compatible-motorcycles">
	<?php foreach ($compatible_motorcycles as $index => $motorcycle) : ?>
		<li data-id="<?php echo $motorcycle->id ?>">
			<input type="hidden" name="existing_compatible_motorcycles[<?php echo $index ?>][id]" value="<?php echo esc_html( $motorcycle->id ) ?>">

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][make]" class="postbox">
				<option value="" default>Марка</option>
				
				<?php foreach ( $makes as $make ) : ?>
					<option value="<?php echo esc_html( $make ) ?>"<?php echo $motorcycle->make == $make ? ' selected' : '' ?>><?php echo esc_html( $make ) ?></option>
				<?php endforeach ?>
			</select>
			
			<select name="existing_compatible_motorcycles[<?php echo $index ?>][model]" class="postbox">
				<option value="" default>Модел</option>
			</select>

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][year_from]" class="postbox">
				<option value="" default>От Година</option>
			</select>

			<select name="existing_compatible_motorcycles[<?php echo $index ?>][year_to]" class="postbox">
				<option value="" default>До Година</option>
			</select>

			<button class="button button-remove-compatible-motorcycle">Премахни</button>
		</li>
	<?php endforeach ?>
</ul><!-- /.compatible-motorycles -->

<div class="removed-compatible-motorcycles hidden">
</div><!-- /.removed-compatible-motorcycles -->

<div class="template-element-with-new-compatible-motorcycle hidden">
	<li>
		<select name="new_compatible_motorcycles[__INDEX__][make]" class="postbox">
			<option value="" default>Марка</option>

			<?php foreach ( $makes as $make ) : ?>
					<option value="<?php echo esc_html( $make ) ?>"><?php echo esc_html( $make ) ?></option>
				<?php endforeach ?>
		</select>
		
		<select name="new_compatible_motorcycles[__INDEX__][model]" class="postbox" disabled>
			<option value="" default>Модел</option>
		</select>

		<select name="new_compatible_motorcycles[__INDEX__][year_from]" class="postbox" disabled>
			<option value="" default>От Година</option>
		</select>

		<select name="new_compatible_motorcycles[__INDEX__][year_to]" class="postbox" disabled>
			<option value="" default>До Година</option>
		</select>

		<button class="button button-remove-compatible-motorcycle">Премахни</button>
	</li>
</div><!-- /.template-element-with-new-compatible-motorcycle -->

<button class="button button-add-compatible-motorcycle">Добави Мотор</button>

<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/add-remove-compatible-motorcycle-row.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
