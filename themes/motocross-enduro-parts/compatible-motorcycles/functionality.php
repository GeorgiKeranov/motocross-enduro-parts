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
 */
add_action( 'save_post', 'crb_save_product_compatible_motorcycles', 10, 3 );
function crb_save_product_compatible_motorcycles( $post_id, $post, $update ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( 'auto-draft' === $post->post_status ) {
		return;	
	}

	// Do this function only on the products from woocommerce
	if ( $post->post_type != 'product' ) {
		return;
	}

	global $wpdb;
	$table_name = $wpdb->base_prefix . 'product_compatible_motorcycle_types';

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
				'post_id' => $post_id,
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
				'post_id' => $post_id,
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

function crb_get_all_motorcycle_types() {
	$motorcycle_types = carbon_get_theme_option( 'crb_motorcycle_types' );
	$motorcycle_types_structured_array = array();

	if ( empty( $motorcycle_types ) ) {
		return array();
	}

	foreach ( $motorcycle_types as $motorcycle_type ) {
		$motorcycle_types_structured_array[$motorcycle_type['make']] = array();

		foreach ( $motorcycle_type['motorcycle_models'] as $model ) {
			$motorcycle_types_structured_array[$motorcycle_type['make']][$model['model']] = array(
				'first_production_year' => $model['first_production_year'],
				'last_production_year' => $model['last_production_year']
			);
		}
	}
	
	return $motorcycle_types_structured_array;
}

function crb_get_compatible_motorcycles_excerpt( $compatible_motorcycles ) {
	$compatible_motorcycles_excerpt = '';

	if ( empty( $compatible_motorcycles ) ) {
		return $compatible_motorcycles_excerpt;
	}

	$compatible_motorcycles_sorted = array();

	// Create associative array by make and model
	foreach ( $compatible_motorcycles as $compatible_motorcycle )  {
		$make = $compatible_motorcycle['make'];
		$model = $compatible_motorcycle['model'];

		$compatible_motorcycles_sorted[$make][$model][] = array(
			'year_from' => $compatible_motorcycle['year_from'],
			'year_to' => $compatible_motorcycle['year_to'],
		);
	}

	// Sort the makes and models by the alphabets
	$compatible_motorcycles_sorted = crb_ksort_nested_array( $compatible_motorcycles_sorted );

	// Create custom string from all of the makes, models and years
	$is_first_make = true;
	foreach ( $compatible_motorcycles_sorted as $make => $models ) {
		// Apply comma only on the makes after the first one
		if ( !$is_first_make ) {
			$compatible_motorcycles_excerpt .= ', ';
		}

		$is_first_make = false;

		$compatible_motorcycles_excerpt .= $make . ' ';

		$is_first_model = true;
		foreach ( $models as $model => $years ) {
			// Apply comma only on the models after the first one
			if ( !$is_first_model ) {
				$compatible_motorcycles_excerpt .= ', ';
			}

			$is_first_model = false;

			$compatible_motorcycles_excerpt .= $model . ' ';

			foreach ( $years as $index_years => $years ) {
				// Apply space only on the years after the first one
				if ( $index_years > 0 ) {
					$compatible_motorcycles_excerpt .= ' ';
				}

				$compatible_motorcycles_excerpt .=  crb_get_compatible_years( $years['year_from'], $years['year_to'] );
			}
		}
	}
	
	return $compatible_motorcycles_excerpt;
}

function crb_ksort_nested_array( $array ) {
	if ( is_array( $array ) ) {
		ksort( $array );

		foreach ( $array as $key => $value ) {
			$array[$key] = crb_ksort_nested_array( $value );
		}
	}

	return $array;
}

function crb_get_last_two_digits_from_year( $year ) {
	return substr( $year, -2 );
}

function crb_get_compatible_years( $year_from, $year_to ) {
	if ( $year_from === $year_to ) {
		return $year_from;
	}
	
	$year_from_last_two_digits = substr( $year_from, -2 );
	$year_to_last_two_digits = substr( $year_to, -2 );

	return $year_from_last_two_digits . '-' . $year_to_last_two_digits;	
}
