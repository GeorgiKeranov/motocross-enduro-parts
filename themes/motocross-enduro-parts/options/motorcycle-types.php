<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

Container::make( 'theme_options', __( 'Типове Мотори', 'crb' ) )
	->set_page_file( 'motorcycle-types.php' )
	->add_fields( array(
		Field::make( 'complex', 'crb_motorcycle_types', __( 'Типове Мотори', 'crb' ) )
			->set_layout( 'tabbed-vertical' )
			->add_fields( array(
				Field::make( 'text', 'make', __( 'Марка', 'crb' ) ),
				Field::make( 'complex', 'motorcycle_models', __( 'Модели', 'crb' ) )
					->set_layout( 'tabbed-vertical' )
					->add_fields( array(
						Field::make( 'text', 'model', __( 'Модел', 'crb' ) ),
						Field::make( 'text', 'first_production_year', __( 'Първа година на производство', 'crb' ) )
							->set_width( 50 ),
						Field::make( 'text', 'last_production_year', __( 'Последна година на производство', 'crb' ) )
							->set_width( 50 ),
					) )
					->set_header_template( '<%- model %>' ),
			) )
			->set_header_template( '<%- make %>' ),
	) );
