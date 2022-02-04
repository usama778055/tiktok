<?php
$slug = array();
 foreach ($alldata as $value) {
	$slug[] = $value->slug; 
	$body = $value->body;
	$body = htmlspecialchars_decode(stripslashes($body));
	?>
	<div class="blog-article">
		<div class="" uk-grid>
			<div class="uk-width-1-4@m">
				<div class="">
					<a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>">
						<div class="blog-image">
							<?php $post_image = file_exists(FCPATH . "assets/blogs_images/{$value->post_image}") ? "{$value->post_image}" : "no_thumbnail.jpg" ?>
							<img width="250" height="150" src="<?php echo base_url("assets/blogs_images/{$post_image}") ?>">
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
		<!-- <div class="push_data"></div> -->
	</div>
<?php } ?>


<?php $last_blog = end($alldata);

if(!empty($last_blog)) { ?>
	<a id="loadmoreBlog" class="serv-btn" data_id="<?php echo $last_blog->slug; ?>" href="#"><span class="spanbtn">Load More</span></a>

<?php } ?>