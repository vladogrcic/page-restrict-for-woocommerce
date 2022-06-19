<?php

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
?>
<style>
	table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	td,
	th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #dddddd;
	}
</style>
<div class="">
	<h3><?php esc_html_e('Check users page expiration by time', 'page_restrict_domain'); ?></h3>
	<hr style="margin-bottom: 25px; border: 2px solid grey;">
	<div class="users-inline pages-list"><?php
		if (empty($page_users_paginated_time)) {
			echo '<b>' . esc_html__("There aren't any users that bought any products needed to access restricted pages.", 'page_restrict_domain') . '</b>';
		}
		if($page_users_paginated_time)
			foreach ($page_users_paginated_time as $page_num => $user_data) :
				if ($page_num === 0) {
					$page_display_style = 'display: block;';
				} else {
					$page_display_style = 'display: none;';
				} ?>
				<div id="page_time_<?php echo $page_num + 1; ?>" class="page-pagination" data-pagination-page="<?php echo $page_num + 1; ?>" style="<?php echo $page_display_style; ?>"><?php
					foreach ($user_data as $post_id => $value) : ?>
						<div class="locked-pages">
							<div class="page-boxes time">
								<div>
									<h3><?php esc_html_e('Post ID', 'page_restrict_domain'); ?></h3>
									<span><?php echo $locked_posts[$post_id]['post']->ID; ?></span>
								</div>
								<div>
									<h3><?php esc_html_e('Post Title', 'page_restrict_domain'); ?></h3>
									<span><?php echo $locked_posts[$post_id]['post']->post_title; ?></span>
								</div>
								<div>
									<h3><?php esc_html_e('Post Slug', 'page_restrict_domain'); ?></h3>
									<span><?php echo $locked_posts[$post_id]['post']->post_name; ?></span>
								</div><?php
								if (isset($locked_posts[$post_id]['time'])) : ?>
									<div>
										<h3><?php esc_html_e('Expiration Time', 'page_restrict_domain'); ?></h3>
										<span><?php echo $locked_posts[$post_id]['time']['days']; ?> days</span>
										<span><?php echo $locked_posts[$post_id]['time']['hours']; ?> h</span><br>
										<span><?php echo $locked_posts[$post_id]['time']['minutes']; ?> min</span>
										<span><?php echo $locked_posts[$post_id]['time']['seconds']; ?> sec</span>
									</div><?php
								endif;	 ?>
								<div>
									<div class="edit"><?php
										echo '<a href="' . get_post_permalink($locked_posts[$post_id]['post']->ID) . '">' . esc_html__("View", "page_restrict_domain") . '</a>';
										echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $locked_posts[$post_id]['post']->ID . '&action=edit">' . esc_html__("Edit", "page_restrict_domain") . '</a>'; ?>
									</div>
								</div>
							</div>
							<div class="user-boxes"><?php
								foreach ($value as $user_id => $vars) :
									$restrict_by = $vars['restrict_by'];
									if($restrict_by === 'product'){
										$expiration = 1;
									}
									else{
										$expiration = $vars['time_compare'] - $vars['time_elapsed'];
									}
									$products_by_user = $purchased_products_by_user[$post_id][$user_id]['purchased_products']; ?>
									<div class="inline-boxes <?php echo $expiration <= 0 ? 'red-palette expired' : 'valid'; ?>">
										<div>
											<h3><?php esc_html_e('Orders', 'page_restrict_domain'); ?> <span class="pos-right"><?php esc_html_e('Products', 'page_restrict_domain'); ?></span></h3><?php
											for ($m = 0; $m < count($products_by_user); $m++) :
												$product_order_data = $products_by_user[$m];
												$order_id = $product_order_data['order_id'];
												$prod_id = $product_order_data['product']['product_id'];

												$date_format = get_option('date_format');
												$time_format = get_option('time_format');
												$format = $date_format . ' ' . $time_format;

												$product = wc_get_product($prod_id);
												$product_data = $product->get_data();
												$order_edit_page = get_edit_post_link($order_id);
												$prod_edit_page = get_edit_post_link((int)$prod_id, 'product');

												$order_data = $product_order_data; ?>
												<div class="id-data padded-text">
													<span class="pos-left">
														<a href="<?php echo $order_edit_page; ?>">
															<div class="tooltip">
																<?php echo $order_id; ?>
																<span class="tooltiptext">
																	<table>
																		<thead>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Status:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Payment Method Title:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Created Via:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Discount Total:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Shipping Total:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Total:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Date Created:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Date Completed:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Date Paid:', 'page_restrict_domain'); ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td><?php echo ucfirst($order_data['status']); ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $order_data['payment_method_title']?$order_data['payment_method_title']:'&nbsp;'; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo ucfirst($order_data['created_via']); ?></td>
																			</tr>
																			<tr>
																				<td><?php echo (float)$order_data['discount_total']; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo (float)$order_data['shipping_total']; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo (float)$order_data['total']; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $order_data['date_created']->date($format); ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $order_data['date_completed']->date($format); ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $order_data['date_paid']->date($format); ?></td>
																			</tr>
																		</tbody>
																	</table>
																</span>
															</div>
														</a>
													</span>
													<span class="pos-right">
														<a href="<?php echo $prod_edit_page; ?>">
															<div class="tooltip">
																<?php echo $prod_id; ?>
																<span class="tooltiptext">
																	<b><?php esc_html_e('Name:', 'page_restrict_domain'); ?> </b></br><?php echo $product_data['name']; ?></br>
																	<b><?php esc_html_e('Slug:', 'page_restrict_domain'); ?> </b></br><?php echo $product_data['slug']; ?></br>
																	<b><?php esc_html_e('Short Description:', 'page_restrict_domain'); ?> </b></br><?php echo $product_data['short_description']; ?></br>
																	<table>
																		<thead>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Date Created:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Total Sales:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Stock Status:', 'page_restrict_domain'); ?></th>
																			</tr>

																			<tr>
																				<th colspan="3"><?php esc_html_e('Virtual:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Downloadable:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Price:', 'page_restrict_domain'); ?></th>
																			</tr>

																			<tr>
																				<th colspan="3"><?php esc_html_e('Regular Price:', 'page_restrict_domain'); ?></th>
																			</tr>
																			<tr>
																				<th colspan="3"><?php esc_html_e('Sale Price:', 'page_restrict_domain'); ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td><?php echo $product_data['date_created']->date($format); ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $product_data['total_sales']; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo ucfirst($product_data['stock_status']); ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $product_data['virtual']?'Yes':'No'; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo $product_data['downloadable']?'Yes':'No'; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo (float)$product_data['price']; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo (float)$product_data['regular_price']; ?></td>
																			</tr>
																			<tr>
																				<td><?php echo (float)$product_data['sale_price']; ?></td>
																			</tr>
																		</tbody>
																	</table>
																</span>
															</div>
														</a>
													</span>
												</div><?php
											endfor; ?>
										</div>
										<div>
											<h3><?php esc_html_e('Username', 'page_restrict_domain'); ?></h3>
											<div class="padded-text">
												<span><?php echo $vars['user']->user_login; ?><a class="edit-link" href="<?php echo get_edit_user_link($vars['user']->ID); ?>">Edit</a></span>
											</div>
										</div>
										<div>
											<h3><?php esc_html_e('Email', 'page_restrict_domain'); ?></h3>
											<div class="padded-text">
												<span><?php echo $vars['user']->user_email; ?></span>
											</div>
										</div>
										<?php if ($restrict_by === 'time') : ?>
											<div style="background-color: <?php echo $expiration <= 0 ? '#BB4F4D' : ''; ?>;">
												<h3><?php echo $expiration <= 0 ? 'Expired' : 'Expires'; ?></h3>
												<div class="padded-text">
													<span><?php echo $helpers->seconds_to_dhms($expiration, '%a days, %h h<br>%i min and %s sec'); ?></span>
												</div>
											</div>
											<div style="background-color: <?php echo $expiration <= 0 ? '#BB4F4D' : ''; ?>;">
												<h3><?php esc_html_e('Date and Time of Expiration', 'page_restrict_domain'); ?></h3>
												<div class="padded-text">
													<span><?php echo date($date_format . " " . $time_format, $expiration + time()); ?></span>
												</div>
											</div>
										<?php endif; ?>
									</div><?php
								endforeach; ?>
							</div>
						</div><?php
					endforeach; ?>
				</div><?php
			endforeach; ?>
		<div class="pagination">
			<ul>
				<?php
				for ($s = 0; $s < $totalPages_time; $s++) :
					$page_class = '';
					if ($s === 0) {
						$page_class = 'active';
					} else {
						$page_class = '';
					} ?>
					<li class="<?php echo $page_class; ?>" data-pagination-page="<?php echo $s + 1; ?>">
						<?php
						echo $s + 1;
						?>
					</li>
				<?php
				endfor;
				?>
			</ul>
		</div>
	</div>
</div>