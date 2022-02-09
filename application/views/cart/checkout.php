<?php $this->load->view('layouts/header'); ?>

<div class="uk-section checkout-banner custom-padding-top">
	<div class="uk-container uk-text-center">
		<img src="<?= base_url('assets/images/Group10.png') ?>">
		<h1>Checkout Page</h1>
		<h6>Let's finalize your order</h6>
	</div>
</div>

<!----------------Checkout-Sec---------------------->
<div class="uk-section checkout-sec">
	<div class="uk-container">
		<table class="uk-table uk-table-divider">
			<thead>
				<tr>
					<th>Package</th>
					<th>Price</th>
					<th>Selected Post</th>
					<th>Total</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr class="tr_container">
					<td>Tiktok Likes</td>
					<td>4.53 $</td>
					<td class="push_selected_posts">
						<div class="value">
							<span class="uk-text-bold">100 likes For
								<a class="uk-text-light uk-text-primary" href="https://www.instagram.com/p/CQQBSTAlp5s" target="_blank" uk-tooltip="title:https://www.instagram.com/p/CQQBSTAlp5s;pos: top" title="" aria-expanded="false"> Link </a>
							</span>
						</div>
					</td>
					<td>4.53 $</td>
					<td><button id="cart-remove-id" class="cart-remove" data-id="0">×
					</button></td>
				</tr>
				<tr>
					<td>Tiktok Likes</td>
					<td>4.53 $</td>
					<td>100</td>
					<td>4.53 $</td>
				</tr>
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
				<input class="promo_code_input" type="text" name="" placeholder="Enter Your Coupon Code">
				<button class="uk-button uk-button-default">apply coupon</button>
			</div>
			<div>

				<div class="total-check">
					<h4>Subtotal</h4>
					<h4>9.6 $</h4>
				</div>

			</div>
			<span class="total-sec-bar"></span>
			<a href="">Pay</a>
		</div>
		<div class="checkout_page_email_div"><input class="promo_code_input" type="text" name="" placeholder="Enter Your Email"></div>
	</div>
</div>

<?php $this->load->view('layouts/footer') ?>