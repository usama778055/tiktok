<?php $this->load->view('layouts/header'); ?>

<div class="uk-section checkout-banner custom-padding-top">
	<div class="uk-container uk-text-center">
		<img src="<?= base_url('assets/images/Group10.png') ?>">
		<h1>Checkout Page</h1>
		<h6>Let's finalize your order</h6>
	</div>
</div>

<!----------------Checkout-Sec---------------------->
<div id="wrap_cart_detail">
<div class="uk-section checkout-sec" id="cart-details-sec">
	<?php if(empty($cartData["items"])) { ?>
		<div class="uk-text-center">
			<?php echo 'Cart is empty. <a href="' . base_url() . '" >Continue Shop</a>'; ?>
		</div>
	<?php } 
	else { ?>
		<div class="uk-container">
			<table class="uk-table uk-table-divider">
				<thead>
					<tr>
						<th>Package</th>
						<th>Price</th>
						<th>Selected Post</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$totalPrice = 0;
					$cart_items = $cartData["items"];
					foreach ($cart_items as $dataKey => $cart_item) {
						$unitPrice = $cart_item['amount_payable'];
						$totalPrice = $totalPrice + floatval($unitPrice);
						$service = $cart_item['service_detail'];
						$username = (isset($cart_item['user_name'])) ? $cart_item['user_name'] : "";
						$url = (isset($cart_item['url'])) ? $cart_item['url'] : "";
						$thumbnail = isset($cart_item['thumbnail']) ? $cart_item['thumbnail'] : '';
					?>
						<tr class="tr_container">
							<td><?php echo $service["packageQty"] . " " . $service["packageTitle"];?></td>
							<td><?php echo $cart_item["priceUnit"] . $unitPrice; ?></td>
							<td class="push_selected_posts">
								<?php if (isset($cart_item['selected_posts'])) { 
									$selected = $cart_item['selected_posts'];
									foreach ($selected as $key => $post) {
										$postId = isset($post['post_id']) ? $post['post_id'] : $key;
										$postLink = isset($post['post_id']) ? $post['post_id'] : $key;
										$quantity = $post['quantity'];
										$class = (isset($post['post_comments'])) ? "cartCmnt" : ""; 
									?>
										<?php if (isset($post['post_comments'])) {
											$comments = preg_split('/\r\n|\r|\n/', $post['post_comments']); ?>
											<div class="row cartcmmmns">
												<div class="heading">Comments: </div>
												<?php foreach ($comments as $key => $comment) { ?>
													<div class="value">
														<?php echo '<b>' . ($key + 1) . '</b>' . '. ' . $comment; ?>
													</div>
												<?php } ?>
											</div>
										<?php }
										else { ?>
											<div class="value">
												<span class="uk-text-bold"><?php echo $quantity . ' ' . $service["serviceType"]; ?> For
													<a class="uk-text-light uk-text-primary" href="<?= $postId ?>" target="_blank" uk-tooltip="<?= $postId ?>;pos: top" title="" aria-expanded="false"> Link </a>
												</span>
											</div>
										<?php } ?>
									<?php } ?>
								<?php } 
								else { ?>
									 <a class="uk-text-light uk-text-primary" href="<?= $username ?>" target="_blank" uk-tooltip="<?= $username ?>;pos: top" title="" aria-expanded="false"> Link </a>
								<?php } ?>
							</td>
							<td><button id="cart-remove" class="cart-remove" data-id="<?php echo $dataKey; ?>">×
							</button></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="subTotal-sec">
				<div class="promo-select">
					<div id="promo_div" uk-form-custom="target: > * > span:first-child">
						<h4 class="promocode_h4">Have a promo code?</h4>
						<button class="uk-button uk-button-default promo_code" type="button" tabindex="-1">
							<span></span>
							<span class="promospan" uk-icon="icon: chevron-down"></span>
						</button>
					</div>
				</div>
				<div class="promo_input_div">
					<input class="promo_code_input" type="text" id="discount_coupon" name="promo_name" placeholder="Enter Your Coupon Code">
					<button class="uk-button uk-button-default" id="getpromo">apply coupon</button>
				</div>
				<div>
					<div class="total-check">
						<h4>Subtotal</h4>
						<h4><?= $cartData["items"][0]["priceUnit"] ?? '£' ?> <?php echo $cartData["total_amount"]; ?></h4>
					</div>
				</div>

				<div class="promoDiscount uk-list" <?php echo isset($_SESSION['discount']['discount_percent']) && !empty($_SESSION['discount']['discount_percent']) ?  "style=display: block": 'style=display: none'; ?>>
					<div class="invodis_h total total-check">
						<h4>Discount (%)</h4>
						<h4 class="invodis_v total total-check"><?php echo isset($_SESSION['discount']['discount_percent']) && !empty($_SESSION['discount']['discount_percent']) ? $_SESSION['discount']['discount_percent'] : 0 ; ?>%</h4>
					</div>
				</div>
				<div>
					<div class="total-check">
						<h4>Total</h4>
						<?php
						$discountAmount=isset($_SESSION['discount']['discount_price']) && !empty($_SESSION['discount']['discount_price']) ? $_SESSION['discount']['discount_price'] : 0 ; ?>

						<h4 class="invototal_v"><?= $cartData["items"][0]["priceUnit"] ?? '£' ?> <?php echo $cartData["total_amount"] - $discountAmount ;?></h4>
					</div>
				</div>
				<span class="total-sec-bar"></span>

			</div>
			<div class="checkout_email">
				<label class="email_text" for="user_checkout_email">Your Checkout Email</label>
				<input class="promo_code_input" id="user_checkout_email" type="text" name="" placeholder="Enter Your Email">
				<input type="hidden" id="stripe_public_key" value="<?php echo $stripe_key ?>">
			</div>
			<div>
				<button id="payButton" type="submit">Pay Now</button>
			</div>
		</div>
	<?php } ?> 
</div>
</div>
<?php $this->load->view('layouts/footer') ?>
<script src="https://js.stripe.com/v3/?advancedFraudSignals=true"></script>
<script type="text/javascript" src="<?= base_url('assets/js/checkout.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/stripe/StripeCartCheckout.js') ?>"></script>
