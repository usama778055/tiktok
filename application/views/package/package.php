<?php $this->load->view('layouts/header'); ?>

<div id="package-lottie" class="uk-section pakages-banner custom-padding-top">
	<div class="uk-container">
		<div class="pakages-banner-content uk-width-3-4@s">
			<h4>Buy <?php echo $single_data[0]->packageTitle ?></h4>
			<h3>Welcome to the <span> <?php echo $single_data[0]->packageTitle ?> </span> </h3>
			<p>Where you can get your favorite packages instantly. Lorem Ipsum is simply dummy text of the printing.</p>
		</div>
		<div class="uk-margin-top">
			<ul class="uk-list uk-flex uk-flex-center pakages-banner-btn">
				<li>
					<a class="serv-btn" href="<?php echo base_url('buy-tiktok-reallikes') ?>"><span class="spanbtn">Real Likes</span></a>
					<!-- <a href="#">Buy Tiktok Likes</a> -->
				</li>
				<li>
					<a class="serv-btn link" href="<?php echo base_url('buy-tiktok-premiumlikes') ?>"><span class="spanbtn">Premium Likes</span></a>
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
					<small><a href="<?php echo base_url(); ?>">Home</a>/<a class="active" href="#">Tiktok <?php echo $single_data[0]->serviceType; ?></a></small>
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
		<div class="uk-width-4-5@s wanted-pakages-article" uk-slider>
			<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
				<ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-grid">
				<?php foreach ($featured as $key => $value) {// code...
					$parts = explode('.', $value->packagePrice);
					?>
					<div class="">
						<div class="uk-card uk-card-default">
							<p><?php echo $value->serviceType; ?></p>
							<h3>Buy <?php echo $value->packageQty ?> Tiktok <br><?php echo $value->serviceType; ?></h3>
							<h4><?php echo $value->priceUnit.' '.$parts[0]; ?><sup><?php if(!empty($parts[1])){
								echo $parts[1];
							}
							else{

							}  ?></sup></h4>
							<div class="wanted-pakages-btn">
								<a class="serv-btn" href="<?php echo base_url('buy-'.$value->packageQty.'-tiktok-'.$value->serviceType); ?>"><span class="spanbtn">Buy Now</span></a>
							</div>
						</div>
					</div>
				<?php } ?>
			</ul>
			<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
			<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
		</div>
		<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
	</div>

</div>
</div>
<!-------------------------------------------->
<?php $this->load->view('layouts/footer'); ?>


