<?php

/**
 * Remove Actions
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Add Actions
 */
add_action( 'woocommerce_before_main_content', 'crb_woocommerce_before_main_content', 10 );

add_action( 'woocommerce_before_shop_loop', 'crb_woocommerce_before_shop_loop', 5 );
add_action( 'woocommerce_after_shop_loop', 'crb_woocommerce_after_after_shop_loop', 10 );

add_action( 'woocommerce_no_products_found', 'crb_woocommerce_before_shop_loop', 5 );
add_action( 'woocommerce_no_products_found', 'crb_woocommerce_after_after_shop_loop', 20 );

add_action( 'woocommerce_archive_description', 'crb_woocommerce_archive_description', 20 );

add_action( 'woocommerce_before_shop_loop_item_title', 'crb_start_product_images_wrapper', 0 );
add_action( 'woocommerce_before_shop_loop_item_title', 'crb_add_on_hover_shop_loop_image', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'crb_end_product_images_wrapper', 20 );

/**
 * Add Filters
 */
add_filter( 'woocommerce_sale_flash', 'crb_woocommerce_sale_flash', 20, 3 );
add_filter( 'woocommerce_get_script_data', 'crb_change_js_view_cart_button', 10, 2 ); 

/**
 * Functions
 */
function crb_woocommerce_before_main_content() {
	echo '<div class="woocommerce-wrapper">';
}

function crb_woocommerce_before_shop_loop() {
	echo '<div class="woocommerce-columns">
                <div class="shell">
                    <div class="woocommerce__columns">
                        <div class="woocommerce__shop">';
}

function crb_woocommerce_after_after_shop_loop() {
	echo '</div><!-- /.woocommerce__shop -->';
}

function crb_woocommerce_archive_description() {
	get_template_part( 'woocommerce/wc-archive-description' );
}

function crb_woocommerce_sale_flash( $html, $post, $product ) {
	 if ( $product->is_type( 'variable' ) ) {
        $percentages = array();

        // Get all variation prices
        $prices = $product->get_variation_prices();

        // Loop through variation prices
        foreach ( $prices['price'] as $key => $price ){
            // Only on sale variations
            if ( $prices['regular_price'][$key] !== $price ){
                // Calculate and set in the array the percentage for each variation on sale
                $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
            }
        }
        $percentage = max($percentages) . '%';
    } else {
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();

        $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
    }

    return '<span class="onsale">- ' . $percentage . '</span>';
}

function crb_change_js_view_cart_button( $params, $handle )  {
    if( 'wc-add-to-cart' !== $handle ) return $params;

    // Changing "View Cart" button text
    $params['i18n_view_cart'] = esc_attr__('Cart', 'woocommerce');

    return $params;
}

function crb_start_product_images_wrapper() {
    echo '<div class="woocommerce-product-images">';
}

function crb_end_product_images_wrapper() {
    echo '</div><!-- /.woocommerce-product-images -->';
}


function crb_add_on_hover_shop_loop_image() {
    $images_ids = wc_get_product()->get_gallery_image_ids(); 

    if ( !isset( $images_ids ) ) {
    	return;
    }

    if ( !is_array( $images_ids ) ) {
    	return;
    }

    if ( !array_key_exists( 1, $images_ids ) ) {
    	return;
    }

    echo wp_get_attachment_image( $images_ids[0], 'woocommerce_thumbnail' );
}
