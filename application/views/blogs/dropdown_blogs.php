
<div class="uk-section vertical-blog-sec">
	<div class="uk-container">
		<?php foreach ($alldata as $value) { 
			$body = $value->body;
			$body = htmlspecialchars_decode(stripslashes($body));
			?>
			<div class="blog-article">
				<div class="" uk-grid>
					<div class="uk-width-1-4@m">
						<div class="">
							<a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>">
								<div class="blog-image">
									<img src="<?php echo base_url('assets/images/blog1.PNG') ?>">
								</div>
							</a>
						</div>
					</div>
					<div class="uk-width-3-4@m">
						<div class="">
							<div class="blog-text">
								<div class="blog-published">
									<a href="<?= base_url("category/{$value->cat_name}/1") ?>"><?php echo $value->cat_name; ?></a>
									<p><?php echo date('F j, Y',strtotime($value->created_at)); ?></p>
								</div>
								<a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><h4><?php echo $value->title; ?></h4></a>
								<a class="inside_single_page uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><p><?php echo substr(strip_tags($body), 0, 80) . '...'?></p></a>
								<span><?php echo $value->name; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<a id="loadmoreBlog" class="serv-btn" href="#"><span class="spanbtn">Load More</span></a>
	</div>
</div>
