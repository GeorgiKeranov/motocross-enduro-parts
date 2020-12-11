<div class="section-search-parts">
	<div class="section__overlay" style="background-image: url(<?php echo wp_get_attachment_url( $section['background_image'], 'full-width' ) ?>)">
		<div class="section__overlay-black"></div><!-- /.section__overlay-black -->
	</div><!-- /.section__overlay -->
	
	<div class="shell">
		<div class="section__inner">
			<?php if ( !empty( $section['title'] ) ) : ?>
				<div class="section__heading">
					<h1><?php echo esc_html( $section['title'] ) ?></h1>
				</div><!-- /.section__heading -->
			<?php endif; ?>

			<div class="section__search">
				<?php if ( !empty( $section['search_field_title'] ) ) : ?>
					<h3><?php echo esc_html( $section['search_field_title'] ) ?></h3>
				<?php endif; ?>

				<form class="form-search">
					<input type="text" name="search" placeholder="<?php echo esc_html( $section['search_field_placeholder'] ) ?>">

					<button type="submit"><?php crb_render_fragment( 'svgs/icon-search' ) ?></button>
				</form>
			</div><!-- /.section__search -->

			<?php if ( !empty( $section['separator_text'] ) ) : ?>
				<div class="section__separator">
					<h2><?php echo esc_html( $section['separator_text'] ) ?></h2>
				</div><!-- /.section__separator -->
			<?php endif; ?>

			<?php
			$motorcycle_types = crb_get_all_motorcycle_types();
			
			if ( !empty( $motorcycle_types ) ) : ?>
				<div class="section__search-filters">
					<?php if ( !empty( $section['type_fields_title'] ) ) : ?>
						<h3><?php echo esc_html( $section['type_fields_title'] ) ?></h3>
					<?php endif; ?>

					<form class="form-compatible-motorcycle compatible-motorcycles">
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
					</form>
				</div><!-- /.section__search-filters -->

				<!-- Scripts needed to fill the motorcycle model and year based on the make and model -->
				<script type="text/javascript">let jsonMotorcyclesTypes = <?php echo json_encode( $motorcycle_types ); ?>;</script>
				<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/compatible-motorcycles/load-values-in-selects-dynamically.js"></script>
			<?php endif; ?>
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->