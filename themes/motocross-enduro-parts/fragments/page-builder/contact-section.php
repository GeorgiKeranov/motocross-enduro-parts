<?php 
$has_fields = array_filter( array(
	$section['form_shortcode'],
	$section['phone'],
	$section['email'],
	$section['work_time_title'],
	!empty( $section['work_time_rows'] ),
) );

if ( empty( $has_fields ) ) {
	return;
}
?>

<div class="section-contact">
	<div class="shell">
		<div class="section__inner">
			<div class="section__form">
				<?php if ( !empty( $section['form_shortcode'] ) ) {
					echo do_shortcode( $section['form_shortcode'] );
				} ?>
			</div><!-- /.section__form -->

			<div class="section__details">
				<div class="section__details-contacts">
					<?php if ( !empty( $section['phone'] ) ) : ?>
						<a class="icotext-phone" href="tel:<?php echo esc_html( $section['phone'] ) ?>"><i class="ico-phone"></i> <?php echo esc_html( $section['phone'] ) ?></a>
					<?php endif; ?>
					
					<?php if ( !empty( $section['email'] ) ) : ?>
						<a class="icotext-mail" href="mailto:<?php echo esc_html( $section['email'] ) ?>"><i class="ico-mail"></i> <?php echo esc_html( $section['email'] ) ?></a>
					<?php endif; ?>
				</div><!-- /.section__details-email -->

				<div class="section__details-text">
					<?php if ( !empty( $section['work_time_title'] ) ) : ?>
						<h3><?php echo esc_html( $section['work_time_title'] ) ?></h3>
					<?php endif; ?>
					
					<?php if ( !empty( $section['work_time_rows'] ) ) : ?>
						<?php foreach ( $section['work_time_rows'] as $row ) : ?>
							<div class="section-columns">
								<div class="section__col">
									<?php if ( !empty( $row['left_text'] ) ) : ?>
										<p><?php echo esc_html( $row['left_text'] ) ?></p>
									<?php endif; ?>
								</div><!-- /.section__col -->

								<div class="section__col">
									<?php if ( !empty( $row['right_text'] ) ) : ?>
										<p><?php echo esc_html( $row['right_text'] ) ?></p>
									<?php endif; ?>
								</div><!-- /.section__col -->
							</div><!-- /.section-columns -->
						<?php endforeach; ?>
					<?php endif; ?>
				</div><!-- /.section__details-text -->
			</div><!-- /.section__details -->
		</div><!-- /.section__inner -->
	</div><!-- /.shell -->
</div><!-- /.section-contact -->