<?php $this->load->view('layouts/header'); ?>
<div class="uk-section custom-uk-first-panel custom-padding-top">
	<div class="uk-container">

		<div class="uk-flex uk-flex-column first-panel-content">
			<div class="tiktok-logo">
				<img src="<?php echo base_url('assets/images/Group10.PNG') ?>" alt="">
			</div>
			<div class="uk-margin-top uk-text-center">
				<h1>We Are Beast in our competitors</h1>
				<p>Providing the vast amount of TIKTOK
					<br>services for our users</p>
				</div>
				<div class="uk-margin-top">
					<ul class="uk-list uk-flex uk-flex-center likeNview">
						<li>
							<!-- <a class="serv-btn" href="#"><span class="spanbtn">Buy Tiktok Likes</span></a> -->
							<a href="<?php echo base_url('buy-tiktok-likes'); ?>">Buy Tiktok Likes</a>
						</li>
						<li>
							<a class="red-btn" href="<?php echo base_url('buy-tiktok-views'); ?>">Buy Tiktok Views</a>
						</li>
					</ul>
				</div>
				<div class="hero-sec-img">
					<img src="<?php echo base_url('assets/images/herosection.svg') ?>" alt="">
				</div>
			</div>

		</div>
	</div>

	<div class="uk-section custom-uk-second-panel">
		<div class="uk-container">

			<div class="uk-flex uk-flex-column second-panel-content">
				<div class="">
					<img src="<?php echo base_url('assets/images/5star.PNG') ?>" alt="">
				</div>
				<div class="uk-margin-top uk-text-center">
					<h3>5 Star Reviews</h3>
					<ul class="uk-list custom-rating uk-flex">
						<li><span uk-icon="star"></span></li>
						<li><span uk-icon="star"></span></li>
						<li><span uk-icon="star"></span></li>
						<li><span uk-icon="star"></span></li>
						<li><span uk-icon="star"></span></li>
					</ul>
					<p>Trusted By Thousand Of Influencers and Companies Around The World</p>
				</div>
			</div>

			<!-------Slider--------->
			<div class="uk-position-relative uk-visible-toggle custom-uk-slider" tabindex="-1" uk-slider>

				<ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-grid">
					<li>
						<div class="uk-panel">
							<img src="<?php echo base_url('assets/images/company1.PNG') ?>" alt="">
							<div class="uk-position-center uk-panel"></div>
						</div>
					</li>

					<li>
						<div class="uk-panel">
							<img src="<?php echo base_url('assets/images/company2.PNG') ?>" alt="">
							<div class="uk-position-center uk-panel"></div>
						</div>
					</li>
					<li>
						<div class="uk-panel">
							<img src="<?php echo base_url('assets/images/company3.PNG') ?>" alt="">
							<div class="uk-position-center uk-panel"></div>
						</div>
					</li>
					<li>
						<div class="uk-panel">
							<img src="<?php echo base_url('assets/images/company4.PNG') ?>" alt="">
							<div class="uk-position-center uk-panel"></div>
						</div>
					</li>
				</ul>

				<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
				<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

			</div>
			<!---------------------->

			<!---------TikTok-Services-------------------->
			<div class="services uk-section" uk-grid>
				<?php  ?>
				<div class="uk-width-1-2@s">
					<div class="uk-card">
						<div class="content">
							<h5>Top</h5>
							<h3>Never-Ending <br>Services For Tiktok</h3>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
							<ul class="uk-list uk-flex tiktok-serve">
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-likes'); ?>"><span class="spanbtn">buy likes</span></a>
								</li>
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-followers'); ?>"><span class="spanbtn">buy followers</span></a>
								</li>
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-views'); ?>"><span class="spanbtn">buy views</span></a>
								</li>
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-comments'); ?>"><span class="spanbtn">buy comments</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="uk-width-1-2@s img-end">
					<div class="uk-card">
						<img src="<?php echo base_url('assets/images/tablet.webp') ?>" alt="">
					</div>
				</div>
			</div>
			<!--------------------------------------------------->


			<!-------------LiveStreaming-Services--------------->
			<div class="services uk-section" uk-grid>
				<div class="uk-width-1-2@s img-center">
					<div class="uk-card">
						<img src="<?php echo base_url('assets/images/Group359.webp') ?>" alt="">
					</div>
				</div>
				<div class="uk-width-1-2@s">
					<div class="uk-card">
						<div class="content">
							<h3>Introducing Tiktok <br><span> Live Streaming </span><br>Services</h3>
							<h5>New</h5>
							<h3>Tiktok Live Stream</h3>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
							<ul class="uk-list uk-flex tiktok-serve live-streaming-sec">
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-livestreamviews') ?>"><span class="spanbtn">buy live streaming views</span></a>
								</li>
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-videoshares') ?>"><span class="spanbtn">buy video shares</span></a>
								</li>
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-postshares') ?>"><span class="spanbtn">buy post shares</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--------------------------------------------------->

			<!---------TikTok-Auto-Services-------------------->
			<div class="services uk-section" uk-grid>
				<div class="uk-width-1-2@s">
					<div class="uk-card">
						<div class="content">
							<h5>New</h5>
							<h3>Tiktok Auto Services</h3>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
							<h4>Lorem Ispum</h4>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industryLorem Ipsum has been the industry's standard dummy text ever since the 1500s..</p>
							<ul class="uk-list uk-flex tiktok-serve">
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-autolikes'); ?>"><span class="spanbtn">buy auto likes</span></a>
								</li>
								<li>
									<a class="serv-btn" href="<?php echo base_url('buy-tiktok-autoviews'); ?>"><span class="spanbtn">buy auto views</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="uk-width-1-2@s img-end">
					<div class="uk-card">
						<img src="<?php echo base_url('assets/images/mobiles.webp') ?>" alt="">
					</div>
				</div>
			</div>
			<!--------------------------------------------------->

		</div>
	</div>

	<!------------Features------------------------------->
	<div class="features uk-section">
		<div class="feature-watermark-one">
			<img src="<?php echo base_url('assets/images/righthex.PNG') ?>">
		</div>
		<div class="feature-watermark-two">
			<img src="<?php echo base_url('assets/images/left-hex.PNG') ?>">
		</div>
		<div class="uk-container">
			<div class="" uk-grid>
				<div class="feature-heading uk-width-3-4@s">
					<h4>Extraordinary Features</h4>
					<h3>Why Us? And No One Else!</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
				</div>
			</div>
			<div class="uk-child-width-1-3@s uk-child-width-1-5@m uk-text-center uk-flex-center" uk-grid>
				<?php foreach($feature_data as $val){ ?>
					<div>
						<div class="uk-card feature-content">
							<div class="feature-content-overlay">
								<h3><?php echo '0'.$val['feature_id']; ?></h3>
								<h4><?php echo $val['feature_title']; ?></h4>
								<p><?php echo $val['feature_body']; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
				
			</div>
		</div>
	</div>
	<!--------------------------------------------------->

	<!----------------Tiktok-signal-image---------------->

	<div id="signal-img-lottie" class="uk-section signals-img">
		<!-- <img src="images/Group160.PNG" alt=""> -->
	</div>

	<!--------------------------------------------------->

	<!---------------Testimonials------------------------>
	<div class="uk-section testimonials">
		<div class="testimonial-watermark">
			<img src="<?php echo base_url('assets/images/Clientreviewshexagon.PNG') ?>">
		</div>
		<div class="uk-container">
			<div class="testimonial-heading uk-width-3-4@s">
				<h3>Curious About Our Work?</h3>
				<h4>Let's hear from our clients</h4>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
			</div>

			<!---------Testimonial-Slider----------->

			<div class="custom-slider" uk-slider="autoplay: false">

				<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

					<ul class="uk-slider-items uk-child-width-1-1@s uk-grid">
						<?php foreach($data as $val){
							$img = $val['profile_photo_url'];
							$author_name = $val['author_name'];
							$rating = $val['rating'];
							$active = $val['active'];
							if($active == 1){
								?>
								<li>
									<div class="uk-card uk-card-default uk-flex testimonial-slide">
										<div class="uk-card-media-top agent uk-width-1-4@s">
											<img src="<?php echo $img ;?>" alt="">
										</div>
										<div class="uk-card-body uk-width-3-4@s">
											<h3 class=""><?php echo $author_name; ?></h3>
											<ul class="uk-list">
												<li class="uk-list custom-rating"><?php for($i = 1; $i <= $rating; $i++){ ?>
													<img class="svg_stype"
													src="<?php echo base_url('assets/images/1289679474.svg') ?>"
													alt="triangle with all three sides equal"/>
												<?php } ?>
											</li>
											<li><span><?= date('j F Y', strtotime($val['updated_time'])) ?></span></li>
										</ul>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
									</div>
								</div>
							</li>
						<?php } } ?>
						
					</ul>

					<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
					<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

				</div>

				<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

			</div>

			<!-------------------------------------->

		</div>
	</div>
	<!--------------------------------------------------->

	<!----------------Statisfied-Sec--------------------->

	<div class="statisfied-sec uk-section">
		<div class="uk-container">
			<div class="statisfied-sec-heading">
				<h3 class="uk-text-center">Satisfied With Us? <br>Lets Begin with one of our services</h3>
				<p class="uk-text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
			</div>
			<div class="statisfied-sec-box" uk-grid>
				<?php foreach($service_data as $key => $val){ ?>
					<div class="uk-width-1-3">
						<div class="uk-card">
							<?php if($key == 0){?>
								<img src="<?php echo base_url('assets/images/Asset5.PNG') ?>" alt="">	
								<?php
							} 
							else if($key == 1){?>
								<img src="<?php echo base_url('assets/images/Asset4.PNG') ?>" alt="">	
								<?php
							}
							else if($key == 2){?>
								<img src="<?php echo base_url('assets/images/Asset6.PNG') ?>" alt="">	
								<?php
							}
							?>
							
							<div class="statisfied-sec-content">
								<span><?php echo $val['cat_name']; ?></span>
								<h4><?php echo $val['service_title']; ?> <br>Services</h4>
								<p><?php echo $val['service_body']; ?></p>
								<a class="serv-btn" href="#"><span class="spanbtn">buy now</span></a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="whiteBg">
		</div>
	</div>

	<!--------------------------------------------------->

	<div class="coupon-sec">
		<div class="coupon uk-width-1-2@s uk-align-center">
			<h3>Apply for a coupon </h3>
			<form class="uk-margin">
				<div class="">
					<input class="apply_cop_email uk-input" type="text" placeholder="Enter your email">
				</div>
				<div>
					<a class="serv-btn" href="javascript:void(0)"><span class="spanbtn">Submit</span></a>
				</div>
				<div class="error" style="height: 10px;"></div>
			</form>
			
		</div>
	</div>

	<?php $this->load->view('layouts/footer'); ?>