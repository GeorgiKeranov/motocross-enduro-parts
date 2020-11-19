<?php
/**
 * Template Name: Page Builder
 */

the_post();

get_header();

$sections = carbon_get_the_post_meta( 'crb_page_builder_sections' );

foreach ( $sections as $section ) {
	$fragment_name = str_replace( '_', '-', $section['_type'] );

	crb_render_fragment( 'page-builder/' . $fragment_name, array(
		'section' => $section,
	) );
}

get_footer();
