<?php 
/**
 * Template Name: Contacts
 */

the_post();

get_header();
?>

<div class="section-intro" style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/resources/images/contact-background-2.jpg)">
	<div class="shell">
		<h1>Контакти</h1>

		<p>Имате въпроси относно някоя част, не се притеснявайте да ни пишете или звъннете.</p>
	</div><!-- /.shell -->
</div><!-- /.section-intro -->

<div class="section-contact">
	<div class="shell">
		<div class="section__inner">
			<div class="section__form">
				<?php echo do_shortcode('[wpforms id="20" title="true"]') ?>
			</div><!-- /.section__form -->

			<div class="section__details">
				<div class="section__details-contacts">
					<a class="icotext-phone" href="tel:0898767873"><i class="ico-phone"></i> 0898767873</a>

					<a class="icotext-mail" href="mailto:moto_parts_bg@gmail.com"><i class="ico-mail"></i> moto_parts_bg@gmail.com</a>
				</div><!-- /.section__details-email -->

				<div class="section__details-text">
					<h3>Работно време:</h3>
					
					<div class="section-columns">
						<div class="section__col">
							<p>Понеделник - Петък</p>
						</div><!-- /.section__col -->

						<div class="section__col">
							<p>9:00 - 18:00</p>
						</div><!-- /.section__col -->
					</div><!-- /.section-columns -->

					<div class="section-columns">
						<div class="section__col">
							<p>Събота</p>
						</div><!-- /.section__col -->

						<div class="section__col">
							<p>9:00 - 13:00</p>
						</div><!-- /.section__col -->
					</div><!-- /.section-columns -->

					<div class="section-columns">
						<div class="section__col">
							<p>Неделя</p>
						</div><!-- /.section__col -->

						<div class="section__col">
							<p>Почивен</p>
						</div><!-- /.section__col -->
					</div><!-- /.section-columns -->
				</div><!-- /.section__details-text -->
			</div><!-- /.section__details -->
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-contact -->

<?php 
get_footer();
