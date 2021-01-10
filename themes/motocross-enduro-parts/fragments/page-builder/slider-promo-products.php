<?php 
$products = new WP_Query( array(
	'post_type' => 'product',
	'posts_per_page' => 10,
	'meta_query' => array(
		array(
			'key' => '_sale_price',
			'compare' => 'EXISTS', //TODO test if we add sale price to product then remove it. WIll the _sale_price exist
		)
	)
) );
?>

<div class="slider-promo-products">
	<div class="shell">
		<?php if ( !empty( $section['title'] ) ) : ?>
			<h2><?php echo esc_html( $section['title'] ) ?></h2>
		<?php endif; ?>

		<?php if ( $products->have_posts() ) : ?>
			<div class="slider__slides">
				<?php foreach ( $products->posts as $product ) :
					$product_id = $product->ID;
					
					$wc_product = new WC_Product( $product_id );

					$permalink = get_permalink( $product_id );
					$title = get_the_title( $product_id );
					$thumbnail_image = $wc_product->get_image( 'woocommerce_thumbnail' );
					?>

					<div class="slider__slide">
						<div class="slider__slide-product">
							<a href="<?php echo $permalink ?>">
								<div class="slider__slide-image">
									<?php
									if ( $wc_product->is_on_sale() ) {
										echo crb_woocommerce_sale_flash( '', '', $wc_product );
									}

									echo $thumbnail_image;
									?>
								</div><!-- /.slider_slide-image -->

								<h3><?php echo esc_html( $title ) ?></h3>
								
								<?php if ( $price_html = $wc_product->get_price_html() ) : ?>
									<span class="price"><?php echo $price_html; ?></span>
								<?php endif; ?>
							</a>

							<a href="?add-to-cart=<?php echo $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id ?>" rel="nofollow">Купи</a>
						</div><!-- /.section__product -->
					</div><!-- /.slider__slide -->
				<?php endforeach; ?>
			</div><!-- /.slider__slides -->
		<?php endif; ?>

		<?php if ( !empty( $section['btn_text'] ) && !empty( $section['btn_url'] ) ) : ?>
			<div class="slider__actions">
				<a href="<?php echo esc_url( $section['btn_url'] ) ?>"<?php echo $section['btn_target'] ? ' target="_blank"' : '' ?>><?php echo esc_html( $section['btn_text'] ) ?></a>
			</div><!-- /.slider__actions -->
		<?php endif; ?>
	</div><!-- /.shell -->
</div><!-- /.slider-promo-products -->

