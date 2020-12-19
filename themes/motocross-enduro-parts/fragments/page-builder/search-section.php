<?php 
$shop_page_permalink = '';

$shop_page_id = wc_get_page_id( 'shop' );
if ( !empty( $shop_page_id ) ) {
	$shop_page_permalink = get_permalink( $shop_page_id );
}

$motorcycle_types = crb_get_all_motorcycle_types();
?>

<div class="section-search-parts">
	<div class="section__overlay" style="background-image: url(<?php echo wp_get_attachment_url( $section['background_image'], 'full-width' ) ?>)">
		<div class="section__overlay-black"></div><!-- /.section__overlay-black -->
	</div><!-- /.section__overlay -->
	
	<div class="shell">
		<form action="<?php echo esc_url( $shop_page_permalink ) ?>" method="get" autocomplete="off">
			<div class="section__inner">
				<?php if ( !empty( $section['title'] ) ) : ?>
					<div class="section__heading">
						<h1><?php echo esc_html( $section['title'] ) ?></h1>
					</div><!-- /.section__heading -->
				<?php endif; ?>

				<div class="section__search">
					<?php if ( !empty( $section['search_field_title'] ) ) : ?>
						<h2><?php echo esc_html( $section['search_field_title'] ) ?></h2>
					<?php endif; ?>

					<div class="form-search">
						<input type="text" name="search" placeholder="<?php echo esc_html( $section['search_field_placeholder'] ) ?>">

						<button type="submit"><?php crb_render_fragment( 'svgs/icon-search' ) ?></button>
					</div>

					<?php if ( !empty( $motorcycle_types ) ) : ?>
						<div class="form-compatible-motorcycle compatible-motorcycles">
							<div class="form__inner">
								<select name="motorcycle_make" class="compatible-motorcycle-make">
									<option value="" default>Марка</option>
									
									<?php foreach ( $motorcycle_types as $make => $model ) : ?>
										<option value="<?php echo esc_html( $make ) ?>"><?php echo esc_html( $make ) ?></option>
									<?php endforeach ?>
								</select>

								<select name="motorcycle_model" class="compatible-motorcycle-model" disabled="disabled">
									<option value="" default>Модел</option>
								</select>

								<select name="motorcycle_year" class="compatible-motorcycle-year" disabled="disabled">
									<option value="" default>Година</option>
								</select>
							</div>

							<input type="submit" class="btn-make-search" value="Търсене">
						</div><!-- /.form-compatible-motorcycle -->

						<!-- Scripts needed to fill the motorcycle model and year based on the make and model -->
						<script type="text/javascript">let jsonMotorcyclesTypes = <?php echo json_encode( $motorcycle_types ); ?>;</script>
						<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
					<?php endif; ?>
				</div><!-- /.section__search -->
			</div><!-- /.section__inner -->
		</form>
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->