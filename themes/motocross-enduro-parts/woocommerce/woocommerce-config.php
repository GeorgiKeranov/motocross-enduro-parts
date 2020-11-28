<?php

/**
 * Remove Actions
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/**
 * Add Actions
 */
add_action( 'woocommerce_before_main_content', 'crb_woocommerce_before_main_content', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'crb_start_product_images_wrapper', 0 );
add_action( 'woocommerce_before_shop_loop_item_title', 'crb_add_on_hover_shop_loop_image', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'crb_end_product_images_wrapper', 20 );

add_action( 'woocommerce_checkout_before_order_review_heading', 'crb_start_wrapper_to_order_review', 10 );
add_action( 'woocommerce_checkout_after_order_review', 'crb_end_wrapper_to_order_review', 10 );

add_action( 'woocommerce_order_status_completed', 'crb_outofstock_products_from_completed_order', 10, 1 );
add_action( 'woocommerce_order_status_cancelled', 'crb_instock_products_from_canceled_order', 10, 1 );

add_action( 'woocommerce_before_single_product', 'crb_add_product_title_for_mobile_devices', 10 );

/**
 * Add Filters
 */
add_filter( 'woocommerce_sale_flash', 'crb_woocommerce_sale_flash', 20, 3 );
add_filter( 'woocommerce_get_script_data', 'crb_change_js_view_cart_button', 10, 2 ); 
add_filter( 'woocommerce_is_sold_individually', 'crb_remove_all_quantity_fields', 10, 2 );
add_filter( 'woocommerce_checkout_fields', 'crb_change_checkout_fields', 10 );
add_filter( 'woocommerce_default_address_fields', 'crb_change_checkout_address_fields', 10 );
add_filter( 'woocommerce_add_to_cart_fragments', 'crb_refresh_mini_cart_count', 10);

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

function crb_add_product_title_for_mobile_devices() {
	echo '<h2 class="woocommerce-product-mobile-title">' . get_the_title() . '</h2>';
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
	// Reorder fields
	$fields['billing']['billing_email']['priority'] = 30;
	$fields['billing']['billing_phone']['priority'] = 31;

	return $fields;
}

function crb_change_checkout_address_fields( $fields ) {
	// Reorder fields
	$fields['state']['priority'] = 32;
	$fields['city']['priority'] = 33;
	$fields['postcode']['priority'] = 34;

	// Rename fields
	$fields['city']['label'] = 'Населено място';
	$fields['address_1']['label'] = 'Адрес или офис на куриер';
	$fields['address_1']['placeholder'] = '';

	return $fields;
}

function crb_start_wrapper_to_order_review() {
	echo '<div class="woocommerce-order-review-wrapper">';
}

function crb_end_wrapper_to_order_review() {
	echo '</div><!-- /.woocommerce-order-review-wrapper -->';
}

function crb_outofstock_products_from_completed_order( $order_id ) {
	crb_set_status_for_products_from_order( $order_id, 'outofstock' );
}

function crb_instock_products_from_canceled_order( $order_id ) {
	crb_set_status_for_products_from_order( $order_id, 'instock' );
}

function crb_set_status_for_products_from_order( $order_id, $status ) {
	if ( ! $order_id ) {
		return;
	}

	$order = new WC_Order( $order_id );
	$items = $order->get_items();

	foreach ( $items as $item ) {
		$product = wc_get_product( $item['product_id'] );
		$product_id = $product->get_id();

		// Make the product with out of stock status
		$product = new WC_Product( $product_id );
		$product->set_stock_status( $status );
		$product->save();
	}
}

function crb_refresh_mini_cart_count( $fragments ) {
    ob_start(); ?>
    	<span id="mini-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['#mini-cart-count'] = ob_get_clean();

    return $fragments;
}

function crb_get_woocommerce_products( $parameters ) {
	global $wpdb;

	$prefix = $wpdb->prefix;

	// This array is used to store all of the user variables that are coming so we
	// can prepare the dynamic sql query with them at the end to prevent sql injection
	$sql_query_parameters = array();

	// This string will store the dynamic sql query and we will not add directly here the user input
	$sql_query = "SELECT {$prefix}posts.post_title FROM {$prefix}posts WHERE {$prefix}posts.post_type = 'product' and {$prefix}posts.post_status = 'publish'";

	// Search in the title of the product
	if ( !empty( $parameters['search'] ) ) {
		if ( strpos($parameters['search'], ' ') === false ) {
			// Build search query for only one keyword
			$sql_query .= " and {$prefix}posts.post_title LIKE '%s'";
			$sql_query_parameters[] = '%' . $parameters['search'] . '%';
		} else {
			// Build search query for multiple keywords
			$sql_query .= " and (";

			$keywords = explode( ' ', $parameters['search'] );
			$keywords_count = count( $keywords ) - 1;

			// Add sql search query and parameter for each keyword
			foreach ( $keywords as $index => $keyword ) {
				$sql_query .= "{$prefix}posts.post_title LIKE '%s'";
				$sql_query_parameters[] = '%' . $keyword . '%';

				if ( $index < $keywords_count ) {
					$sql_query .= " and ";
				}
			}

			$sql_query .= ")";
		}

		// TODO MAYBE add order by ( case when ... when ... )
	}

	$sql_query .= " ORDER BY {$prefix}posts.post_date DESC LIMIT 0, 16";

	// Do not prepare sql query with parameters if there are not parameters to be prepared
	$sql_query_prepared = $sql_query;

	// Prepare sql query with parameters if there are defined parameters in the array
	if ( !empty( $sql_query_parameters ) ) {
		$sql_query_prepared = $wpdb->prepare( $sql_query, $sql_query_parameters );
	}

	$products_ids = $wpdb->get_results( $sql_query_prepared );

	return $products_ids;
}

function crb_get_woocommerce_pages_for_products( $parameters ) {
	$products_count = $wpdb->get_var( "SELECT COUNT(*) FROM wp_posts WHERE wp_posts.post_type = 'product' and wp_posts.post_status = 'publish'" );
	$pages_count = intval($products_count / 16) + ($products_count % 16 == 0 ? 0 : 1);

	return $pages_count;
}
