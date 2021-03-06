<?php

$has_content = array_filter( [
	$section['title'],
	$section['slides'],
] );

if ( empty( $has_content ) ) {
	return;
}

?>

<div class="slider-testimonials section-fade">
	<div class="shell">
		<div class="slider__inner">
			<?php if ( !empty( $section['title'] ) ) : ?>
				<div class="slider__title">
					<h2><?php echo esc_html( $section['title'] ) ?></h2>
				</div><!-- /.slider__title -->
			<?php endif; ?>

			<?php if ( !empty( $section['slides'] ) ) : ?>
				<div class="slider__body">
					<div class="slider__clip">
						<div class="slider__slides">
							<?php foreach ( $section['slides'] as $slide ) :
								if ( empty( $slide['image'] ) && empty( $slide['text'] ) && empty( $slide['author'] ) ) {
									continue;
								} ?>
								<div class="slider__slide">
									<div class="slider__slide-inner">
										<div class="slider__slide-image">
											<?php echo wp_get_attachment_image( $slide['image'] ) ?>
										</div><!-- /.slider__slide-image -->

										<div class="slider__slide-text">
											<?php if ( !empty( $slide['text'] ) ) : ?>
												<p><?php echo nl2br( esc_html( $slide['text'] ) ) ?></p>
											<?php endif; ?>
											
											<?php if ( !empty( $slide['author'] ) ) : ?>
												<p><strong><?php echo esc_html( $slide['author'] ) ?></strong></p>
											<?php endif; ?>
										</div><!-- /.slider__slide-text -->
									</div><!-- /.slider__slide-inner -->
								</div><!-- /.slider__slide -->
							<?php endforeach; ?>
						</div><!-- /.slider__slides -->
					</div><!-- /.slider__clip -->	

					<div class="slider__actions">
					</div><!-- /.slider__actions -->
				</div><!-- /.slider__body -->
			<?php endif; ?>
		</div><!-- /.shell -->
	</div><!-- /.slider__inner -->
</div><!-- /.slider-testimonials -->
