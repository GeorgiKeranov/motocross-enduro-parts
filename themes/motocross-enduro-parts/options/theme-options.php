<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

Container::make( 'theme_options', __( 'Theme Options', 'crb' ) )
	->set_page_file( 'crbn-theme-options.php' )
	->add_tab( __( 'Footer', 'crb' ), array(
		Field::make( 'rich_text', 'crb_footer_text', __( 'Text', 'crb' ) ),
		Field::make( 'text', 'crb_footer_phone', __( 'Phone Number', 'crb' ) ),
		Field::make( 'text', 'crb_footer_email', __( 'Email', 'crb' ) ),
		Field::make( 'text', 'crb_footer_copyright', __( 'Copyright', 'crb' ) ),
	) );
