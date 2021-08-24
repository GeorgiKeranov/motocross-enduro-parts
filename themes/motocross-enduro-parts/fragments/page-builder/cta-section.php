<?php 
$background_image = wp_get_attachment_image_url( $section['background_image'], 'full-width' );
?>

<div class="section-cta section-fade" style="background-image: url(<?php echo $background_image ?>)">
	<div class="shell">
		<div class="section__content">
			<h2><?php echo nl2br( esc_html( $section['text'] ) ) ?></h2>

			<?php if ( !empty( $section['btn_text'] ) && !empty( $section['btn_url'] ) ) : ?>
				<a href="<?php echo esc_url( $section['btn_url'] ) ?>"<?php echo $section['btn_target'] ? ' target="_blank"' : '' ?>><?php echo esc_html( $section['btn_text'] ) ?></a>
			<?php endif; ?>
		</div><!-- /.section__content -->
	</div><!-- /.shell -->
</div><!-- /.section-cta -->