<?php 
/**
 * Template Name: Home
 */

the_post();

get_header();
?>

<div class="section-search-parts">
	<div class="section__overlay" style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/resources/images/motocross-image.jpg)">
		<div class="section__overlay-black"></div><!-- /.section__overlay-black -->
	</div><!-- /.section__overlay -->
	
	<div class="shell">
		<div class="section__inner">
			<div class="section__heading">
				<h1>Части за ендуро и кросови мотори втора упротреба</h1>
			</div><!-- /.section__heading -->

			<div class="section__search">
				<h3>Търсете части по име:</h3>

				<form class="form-search">
					<input type="text" name="s" placeholder="Например: Кормило Honda CRF450R">

					<button type="submit">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/resources/images/icon-search.svg)" alt="Search Button">
					</button>
				</form>
			</div><!-- /.section__search -->

			<div class="section__separator">
				<h2>ИЛИ</h2>
			</div><!-- /.section__separator -->

			<div class="section__search-filters">
				<h3>Търсете части за вашият мотор:</h3>
				
				<form class="form-make-filter">
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
				</form>
			</div><!-- /.section__search-filters -->
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-search-parts -->

<?php
crb_render_fragment('slider-testimonials');

get_footer();
