<?php 
if ( empty( $pages_count ) || empty( $current_page ) ) {
	return;
}

for ( $page_counter = 1; $page_counter <= $pages_count; $page_counter++ ) :
	if ( $page_counter !== 1 && !empty( $pages_skip_to ) && $page_counter < $pages_skip_to ) {
		continue;
	}

	if ( $page_counter !== $pages_count && !empty( $pages_skip_from ) && $page_counter > $pages_skip_from ) {
		continue;
	}

	if ( $page_counter === $pages_count && !empty( $pages_skip_from ) ) : ?>
		<li>
			<span class="inactive">...</span>
		</li>
	<?php endif; ?>

	<li>
		<?php if ( $page_counter === $current_page ) : ?>
			<span class="current"><?php echo $current_page ?></span>
		<?php else : ?>
			<a href="<?php echo $page_counter ?>"><?php echo $page_counter ?></a>
		<?php endif ?>
	</li>

	<?php if ( $page_counter === 1 && !empty( $pages_skip_to ) ) : ?>
		<li>
			<span class="inactive">...</span>
		</li>
	<?php endif;
endfor;
