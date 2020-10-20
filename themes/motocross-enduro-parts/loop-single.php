<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'article article--single' ) ?>>
		<header class="article__head">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="article__image">
					<?php the_post_thumbnail( 'large' ); ?>
				</div><!-- /.article__image -->
			<?php endif; ?>

			<h2 class="article__title">
				<?php the_title(); ?>
			</h2><!-- /.article__title -->

			<?php get_template_part( 'fragments/post-meta' ); ?>
		</header><!-- /.article__head -->

		<div class="article__body">
			<div class="article__entry">
				<?php the_content(); ?>
			</div><!-- /.article__entry -->
		</div><!-- /.article__body -->
	</article><!-- /.article -->

	<?php comments_template(); ?>

	<?php theme_pagination( 'post', [
		'prev_html' => '<a href="{URL}" class="paging__prev">' . esc_html__( '« Previous Entry', 'crb' ) . '</a>',
		'next_html' => '<a href="{URL}" class="paging__next">' . esc_html__( 'Next Entry »', 'crb' ) . '</a>',
	] ); ?>
<?php endwhile; ?>
