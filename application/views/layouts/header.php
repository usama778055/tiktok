<?php
$this->load->helper('cart');
?>
<!DOCTYPE html>
<html>
<head>
  <title>TikTok</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url('favicon.icon')?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/css/uikit.min.css') ?>" />
  <link href="<?php echo base_url('assets/css/main.css'); ?>" rel="stylesheet" type="text/css">

</head>

<body>
  <header>
    <div class="bgColor-nav">   
      <nav class="uk-container custom-navbar" uk-navbar>
        <div class="uk-navbar">
          <a class="uk-navbar-item uk-logo" href="<?php echo base_url(); ?>">
            <img width="180" src="<?php echo base_url('assets/images/new-logo.png'); ?>"/>
          </a>
        </div>
        <div class="uk-navbar custom-margin">
          <a class="uk-navbar-toggle mobile" uk-navbar-toggle-icon href="#" uk-toggle="target: #offcanvas-nav"></a>
          <!-- <a href="#"><img src="images/Group166.PNG" alt=""></a> -->
          <ul class="uk-navbar-nav uk-navbar desktop">
            <li>
              <a href="#">Tiktok<span uk-icon="chevron-down"></span></a>
              <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                  <li><a href="<?php echo base_url('buy-tiktok-followers'); ?>">TikTok Followers</a></li>
                  <li><a href="<?php echo base_url('buy-tiktok-likes'); ?>">Buy TikTok Likes</a></li>
                  <li><a href="<?php echo base_url('buy-tiktok-views'); ?>">Buy TikTok Views</a></li>
                </ul>
              </div>
            </li>
            <li>
              <a href="<?php echo base_url('blogs') ?>">blogs</a>
            </li>
            <li><a href="<?php echo base_url('faqs') ?>">faqs</a></li>
            <li><a class="aboutus" href="<?php echo base_url('about-us'); ?>">about us</a></li>
            <li><a href="<?php echo base_url('about-us#contact_sec'); ?>">contact us</a></li>
          </ul>
        </div>

        <div class="uk-navbar shoping-cart">
          <ul class="uk-navbar-nav">
            <li class="cartPopup"><a href="javascript:void(0)" onclick="cardfunction()">
					<?php if (show_cart_count()) { ?>
					<span class="uk-badge" style="background-color:#FE2C55 !important;"><?php echo show_cart_count(); ?></span>
					<?php } ?>
					<img  class="popupbtn"  src="<?php echo base_url('assets/images/cart.svg') ?>" alt=""></a>
              <div id="myPopup" class="popupbtn-content">
                <div class="cart-modal">
                  <h3>Your Cart</h3>
                  <div class="custom-bar"></div>
                  <div class="shopping-details">
                    <?php if(!empty($user_data[0])){ ?>
                      <table class="uk-table uk-table-striped">
                        <thead>
                          <tr class="shopping-detail-head">
                            <th>Services</th>
                            <th>Qty</th>
                            <th>Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="shopping-detail-body">
                            <td><?php if(!empty($user_data[0]->serviceType)){ echo 'TikTok'.$user_data[0]->serviceType; } ?></td>
                            <td><?php if(!empty($user_data[0]->packageQty)){ echo $user_data[0]->packageQty; }  ?></td>
                            <td><?php if(!empty($user_data[0]->packagePrice) && !empty($user_data[0]->packagePrice)){ echo $user_data[0]->priceUnit .' '. $user_data[0]->packagePrice; } ?></td>
                          </tr>
                        </tbody>
                      </table>
                    <?php } ?>
                    <div class="cart-btn">
                      <a href="<?= base_url() ?>">I want to shop more</a>
                      <a class="payment-btn" href="<?= base_url('checkout') ?>">Proceed To Payment</a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <div id="offcanvas-nav" class="custom-mobile-menu" uk-offcanvas>
      <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <br/>
        <div class="">
          <ul class="uk-nav uk-padding">
            <li class="uk-parent uk-margin">
              <ul class="uk-nav-parent-icon" uk-nav>
                <li class="uk-parent">
                  <a href="#">tiktok</a>
                  <ul class="uk-nav-sub">
                    <li><a href="#">Sub item</a></li>
                    <li><a href="#">Sub item</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="uk-margin">
              <a href="#">blogs</a>
            </li>
            <li class="uk-margin">
              <a href="#">faqs</a>
            </li>
            <li class="uk-margin">
              <a href="#">about us</a>
            </li>
            <li class="uk-margin">
              <a href="#">contact us</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
