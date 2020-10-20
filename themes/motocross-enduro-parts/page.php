<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class( 'page' ); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="page__image">
				<?php the_post_thumbnail(); ?>
			</div><!-- /.page__image -->
		<?php endif; ?>

		<?php crb_the_title( '<h2 class="page__title pagetitle">', '</h2>' ); ?>

		<div class="page__entry">
			<?php
			the_content();

			theme_pagination( 'custom' );

			edit_post_link( __( 'Edit this entry.', 'crb' ), '<p>', '</p>' );
			?>
		</div><!-- /.page__entry -->
	</div><!-- /.page -->
<?php endwhile; ?>

<?php get_footer(); ?>