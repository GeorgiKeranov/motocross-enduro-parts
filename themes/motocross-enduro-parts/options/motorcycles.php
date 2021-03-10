<?php

function crb_get_motorcycles() {
	$motorcycles = new WP_Query( array(
		'post_type' => 'crb_motorcycle',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	) );

	$motorcycles_data = array( 0 => 'Изберете мотора от който идва тази част' );

	if ( !$motorcycles->have_posts() ) {
		return $motorcycles_data;
	}

	foreach ( $motorcycles->posts as $motorcycle ) {
		$motorcycles_data[$motorcycle->ID] = $motorcycle->post_title;
	}

	return $motorcycles_data;
}

# Add automatically disassembled from motorcycle to every new part with empty field
add_action( 'save_post' , 'crb_add_disassembled_motorcycle' , 20, 3 );
function crb_add_disassembled_motorcycle( $post_id, $post, $update ) {
    
	if ( $post->post_type != 'product' ) {
		return;
	}

    if ( !empty( $_POST['carbon_fields_compact_input']['_crb_part_disassembled_from_motorcycle'] ) ) {
    	return $post_id;
    }

    $autofill_part_disassembled_from_motorcycle = carbon_get_theme_option( 'crb_autofill_new_parts_disassembled_from_motorcycle' );

    if ( empty( $autofill_part_disassembled_from_motorcycle ) ) {
    	return $post_id;
    }

	carbon_set_post_meta( $post_id, 'crb_part_disassembled_from_motorcycle', $autofill_part_disassembled_from_motorcycle );

    return $post_id;
}
