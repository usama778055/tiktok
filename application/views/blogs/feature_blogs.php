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