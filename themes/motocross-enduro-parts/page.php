<?php
the_post();

get_header();
?>

<div class="section-intro-alt">
	<div class="shell">
		<h1><?php the_title() ?></h1>

		<ul class="section__links">
			<li>
				<p><a href="<?php echo home_url('/') ?>"><i class="ico-home"></i> Начало</a></p>
			</li>
			
			<li>
				<p><?php the_title() ?></p>
			</li>
		</ul><!-- /.section__links -->
	</div><!-- /.shell -->
</div><!-- /.section-intro-alt -->

<div class="section-default">
	<div class="shell">
		<?php the_content() ?>
	</div><!-- /.shell -->
</div><!-- /.section-default -->

<?php
get_footer();
