<?php

add_action( 'admin_menu', 'crb_add_sales_by_motorcycles_page' );
function crb_add_sales_by_motorcycles_page() {
	add_submenu_page( 
		'edit.php?post_type=crb_motorcycle',
		__( 'Sales By Motorcycles', 'crb' ),
		__( 'Sales By Motorcycles', 'crb' ),
		'manage_options',
		'sales_by_motorcycles',
		'crb_sales_by_motorcycles'
	);
}

function crb_sales_by_motorcycles() {
	crb_render_fragment( 'admin/sales-by-motorcycles' );
}

function crb_get_total_sales_and_future_sales_by_motorcycles() {
	$products_sold = new WP_Query( array(
		'post_type' => 'product',
		'meta_query' => array(
			array(
				'key' => '_stock_status',
				'compare' => '=',
				'value' => 'outofstock',
			)
		),
		'posts_per_page' => -1,
		'fields' => 'ids',
	) );

	if ( !$products_sold->have_posts() ) {
		return array();
	}

	$total_sales_by_motorcycle = array();

	foreach ( $products_sold->posts as $product_id ) {
		$motorcycle_disassembled_id = carbon_get_post_meta( $product_id, 'crb_part_disassembled_from_motorcycle' );

		// Add new motorcycle to the array if it doesn't already exists
		if ( !isset( $total_sales_by_motorcycle[$motorcycle_disassembled_id] ) ) {
			$total_sales_by_motorcycle[$motorcycle_disassembled_id] = array(
				'title' => get_the_title( $motorcycle_disassembled_id ),
				'permalink' => get_the_permalink( $motorcycle_disassembled_id ),
				'total_sales' => 0,
				'total_future_sales' => 0
			);
		}

		$wc_product = wc_get_product( $product_id );
		$product_price = $wc_product->get_price();

		$total_sales_by_motorcycle[$motorcycle_disassembled_id]['total_sales'] += $product_price;
	}

	$products_available = new WP_Query( array(
		'post_type' => 'product',
		'meta_query' => array(
			array(
				'key' => '_stock_status',
				'compare' => '=',
				'value' => 'instock',
			)
		),
		'posts_per_page' => -1,
		'fields' => 'ids',
	) );

	if ( !$products_available->have_posts() ) {
		return $total_sales_by_motorcycle;
	}

	foreach ( $products_available->posts as $product_id ) {
		$motorcycle_disassembled_id = carbon_get_post_meta( $product_id, 'crb_part_disassembled_from_motorcycle' );

		// Add new motorcycle to the array if it doesn't already exists
		if ( !isset( $total_sales_by_motorcycle[$motorcycle_disassembled_id] ) ) {
			$total_sales_by_motorcycle[$motorcycle_disassembled_id] = array(
				'title' => get_the_title( $motorcycle_disassembled_id ),
				'permalink' => get_the_permalink( $motorcycle_disassembled_id ),
				'total_sales' => 0,
				'total_future_sales' => 0
			);
		}

		$wc_product = wc_get_product( $product_id );
		$product_price = $wc_product->get_price();

		$total_sales_by_motorcycle[$motorcycle_disassembled_id]['total_future_sales'] += $product_price;
	}

	return $total_sales_by_motorcycle;
}

// TODO add functionality for sales by motorcycle for every month in selected year
// https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query
// $orders = wc_get_orders( array(
// 	'status' => 'wc-completed',
// 	'limit' => -1
// ) );
