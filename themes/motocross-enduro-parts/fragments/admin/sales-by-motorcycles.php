<div class="wrap">
	<h1>Продажби от мотори</h1>
	
	<div id="poststuff">
		<div id="post-body" class="metabox-holder">
			<div id="post-body-content">
				<div class="postbox">
					<div class="table-parts">
						<table>
							<thead>
								<tr>
									<th>Мотор</th>

									<th>Общо продажби за целият период</th>

									<th>Общо оставащи части за продажба</th>
								</tr>
							</thead>
							
							<?php
							$total_sales_and_future_sales_by_motorcycle = crb_get_total_sales_and_future_sales_by_motorcycles();

							if ( !empty( $total_sales_and_future_sales_by_motorcycle ) ) :
								$total_sales_all_motorcycles = 0;
								$total_future_sales_all_motorcycles = 0;
								?>

								<tbody>
									<?php foreach ( $total_sales_and_future_sales_by_motorcycle as $motorcycle_id => $motorcycle_data ) :
										$total_sales_all_motorcycles += $motorcycle_data['total_sales'];
										$total_future_sales_all_motorcycles += $motorcycle_data['total_future_sales'];
										?>
										
										<tr>
											<td>
												<a href="<?php echo $motorcycle_data['permalink'] ?>" target="_blank"><?php echo esc_html( $motorcycle_data['title'] ) ?></a>
											</td>

											<td>
												<?php echo $motorcycle_data['total_sales'] . 'лв'; ?>
											</td>

											<td>
												<?php echo $motorcycle_data['total_future_sales'] . 'лв'; ?>
											</td>
										</tr>
									<?php endforeach; ?>

									<tr>
										<td>
											<strong>Общо за всички мотори</strong>
										</td>

										<td>
											<strong><?php echo $total_sales_all_motorcycles . 'лв'; ?></strong>
										</td>

										<td>
											<strong><?php echo $total_future_sales_all_motorcycles . 'лв'; ?></strong>
										</td>
									</tr>
								</tbody>
							<?php endif; ?>
						</table>
					</div><!-- /.table -->
				</div><!-- /.postbox -->
			</div><!-- /#post-body-content -->
		</div><!-- /#post-body.metabox-holder -->
	</div><!-- /#poststuff -->

	<?php
	$current_year = current_time('Y');
	$years_with_orders = crb_get_years_with_orders();

	if ( !empty( $years_with_orders ) ) : ?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h2>Продажби по месеци на избрана година</h2>

						<div class="choose-year">
							<label for="year-sales">Избери година</label>

							<select name="year-sales" id="year-sales" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ) ?>">
								<?php foreach ( $years_with_orders as $year ) : ?>
									<option value="<?php echo $year ?>"<?php echo $year == $current_year ? ' selected' : '' ?>><?php echo $year ?></option>
								<?php endforeach ?>
							</select>
						</div><!-- /.choose-year -->

						<div class="ajax-image">
							<img src="<?php bloginfo('stylesheet_directory'); ?>/resources/images/ajax-loader.gif">
						</div><!-- /.ajax-image -->

						<?php crb_render_fragment( 'admin/motorcycles-sales-by-months-in-year' ); ?>
					</div><!-- /.postbox -->
				</div><!-- /#post-body-content -->
			</div><!-- /#post-body.metabox-holder -->
		</div><!-- /#poststuff -->
	<?php endif; ?>
</div><!-- /.wrap -->

<style type="text/css" media="screen">
	#poststuff h2 { padding: 0; margin-bottom: 15px; font-size: 20px; }

	.postbox { padding: 12px; }

	.table-parts table { table-layout: fixed; border-collapse: collapse; width: 100%; text-align: left; font-size: 15px; }

	.table-parts td { padding: 8px 0; margin: 0; }

	.table-parts th { padding: 8px 0; font-weight: 500; border-bottom: 1px solid #c3c4c7; margin-bottom: 5px; }

	.table-parts a { text-decoration: none; transition: .5s; line-height: 1.2; }
	.table-parts a:hover { opacity: .5; }

	.table-parts tbody .checkbox-selected td { background-color: #c4ddff; }

	.table-parts--alt { margin-top: 15px; }

	.table-parts--alt th:first-child,
	.table-parts--alt td:first-child { width: 15%; }

	.choose-year label { font-size: 19px; margin-right: 10px; }

	.ajax-image { text-align: center; display: none; }

	.ajax-image--loading { display: block; }
</style>

<script type="text/javascript">
	(function() {
		jQuery('.choose-year select').on('change', function(){
			let $this = jQuery(this);
			let $tableParts = jQuery('.table-parts--alt');
			let $ajaxImage = jQuery('.ajax-image');

			$this.attr('disabled', 'disabled');
			$tableParts.empty();			
			$ajaxImage.addClass('ajax-image--loading');

			let url = $this.data('ajax-url');
			let year = $this.val();

			jQuery.ajax({
				type: 'GET',
				url: url,
				data: {
					action: 'get_motorcycle_sales_by_months_in_year',
					year: year
				},
				success: function(result) {
					if (result['success']) {
						let responseHtml = jQuery(result['data']).html();

						$this.removeAttr('disabled');
						$ajaxImage.removeClass('ajax-image--loading');
						$tableParts.append(responseHtml);
					}
				},
				error: function(msg) {
					$this.removeAttr('disabled');
					$ajaxImage.removeClass('ajax-image--loading');

					console.log(msg);
				}
			});
		});
	})();
</script>