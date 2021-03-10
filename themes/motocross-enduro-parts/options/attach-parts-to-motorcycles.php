<?php

add_action( 'admin_menu', 'crb_add_motorcycle_pages' );
function crb_add_motorcycle_pages() {
	add_submenu_page( 
		'edit.php?post_type=crb_motorcycle',
		__( 'Attach Parts To Motorcycles', 'crb' ),
		__( 'Attach Parts To Motorcycles', 'crb' ),
		'manage_options',
		'attach_parts_to_motorcycles',
		'crb_attach_parts_to_motorcycles'
	);
}

function crb_attach_parts_to_motorcycles() {
	if ( isset( $_POST ) ) {
		crb_save_attached_parts_to_motorcycles( $_POST );
	}

	crb_render_fragment( 'admin/attach-motorcycle-parts-to-motorcycle' );
}

function crb_save_attached_parts_to_motorcycles( $params ) {
	if ( empty( $params['selected_parts'] ) || empty( $params['motorcycle'] ) ) {
		return;
	}

	$selected_parts = $params['selected_parts'];
	$motorcycle = $params['motorcycle'];

	foreach ( $selected_parts as $selected_part_id ) {
		carbon_set_post_meta( $selected_part_id, 'crb_part_disassembled_from_motorcycle', $motorcycle );
	}
}
