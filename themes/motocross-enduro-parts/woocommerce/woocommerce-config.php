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

add_action( 'woocommerce_before_shop_loop_item_title', 'crb_start_product_images_wrapper', 0 );
add_action( 'woocommerce_before_shop_loop_item_title', 'crb_add_on_hover_shop_loop_image', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'crb_end_product_images_wrapper', 20 );

add_action( 'woocommerce_checkout_before_order_review_heading', 'crb_start_wrapper_to_order_review', 10 );
add_action( 'woocommerce_checkout_after_order_review', 'crb_end_wrapper_to_order_review', 10 );

/**
 * Add Filters
 */
add_filter( 'woocommerce_sale_flash', 'crb_woocommerce_sale_flash', 20, 3 );
add_filter( 'woocommerce_get_script_data', 'crb_change_js_view_cart_button', 10, 2 ); 
add_filter( 'woocommerce_is_sold_individually', 'crb_remove_all_quantity_fields', 10, 2 );
add_filter( 'woocommerce_checkout_fields', 'crb_change_checkout_fields' );

/**
 * Functions
 */
function crb_woocommerce_before_main_content() {
	get_template_part( 'woocommerce/wc-before-main-content' );
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

function crb_remove_all_quantity_fields( $return, $product ) {
    return true;
}

function crb_change_checkout_fields( $fields ) {
    // var_dump( $fields );
    // exit;

    return $fields;
}

function crb_start_wrapper_to_order_review() {
    echo '<div class="woocommerce-order-review-wrapper">';
}

function crb_end_wrapper_to_order_review() {
    echo '</div><!-- /.woocommerce-order-review-wrapper -->';
}

