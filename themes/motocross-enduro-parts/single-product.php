<?php
the_post();

get_header();
?>

<div class="section-default">
	<div class="shell">
		<h1><?php the_title() ?></h1>

		<?php the_content() ?>
	</div><!-- /.shell -->
</div><!-- /.section-default -->

<?php
get_footer();
