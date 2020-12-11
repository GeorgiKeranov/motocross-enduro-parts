<?php
if ( !is_object( $product ) ) {
	return;
}

if ( !property_exists($product, 'ID') ) {
	return;
}

$product_id = $product->ID;
$wc_product = new WC_Product( $product_id );

$permalink = get_permalink( $product_id );
$title = get_the_title( $product_id );
$thumbnail_image = $wc_product->get_image( 'woocommerce_thumbnail' );

$first_gallery_image = '';
$gallery_images_ids = $wc_product->get_gallery_image_ids();

if ( !empty( $gallery_images_ids ) ) {
	$first_gallery_image = wp_get_attachment_image( $gallery_images_ids[0], 'woocommerce_thumbnail', false, array( 'sizes' => '(max-width: 300px) 100vw, 300px' ) );
}
?>

<li class="product">
	<a href="<?php echo $permalink ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
		<div class="woocommerce-product-images">
			<?php
			if ( $wc_product->is_on_sale() ) {
				echo crb_woocommerce_sale_flash( '', '', $wc_product );
			}

			echo $thumbnail_image;

			if ( !empty( $first_gallery_image ) ) {
				echo $first_gallery_image;
			}
			?>
		</div><!-- /.woocommerce-product-images -->

		<h2 class="woocommerce-loop-product__title"><?php echo esc_html( $title ) ?></h2>
		
		<?php if ( $price_html = $wc_product->get_price_html() ) : ?>
			<span class="price"><?php echo $price_html; ?></span>
		<?php endif; ?>
	</a>

	<a href="?add-to-cart=<?php echo $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id ?>" rel="nofollow">Купи</a>
</li>
