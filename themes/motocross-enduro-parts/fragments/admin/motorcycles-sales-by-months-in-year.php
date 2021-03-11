<?php 
// If year is not set get the current one
if ( empty( $year ) ) {
	$year = current_time('Y');
}

$motorcycles_sales_by_months_in_year = crb_get_motorcycles_sales_by_months_in_year( $year );
$months_bg = crb_get_months_bg();
$total_sales_by_months = array_fill_keys( $months_bg, 0 );
?>

<div class="table-parts table-parts--alt">
	<table>
		<thead>
			<tr>
				<th>Мотор</th>
					
				<?php foreach ( $months_bg as $month ) : ?>
					<th><?php echo $month ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		
		<?php if ( !empty( $motorcycles_sales_by_months_in_year ) ) : ?>
			<tbody>
				<?php foreach ( $motorcycles_sales_by_months_in_year as $motorcycle ) : ?>
					<tr>
						<td>
							<a href="<?php echo $motorcycle['permalink'] ?>" target="_blank"><?php echo esc_html( $motorcycle['title'] ) ?></a>
						</td>

						<?php foreach ( $motorcycle['months'] as $month => $sales ) :
							$total_sales_by_months[$month] += $sales; ?>

							<td>
								<?php echo $sales . 'лв'; ?>
							</td>
						<?php endforeach ?>
					</tr>
				<?php endforeach; ?>

				<tr>
					<td>
						<strong>Общо за всички мотори</strong>
					</td>
					
					<?php foreach ( $total_sales_by_months as $month => $sales ) : ?>
						<td>
							<strong><?php echo $sales . 'лв'; ?></strong>
						</td>
					<?php endforeach; ?>
				</tr>
			</tbody>
		<?php endif; ?>
	</table>
</div><!-- /.table -->