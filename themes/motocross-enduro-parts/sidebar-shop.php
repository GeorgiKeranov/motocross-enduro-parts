			<?php $sidebar_id = 'woocommerce-sidebar';

			if ( is_active_sidebar( $sidebar_id ) ) : ?>
				<div class="woocommerce__sidebar">
					<ul class="widgets">
						<?php dynamic_sidebar( $sidebar_id ); ?>
					</ul><!-- /.widgets -->
				</div><!-- /.woocommerce__sidebar -->
			<?php endif; ?>

			</div><!-- /.woocommerce__columns -->
		</div><!-- /.shell -->
	</div><!-- /.woocommerce-columns -->
</div><!-- /.woocommerce-wrapper -->