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
			            <th>Quantity</th>
			            <th>Total</th>
			        </tr>
			    </thead>
			    <tbody>
			        <tr>
			            <td>Tiktok Likes</td>
			            <td>4.53 $</td>
			            <td><select class="uk-select">
			                <option>1</option>
			                <option>2</option>
			                <option>3</option>
			            	</select>
			        	</td>
			            <td>4.53 $</td>
			        </tr>
			        <tr>
			            <td>Tiktok Likes</td>
			            <td>4.53 $</td>
			            <td><select class="uk-select">
			                <option>1</option>
			                <option>2</option>
			                <option>3</option>
			            	</select>
			        	</td>
			            <td>4.53 $</td>
			        </tr>
			    </tbody>
			</table>
			<div class="subTotal-sec">
				<div class="promo-select">
				<h4>Have a promo code?</h4>
					<div uk-form-custom="target: > * > span:first-child">
			            <select>
			                <option value=""></option>
			                <option value="1">01</option>
			                <option value="2">02</option>
			                <option value="3">03</option>
			            </select>
			            <button class="uk-button uk-button-default" type="button" tabindex="-1">
			                <span></span>
			                <span uk-icon="icon: chevron-down"></span>
			            </button>
			        </div>
		        </div>
		        <div class="total-check">
		        	<h4>Subtotal</h4>
		        	<h4>9.6 $</h4>
		        </div>
		        <span class="total-sec-bar"></span>
		        <a href="">Pay</a>
			</div>
		</div>
	</div>

<?php $this->load->view('layouts/footer') ?>