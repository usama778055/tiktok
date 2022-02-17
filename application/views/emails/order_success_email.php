<!DOCTYPE html>
<html lang="en">

<?php

function numberToRoman($number)
{
	$map = array('m' => 1000, 'cm' => 900, 'd' => 500, 'cd' => 400, 'c' => 100, 'xc' => 90, 'l' => 50, 'xl' => 40, 'x' => 10, 'ix' => 9, 'v' => 5, 'iv' => 4, 'i' => 1);
	$returnValue = '';
	while ($number > 0) {
		foreach ($map as $roman => $int) {
			if ($number >= $int) {
				$number -= $int;
				$returnValue .= $roman;
				break;
			}
		}
	}
	return $returnValue;
}

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="format-detection" content="telephone=no">
	<link href="https://fonts.googleapis.com/css2?family=Caveat&family=Montserrat:wght@200;300;400;500;600;700&family=Roboto&family=Source+Sans+Pro&display=swap" rel="stylesheet" />
	<title>Tiktoklikes</title>
	<style type="text/css">
		table td {
			/*border: 1px solid cyan;*/
		}

		body,
		table,
		td,
		a {
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
		}

		table,
		td {
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}

		img {
			-ms-interpolation-mode: bicubic;
		}

		img {
			border: 0;
			outline: none;
			text-decoration: none;
		}

		table {
			border-collapse: collapse !important;
		}

		body {
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
		}

		/* iOS BLUE LINKS */
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		.custom-table-container .table-responsive {
			overflow-x: scroll;
		}

		.custom-table-container .width {

			width: 640px;
		}

		/* MEDIA QUERIES */
		@media all and (max-width:639px) {
			.table-container {
				width: 100%;
			}

			.td-container {
				width: 50%;
				/* text-align: center; */
			}

			.center {
				text-align: center;
			}

			.table-responsive {
				overflow-x: scroll;
			}

			.table-width {
				width: 640px;
			}
		}

		@media all and (max-width:576px) {
			.footer {
				display: flex;
				flex-direction: column;
			}

			.footer td,
			.track-sec td {
				text-align: center;
				margin-top: 10px;
			}

			.footer .td-container,
			.track-sec .td-container,
			.services .td-container {
				width: 100%;
				/* text-align: center; */
			}

			.track-sec td a {
				margin: 20px auto;
			}

			.track-sec,
			.services tr {
				display: flex;
				flex-direction: column;
			}
		}
	</style>
</head>

