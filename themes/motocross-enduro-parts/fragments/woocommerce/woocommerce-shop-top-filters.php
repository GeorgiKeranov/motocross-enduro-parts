<div class="section-search-parts section-search-parts--alt">
	<div class="shell">
		<div class="section__inner">
			<div class="section__search-filters">
				<h3>Търсете части за вашият мотор:</h3>
				
				<div class="section__search">
					<form class="form-search">
						<input type="text" name="search" placeholder="Търсене на части">

						<button type="submit"><?php crb_render_fragment( 'svgs/icon-search' ) ?></button>
					</form>
				</div><!-- /.section__search -->

				<button class="section__filter-mobile">Филтри <span class="ico-filter"></span></button>

				<?php
				$motorcycle_types = crb_get_all_motorcycle_types();
				
				if ( !empty( $motorcycle_types ) ) : ?>
					<div class="section__filter-menu">
						<form class="form-compatible-motorcycle">
							<div class="form__inner compatible-motorcycles">
								<select name="motorcycle_make" class="compatible-motorcycle-make">
									<option default>Марка</option>
									
									<?php foreach ( $motorcycle_types as $make => $model ) : ?>
										<option value="<?php echo esc_html( $make ) ?>"><?php echo esc_html( $make ) ?></option>
									<?php endforeach ?>
								</select>

								<select name="motorcycle_model" class="compatible-motorcycle-model" disabled="disabled">
									<option default>Модел</option>
								</select>

								<select name="motorcycle_year" class="compatible-motorcycle-year" disabled="disabled">
									<option default>Година</option>
								</select>
							</div><!-- /.from__inner -->

							<input type="submit" class="btn-make-search" value="Търсене">
						</form>
					</div><!-- /.section__filter-menu -->

					<!-- Scripts needed to fill the motorcycle model and year based on the make and model -->
					<script type="text/javascript">let jsonMotorcyclesTypes = <?php echo json_encode( $motorcycle_types ); ?>;</script>
					<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
				<?php endif; ?>
			</div><!-- /.section__search-filters -->
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->