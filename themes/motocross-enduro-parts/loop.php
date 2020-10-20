<?php if ( have_posts() ) : ?>
	<ol class="articles">
		<?php while ( have_posts() ) : the_post(); ?>
			<li <?php post_class( 'article' ) ?>>
				<header class="article__head">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="article__image">
							<?php the_post_thumbnail( 'large' ); ?>
						</div><!-- /.article__image -->
					<?php endif; ?>

					<h2 class="article__title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permanent Link to %s', 'crb' ), get_the_title() ) ); ?>">
							<?php the_title(); ?>
						</a>
					</h2><!-- /.article__title -->

					<?php get_template_part( 'fragments/post-meta' ); ?>
				</header><!-- /.article__head -->

				<div class="article__body">
					<div class="article__entry">
						<?php the_content( __( 'Read the rest of this entry &raquo;', 'crb' ) ); ?>
					</div><!-- /.article__entry -->
				</div><!-- /.article__body -->
			</li><!-- /.article -->
		<?php endwhile; ?>
	 </ol><!-- /.articles -->
<?php else : ?>
	<ol class="articles">
		<li class="article article--error404 article--not-found">
			<div class="article__body">
				<div class="article__entry">
					<p>
						<?php
						if ( is_category() ) { // If this is a category archive
							printf( __( "Sorry, but there aren't any posts in the %s category yet.", 'crb' ), single_cat_title( '', false ) );
						} else if ( is_date() ) { // If this is a date archive
							_e( "Sorry, but there aren't any posts with this date.", 'crb' );
						} else if ( is_author() ) { // If this is a category archive
							$userdata = get_user_by( 'id', get_queried_object_id() );
							printf( __( "Sorry, but there aren't any posts by %s yet.", 'crb' ), $userdata->display_name );
						} else if ( is_search() ) { // If this is a search
							_e( 'No posts found. Try a different search?', 'crb' );
						} else {
							_e( 'No posts found.', 'crb' );
						}
						?>
					</p>

					<?php get_search_form(); ?>
				</div><!-- /.article__entry -->
			</div><!-- /.article__body -->
		</li><!-- /.article -->
	</ol><!-- /.articles -->
<?php endif; ?>