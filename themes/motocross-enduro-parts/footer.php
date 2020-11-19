	<?php
	$text = carbon_get_theme_option( 'crb_footer_text' );
	$phone = carbon_get_theme_option( 'crb_footer_phone' );
	$email = carbon_get_theme_option( 'crb_footer_email' );
	$copyright = carbon_get_theme_option( 'crb_footer_copyright' );
	?>

	<footer class="footer">
		<div class="footer__body">
			<div class="shell">
				<div class="footer__body-flex">
					<div class="footer__logo">
						<a href="<?php echo home_url('/') ?>" class="logo-alt"></a>
					</div><!-- /.footer__logo -->

					<div class="footer__text">
						<?php echo crb_content( $text ) ?>
					</div><!-- /.footer__text -->

					<div class="footer__contacts">
						<?php if ( !empty( $phone ) ) : ?>
							<a class="icotext-phone" href="tel:<?php echo esc_html( $phone ) ?>"><i class="ico-phone"></i> <?php echo esc_html( $phone ) ?></a>
						<?php endif; ?>
						
						<?php if ( !empty( $email ) ) : ?>
							<a class="icotext-mail" href="mailto:<?php echo esc_html( $email ) ?>"><i class="ico-mail"></i> <?php echo esc_html( $email ) ?></a>
						<?php endif; ?>
					</div><!-- /.footer__contacts -->
				</div><!-- /.footer__body-flex -->
			</div><!-- /.shell -->
		</div><!-- /.footer__body -->

		<div class="footer__copyright">
			<div class="shell">
				<?php if ( !empty( $copyright ) ) : ?>
					<p><?php echo esc_html( $copyright ) ?></p>
				<?php endif; ?>
			</div><!-- /.shell -->
		</div><!-- /.footer__bottom -->
	</footer><!-- /.footer -->

	<?php wp_footer(); ?>
</div><!-- /.wrapper -->
</body>
</html>