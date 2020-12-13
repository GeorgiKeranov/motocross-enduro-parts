			</div><!-- /.woocommerce__shop -->
			
			<?php $sidebar_id = 'woocommerce-sidebar';

			if ( is_active_sidebar( $sidebar_id ) ) : ?>
				<div class="woocommerce__sidebar">
					<ul class="widgets">
						<?php dynamic_sidebar( $sidebar_id ); ?>
					</ul><!-- /.widgets -->
					
					<div class="woocommerce__sidebar-mobile-buttons">
						<button class="js-mobile-remove-all-filters">Изчисти Филтри</button>						

						<button class="js-mobile-filter"><?php _e( 'Search', 'woocommerce' ) ?></button>
					</div><!-- /.woocommerce__sidebar-mobile-buttons -->
				</div><!-- /.woocommerce__sidebar -->
			<?php endif; ?>

			</div><!-- /.woocommerce__columns -->
		</div><!-- /.shell -->
	</div><!-- /.woocommerce-columns -->
</div><!-- /.woocommerce-wrapper -->