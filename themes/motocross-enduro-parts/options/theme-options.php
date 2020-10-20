<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

Container::make( 'theme_options', __( 'Theme Options', 'crb' ) )
	->set_page_file( 'crbn-theme-options.php' )
	->add_fields( array(
		Field::make( 'separator', 'crb_separator', __( 'Fields', 'crb' ) )
	) );
