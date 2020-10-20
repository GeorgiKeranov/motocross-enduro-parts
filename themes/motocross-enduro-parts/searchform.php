<form action="<?php echo home_url( '/' ); ?>" class="search-form" method="get" role="search">
	<label>
		<span class="screen-reader-text"><?php _e( 'Search for:', 'crb' ); ?></span>

		<input type="text" title="<?php esc_attr_e( 'Search for:', 'crb' ); ?>" name="s" value="" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'crb' ); ?>" class="search__field" />
	</label>

	<button type="submit" class="search__btn screen-reader-text">
		<?php echo esc_attr( __( 'Search', 'crb' ) ); ?>
	</button>
</form>
