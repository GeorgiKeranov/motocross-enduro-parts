<?php 
get_header();

if ( is_single() ) {
	get_template_part( 'loop', 'single' );
} else {
	get_template_part( 'loop' );
}

get_footer();