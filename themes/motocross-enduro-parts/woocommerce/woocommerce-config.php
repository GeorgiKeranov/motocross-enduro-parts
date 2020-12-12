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

add_action( 'wp_insert_post_data', 'crb_set_custom_product_title', 20, 1 );

add_action( 'wp_ajax_nopriv_get_products_html', 'crb_get_products_html_by_ajax' );
add_action( 'wp_ajax_get_products_html', 'crb_get_products_html_by_ajax' );
/**
 * Add Filters
 */
add_filter( 'woocommerce_sale_flash', 'crb_woocommerce_sale_flash', 20, 3 );
add_filter( 'woocommerce_get_script_data', 'crb_change_js_view_cart_button', 10, 2 ); 
add_filter( 'woocommerce_is_sold_individually', 'crb_remove_all_quantity_fields', 10, 2 );
add_filter( 'woocommerce_checkout_fields', 'crb_change_checkout_fields', 10 );
add_filter( 'woocommerce_default_address_fields', 'crb_change_checkout_address_fields', 10 );
add_filter( 'woocommerce_add_to_cart_fragments', 'crb_refresh_mini_cart_count', 10);

add_filter( 'wp_insert_post_empty_content', 'crb_insert_product_empty_content', 10, 2 );

add_filter( 'woocommerce_catalog_orderby', 'crb_change_catalog_orderby', 10, 1 );

/**
 * Functions
 */
