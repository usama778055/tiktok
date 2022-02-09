
<?php $this->load->view('layouts/header'); ?>

<!-----------Side-Icons---------------------->
<?php $this->load->view('layouts/share_buttons'); ?>
<!------------------------------------------->

<?php foreach ($data as $key => $value){

	$body = htmlspecialchars_decode(stripslashes($value->body));
	$body_strip_slashes = stripslashes($body);
	$body_span_stripped = strip_tags($body_strip_slashes, '<img><a><p><h1><h2><h3><h4><h5><h6><h3>');
	$body_styles_stripped = preg_replace('/(dir=".*?")? (style=".*?")/i', '$1', $body_span_stripped);
	$body_remove_empty_para = preg_replace('/<p><\/p>/i', '', $body_styles_stripped);

	$postSlug = $value->slug;
	$title = $value->title;
	$name = $value->name;
	$created_at = $value->created_at;
	$next_slug = $value->next_slug;
	$prev_slug = $value->prev_slug;

?>
	<div class="uk-section blog-banner">
		<div class="blog-banner-content uk-text-center">
			<h1><?php echo $title; ?></h1>
		</div>
		<div class="single-blog">
			<div class="uk-container">
				<div class="uk-width-3-4@s uk-margin-auto">
					<div class="single-blog-image">
						<?php $post_thumbnail = file_exists(FCPATH . "assets/blogs_images/{$value->post_thumbnail}") ? "{$value->post_thumbnail}" : "no_thumbnail.jpg" ?>
						<img src="<?php echo base_url("assets/blogs_images/{$post_thumbnail}"); ?>">
					</div>
				</div>
				<div class="uk-width-3-4@s uk-margin-auto">
					<div class="single-blog-text">
						<div class="blog-published">
							<a href="<?= base_url("category/{$value->cat_name}/1") ?>"><?php echo $value->cat_name; ?></a>
							<p><?php echo date('F j, Y',strtotime($value->created_at)); ?></p>
						</div>
						<small><?php echo $value->name; ?></small>
						<div class="blogs-body">
							<?php print_r($body_remove_empty_para); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }
?>

<div class="prevNext custom-padding-top">
	<div class="uk-container">
		<ul class="uk-list">
			<li>
				<?php if($prev_slug != ""){ ?>
					<a class="btn btn-secondary" href="<?php echo base_url('blogs/'.$prev_slug); ?>">Previous</a>
				<?php }else{
					echo '';
				} ?>
			</li>
			<li>
				<?php if($next_slug != ""){ ?>
					<a class="btn btn-primary" href="<?php echo base_url('blogs/'.$next_slug); ?>">Next</a>
				<?php }else{
					echo "";
				} ?>
			</li>
		</ul>
	</div>
</div>


<!--------------------Blog-------------------->
<div class="uk-section blog-sec related-art">
	<div class="uk-container">
		<div class="blog-sec-heading">
			<h3>Related Articles:</h3>
		</div>

		<div class="blog-panel">

			<div class="uk-child-width-1-2@s uk-child-width-1-3@m small-blog-article" uk-grid>
				<?php foreach ($alldata as $key => $val){
					$name = $val->name;
					$title = $val->title;
					$slug = $val->slug;
					$meta_des = $val->meta_description;
					$status = $val->status;
					$body = $val->body;
					$body = htmlspecialchars_decode(stripslashes($body));
					$feature = $val->feature;
					$post_image = $val->post_image;
					$post_thumb = $val->post_thumbnail;
					$created_at = $val->created_at;
					$updated_at = $val->updated_at;


					?>
					<div>
						<div class="blog-image">
							<a class="uk-link-heading" href="<?= base_url("blogs/{$slug}") ?>">
								<img src="<?php echo base_url('assets/blogs_images/'.$post_image); ?>">
							</a>
						</div>
						<div class="blog-text">
							<div class="blog-published">
								<a href="<?= base_url("category/{$val->cat_name}/1") ?>"><?php echo $val->cat_name; ?></a>
								<p><?php echo date('F j, Y',strtotime($val->created_at)); ?></p>
							</div>
							<a class="uk-link-heading" href="<?= base_url("blogs/{$val->slug}") ?>"><h4><?php echo $title; ?></h4></a>
							<a class="uk-link-heading" href="<?= base_url("blogs/{$slug}") ?>"><p><?php echo substr(strip_tags($body), 0, 25) . '...'?></p></a>
							<span><?php echo $name; ?></span>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

	</div>
</div>
<!-------------------------------------------->
<?php $this->load->view('layouts/footer'); ?>
