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

// TODO show max 5 pages with one first and one last pages:
// Example -> [1] 2 3 {4} 5 6 [7]
// If pages are more than 7 add [...] before first or last or both pages
// Example -> [1] [...] 6 7 {8} 9 10 [...] [15]
// Example -> [1] 2 {3} 4 5 6 [...] [15]
// Example -> [1] [...] 6 7 {8} 9 10 [11]
?>

<nav class="woocommerce-pagination">
	<ul class="page-numbers">
		<?php if ( $current_page !== 1 ) : ?>
			<li>
				<a class="prev page-numbers" href="<?php echo $current_page - 1 ?>">←</a>
			</li>
		<?php endif; ?>

		<?php for ( $page_counter = 1; $page_counter <= $pages_count; $page_counter++ ) : ?>
			<li>
				<?php if ( $page_counter === $current_page ) : ?>
					<span class="page-numbers current"><?php echo $current_page ?></span>
				<?php else : ?>
					<a class="page-numbers" href="<?php echo $page_counter ?>"><?php echo $page_counter ?></a>
				<?php endif ?>
			</li>
		<?php endfor; ?>

		<?php if ( $current_page !== $pages_count ) : ?>
			<li>
				<a class="next page-numbers" href="<?php echo $current_page + 1 ?>">→</a>
			</li>
		<?php endif; ?>
	</ul>
</nav>
