<?php 
$shop_page_permalink = '';

$shop_page_id = wc_get_page_id( 'shop' );
if ( !empty( $shop_page_id ) ) {
	$shop_page_permalink = get_permalink( $shop_page_id );
}

$motorcycle_types = crb_get_all_motorcycle_types();

$selected_motorcycle_make = !empty( $_GET['motorcycle_make'] ) ? $_GET['motorcycle_make'] : '';
$selected_motorcycle_model = !empty( $_GET['motorcycle_model'] ) ? $_GET['motorcycle_model'] : '';
$selected_motorcycle_year = !empty( $_GET['motorcycle_year'] ) ? $_GET['motorcycle_year'] : '';

$is_selected_motorcycle_make = !empty( $selected_motorcycle_make ) && array_key_exists($selected_motorcycle_make, $motorcycle_types);
$is_selected_motorcycle_model = $is_selected_motorcycle_make && !empty( $selected_motorcycle_model ) && array_key_exists($selected_motorcycle_model, $motorcycle_types[$selected_motorcycle_make]);
?>

<div class="section-search-parts section-search-parts--alt">
	<div class="shell">
		<form class="js-form-get-products-ajax" action="<?php echo $shop_page_permalink ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="get" autocomplete="off">
			<div class="section__inner">
				<div class="section__search-filters">
					<h3>Търсете части за вашият мотор:</h3>
					
					<div class="section__search">
						<div class="form-search">
							<input type="text" name="search" placeholder="Търсене на части" value="<?php echo !empty( $_GET['search'] ) ? $_GET['search'] : '' ?>">

							<button type="submit"><?php crb_render_fragment( 'svgs/icon-search' ) ?></button>
						</div><!-- /.form-search -->
					</div><!-- /.section__search -->

					<button class="section__filter-mobile">Филтри <span class="ico-filter"></span></button>

					<?php if ( !empty( $motorcycle_types ) ) : ?>
						<div class="section__filter-menu">
							<div class="form-compatible-motorcycle">
								<div class="form__inner compatible-motorcycles">
									<select name="motorcycle_make" class="compatible-motorcycle-make">
										<option value="" default>Марка</option>
										
										<?php foreach ( $motorcycle_types as $make => $model ) : ?>
											<option value="<?php echo esc_html( $make ) ?>" <?php echo $selected_motorcycle_make === $make ? 'selected' : '' ?>><?php echo esc_html( $make ) ?></option>
										<?php endforeach ?>
									</select>

									<select name="motorcycle_model" class="compatible-motorcycle-model"<?php echo $is_selected_motorcycle_make ? '' : ' disabled="disabled"' ?>>
										<option value="" default>Модел</option>

										<?php if ( $is_selected_motorcycle_make ) :
											foreach ( $motorcycle_types[$selected_motorcycle_make] as $model => $years ) : ?>
												<option value="<?php echo esc_html( $model ) ?>" <?php echo $selected_motorcycle_model === $model ? 'selected' : '' ?>><?php echo esc_html( $model ) ?></option>
											<?php endforeach;
										endif; ?>
									</select>

									<select name="motorcycle_year" class="compatible-motorcycle-year"<?php echo $is_selected_motorcycle_model ? '' : ' disabled="disabled"' ?>>
										<option value="" default>Година</option>

										<?php if ( !empty( $selected_motorcycle_model ) ) :
											$selected_make_and_model = $motorcycle_types[$selected_motorcycle_make][$selected_motorcycle_model];

											$first_production_year = $selected_make_and_model['first_production_year'];
											$last_production_year = $selected_make_and_model['last_production_year'];
											
											for ( $year_counter = $first_production_year; $year_counter <= $last_production_year; $year_counter++ ) : ?>
												<option value="<?php echo esc_html( $year_counter ) ?>" <?php echo $selected_motorcycle_year == $year_counter ? 'selected' : '' ?>><?php echo esc_html( $year_counter ) ?></option>
											<?php endfor;
										endif; ?>
									</select>
								</div><!-- /.from__inner -->

								<input type="submit" class="btn-make-search" value="Търсене">
							</div><!-- /.form-compatible-motorcycle -->
						</div><!-- /.section__filter-menu -->

						<!-- Scripts needed to fill the motorcycle model and year based on the make and model -->
						<script type="text/javascript">let jsonMotorcyclesTypes = <?php echo json_encode( $motorcycle_types ); ?>;</script>
						<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
					<?php endif; ?>
				</div><!-- /.section__search-filters -->
			</div><!-- /.section__inner -->
		</form>
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->