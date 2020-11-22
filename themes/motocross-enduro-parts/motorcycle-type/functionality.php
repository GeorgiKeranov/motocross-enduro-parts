<?php

add_action( 'after_switch_theme', 'create_custom_sql_table_for_motorcycle_types_in_products' );
function create_custom_sql_table_for_motorcycle_types_in_products() {
	global $wpdb;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$charset_collate = $wpdb->get_charset_collate();

	$create_custom_table = "CREATE TABLE `{$wpdb->base_prefix}product_compatible_motorcycle_types` (
	  id bigint(20) NOT NULL AUTO_INCREMENT,
	  post_id bigint(20) NOT NULL,
	  make varchar(255) NOT NULL,
	  model varchar(255) NOT NULL,
	  year_from YEAR NOT NULL,
	  year_to YEAR NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";

	dbDelta($create_custom_table);
}

add_action( 'add_meta_boxes', 'crb_add_compatible_motorcycles_metabox' );
function crb_add_compatible_motorcycles_metabox() {
    add_meta_box(
        'compatible_motorcycles',
        'Съвместими Мотори',
        'crb_get_compatible_motorcycles_scripts_markup',
        'product'
    );
}

function crb_get_compatible_motorcycles_scripts_markup( $post ) {
	include_once( CRB_THEME_DIR . 'motorcycle-type\markup.php' );
}
