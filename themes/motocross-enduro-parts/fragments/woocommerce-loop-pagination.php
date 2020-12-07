<?php
if ( empty( $pages_count ) ) {
	return;
}

if ( $pages_count === 1 ) {
	return;
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
		<!-- TODO show prev page button if current page is not the first page -->
		<li>
			<a class="prev page-numbers" href="">←</a>
		</li>

		<?php for ( $page_counter = 1; $page_counter <= $pages_count; $page_counter++ ) : ?>
			<li>
				<!-- TODO check if we are on the current page_counter page -->
				<!-- <span class="page-numbers current"></span> -->

				<a class="page-numbers" href="<?php echo $page_counter ?>"><?php echo $page_counter ?></a>
			</li>
		<?php endfor; ?>

		<!-- TODO show next page button if current page is not the last page -->
		<li>
			<a class="next page-numbers" href="">→</a>
		</li>
	</ul>
</nav>
