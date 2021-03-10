<?php

function crb_get_motorcycles( $default_field_title = '' ) {
	$motorcycles = new WP_Query( array(
		'post_type' => 'crb_motorcycle',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	) );

	if ( empty( $default_field_title ) ) {
		$default_field_title = 'Изберете мотора от който идва тази част';
	}

	$motorcycles_data = array( 0 => $default_field_title );

	if ( !$motorcycles->have_posts() ) {
		return $motorcycles_data;
	}

	foreach ( $motorcycles->posts as $motorcycle ) {
		$motorcycles_data[$motorcycle->ID] = $motorcycle->post_title;
	}

	return $motorcycles_data;
}
