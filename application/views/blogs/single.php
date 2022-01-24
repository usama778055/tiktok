<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title></title>
</head>
<body>
  
  <?php foreach ($data as $key => $value){

    $body = htmlspecialchars_decode(stripslashes($value->body));
    $postSlug = $value->slug;
    $title = $value->title;
    $name = $value->name;
    $created_at = $value->created_at;
    $next_slug = $value->next_slug;
    

    $prev_slug = $value->prev_slug;


    ?>
    <div class="container-sm">
      <div class="pt-3 pb-3">
        <img class="img-fluid" src="<?php echo base_url().'assets/images/blog2.JPG';?>">
      </div>
      <div class="">
        <div class="h3"><?php echo $title; ?></div>
      </div>
      <div class="row">
        <small class="col"><?php echo $name; ?></small>
        <small class="col"><?php echo $created_at; ?></small>
      </div>
    </div>
    <div class="p-4">
      <div class="row">
        <div class="col-sm-8">


          
          <div class="">
            <?php echo $body; ?>
          </div>
          <div class="row">
            <div class="col">
              <?php if($prev_slug != ""){ ?>
                <a class="btn btn-secondary" href="<?php echo base_url('blogs/'.$prev_slug); ?>">previous</a>
              <?php }else{
                echo '';
              } ?>
              
            </div>
            <div>
              <?php if($next_slug != ""){ ?>
                <a class="btn btn-primary" href="<?php echo base_url('blogs/'.$next_slug); ?>">Next</a>
              <?php }else{
                echo "";
              } ?>
              
            </div>
          </div>
        </div>
        <div class="col-1">
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
            <div class="mb-3" style="width: 26rem;">
              <div class="row g-0">
                <div class="col-sm-5">
                  <a class="text-decoration-none" href="<?php echo base_url('blogs/'.$slug); ?>"><small><img style="" src="<?php echo base_url('assets/images/blog2.JPG');?>" class="img-thumbnail" alt="Responsive image"></small></a>
                </div>
                <div class="col ">
                  <div class="">
                    <a class="text-decoration-none" href="<?php echo base_url('blogs/'.$slug); ?>"><div class="h6 card-title text-dark"><?php echo substr(strip_tags($title), 0, 50) . '...'; ?></div></a>
                  </div>
                  <div class="">
                    <div><small><?php echo $name; ?></small></div>
                    <div class=""><a class="text-decoration-none" href="<?php echo base_url('blogs/'.$slug); ?>"><p class="text-dark">Detail</p></a></div>

                  </div>
                </div>
              </div>
            </div>
            <?php
          }
          ?>

        </div>
      </div>


      <?php
    }
    ?>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
</body>
</html>
