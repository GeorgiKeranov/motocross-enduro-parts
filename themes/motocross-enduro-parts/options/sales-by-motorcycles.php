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
				'permalink' => get_edit_post_link( $motorcycle_disassembled_id ),
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
				'permalink' => get_edit_post_link( $motorcycle_disassembled_id ),
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

function crb_get_years_with_orders() {
	$orders = wc_get_orders( array(
		'limit' => 1,
		'orderby' => 'date',
		'order' => 'ASC',
	) );

	if ( empty( $orders ) ) {
		return;
	}

	$first_order = current( $orders );
	$first_order_created_on_year = $first_order->get_date_created()->format( 'Y' );

	$current_year = current_time( 'Y' );
	
	$years_sequence = range( $first_order_created_on_year, $current_year );

	return $years_sequence;
}

function crb_get_months_bg() {
	return array(
		'Януари',
		'Февруари',
		'Март',
		'Април',
		'Май',
		'Юни',
		'Юли',
		'Август',
		'Септември',
		'Октомври',
		'Ноември',
		'Декември',
	);
}

function crb_get_motorcycles_sales_by_months_in_year($year) {
	$orders = wc_get_orders( array(
		'status' => 'wc-completed',
		'limit' => -1,
		'orderby' => 'date',
		'order' => 'ASC',
		'date_created' => $year . '-01-01...' . $year . '-12-31'
	) );

	if ( empty( $orders ) ) {
		return array();
	}

	$months_bg = crb_get_months_bg();
	$months_bg_preset_zero = array_fill_keys( $months_bg, 0 );

	$motorcycles_sales_by_months = array();

	foreach ( $orders as $order ) {
		$month_num = $order->get_date_created()->format( 'n' ) - 1;
		$month_name = $months_bg[$month_num];

		$order_items = $order->get_items();

		foreach ( $order_items as $item ) {
			$product_id = $item->get_product_id();
			$motorcycle_id = carbon_get_post_meta( $product_id, 'crb_part_disassembled_from_motorcycle' );

			if ( empty( $motorcycle_id ) ) {
				continue;
			}

			if ( !isset( $motorcycles_sales_by_months[$motorcycle_id] ) ) {
				$motorcycles_sales_by_months[$motorcycle_id] = array(
					'title' => get_the_title( $motorcycle_id ),
					'permalink' => get_edit_post_link( $motorcycle_id ),
					'months' => $months_bg_preset_zero,
				);
			}

			$product = $item->get_product();
			$motorcycles_sales_by_months[$motorcycle_id]['months'][$month_name] += $product->get_price();
		}
	}

	return $motorcycles_sales_by_months;
}

