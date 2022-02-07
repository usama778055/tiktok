
<small><a href="<?php echo base_url(); ?>">Home</a>/<a class="active" href="#">Tiktok <?php echo $single_data->serviceType; ?></a></small>
<h3>Buy <?php echo $single_data->packageQty; ?> <?php echo $single_data->packageTitle; ?></h3>
<strong><?php echo $single_data->priceUnit; ?> <?php echo $single_data->packagePrice; ?></strong>
<p><?php echo $single_data->package_description; ?></p>
<ul class="uk-list">
    <li>High Quality</li>
    <li>Active and Real Users </li>
    <li>Instant Delivery</li>
    <li>24/7 Support</li>
</ul>
<div class="purchase-btn">
    <a class="serv-btn" href="<?php echo base_url('buy-'.$single_data->packageQty.'-tiktok-'.$single_data->serviceType) ?>"><span onclick='' class="spanbtn">Purchase<br></span></a>
</div>