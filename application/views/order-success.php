<?php $this->load->view('layouts/header'); ?>

	<div class="order-succes-sec uk-section" style="background-color: #fff;">
		<div class="uk-container">
			<div class="">
				<div class="order-success-panel uk-width-2-3@m uk-margin-auto">
					<div class="order-succes-image uk-text-center">
						<img width="569" height="284" src="<?= base_url('assets/images/ordersuccessfull.PNG') ?>" alt="Order Success Image">
					</div>
					<div class="order-success-content">
						<?php
						$tracking_id = $this->uri->segment(2);
						$tracking_page = base_url("tracking/{$tracking_id}");
						?>
						<h3>Thank you for your purchase</h3>
						<p>Your order number is :
							<a class="track-link" href="<?php echo $tracking_page; ?>"> <?= $tracking_id ?>
							</a>
						</p>
						<p>Please check your email for order details and tracking info.</p>
						<a class="return-shopping" href="<?= base_url() ?>">Continue Shopping</a>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->load->view('layouts/footer'); ?>
