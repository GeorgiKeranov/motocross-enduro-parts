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

add_action( 'woocommerce_archive_description', 'crb_woocommerce_archive_description', 10 );

/**
 * Functions
 */
function crb_woocommerce_before_main_content() {
	get_template_part( 'woocommerce/wc-before-main-content' );
}

function crb_woocommerce_before_shop_loop() {
	get_template_part( 'woocommerce/wc-before-shop-loop' );
}

function crb_woocommerce_after_after_shop_loop() {
	get_template_part( 'woocommerce/wc-after-shop-loop' );
}

function crb_woocommerce_archive_description() {
	get_template_part( 'woocommerce/wc-archive-description' );
}

