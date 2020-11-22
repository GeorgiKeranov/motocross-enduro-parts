<?php

/**
 * Create custom sql table for storing compatible motorcycles for each product
 */
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

/**
 * Create Meta Boxes for adding/removing compatible motorcycles at the products in admin panel
 */
add_action( 'add_meta_boxes', 'crb_add_compatible_motorcycles_metabox' );
function crb_add_compatible_motorcycles_metabox() {
	add_meta_box(
		'compatible_motorcycles',
		'Съвместими Мотори',
		'crb_get_compatible_motorcycles_scripts_markup',
		'product'
	);
}

/**
 * Render html and javascript that will be inside the metabox
 */
function crb_get_compatible_motorcycles_scripts_markup( $post ) {
	include_once( CRB_THEME_DIR . 'compatible-motorcycles\metaboxes-html.php' );
}

/**
 * When the product is saved get the compatible motorcycles and save them in the database
 * TODO: add validation for the fields
 */
add_action( 'save_post', 'crb_save_product_compatible_motorcycles' );
function crb_save_product_compatible_motorcycles() {
	global $wpdb;
	$table_name = $wpdb->base_prefix . 'product_compatible_motorcycle_types';
	$current_product_id = get_the_ID();

	// Remove deleted compatible motorcycles
	if ( !empty( $_POST['removed_compatible_motorcycles'] ) ) {
		$removed_compatible_motorcycles = $_POST['removed_compatible_motorcycles'];

		foreach ( $removed_compatible_motorcycles as $removed_compatible_motorcycle_id ) {
			$wpdb->delete( $table_name, array(
				'id' => $removed_compatible_motorcycle_id
			) );
		}
	}

	// Add the new compatible motorcycles
	if ( !empty( $_POST['new_compatible_motorcycles'] ) ) {
		$new_compatible_motorcycles = $_POST['new_compatible_motorcycles'];

		foreach ( $new_compatible_motorcycles as $motorcycle ) {
			$wpdb->insert( $table_name, array(
				'post_id' => $current_product_id,
				'make' => $motorcycle['make'],
				'model' => $motorcycle['model'],
				'year_from' => $motorcycle['year_from'],
				'year_to' => $motorcycle['year_to'],
			) );
		}
	}

	if ( !empty( $_POST['existing_compatible_motorcycles'] ) ) {
		$existing_compatible_motorcycles = $_POST['existing_compatible_motorcycles'];

		foreach ( $existing_compatible_motorcycles as $motorcycle ) {
			$sucess = $wpdb->update( $table_name, array(
				'post_id' => $current_product_id,
				'make' => $motorcycle['make'],
				'model' => $motorcycle['model'],
				'year_from' => $motorcycle['year_from'],
				'year_to' => $motorcycle['year_to'],
			), array( 'id' => $motorcycle['id'] ) );
		}	
	}
}

function crb_get_product_compatible_motorycles( $product_id ) {
	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}product_compatible_motorcycle_types WHERE post_id = $product_id" );

	if ( empty( $results ) ) {
		return array();
	}

	return $results;
}

function crb_get_all_motorcycle_makes() {
	$makes = carbon_get_theme_option( 'crb_motorcycle_types' );
	$makes_only = array();

	if ( empty( $makes ) ) {
		return $makes_only;
	}

	foreach ( $makes as $make ) {
		$makes_only[] = $make['make'];
	}

	return $makes_only;
}