<body style="margin: 0; padding: 0;background-color: #f2f2f2;">
	<center>
		<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
			<tbody>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" align="center">
						<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td valign="top" align="center"><img width="150" src="<?php echo base_url(); ?>assets/images/logo.png"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
			</tbody>
		</table>

		<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
			<tbody>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" align="center">
						<table class="table-container" width="600" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr class="track-sec">
									<td class="td-container" width="300" valign="middle" align="left">
										<?php $user_or_email = $emailData['user_name'] ?? $emailData['user_email'] ?>
										<p style="line-height: 1.4;margin:0;font-family:'Poppins',sans-serif;font-size:16px;color:#302E2E;padding-bottom:20px">
											Hi <a style="color: #FF7800;text-decoration: none;" href="mailto:<?= $user_or_email ?>">
												<?= $user_or_email ?></a>
											<br>Thank You For Your Purchase
										</p>
									</td>
									<td class="td-container" width="300" valign="top" align="right">
										<span><a style="color: #fff;
												    background-color: #FF003D;
												    text-decoration: none;
												    font-size: 20px;
												    font-family:'Poppins',sans-serif;
												    padding: 6px 18px;
												    margin-top: 10px;
												    display: block;
												    width: 120px;" href="<?php echo $emailData['trackOrderLink'] ?>" target="_blank">Track Order</a>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
			</tbody>
		</table>

		<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
			<tbody>
				<tr>
					<td valign="top" align="center">
						<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td class="td-container" width="300" valign="top" align="center"><img src="<?php echo base_url(); ?>assets/images/socialfollower.gif <?php // base_url('assets/images/socialfollower.gif') 
																																																																												?>"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" align="center">
						<table class="table-container" width="350" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr bgcolor="#E5E5E5">
									<td class="td-container" width="150" valign="middle" align="left" style="padding: 10px 0;">
										<p style="color: #FF7800;font-family:'Poppins',sans-serif;font-size:18px;margin: 0;padding-left: 16px;">Order Date:</p>
									</td>
									<td class="td-container" width="200" valign="middle" align="left" style="padding: 10px 0;">
										<p style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;margin: 0;"><?php echo date("j F Y"); //$emailData['order_date']
																																																					?></p>
									</td>
								</tr>
								<tr>
									<td style="font-size:1px;line-height:4px" height="4">&nbsp;</td>
								</tr>
								<tr bgcolor="#E5E5E5">
									<td class="td-container" width="150" valign="middle" align="left" style="padding: 10px 0;">
										<p style="color: #FF7800;font-family:'Poppins',sans-serif;font-size:18px;margin: 0;padding-left: 16px;">Order ID:</p>
									</td>
									<td class="td-container" width="200" valign="middle" align="left" style="padding: 10px 0;">
										<p style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;margin: 0;"><?php echo $emailData['orderId'] ?></p>
									</td>
								</tr>
								<tr>
									<td style="font-size:1px;line-height:4px" height="4">&nbsp;</td>
								</tr>
								<tr bgcolor="#E5E5E5">
									<td class="td-container" width="150" valign="middle" align="left" style="padding: 10px 0;">
										<p style="color: #FF7800;font-family:'Poppins',sans-serif;font-size:18px;margin: 0;padding-left: 16px;">Email ID:</p>
									</td>
									<td class="td-container" width="200" valign="middle" align="left" style="padding: 10px 0;">
										<p style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;margin: 0;"><?php echo $emailData['user_email'] ?></p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
			</tbody>
		</table>


		<div class="table-responsive">
			<div class="table-width">
				<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
					<tbody>
						<tr>
							<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" align="center">
								<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
									<thead>
										<tr bgcolor="#302E2E" style="color: #fff;font-family:'Poppins',sans-serif;font-size:16px;">
											<th class="td-container" width="170" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">Service</th>
											<th class="td-container" width="370" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">Posts/Profile URL</th>
											<th class="td-container" width="100" valign="middle" align="right" style="padding: 10px 20px 10px 0px;">Price</th>
									</thead>
									<tbody>
										<?php
										$details = $cartData['items'];
										foreach ($details as $detail) {
											$service = $detail['service_detail'];
											$serviceType = $service['serviceType'];
											$username = isset($detail['user_name']) ? $detail['user_name'] : "";
											$url = isset($detail['url']) ? $detail['url'] : "";
										?>
											<tr bgcolor="#E5E5E5" style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;border-bottom: 1px solid #302E2E;">
												<td class="td-container" width="170" valign="middle" align="left" style="padding: 10px;display: block;border-right: 1px solid #302E2E;">
													<?php echo $detail['service_detail']['packageQty'] . ' ' . $detail['service_detail']['packageTitle'];
													
													if (isset($detail['free_services']) && !empty($detail['free_services'])) {
														foreach ($detail['free_services'] as $free_service) { ?>
															<br>
															<span style="color:#ff005f;font-size: 12px;margin-left: 10px;">
																<?= '+ ' . $free_service['quantity'] . ' free ' . $free_service['title'] . ' on ' ?>
																<a style="color:#ff005f;" href="<?= $free_service['free_post_id'] ?>" target="_blank">
																	<strong>Link</strong>
																</a>
															</span>
													<?php }
													} ?>
												</td>
												<td class="td-container" width="370" valign="middle" align="left" style="padding: 10px;border-right: 1px solid #302E2E;">
													<?php if (!isset($detail['selected_posts'])) {
														if (strpos($detail['service_detail']['packageTitle'], 'Instagram') !== false) { ?>
															<a style="color: #FF003D;text-decoration: none;word-break: break-word;" href="<?php echo IG_URL . $username; ?>" target="_blank">
																<?php echo IG_URL . $username; ?>
															</a>
														<?php } else { ?>
															<a style="color: #FF003D;text-decoration: none;word-break: break-word;" href="<?php echo $url; ?>" target="_blank">
																<?php echo $url; ?>
															</a>
														<?php } ?>
													<?php
													} else if (isset($detail['selected_posts'])) { ?>
														<div class='selectedPost'>
															<?php
															$post_num = 1;
															foreach ($detail['selected_posts'] as $key => $selected_post) {
																$postId = isset($selected_post['post_id']) ? $selected_post['post_id'] : $key;
																$postLink = isset($selected_post['post_id']) ? $selected_post['post_id'] : $key;
																if (strpos($service['packageTitle'], 'Instagram') !== false) {
																	$post_link = IG_URL . 'p/' . $postId;
																} else if (strpos($service['packageTitle'], 'IGTV') !== false) {
																	$post_link = IG_URL . 'tv/' . $postId;
																} else {
																	$post_link = $postLink;
																}
															?>
																<div style="font-weight: 600;">
																	<?= $selected_post['quantity'] . ' ' . $serviceType . ' on ' ?>
																	<a href="<?= $post_link; ?>" style="color:#ff005f;" target="_blank">
																		Link
																	</a>
																</div>
																<?php
																$comments = $selected_post['post_comments'] ?? false;
																if ($comments == true) {
																	$comments = preg_split('/\r\n|\r|\n/', $comments);
																	foreach ($comments as $number => $comment) { ?>
																		<div class="comments" style="margin-left: 5px;">
																			<?php echo '<b>' . (numberToRoman($number + 1)) . '</b>' . '. ' . $comment; ?>
																		</div>
															<?php }
																}
															} ?>
														</div>
													<?php } ?>
												</td>
												<td class="td-container" width="100" valign="right" align="right" style="padding: 10px;font-weight: bold;">
													<?= $detail['priceUnit'] . $detail['amount_payable']; ?>
												</td>
											</tr>
										<?php } ?>
										<?php if (!empty($discount)) {
											$prcnt = (!empty($discount)) ? $discount['discount_percent'] : '';
											$offAmount = (!empty($discount)) ? $discount['discount_price'] : '';
											$discountedAmount = (!empty($discount)) ? $discount['discount_pkgprice'] : '';
											$totalPrice = (!empty($discount)) ? $discountedAmount : $totalPrice;
										?>
											<tr>
												<td class="td-container" width="170" valign="middle" align="left"></td>
												<td class="td-container" width="300" valign="middle" align="left"></td>
												<td class="td-container" width="170" valign="middle" align="right" style="padding: 16px 0;">
													<p style="font-family:'Poppins',sans-serif;font-size:16px;
											margin: 0 20px 0 0;
										    padding: 10px 0;
										    border-top: 1px solid #302E2E;
										    border-bottom: 1px solid #302E2E;
											font-weight: 600;">
														Sub Total
														<span style="margin-left: 70px;"><?= $emailData['currency'] . $cartData['total_amount']; ?></span>
													</p>
												</td>
											</tr>
											<tr>
												<td class="td-container" width="170" valign="middle" align="left"></td>
												<td class="td-container" width="300" valign="middle" align="left"></td>
												<td class="td-container" width="170" valign="middle" align="right" style="padding: 16px 0;">
													<p style="font-family:'Poppins',sans-serif;font-size:16px;
											margin: 0 20px 0 0;
										    padding: 10px 0;
										    border-top: 1px solid #302E2E;
										    border-bottom: 1px solid #302E2E;
											font-weight: 600;">Discounted (<?php echo $prcnt; ?>%):<span style="margin-left: 70px;"><?= $emailData['currency'] . $offAmount; ?></span></p>
												</td>
											</tr>
										<?php } ?>

										<!-- For totals -->
										<tr>
											<td class="td-container" width="170" valign="middle" align="left"></td>
											<td class="td-container" width="300" valign="middle" align="left"></td>
											<td class="td-container" width="170" valign="middle" align="right" style="padding: 16px 0;">
												<p style="font-family:'Poppins',sans-serif;font-size:16px;
									margin: 0 20px 0 0;
								    padding: 10px 0;
								    border-top: 1px solid #302E2E;
								    border-bottom: 1px solid #302E2E;
									font-weight: 600;">Total<span style="margin-left: 70px;"><?= $emailData['currency'] . $emailData['price_paid']; ?></span></p>
											</td>
										</tr>
										<!-- For totals -->

									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
			<tbody>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" align="center">
						<table class="table-container services" width="640" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;">
									<th class="td-container" width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">Services You Might Also Like:</th>
								</tr>
								<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;">
									<td class="td-container" width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">
										<a onmouseover="this.style.color='#FF003D'" onmouseout="this.style.color='#302E2E'" href="<?= base_url('buy-instagram-likes') ?>" style="color: #FF003D;text-transform: capitalize;text-decoration: none;">Buy Instagram Likes</a>
									</td>
									<td class="td-container" width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">
										<a onmouseover="this.style.color='#FF003D'" onmouseout="this.style.color='#302E2E'" href="<?= base_url('buy-tiktok-likes') ?>" style="color: #FF003D;text-transform: capitalize;text-decoration: none;">Buy Tiktok Likes</a>
									</td>
								</tr>
								<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;">
									<td class="td-container" width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">
										<a onmouseover="this.style.color='#FF003D'" onmouseout="this.style.color='#302E2E'" href="<?= base_url('buy-youtube-subscribers') ?>" style="color: #FF003D;text-transform: capitalize;text-decoration: none;">Buy Youtube Subscribers</a>
									</td>
									<td class="td-container" width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">
										<a onmouseover="this.style.color='#FF003D'" onmouseout="this.style.color='#302E2E'" href="<?= base_url('buy-instagram-femalefollowers') ?>" style="color: #FF003D;text-transform: capitalize;text-decoration: none;">Buy Instagram Female Followers</a>
									</td>
								</tr>
								<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;">
									<td class="td-container" width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">
										<a onmouseover="this.style.color='#FF003D'" onmouseout="this.style.color='#302E2E'" href="<?= base_url('buy-tiktok-autoviews') ?>" style="color: #FF003D;text-transform: capitalize;text-decoration: none;">Buy Tiktok Auto Views</a>
									</td>

								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;">
					<td valign="middle" align="center">
						<p>This email is sent from <a style="color: #302E2E;font-weight: 600;
					text-decoration: none;" href=""> sales@socialfollowers.uk</a></p>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#434343">
			<tbody>
				<tr>
					<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" align="center">
						<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td valign="top" align="center"><img src="<?php echo base_url(); ?>assets/images/logo-white.png" width="150" height="50"></td>
								</tr>
								<tr style="color: #fff;font-family:'Poppins',sans-serif;font-size:16px;">
									<td valign="top" align="center">
										<p>This email is automated response. Please don't reply this email</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr class="footer" style="color: #fff;font-family:'Poppins',sans-serif;font-size:14px;">
									<td class="td-container" width="300" valign="middle" align="left" style="padding-left: 20px;">
										<a style="color: #fff;
										text-decoration: none;padding: 0 6px;" href="<?= base_url('faq') ?>">FAQs</a>|<a style="color: #fff;
										text-decoration: none;padding: 0 6px;" href="<?= base_url('about') ?>">About us</a>|<a style="color: #fff;
										text-decoration: none;padding: 0 6px;" href="<?= base_url('terms-and-conditions') ?>">Term & Conditions</a>
									</td>
									<td class="td-container" width="300" valign="middle" align="right" style="padding-right: 20px;">
										<p>Powered By <a href="<?= base_url() ?>" style="color: #FF7800;
										text-decoration: none;"> Social Followers</a></p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</center>
</body>

</html>