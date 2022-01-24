<?php $this->load->view('layouts/header'); ?>
<div class="uk-section blog-banner custom-padding-top">
  <div class="blog-banner-content uk-text-center">
    <h3>Hello World</h3>
    <p>Top Articles to Read</p>
  </div>
</div>

<!--------------------Blog-------------------->

<div class="uk-section blog-sec">
  <div class="uk-container">
    <div class="blog-sec-heading">
      <h3>Latest</h3>
      <p>Lorem Ipsum is simply dummy text of the printing.</p>
    </div>
    <div class="blog-panel">

      <?php
      $leng = 0;


      foreach ($result as $value) {
        if($leng == 0){

          $body = $value->body;
          $body = htmlspecialchars_decode(stripslashes($body));
          ?>
          <div class="uk-grid-collapse uk-child-width-expand@m uk-margin-large-top big-blog-article" uk-grid>
            <div>
              <a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>">
                <div class="blog-image">
                  <img src="<?php echo base_url('assets/images/blog1.PNG') ?>">
                </div>
              </a>
            </div>
            <div>
              <div class="blog-content">
                <div class="blog-published">
                  <a href="<?= base_url("category/{$value->cat_name}/1") ?>"><?php echo $value->cat_name; ?> </a>
                  <p><?php echo date('F j, Y',strtotime($value->created_at)); ?></p>
                </div>
                <a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><h4><?php echo $value->title; ?></h4></a>
                <a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><p><?php echo substr(strip_tags($body), 0, 80) . '...'?></p></a>
                <span><?php echo $value->name; ?></span>
              </div>
            </div>
          </div>
          <div class="uk-child-width-1-2@s uk-child-width-1-3@m small-blog-article" uk-grid>

            <?php

          }else{
            $data = $result[$leng];
            $name = $data->name;
            $title = $data->title;
            $slug = $data->slug;
            $meta_des = $data->meta_description;
            $status = $data->status;
            $body = $data->body;
            $body = htmlspecialchars_decode(stripslashes($body));
            $post_image = $data->post_image;
            $post_thumb = $data->post_thumbnail;
            $created_at = $data->created_at;
            ?>
            <div>
              <a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>">
                <div class="blog-image">
                  <img src="<?php echo base_url('assets/images/blog2.JPG') ?>">
                </div>
              </a>
              <div class="blog-text">
                <div class="blog-published">
                  <a href="<?= base_url("category/{$value->cat_name}/1") ?>"><?php echo $value->cat_name; ?></a>
                  <p><?php echo date('F j, Y',strtotime($value->created_at)); ?></p>
                </div>
                <a class="uk-link-heading" href="<?= base_url("blogs/{$value->slug}") ?>"><h4><?php echo $title; ?></h4></a>
                <a class="uk-link-heading" href="<?= base_url("blogs/{$slug}") ?>"><p><?php echo substr(strip_tags($body), 0, 40) . '...'?> </p></a>
                <span><?php echo $name; ?></span>
              </div>
            </div>

            <?php


          }
          $leng++;
        } ?>

      </div>
    </div>
    <div class="uk-pagination uk-flex-center">
      <?php echo($links);?>
    </div>
  </div>
</div>
<?php $this->load->view('layouts/footer'); ?>