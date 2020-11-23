<div class="section-search-parts section-search-parts--alt">
	<div class="shell">
		<div class="section__inner">
			<div class="section__search-filters">
				<h3>Търсете части за вашият мотор:</h3>
				
				<div class="section__search">
					<form class="form-search">
						<input type="text" name="s" placeholder="Търсене на части">

						<button type="submit"><?php crb_render_fragment( 'svgs/icon-search' ) ?></button>
					</form>
				</div><!-- /.section__search -->

				<button class="section__filter-mobile">Филтри <span class="ico-filter"></span></button>

				<div class="section__filter-menu">
					<form class="form-make-filter">
						<div class="form__inner">
							<select name="make" id="make">
								<option default>Марка</option>
								<option value="honda">Honda</option>
								<option value="kawasaki">Kawasaki</option>
							</select>

							<select name="model" id="model" disabled="disabled">
								<option default>Модел</option>
								<option value="CRF450R">CRF450R</option>
								<option value="CRF450X">CRF450X</option>
							</select>

							<select name="year" id="year" disabled="disabled">
								<option default>Година</option>
								<option value="2000">2000</option>
								<option value="2001">2001</option>
							</select>
						</div><!-- /.from__inner -->

						<input type="submit" class="btn-make-search" value="Търсене">
					</form>
				</div><!-- /.section__filter-menu -->
			</div><!-- /.section__search-filters -->
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->

<div class="woocommerce-wrapper">
	<div class="woocommerce-columns">
		<div class="shell">
			<div class="woocommerce__columns">
				<div class="woocommerce__shop">