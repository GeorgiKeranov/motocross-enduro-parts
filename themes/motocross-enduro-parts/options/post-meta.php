<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;


Container::make( 'post_meta', __( 'Settings', 'crb' ) )
	->show_on_post_type( 'page' )
	->show_on_template( 'templates/home.php' )
	->add_tab( __( 'Slider Testimonials', 'crb' ), array(
		Field::make( 'text', 'crb_slider_testimonials_title', __( 'Title', 'crb' ) ),
		Field::make( 'complex', 'crb_slider_testimonials', __( 'Slides', 'crb' ) )
			->set_layout( 'tabbed-horizontal' )
			->add_fields( array(
				Field::make( 'image', 'image', 'Image')
					->set_required( true ),
				Field::make( 'textarea', 'text', 'Text' )
					->set_required( true ),
				Field::make( 'text', 'author', 'Author' )
					->set_required( true ),
			) ),
	) );