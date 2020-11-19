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
					<input type="text" name="s" placeholder="<?php echo esc_html( $section['search_field_placeholder'] ) ?>">

					<button type="submit"><?php crb_render_fragment( 'svgs/icon-search' ) ?></button>
				</form>
			</div><!-- /.section__search -->

			<?php if ( !empty( $section['separator_text'] ) ) : ?>
				<div class="section__separator">
					<h2><?php echo esc_html( $section['separator_text'] ) ?></h2>
				</div><!-- /.section__separator -->
			<?php endif; ?>

			<div class="section__search-filters">
				<?php if ( !empty( $section['type_fields_title'] ) ) : ?>
					<h3><?php echo esc_html( $section['type_fields_title'] ) ?></h3>
				<?php endif; ?>

				<!-- TODO -->
				<form class="form-make-filter">
					<!-- Fill this up and others after this field is chosen -->
					<select name="make" id="make">
						<option default>Марка</option>
						<!-- <option value="honda">Honda</option>
						<option value="kawasaki">Kawasaki</option> -->
					</select>

					<select name="model" id="model" disabled="disabled">
						<option default>Модел</option>
						<!-- <option value="CRF450R">CRF450R</option>
						<option value="CRF450X">CRF450X</option> -->
					</select>

					<select name="year" id="year" disabled="disabled">
						<option default>Година</option>
						<!-- <option value="2000">2000</option>
						<option value="2001">2001</option> -->
					</select>
				</form>
			</div><!-- /.section__search-filters -->
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->