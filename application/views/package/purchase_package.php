
<?php $this->load->view('layouts/header'); ?>
<div class="uk-section feed-banner custom-padding-top">
	<div class="uk-container">
		<h6>Checkout</h6>
		<h3>Buy <?php echo $user_data[0]->packageQty.' '.'TikTok'.' '.$user_data[0]->serviceType; ?></h3>
	</div>
</div>


<!--------------------Feed-main-sec----------------->
<div class="feed-main uk-section">
	<div class="uk-container">
		<div class="" uk-grid>
			<div class="uk-width-1-2@s">
				<div class="left-feed-sec">
					<div class="left-feed-upper">

						<form class="" uk-grid>
							<div class="uk-width-1-2@m">
								<label class="uk-form-label" for="form-stacked-text">Your Tiktok User ID</label>
								<div class="uk-form-controls">
									<input class="uk-input user_name" id="form-stacked-text" type="text" placeholder="@therock" onchange="from_get_api(event)">
								</div>
							</div>
							<div class="uk-width-1-2@m custom-selected" uk-form-custom="target: > * > span:first-child">
								<label for="" class="uk-form-label">Package Selected</label>			<select class="js-example-basic-single" onchange="myFunction()">
									<?php foreach($alldata as $values){

										if($user_data[0]->id == $values->id){
											$att = 'selected';
										}
										else{
											$att = '';
										}
										?>

										<option value="<?php echo base_url('buy-'.$values->packageQty.'-tiktok-'.$values->serviceType) ?>" class="" data_id="<?php echo $values->packageQty;?>" <?php echo $att; ?>><?php echo $values->packageQty.' '.$values->packageTitle; ?></option>
									<?php } ?>
								</select>
								<button class="uk-button uk-button-default" type="button" tabindex="-1">
									<span></span>
									<span uk-icon="icon: chevron-down"></span>
								</button>
							</div>
						</form>

					</div>
					<div class="left-feed-botoom">

						<div class="load-gallery custom_image_class">
							<div class="loader_class" uk-spinner style="display: none; color: white;"></div>		

						</div>
						<a id="loadmore" class="serv-btn" href="#"><span class="spanbtn">Load More</span></a>
					</div>
				</div>
			</div>
			<div class="uk-width-1-2@s">
				<div class="right-feed-sec">
					<div class="invoice-modal">
						<h4>Invoice</h4>
						<div class="user-img">
							<img height=100 width=100 src="<?php echo base_url('assets/images/placeholder_person.png') ?>">
							<div class="">
								<h5>The Rock</h5>
								<p>@therock</p>
							</div>
						</div>
						<div class="order">
							<h5>Order</h5>
							<p><?php echo $user_data[0]->packageQty .' '. $user_data[0]->serviceType ?></p>
						</div>
						<div class="price">
							<h5>Price</h5>
							<p><?php echo $user_data[0]->priceUnit .' '. $user_data[0]->packagePrice ?></p>
						</div>
						<div class="promo-code">
							<h5>Have a promo code?</h5>
							<input class="uk-input" id="form-stacked-text" type="text" placeholder="apply here">
						</div>
						<div class="total">
							<h5>Total</h5>
							<p><?php echo $user_data[0]->priceUnit .' '. $user_data[0]->packagePrice ?></p>
						</div>
						<div class="invoice-modal-btn">
							<a href="<?= base_url('add-to-cart') ?>">Add To Cart</a>
							<a class="active" href="<?= base_url('checkout') ?>">Checkout</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-------------------------------------------------->

<!------------------feed-sec-packages--------------->
<div class="feed-sec-packages uk-section">
	<div class="uk-container uk-width-4-5@s"uk-slider>
		<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
			<h6>Add on</h6>
			<h4>Take a look at these amazing packages</h4>
			<ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-grid">
				<?php foreach ($featured as $key => $value) {// code...
					$parts = explode('.', $value->packagePrice);
					?>
					<li class="feed-box">
						<div class="amazing-package">
							<h5>Buy <?php echo $value->packageQty ?> Tiktok <?php echo $value->serviceType; ?></h5>
							<small><?php echo $value->priceUnit.' '.$parts[0]; ?><sup><?php if(!empty($parts[1])){
								echo $parts[1];
							}
							else{

							}?></sup></small>
							<ul class="uk-list">
								<li>High Quality</li>
								<li>Active and Real Users </li>
								<li>Instant Delivery</li>
								<li>24/7 Support</li>
							</ul>
							<span class="spanbtn"><a class="" href="<?php echo base_url('buy-'.$value->packageQty.'-tiktok-'.$value->serviceType); ?>">Purchase</a></span>
						</div>
					</li>

				<?php } ?>
			</ul>
			
		</div>
	</div>
</div>
	<!-------------------------------------------------->


	<?php $this->load->view('layouts/footer'); ?>