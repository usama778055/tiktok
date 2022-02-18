<?php
$this->load->view('layouts/header');

?>
<link href="<?php echo base_url('assets/css/tracking.css'); ?>" rel="stylesheet" type="text/css">
<div style="background-color: white;">
	<div class="tracking-order-banner uk-section">
		<div class="uk-container uk-text-center">
			<h1 class="">Track my order</h1>
			<div class="tracking-order-bar">
				<img src="<?= base_url('assets/images/Group370.png') ?>" alt="Order Tracking Image">
			</div>
		</div>
	</div>

	<div class="uk-section tracking-sec">
		<div class="uk-container">
			<div class="uk-width-3-4@s uk-margin-auto">
				<h4>Track Order</h4>
				<p>Real time order tracking made for our valuable customers with love.</p>
			</div>
			<div class="tracking-form uk-width-3-4@s uk-margin-auto">
				<form action="">
					<div class="uk-margin">
						<label class="uk-form-label" for="form-stacked-text">Order ID</label>
						<div class="uk-form-controls">
							<input class="uk-input" id="orderCode" type="text" placeholder="Your Order Tracking id here, e.g. 16412037001" value="<?php echo $order_id; ?>">
						</div>
					</div>
					<button type="button" class="uk-button" id="trackOrder">Track Now</button>
				</form>
				<div class="wraptrackresults" style="display: none;"></div>
			</div>
		</div>
	</div>

	<div class="uk-container">
		<div class="order-content uk-section">
			<h4>For Tracking The Order following is process:</h4>
			<p>1: Please enter your Order ID e.g. 163700006111</p>
			<p>You can find out your order ID on the Payment Invoice email that is sent to you, right after placing the order. If you have not received your Payment Invoice, please contact us with your Instagram username.</p>
			<p>2: All tracking information is LIVE and in sync with our systems. You will have the status resutls within a min.</p>
			<p>3: This will show you the "START COUNT", When the order was started, It can be the followers count or Posts like "Remains", Remains will show the remaining amount of service "Status" will show either its completed, Running, pending or canceled by some reason.</p>
			<p>4: we have an advanced algorithm that we've developed & working on since 2018 that will ensure you will have completed service, If you feel there is some drop you can start the "REFILL" by clicking the button above.</p>
		</div>
	</div>
</div>


<?php $this->load->view('layouts/footer') ?>
<script type="text/javascript" src="<?= base_url('assets/js/tracking.js') ?>"></script>
<script>
	const trackUrl = "<?= $this->uri->segment(1); ?>"
</script>
