<?php 
$has_fields = array_filter( array(
	$section['background_image'],
	$section['title'],
	$section['text']
) );

if ( empty( $has_fields ) ) {
	return;
}
?>

<div class="section-intro" style="background-image: url(<?php echo wp_get_attachment_image_url( $section['background_image'], 'full-width' ) ?>)">
	<div class="shell">
		<?php if ( !empty( $section['title'] ) ) : ?>
			<h1><?php echo esc_html( $section['title'] ) ?></h1>
		<?php endif; ?>

		<?php if ( !empty( $section['text'] ) ) : ?>
			<p><?php echo nl2br( esc_html( $section['text'] ) ) ?></p>
		<?php endif; ?>
	</div><!-- /.shell -->
</div><!-- /.section-intro -->