<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

Container::make( 'post_meta', __( 'Page Builder', 'crb' ) )
	->show_on_post_type( 'page' )
	->show_on_template( 'templates/page-builder.php' )
	->add_fields( array(
		Field::make( 'complex', 'crb_page_builder_sections', __( 'Sections', 'crb' ) )
			->set_layout( 'tabbed-vertical' )
			
			/**
			 * Search Section
			 */
			->add_fields( 'search-section', __( 'Search Section', 'crb' ), array(
				Field::make( 'image', 'background_image', __( 'Background Image', 'crb' ) ),
				Field::make( 'text', 'title', __( 'Title', 'crb' ) ),
				Field::make( 'text', 'search_field_title', __( 'Search Field Title', 'crb' ) ),
				Field::make( 'text', 'search_field_placeholder', __( 'Search Field Placeholder', 'crb' ) ),
				Field::make( 'text', 'separator_text', __( 'Separator Text', 'crb' ) ),
				Field::make( 'text', 'type_fields_title', __( 'Type Fields Title', 'crb' ) ),
			) )

			/**
			 * Intro Section
			 */
			->add_fields( 'intro-section', __( 'Intro Section', 'crb' ), array(
				Field::make( 'image', 'background_image', __( 'Background Image', 'crb' ) ),
				Field::make( 'text', 'title', __( 'Title', 'crb' ) ),
				Field::make( 'textarea', 'text', __( 'Text', 'crb' ) )
					->set_rows( 4 ),
			) )

			/**
			 * Contact Section
			 */
			->add_fields( 'contact-section', __( 'Contact Section', 'crb' ), array(
				Field::make( 'text', 'form_shortcode', __( 'Form Shortcode', 'crb' ) ),
				Field::make( 'text', 'phone', __( 'Phone', 'crb' ) ),
				Field::make( 'text', 'email', __( 'Email', 'crb' ) ),
				Field::make( 'text', 'work_time_title', __( 'Work Time Title', 'crb' ) ),
				Field::make( 'complex', 'work_time_rows', __( 'Work Time Rows', 'crb' ) )
					->set_layout( 'tabbed-vertical' )
					->add_fields( array(
						Field::make( 'text', 'left_text', __( 'Left Text', 'crb' ) )
							->set_width( 50 ),
						Field::make( 'text', 'right_text', __( 'Right Text', 'crb' ) )
							->set_width( 50 ),
					) )
					->set_header_template( '<%- left_text %>' ),
			) )

			/**
			 * Slider Section
			 */
			->add_fields( 'slider-section', __( 'Slider Section', 'crb' ), array(
				Field::make( 'text', 'title', __( 'Title', 'crb' ) ),
				Field::make( 'complex', 'slides', __( 'Slides', 'crb' ) )
					->set_layout( 'tabbed-horizontal' )
					->add_fields( array(
						Field::make( 'image', 'image', 'Image'),
						Field::make( 'textarea', 'text', 'Text' ),
						Field::make( 'text', 'author', 'Author' ),
					) ),
			) )
	) );