<?php
get_header();

crb_the_title( '<h2 class="pagetitle">', '</h2>' );

printf( __( '<p>Please check the URL for proper spelling and capitalization.<br />If you\'re having trouble locating a destination, try visiting the <a href="%1$s">home page</a>.</p>', 'crb' ), home_url( '/' ) );

get_sidebar();

get_footer();