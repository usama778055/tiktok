<?php $this->load->view('layouts/header'); ?>

<div id="package-lottie" class="uk-section pakages-banner custom-padding-top">
	<div class="uk-container">
		<div class="pakages-banner-content uk-width-3-4@s">
			<h4>Buy Tiktok likes</h4>
			<h3>Welcome to the <span> Tiktok Likes </span> </h3>
			<p>Where you can get your favorite packages instantly. Lorem Ipsum is simply dummy text of the printing.</p>
		</div>
		<div class="uk-margin-top">
			<ul class="uk-list uk-flex uk-flex-center pakages-banner-btn">
				<li>
					<a class="serv-btn" href="#"><span class="spanbtn">Real Likes</span></a>
					<!-- <a href="#">Buy Tiktok Likes</a> -->
				</li>
				<li>
					<a class="serv-btn" href="#"><span class="spanbtn">Premium Likes</span></a>
				</li>
			</ul>
		</div>
	</div>
</div>

<!----------------Likes-Sec------------------->
<div class="tiktok-likes-sec uk-section">
	<div class="uk-container">
		<div class="uk-width-3-4@s margin-auto-div" uk-grid>
			<div class="uk-width-1-2@s">
				<div class="likes-menu">
					<ul class="uk-list uk-flex">
						<?php
						foreach ($alldata as $key => $value) {
	// code...				
							if($key == 0){
								$class = 'selected';
							}
							else{
								$class = '';
							}

						?>
						<li> <span class="<?php echo $class; ?> package_button" data_id = "<?php echo $value->id; ?>"><?php echo $value->packageQty; ?><br> <?php echo $value->serviceType; ?></span> </li>
						<?php } ?>
						
					</ul>
				</div>
			</div>
			<div class="uk-width-1-2@s">
				<div class="pakage-details">
					<small><a href="#">Home</a>/<a class="active" href="#">Tiktok <?php echo $single_data[0]->serviceType; ?></a></small>
					<h3>Buy <?php echo $single_data[0]->packageQty; ?> <?php echo $single_data[0]->packageTitle; ?></h3>
					<strong><?php echo $single_data[0]->priceUnit; ?> <?php echo $single_data[0]->packagePrice; ?></strong>
					<p><?php echo $single_data[0]->package_description; ?></p>
					<ul class="uk-list">
						<li>High Quality</li>
						<li>Active and Real Users </li>
						<li>Instant Delivery</li>
						<li>24/7 Support</li>
					</ul>
					<div class="purchase-btn">
						<a class="serv-btn" data_id="" href="<?php echo base_url('buy-'.$single_data[0]->packageQty.'-tiktok-'.$single_data[0]->serviceType) ?>"><span class="spanbtn">Purchase</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-------------------------------------------->

<!--------paragraph-sec----------------------->
<div class="paragraph-sec">
	<div class="uk-container uk-width-3-4@s">
		<div class="custom-bar"></div>
		<div class="uk-section">
			<h3>Why should someone buy Tiktok likes?</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
			<h4>Lorem Ipsum</h4>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
		</div>
	</div>
</div>
<!-------------------------------------------->

<!------------Wanted-Pakages------------------>
<div class="wanted-pakages-sec">
	<div class="uk-section wanted-pakages-heading">
		<div class="uk-container uk-width-3-4@s">
			<h5><img src="<?php echo base_url('assets/images/hot.PNG') ?>">Rock And Hot</h5>
			<h4>Most Wanted Packages</h4>
		</div>
	</div>
	<div class="gradientBg">
		<div class="uk-width-3-4@s wanted-pakages-article">
			<div class="uk-child-width-expand@s" uk-grid>
				<div>
					<div class="uk-card uk-card-default">
						<p>Followers</p>
						<h3>Buy 1000 Tiktok <br>Followers</h3>
						<h4>£ 3<sup>.12</sup></h4>
						<div class="wanted-pakages-btn">
							<a class="serv-btn" href="#"><span class="spanbtn">Buy Now</span></a>
						</div>
					</div>
				</div>
				<div>
					<div class="uk-card uk-card-default">
						<p>Auto Likes</p>
						<h3>Buy 2500 Tiktok <br>Auto Likes</h3>
						<h4>£ 10<sup>.69</sup></h4>
						<div class="wanted-pakages-btn">
							<a class="serv-btn" href="#"><span class="spanbtn">Buy Now</span></a>
						</div>
					</div>
				</div>
				<div>
					<div class="uk-card uk-card-default">
						<p>Comments</p>
						<h3>Buy 1500 Tiktok <br>Comments</h3>
						<h4>£ 16<sup>.30</sup></h4>
						<div class="wanted-pakages-btn">
							<a class="serv-btn" href="#"><span class="spanbtn">Buy Now</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-------------------------------------------->
<?php $this->load->view('layouts/footer'); ?>


