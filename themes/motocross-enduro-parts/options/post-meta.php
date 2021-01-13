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
			 * Slider Testimonials
			 */
			->add_fields( 'slider-testimonials', __( 'Slider Testimonials', 'crb' ), array(
				Field::make( 'text', 'title', __( 'Title', 'crb' ) ),
				Field::make( 'complex', 'slides', __( 'Slides', 'crb' ) )
					->set_layout( 'tabbed-horizontal' )
					->add_fields( array(
						Field::make( 'image', 'image', 'Image'),
						Field::make( 'textarea', 'text', 'Text' ),
						Field::make( 'text', 'author', 'Author' ),
					) ),
			) )

			/**
			 * Slider Promo Products
			 */
			->add_fields( 'slider-promo-products', __( 'Slider Promo Products', 'crb' ), array(
				Field::make( 'text', 'title', __( 'Title', 'crb' ) ),
				Field::make( 'text', 'btn_text', __( 'Button Text', 'crb' ) )
					->set_width( 40 ),
				Field::make( 'text', 'btn_url', __( 'Button Url', 'crb' ) )
					->set_width( 40 ),
				Field::make( 'checkbox', 'btn_target', __( 'Open Button In New Tab', 'crb' ) )
					->set_width( 20 ),
			) )

			->add_fields( 'cta-section', __( 'Call To Action Section', 'crb' ), array(
				Field::make( 'image', 'background_image', __( 'Background Image', 'crb' ) ),
				Field::make( 'textarea', 'text', __( 'Text', 'crb' ) ),
				Field::make( 'text', 'btn_text', __( 'Button Text', 'crb' ) )
					->set_width( 40 ),
				Field::make( 'text', 'btn_url', __( 'Button Url', 'crb' ) )
					->set_width( 40 ),
				Field::make( 'checkbox', 'btn_target', __( 'Open Button In New Tab', 'crb' ) )
					->set_width( 20 ),
			) )
	) );

Container::make( 'post_meta', __( 'Заглавие на продукт', 'crb' ) )
	->show_on_post_type( 'product' )
	->add_fields( array(
		Field::make( 'text', 'crb_part_name', __( 'Име на част', 'crb' ) ),
	) );
