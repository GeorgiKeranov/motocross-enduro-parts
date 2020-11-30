<?php
define( 'CRB_THEME_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );

# Enqueue JS and CSS assets on the front-end
add_action( 'wp_enqueue_scripts', 'crb_enqueue_assets' );
function crb_enqueue_assets() {
	$template_dir = get_template_directory_uri();

	# Enqueue Custom JS files
	wp_enqueue_script(
		'theme-js-bundle',
		$template_dir . crb_assets_bundle( 'js/bundle.js' ),
		array( 'jquery' ), // deps
		null, // version -- this is handled by the bundle manifest
		true // in footer
	);

	# Enqueue Custom CSS files
	wp_enqueue_style(
		'theme-css-bundle',
		$template_dir . crb_assets_bundle( 'css/bundle.css' )
	);

	# The theme style.css file may contain overrides for the bundled styles
	wp_enqueue_style( 'theme-styles', $template_dir . '/style.css' );

	# Enqueue Comments JS file
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

# Attach Custom Post Types and Custom Taxonomies
add_action( 'init', 'crb_attach_post_types_and_taxonomies', 0 );
function crb_attach_post_types_and_taxonomies() {
	# Attach Custom Post Types
	include_once( CRB_THEME_DIR . 'options/post-types.php' );

	# Attach Custom Taxonomies
	include_once( CRB_THEME_DIR . 'options/taxonomies.php' );
}

add_action( 'after_setup_theme', 'crb_setup_theme' );

# To override theme setup process in a child theme, add your own crb_setup_theme() to your child theme's
# functions.php file.
if ( ! function_exists( 'crb_setup_theme' ) ) {
	function crb_setup_theme() {
		# Make this theme available for translation.
		load_theme_textdomain( 'crb', get_template_directory() . '/languages' );

		# Autoload dependencies
		$autoload_dir = CRB_THEME_DIR . 'vendor/autoload.php';
		if ( ! is_readable( $autoload_dir ) ) {
			wp_die( __( 'Please, run <code>composer install</code> to download and install the theme dependencies.', 'crb' ) );
		}
		include_once( $autoload_dir );
		\Carbon_Fields\Carbon_Fields::boot();

		# Add Actions
		add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
		add_action( 'widgets_init', 'crb_register_custom_sidebars' );

		# Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'gallery' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		# Manually select Post Formats to be supported - http://codex.wordpress.org/Post_Formats
		// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

		# Register Theme Menu Locations
		register_nav_menus( array(
			'header-menu' => __( 'Header Menu', 'crb' ),
		) );

		# Add Image Sizes
		add_image_size( 'full-width', 1920 );

		# Add functionality for compatible motorcycles
		include_once( CRB_THEME_DIR . 'compatible-motorcycles/functionality.php' );

		# Register custom widgets
		include_once( CRB_THEME_DIR . 'options/widgets.php' );

		# Include woocommerce settings
		include_once( CRB_THEME_DIR . 'woocommerce/woocommerce-config.php' );

		# Attach custom shortcodes
		include_once( CRB_THEME_DIR . 'options/shortcodes.php' );

		# Add Filters
		add_filter( 'excerpt_more', 'crb_excerpt_more' );
		add_filter( 'excerpt_length', 'crb_excerpt_length', 999 );
		add_filter( 'crb_theme_favicon_uri', function() {
			return get_template_directory_uri() . '/dist/images/favicon.ico';
		} );
	}
}

/**
 * Add custom sidebars.
 */
function crb_register_custom_sidebars() {
	# WooCommerce Sidebar
	register_sidebar( array(
		'name'          => __( 'WooCommerce Sidebar', 'crb' ),
		'id'            => 'woocommerce-sidebar',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}


function crb_attach_theme_options() {
	include_once(CRB_THEME_DIR . 'options/theme-options.php');
	include_once(CRB_THEME_DIR . 'options/post-meta.php');
	include_once(CRB_THEME_DIR . 'options/motorcycle-types.php');
}

function crb_excerpt_more() {
	return '...';
}

function crb_excerpt_length() {
	return 55;
}

/**
 * Get the path to a versioned bundle relative to the theme directory.
 *
 * @param  string $path
 * @return string
 */
function crb_assets_bundle( $path ) {
	static $manifest = null;

	if ( is_null( $manifest ) ) {
		$manifest_path = CRB_THEME_DIR . 'dist/manifest.json';

		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );
		} else {
			$manifest = array();
		}
	}

	$path = isset( $manifest[ $path ] ) ? $manifest[ $path ] : $path;

	return '/dist/' . $path;
}

add_action( 'init', 'crb_remove_schedule_delete' );
function crb_remove_schedule_delete() {
  remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
}

/**
 * Change the title of the product based on part name and compatible motorcycles
 */
add_action( 'save_post', 'crb_set_custom_product_title', 20, 3 );
function crb_set_custom_product_title( $post_id, $post, $update ) {
	// Do this function only on the products from woocommerce
	if ( $post->post_type != 'product' ) {
		return;
	}

	$part_name = '';
	if ( isset( $_POST['carbon_fields_compact_input'] ) && !empty( $_POST['carbon_fields_compact_input']['_crb_part_name'] ) ) {
		$part_name = $_POST['carbon_fields_compact_input']['_crb_part_name'];
	}

	$compatible_motorcycles = array();

	// Add the new compatible motorcycles
	if ( !empty( $_POST['new_compatible_motorcycles'] ) ) {
		 $compatible_motorcycles = $_POST['new_compatible_motorcycles'];
	}

	// Add existing compatible motorcycles
	if ( !empty( $_POST['existing_compatible_motorcycles'] ) ) {
		$compatible_motorcycles = array_merge($compatible_motorcycles, $_POST['existing_compatible_motorcycles']);
	}

	$product_title = $part_name;
	$compatible_motorcycles_excerpt = crb_get_compatible_motorcycles_excerpt( $compatible_motorcycles );

	if ( !empty( $product_title ) && !empty( $compatible_motorcycles_excerpt ) ) {
		$product_title .= ' ';
	}
	
	$product_title .= $compatible_motorcycles_excerpt;

	if ( empty( $product_title ) ) {
		return;
	}

	wp_update_post( array(
		'ID'         => $post_id,
		'post_title' => $product_title
	) );
}
