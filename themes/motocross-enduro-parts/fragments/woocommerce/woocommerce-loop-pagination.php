<?php
if ( empty( $pages_count ) ) {
	return;
}

if ( $pages_count === 1 ) {
	return;
}

$current_page = 1;

if ( isset( $_GET['page'] ) ) {
	$current_page = intval( $_GET['page'] );
}
?>

<nav class="woocommerce-pagination js-pagination-get-products-ajax">
	<ul class="page-numbers">
		<?php if ( $current_page !== 1 ) : ?>
			<li>
				<a class="prev" href="<?php echo $current_page - 1 ?>">←</a>
			</li>
		<?php endif;
		
		crb_print_pagination_pages( $pages_count, $current_page, 2 );

		if ( $current_page !== $pages_count ) : ?>
			<li>
				<a class="next" href="<?php echo $current_page + 1 ?>">→</a>
			</li>
		<?php endif; ?>
	</ul>
</nav>
