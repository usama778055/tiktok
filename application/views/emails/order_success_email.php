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
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
	<title>Tiktok</title>
	<style type="text/css">
		table td { /*border: 1px solid cyan;*/ }
		body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
		table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
		img { -ms-interpolation-mode: bicubic; }
		img { border: 0; outline: none; text-decoration: none; }
		table { border-collapse: collapse !important; }
		body { margin: 0 !important; padding: 0 !important; width: 100% !important; }
		/* iOS BLUE LINKS */
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}
		.custom-table-container .table-responsive{
			overflow-x: scroll;
		}
		.custom-table-container .width{

			width: 640px;
		}

		/* MEDIA QUERIES */
		@media all and (max-width:639px){
			.table-container{
				width: 100%;
			}
			.td-container{
				width: 50%;
				/* text-align: center; */
			}
			.center{
				text-align: center;
			}
			.table-responsive{
				overflow-x: scroll;
			}
			.table-width{
				width: 640px;
			}
		}
		@media all and (max-width:576px){
			.footer{
				display: flex;
				flex-direction: column-reverse;
			}
			.footer td{
				text-align: center;
				margin-top: 10px;
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
						<td valign="top" align="center"><img src="<?php echo base_url(); ?>assets/images/logo.png"></td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="font-size:10px;line-height:10px" height="10">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" align="center">
				<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" style="background-image: url(<?php echo base_url()?>'assets/images/bkground.png');background-repeat: no-repeat;
									    background-size: 100% 100%;
									    min-height: 100px;"	>
					<tbody>
					<tr style="color: #fff;font-family: 'Lato', sans-serif;;font-size:20px;font-weight: 400;">
						<td valign="middle" align="center"><p>Thank you for using Tiktoklikes</p></td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		</tbody>
	</table>

	<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FCFCFC">
		<tbody>
		<tr>
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" align="center">
				<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr style="color: #FE2C55;font-family: 'Lato', sans-serif;;font-size:18px;">
						<td valign="middle" align="center"><p style="font-weight: 600;">Here Is Your Invoice Details</p></td>
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
				<table class="table-container" width="500" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
						<td class="td-container center" width="350" valign="middle" align="left" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><p>Invoice #<br><span style="font-weight: 400;"><?php echo $emailData['orderId'] ?></span></p></td>
						<td class="td-container center" width="150" valign="middle" align="left" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><p>Payment Date <br> <span style="font-weight: 400;"><?php echo date("j F Y");?></span></p></td>
					</tr>
					<tr>
						<td style="font-size:10px;line-height:10px" height="10">&nbsp;</td>
					</tr>
					<tr>
						<td class="td-container center" width="350" valign="middle" align="left" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><p>Order ID:<br><span style="font-weight: 400;"><?php echo $emailData['orderId'] ?></span></p>
						</td>
						<td class="td-container center" width="150" valign="middle" align="left" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><p>E-mail Address<br><span style="font-weight: 400;"><?php echo $emailData['user_email'] ?></span></p>
						</td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr style="color: #FE2C55;font-family: 'Lato', sans-serif;;font-size:18px;">
			<td valign="middle" align="center"><p style="font-weight: 600;">Your Order Details</p></td>
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
					<td valign="top" align="center">
						<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0">
							<tbody>
							<tr bgcolor="#EDEFF1" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:16px;">
								<th width="350" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">Product</th>
								<th width="240" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">Selected Posts / URL</th>
								<th width="50" valign="middle" align="right" style="padding: 10px 20px 10px 0px;">Amount</th>
							</tr>
							<?php
							$details = $cartData['items'];
							foreach ($details as $detail) {
							$service = $detail['service_detail'];
							$serviceType = $service['serviceType'];
							$username = isset($detail['user_name']) ? $detail['user_name'] : "";
							$url = isset($detail['url']) ? $detail['url'] : "";
							?>
							<tr bgcolor="#F5F6F7" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;text-transform: capitalize;">
								<td width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;"><?php echo $detail['service_detail']['packageQty'] . ' ' . $detail['service_detail']['packageTitle'];
									?></td>
								<td width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;">
									<?php if (!isset($detail['selected_posts'])) {?>
									<a style="color: #FF003D;text-decoration: none;text-transform: lowercase;" target="_blank" href="<?php echo "https://www.tiktok.com/@" . $username; ?>"><?php echo "https://www.tiktok.com/@" . $username; ?></a>
									<?php }else if(isset($detail['selected_posts'])){?>
										<div class='selectedPost'>
											<?php
											$post_num = 1;
											foreach ($detail['selected_posts'] as $key => $selected_post) {
												//$postId = isset($selected_post['post_id']) ? $selected_post['post_id'] : $key;
												$postLink = isset($selected_post['post_id']) ? $selected_post['post_id'] : $key;

												?>
												<div style="font-weight: 600;">
													<?= $selected_post['quantity'] . ' ' . $serviceType . ' on ' ?>
													<a href=" https://www.tiktok.com/@<?php echo $username?>/video/<?php echo $postLink?>" style="color:#ff005f;" target="_blank">
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

									<?php }?>
								</td>

								<td width="40" valign="middle" align="right" style="padding: 10px 50px 10px 0px;"><?= $detail['priceUnit'] . $detail['amount_payable']; ?></td>
							</tr>
							<?php } ?>
							<?php  if(!empty($discount)){
								$prcnt = (!empty($discount)) ? $discount['discount_percent'] : '';
								$offAmount = (!empty($discount)) ? $discount['discount_price'] : '';
								$discountedAmount = (!empty($discount)) ? $discount['discount_pkgprice'] : '';
								$totalPrice = (!empty($discount)) ? $discountedAmount : $totalPrice;
							?>
							<tr bgcolor="#F5F6F7" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;text-transform: capitalize;">
								<td width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;"></td>
								<td width="300" valign="middle" align="center" style="padding: 10px 0px 10px 20px;"><b>Sub Total:</b></td>
								<td width="40" valign="middle" align="right" style="padding: 10px 50px 10px 0px;"><b><?= $emailData['currency'] . $cartData['total_amount']; ?></b></td>
							</tr>
							<tr bgcolor="#F5F6F7" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;text-transform: capitalize;">
								<td width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;"></td>
								<td width="300" valign="middle" align="center" style="padding: 10px 0px 10px 20px;"><b>Discounted (<?php echo $prcnt; ?>%):</b></td>
								<td width="40" valign="middle" align="right" style="padding: 10px 50px 10px 0px;"><b><?= $emailData['currency'] . $offAmount; ?></b></td>
							</tr>
							<?php  }?>
							<tr bgcolor="#F5F6F7" style="color: #302E2E;font-family:'Lato',sans-serif;font-size:14px;text-transform: capitalize;">
								<td width="300" valign="middle" align="left" style="padding: 10px 0px 10px 20px;"></td>
								<td width="300" valign="middle" align="center" style="padding: 10px 0px 10px 20px;"><b>Total :</b></td>
								<td width="40" valign="middle" align="right" style="padding: 10px 50px 10px 0px;"><b><?= $emailData['currency'] . $emailData['price_paid']; ?></b></td>
							</tr>
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
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr>
			<td valign="middle" align="center">
				<a href="<?php echo $emailData['trackOrderLink'] ?>" target="_blank" style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:14px;text-decoration: none;
    								font-weight: 500;
    								background-image: linear-gradient(to right, #00FFF8 , #FF00B4);
								    border-radius: 40px;
								    box-sizing: border-box;
								    display: block;
								    height: 45px;
								    padding: 4px;
								    position: relative;
								    width: 170px;
								    transition: .2s;
								    z-index: 2;">
								    <span onmouseover="this.style.color='#fff'; this.style.background='transparent'" onmouseout="this.style.color='#302E2E'; this.style.background='#fff'" style="align-items: center;
									    background: #fff;
									    border-radius: 40px;
									    display: flex;
									    justify-content: center;
									    height: 100%;
									    transition: background 0.5s ease;
									    width: 100%;">Track My Order</span>
				</a>
			</td>
		</tr>
		<tr>
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:15px;">
			<td valign="middle" align="center"><p style="margin:0;">You are now eligible to apply for coupons</p></td>
		</tr>
		<tr>
			<td style="font-size:10px;line-height:10px" height="10">&nbsp;</td>
		</tr>
		<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:13px;">
			<td valign="middle" align="center"><p style="margin:0;">This email is sent from <a style="color: #FE2C55;font-weight: 600;
    							text-decoration: none;" href=""> info@tiktoklikes.com</a></p></td>
		</tr>
		<tr>
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr style="color: #302E2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight: 600;">
			<td valign="middle" align="center"><p style="margin:0;">Similar Products Recommended for you.</p></td>
		</tr>
		<tr>
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" align="center">
				<table class="table-container" width="340" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
						<td class="td-container center" width="220" valign="middle" align="left" style="font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><a href="<?php echo base_url('buy-tiktok-likes'); ?>" style="margin: 0;color: #FE2C55;text-decoration: none;padding-left: 10px;">Buy Tiktok Likes</a></td>
						<td class="td-container center" width="120" valign="middle" align="left" style="font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><a href="<?php echo base_url('buy-tiktok-autolikes'); ?>" style="margin: 0;color: #FE2C55;text-decoration: none;padding-left: 10px;">Buy Auto Likes</a></td>
					</tr>
					<tr>
						<td style="font-size:10px;line-height:10px" height="10">&nbsp;</td>
					</tr>
					<tr>
						<td class="td-container center" width="220" valign="middle" align="left" style="font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><a href="<?php echo base_url('buy-tiktok-autoviews'); ?>" style="margin: 0;color: #FE2C55;text-decoration: none;padding-left: 10px;">Buy Auto Views</a>
						</td>
						<td class="td-container center" width="120" valign="middle" align="left" style="font-family:'Lato',sans-serif;font-size:14px;margin: 0;font-weight: 600;"><a href="<?php echo base_url('buy-tiktok-followers'); ?>" style="margin: 0;color: #FE2C55;text-decoration: none;padding-left: 10px;">Tik Tok Followers</a>
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

	<table class="table-container" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#EDEFF1">
		<tbody>
		<tr>
			<td style="font-size:10px;line-height:20px" height="20">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" align="center">
				<table class="table-container" width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr class="footer">
						<td class="table-container" width="400" valign="middle" align="left" style="line-height: .8;">
							<p style="color: #FE2C55;margin: 0;font-family:'Lato',sans-serif;font-size:14px;">
								<a style="color: #FE2C55;
    												text-decoration: none;padding: 0 6px 0 0;font-weight: 600;" href="">FAQ</a>|<a style="color: #FE2C55;
    												text-decoration: none;padding: 0 6px;font-weight: 600;" href="">Contact us</a>|<a style="color: #FE2C55;
    												text-decoration: none;padding: 0 6px;font-weight: 600;" href="">Term & Conditions</a>
							</p>
							<br>
							<p style="color: #302E2E;margin: 0;font-family:'Lato',sans-serif;font-size:14px;">This is an automatically generated email. Please don't reply to it.</p>
							<br>
							<p style="color: #302E2E;margin: 0;font-family:'Lato',sans-serif;font-size:14px;line-height: .4;">Powered By: <a style="color: #302E2E;font-weight: 600;
    												text-decoration: none;" href="">Tiktoklikes</a></p>
						</td>
						<td class="table-container" width="200" valign="middle" align="right">
							<img height="60" src="footer-logo.PNG">
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
</center>

</body>
</html>
