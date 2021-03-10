<?php 
$total_sales_by_motorcycle = crb_get_total_sales_by_motorcycles();
?>

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
								</tr>
							</thead>
							
							<?php if ( !empty( $total_sales_by_motorcycle ) ) :
								$total_sales_all_motorcycles = 0; ?>

								<tbody>
									<?php foreach ( $total_sales_by_motorcycle as $motorcycle_id => $motorcycle_data ) :
										$total_sales_all_motorcycles += $motorcycle_data['total_sales']; ?>
										
										<tr>
											<td>
												<a href="<?php echo $motorcycle_data['permalink'] ?>" target="_blank"><?php echo esc_html( $motorcycle_data['title'] ) ?></a>
											</td>

											<td>
												<?php echo esc_html( $motorcycle_data['total_sales'] ) . 'лв'; ?>
											</td>
										</tr>
									<?php endforeach; ?>

									<tr>
										<td>
											<strong>Общо за всички мотори</strong>
										</td>

										<td>
											<?php echo $total_sales_all_motorcycles . 'лв'; ?>
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
</div><!-- /.wrap -->

<style type="text/css" media="screen">
	.postbox { padding: 12px; }

	.table-parts table { table-layout: fixed; border-collapse: collapse; width: 100%; text-align: left; font-size: 15px; }

	.table-parts tbody tr:first-child td { padding-top: 6px; }

	.table-parts td { padding: 4px 0 4px; margin: 0; }

	.table-parts th { padding: 6px 0 6px; font-weight: 500; border-bottom: 1px solid #c3c4c7; margin-bottom: 5px; }

	.table-parts a { text-decoration: none; transition: .5s; line-height: 1.2; }
	.table-parts a:hover { opacity: .5; }

	.table-parts tbody .checkbox-selected td { background-color: #c4ddff; }
</style>