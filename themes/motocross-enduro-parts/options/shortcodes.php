<?php

/**
 * Returns current year
 *
 * @uses [year]
 */
add_shortcode( 'year', 'crb_shortcode_year' );
function crb_shortcode_year() {
	return date( 'Y' );
}

/**
 * Example Shortcode
 */
/*add_shortcode( 'example', 'crb_shortcode_example' );
function crb_shortcode_example( $atts, $content ) {
	$atts = shortcode_atts(
		array(
			'example_attribute' => 'example_value',
		),
		$atts, 'example'
	);

	ob_start();
	?>
	<div class="shortcode-">
		<!-- -->
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}*/
