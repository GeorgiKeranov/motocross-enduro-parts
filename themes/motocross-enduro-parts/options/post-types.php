<?php

register_post_type( 'crb_motorcycle', array(
	'labels' => array(
		'name' => __( 'Motorcycles', 'crb' ),
		'singular_name' => __( 'Motorcycle', 'crb' ),
		'add_new' => __( 'Add New', 'crb' ),
		'add_new_item' => __( 'Add new Motorcycle', 'crb' ),
		'view_item' => __( 'View Motorcycle', 'crb' ),
		'edit_item' => __( 'Edit Motorcycle', 'crb' ),
		'new_item' => __( 'New Motorcycle', 'crb' ),
		'view_item' => __( 'View Motorcycle', 'crb' ),
		'search_items' => __( 'Search Motorcycles', 'crb' ),
		'not_found' =>  __( 'No Motorcycles found', 'crb' ),
		'not_found_in_trash' => __( 'No Motorcycles found in trash', 'crb' ),
	),
	'public' => false,
	'exclude_from_search' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'_edit_link' => 'post.php?post=%d',
	'rewrite' => array(
		'slug' => 'motorcyle',
		'with_front' => false,
	),
	'query_var' => true,
	'menu_icon' => 'dashicons-align-left',
	'supports' => array( 'title', 'editor', 'page-attributes' ),
) );