function crb_woocommerce_before_main_content() {
	crb_render_fragment( 'woocommerce/woocommerce-before-main-content' );
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

function crb_get_woocommerce_products( $parameters, $pagination = false ) {
	global $wpdb;

	$prefix = $wpdb->prefix;

	// This array is used to store all of the user variables that are coming so we
	// can prepare the dynamic sql query with them at the end to prevent sql injection
	$sql_query = "SELECT {$prefix}posts.ID";
	$sql_query_parameters = array();

	if ( $pagination ) {
		$sql_query = "SELECT COUNT(*)";
	}

	// This string will store the dynamic sql query and we will not add directly here the user input
	$sql_query .= " FROM {$prefix}posts";

	if ( !empty( $parameters['motorcycle_make'] ) || !empty( $parameters['motorcycle_model'] ) || !empty( $parameters['motorcycle_year'] ) ) {
		$sql_query .= " INNER JOIN {$prefix}product_compatible_motorcycle_types ON {$prefix}posts.id = {$prefix}product_compatible_motorcycle_types.post_id";
	}

	if ( !empty( $parameters['category'] ) ) {
		$sql_query .= " LEFT JOIN {$prefix}term_relationships ON ({$prefix}posts.ID = {$prefix}term_relationships.object_id)";
		$sql_query .= " LEFT JOIN {$prefix}term_taxonomy ON ({$prefix}term_relationships.term_taxonomy_id = {$prefix}term_taxonomy.term_taxonomy_id)";
		$sql_query .= " LEFT JOIN {$prefix}terms ON ({$prefix}term_taxonomy.term_id = {$prefix}terms.term_id)";
	}

	if ( !empty( $parameters['orderby'] ) && substr( $parameters['orderby'], 0, 5 ) === 'price' ) {
		$sql_query .= " LEFT JOIN {$prefix}wc_product_meta_lookup ON {$prefix}posts.ID = {$prefix}wc_product_meta_lookup.product_id";	
	}

	$sql_query .= " WHERE {$prefix}posts.post_type = 'product' AND {$prefix}posts.post_status = 'publish'";

	if ( !empty( $parameters['motorcycle_make'] ) ) {
		$sql_query .= " AND {$prefix}product_compatible_motorcycle_types.make = '%s'";
		$sql_query_parameters[] = $parameters['motorcycle_make'];
	}

	if ( !empty( $parameters['motorcycle_model'] ) ) {
		$sql_query .= " AND {$prefix}product_compatible_motorcycle_types.model = '%s'";
		$sql_query_parameters[] = $parameters['motorcycle_model'];
	}

	if ( !empty( $parameters['motorcycle_year'] ) ) {
		$sql_query .= " AND ({$prefix}product_compatible_motorcycle_types.year_from <= %d AND %d <= {$prefix}product_compatible_motorcycle_types.year_to)";
		
		$sql_query_parameters[] = intval( $parameters['motorcycle_year'] );
		$sql_query_parameters[] = intval( $parameters['motorcycle_year'] );
	}

	if ( !empty( $parameters['category'] ) ) {
		$sql_query .= " AND {$prefix}terms.term_id = %d";
		$sql_query_parameters[] = intval( $parameters['category'] );

		$sql_query .= " AND {$prefix}term_taxonomy.taxonomy = 'product_cat'";
	}

	// Search in the title of the product
	if ( !empty( $parameters['search'] ) ) {
		if ( strpos($parameters['search'], ' ') === false ) {
			// Build search query for only one keyword
			$sql_query .= " AND {$prefix}posts.post_title LIKE '%s'";
			$sql_query_parameters[] = '%' . $parameters['search'] . '%';
		} else {
			// Build search query for multiple keywords
			$sql_query .= " AND (";

			$keywords = explode( ' ', $parameters['search'] );
			$keywords_count = count( $keywords ) - 1;

			// Add sql search query and parameter for each keyword
			foreach ( $keywords as $index => $keyword ) {
				$sql_query .= "{$prefix}posts.post_title LIKE '%s'";
				$sql_query_parameters[] = '%' . $keyword . '%';

				if ( $index < $keywords_count ) {
					$sql_query .= " AND ";
				}
			}

			$sql_query .= ")";
		}
	}

	// Add 'ORDER BY' and 'LIMIT' only if we are not on the pagination query
	if ( !$pagination ) {
		$sql_query .= " GROUP BY {$prefix}posts.id";

		// If there is not 'orderby' in the get parameters set the order of the products by date
		// also if we have 'orderby' in the get parameters and it is equal to 'date' set the order by date
		if ( empty( $parameters['orderby'] ) || $parameters['orderby'] === 'date' ) {
			$sql_query .= " ORDER BY {$prefix}posts.post_date DESC";
		}

		if ( !empty( $parameters['orderby'] ) && $parameters['orderby'] === 'price' ) {
			$sql_query .= " ORDER BY {$prefix}wc_product_meta_lookup.min_price ASC, {$prefix}wc_product_meta_lookup.product_id ASC";
		}

		if ( !empty( $parameters['orderby'] ) && $parameters['orderby'] === 'price-desc' ) {
			$sql_query .= " ORDER BY {$prefix}wc_product_meta_lookup.min_price DESC, {$prefix}wc_product_meta_lookup.product_id ASC";
		}

		$products_per_page = 16;
		$page = 1;

		if ( !empty( $parameters['page'] ) ) {
			$page = intval( $parameters['page'] );
		}

		$last_product_on_page = $products_per_page * $page;
		$first_product_on_page = $last_product_on_page - $products_per_page;

		$sql_query .= " LIMIT %d, %d";
		$sql_query_parameters[] = $first_product_on_page;
		$sql_query_parameters[] = $last_product_on_page;
	}

	// Do not prepare sql query with parameters if there are not parameters to be prepared
	$sql_query_prepared = $sql_query;

	// Prepare sql query with parameters if there are defined parameters in the array
	if ( !empty( $sql_query_parameters ) ) {
		$sql_query_prepared = $wpdb->prepare( $sql_query, $sql_query_parameters );
	}

	if ( $pagination ) {
		$products_count = $products_count = $wpdb->get_var( $sql_query_prepared );
		
		$pages_count = intval($products_count / 16) + ($products_count % 16 == 0 ? 0 : 1);
		
		return $pages_count;
	}

	$products = $wpdb->get_results( $sql_query_prepared );

	return $products;
}

/**
 * Add additional functionality for determing if the post is empty only if the post_type is product
 *
 * This is done because we have custom fields in the post type product that the default wordpress
 * check for empty post is not detecting by it self and it is thinking that the post is empty
 * while we have content to the custom fields
 */
function crb_insert_product_empty_content( $maybe_empty, $postarr ) {
	// If the post is not empty return that the post is not empty
	if ( $maybe_empty === false ) {
		return $maybe_empty;
	}

	// If the post type is not product return the default behavior of validating
	if ( $postarr['post_type'] != 'product' ) {
		return $maybe_empty;
	}
	
	$are_carbon_fields_changed = !empty( $postarr['carbon_fields_changed'] );
	$are_new_compatible_motorcycles = !empty( $postarr['new_compatible_motorcycles'] );

	// If the carbon fields are changed or the new compatible motorcycles added
	// return that the post is not empty and can be saved by returning false value
	if ( $are_carbon_fields_changed || $are_new_compatible_motorcycles ) {
		return false;
	}

	return true;
}

/**
 * Change the title of the product based on part name and compatible motorcycles
 */
function crb_set_custom_product_title( $data ) {
	// Do this function only on the products from woocommerce
	if ( get_post_type() != 'product' ) {
		return $data;
	}

	$part_name = '';
	if ( isset( $_POST['carbon_fields_compact_input'] ) && !empty( $_POST['carbon_fields_compact_input']['_crb_part_name'] ) ) {
		$part_name = $_POST['carbon_fields_compact_input']['_crb_part_name'];
	}

	$compatible_motorcycles = array();

	// Add the new compatible motorcycles
	if ( !empty( $_POST['new_compatible_motorcycles'] ) ) {
		 $compatible_motorcycles = $_POST['new_compatible_motorcycles'];
	}

	// Add existing compatible motorcycles
	if ( !empty( $_POST['existing_compatible_motorcycles'] ) ) {
		$compatible_motorcycles = array_merge($compatible_motorcycles, $_POST['existing_compatible_motorcycles']);
	}

	$product_title = $part_name;
	$compatible_motorcycles_excerpt = crb_get_compatible_motorcycles_excerpt( $compatible_motorcycles );

	if ( !empty( $product_title ) && !empty( $compatible_motorcycles_excerpt ) ) {
		$product_title .= ' ';
	}
	
	$product_title .= $compatible_motorcycles_excerpt;

	// If the generated title is empty return 'Без заглавие' by default
	if ( empty( $product_title ) ) {
		$data['post_title'] = 'Без заглавие';

		return $data;
	}

	// If the current product title is different from the generated 
	// update the post title and permalink with the generated one
	if ( get_the_title() != $product_title ) {
		$data['post_title'] = $product_title;
		$data['post_name'] = sanitize_title( $product_title );
	}

	return $data;
}

/**
 * Print pages before and after current page based on 'visible_pages_to_current'
 */
function crb_print_pagination_pages( $pages_count, $current_page, $visible_pages_to_current ) {
	$pages_data = array(
		'pages_count' => $pages_count,
		'current_page' => $current_page,
	);

	$page_before_current = $current_page - 1;
	if ( ( $page_before_current - $visible_pages_to_current ) > 1 ) {
		$pages_data['pages_skip_to'] = $current_page - $visible_pages_to_current;
	}

	$page_after_current = $current_page + 1;
	if ( ( $page_after_current + $visible_pages_to_current ) < $pages_count ) {
		$pages_data['pages_skip_from'] = $current_page + $visible_pages_to_current;
	}

	crb_render_fragment( 'woocommerce/woocommerce-loop-pagination-pages', $pages_data );
}

/**
 * Change default woocommerce options for ordering the products on shop page
 */
function crb_change_catalog_orderby( $options ) {
	unset( $options['popularity'] );

	return $options;
}

/**
 * Get products html by ajax request parameters
 */
function crb_get_products_html_by_ajax() {
    $get_parameters = $_GET;

	$products = crb_get_woocommerce_products( $get_parameters );
	$pages_count = crb_get_woocommerce_products( $get_parameters, true );

	ob_start(); ?>

	<div class="products-wrapper">
		<?php if ( !empty( $products ) ) : ?>
			<ul class="products columns-4">
				<?php foreach ( $products as $product ) {
					crb_render_fragment( 'woocommerce/woocommerce-loop-single-product.php', array( 'product' => $product ) );
				} ?>
			</ul>

			<?php crb_render_fragment( 'woocommerce/woocommerce-loop-pagination.php', array( 'pages_count' => $pages_count ) ); ?>
		
		<?php else :
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		endif; ?>
	</div><!-- /.products-wrapper -->

	<?php
	$html = ob_get_clean();
	
	wp_send_json_success( $html );
}
