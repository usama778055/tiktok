<div class="uk-section popular-blog-slider">
	<div class="uk-container">
		<h3>Popular</h3>
		<div class="" uk-slider>

			<div class="uk-position-relative uk-visible-toggle" tabindex="-1">

				<ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-grid">
					<?php foreach ($featured as $key => $value){
						$body = $value->body;
						$body = htmlspecialchars_decode(stripslashes($body));
						?>
						<li>
							<div>
								<a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>">
									<div class="blog-image">
										<img src="<?php echo base_url('assets/images/blog2.JPG') ?>">
									</div>
								</a>
								<div class="blog-text">
									<div class="blog-published">
										<a href="<?= base_url("category/{$value->cat_name}/1") ?>"><?php echo $value->cat_name; ?></a>
										<p><?php echo date('d/m/Y',strtotime($value->created_at)); ?></p>
									</div>
									<a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><h4><?php echo $value->title; ?></h4></a>
									<a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><p><?php echo substr(strip_tags($body), 0, 40) . '...'?></p></a>
									<span><?php echo $value->name; ?></span>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>

				<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
				<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

			</div>

			<!-- <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul> -->

		</div>
	</div>
</div>