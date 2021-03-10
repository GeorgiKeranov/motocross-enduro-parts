<?php 
$motorcycles = crb_get_motorcycles( 'Избери мотор' );
$motorcycles_parts = new WP_Query( array(
	'post_type' => 'product',
	'posts_per_page' => -1,
) );
?>

<div class="wrap">
	<h1>Добави разглобени части към мотор</h1>
	
	<form>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="postbox">
						<?php if ( $motorcycles_parts->have_posts() ) : ?>
							<div class="table-parts">
								<table>
									<thead>
										<tr>
											<th>
												<input type="checkbox" class="check-uncheck-all">
											</th>

											<th>Име на част</th>

											<th>Часта е разглобена от мотор</th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach ( $motorcycles_parts->posts as $part ) :
											$part_id = $part->ID;
											$part_permalink = $part->guid;
											$part_title = $part->post_title;
											$motorcycle_title = '';

											$motorcycle_id = carbon_get_post_meta( $part_id, 'crb_part_disassembled_from_motorcycle' );
											if ( !empty( $motorcycle_id ) ) {
												$motorcycle_post = get_post( $motorcycle_id );

												if ( !empty( $motorcycle_post ) ) {
													$motorcycle_title = $motorcycle_post->post_title;
												}
											}
											?>

											<tr>
												<td>
													<input type="checkbox" name="selected_parts[]" value="<?php echo $part_id ?>">
												</td>

												<td>
													<a href="<?php echo $part_permalink ?>" target="_blank"><?php echo esc_html( $part_title ) ?></a>
												</td>

												<td>
													<?php echo esc_html( $motorcycle_title ); ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div><!-- /.table -->
						<?php else: ?>
							<h2>Няма части в продуктите на сайта</h2>
						<?php endif; ?>
					</div><!-- /.postbox -->
				</div><!-- /#post-body-content -->

				<div id="postbox-container-1" class="postbox-container">
					<div id="submitdiv" class="postbox">
						<h3>Добави към мотор</h3>

						<div id="major-publishing-actions">
							<div class="motorcycle-select">
								<select name="motorcycle" id="motorcycle" required>
									<?php foreach ( $motorcycles as $value => $title ) : ?>
										<option value="<?php echo $value ?>"><?php echo esc_html( $title ) ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div id="publishing-action">
								<input type="submit" value="Запазване" name="publish" id="publish" class="button button-primary button-large">
							</div>

							<div class="clear"></div>
						</div>
					</div>
				</div><!-- /#postbox-container-1.postbox-container -->
			</div><!-- /#post-body -->
		</div><!-- /#poststuff -->
	</form>
</div><!-- /.wrap -->

<style type="text/css" media="screen">
	#major-publishing-actions { background: #fff; }

	.motorcycle-select select { width: 100%; margin-bottom: 15px; }

	.postbox { padding: 12px; }

	.table-parts table { table-layout: fixed; border-collapse: collapse; width: 100%; text-align: left; font-size: 15px; }

	.table-parts tbody tr:first-child td { padding-top: 6px; }

	.table-parts td { padding: 4px 0 4px; margin: 0; }

	.table-parts th { padding: 6px 0 6px; font-weight: 500; border-bottom: 1px solid #c3c4c7; margin-bottom: 5px; }

	.table-parts th:first-child,
	.table-parts td:first-child { width: 25px; }

	.table-parts th:nth-child(2),
	.table-parts td:nth-child(2) { width: 75%; }

	.table-parts a { text-decoration: none; transition: .5s; line-height: 1.2; }
	.table-parts a:hover { opacity: .5; }

	.table-parts tbody .checkbox-selected td { background-color: #c4ddff; }
</style>

<script type="text/javascript">
	(function() {
		let $checkboxes = jQuery('.table-parts tbody input[name="selected_parts[]"]');

		if (!$checkboxes.length) {
			return;
		}

		$checkboxes.on('change', function() {
			let $this = jQuery(this);
			let $tableRow = $this.closest('tr');

			let isChecked = $this.is(':checked');

			if (isChecked) {
				$tableRow.addClass('checkbox-selected');
				return;
			}

			$tableRow.removeClass('checkbox-selected');
		});

		let lastClickedCheckbox = false;
		$checkboxes.on('click', function(e) {
			let $this = jQuery(this);
			let isChecked = $this.is(':checked');
			let isShiftKeyClicked = e.shiftKey;

			if (lastClickedCheckbox && isShiftKeyClicked)  {
				let thisCheckboxIndex = $checkboxes.index($this);
				let lastClickedCheckboxIndex = $checkboxes.index(lastClickedCheckbox);

				let firstCheckboxIndex = Math.min(thisCheckboxIndex, lastClickedCheckboxIndex);
				let lastCheckboxIndex = Math.max(thisCheckboxIndex, lastClickedCheckboxIndex) + 1;

				let checkCheckboxes = lastClickedCheckbox.is(':checked');
				
				let $checkboxesForChange = $checkboxes.slice(firstCheckboxIndex, lastCheckboxIndex);
				
				$checkboxesForChange.prop('checked', checkCheckboxes).change();
			}

			lastClickedCheckbox = $this;
		});

		jQuery('.check-uncheck-all').on('click', function() {
			let $this = jQuery(this);

			let isChecked = $this.is(':checked');

			$checkboxes.prop('checked', isChecked).change();
		});
	})();
</script>
