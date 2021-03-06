
<?php $this->load->view('layouts/header'); ?>
<div class="uk-section feed-banner custom-padding-top">
	<div class="uk-container">
		<h6>Checkout</h6>
		<h3>Buy <?php echo $user_data[0]->packageQty.' '.'TikTok'.' '.$user_data[0]->serviceType; ?></h3>
	</div>
</div>


<!--------------------Feed-main-sec----------------->
<input class="service_type" id='<?php echo $user_data[0]->serviceType; ?>' type="" name="" style="display:none;">
<div class="feed-main uk-section">
	<div class="uk-container">
		<div class="" uk-grid>
			<div class="uk-width-1-2@s">
				<div class="left-feed-sec">
					<div class="left-feed-upper">

						<form class="" uk-grid>
							<div class="uk-width-1-2@m">
								<label class="uk-form-label" for="form-stacked-text">Your Tiktok User Name</label>
								<div class="uk-form-controls">
									<input class="uk-input user_name" id="form-stacked-text" name="tiktok_username" type="text" placeholder="@therock">
								</div>
							</div>
							<div class="uk-width-1-2@m custom-selected custom_selected_container" uk-form-custom="target: > * > span:first-child">

								<label for="" class="uk-form-label">Package Selected</label>			<select class="selcter_custom_class js-example-basic-single" onchange="myFunction()">
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
						<div class="loader_class" uk-spinner="ratio: 4"></div>
						<div class="load-gallery custom_image_class">

						</div>
					</div>
					<div class="add_comment wrap_selected_items" id="add_comment" style="display:none">
						
					</div>
				</div>
			</div>
			<div class="uk-width-1-2@s">
				<div class="right-feed-sec">
					<div class="invoice-modal">
						<h4>Invoice</h4>
						<div class="user-img">

							<img height=100 width=100 id="profile_image_tiktok" src="<?php echo isset($_SESSION['profile_data']['profileImage']) && !empty($_SESSION['profile_data']['profileImage']) ? $_SESSION['profile_data']['profileImage'] : base_url('assets/images/placeholder_person.png');?>">
							<div class="">
								<h5><?php echo isset($_SESSION['profile_data']['full_name']) && !empty($_SESSION['profile_data']['full_name']) ? $_SESSION['profile_data']['full_name'] : '';?></h5>
								<p><?php echo isset($_SESSION['profile_data']['user_name']) && !empty($_SESSION['profile_data']['user_name']) ? '@'.$_SESSION['profile_data']['user_name'] : '';?></p>
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
						<div class="promo-code" style="display:none;">
							<h5>Have a promo code?</h5>
							<input class="uk-input" id="form-stacked-text" type="text" placeholder="apply here">
						</div>
						<div class="total">
							<h5>Total</h5>
							<p><?php echo $user_data[0]->priceUnit .' '. $user_data[0]->packagePrice ?></p>
						</div>
						<div class="invoice-modal-btn">
							<a id="add-to-cart" href="<?= base_url('add-to-cart') ?>">Add To Cart</a>
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
			
			
		</div>
	</div>
	<?php $this->load->view('blogs/feature_blogs',$featured); ?>
</div>
<!-------------------------------------------------->

<?php $this->load->view('layouts/footer'); ?>
<script type="text/javascript">
	const sType = "<?php echo $user_data[0]->serviceType; ?>",
	packageQty = "<?php echo $user_data[0]->packageQty; ?>",
	user_name = '<?php echo (isset($_SESSION["user_name"])) ? $_SESSION["user_name"] : ""; ?>',
	user_email = '<?php echo (isset($_SESSION["user_email"])) ? $_SESSION["user_email"] : ""; ?>';
</script>

<script type="text/javascript" src="<?= base_url('assets/js/app.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/cart.js') ?>"></script>
