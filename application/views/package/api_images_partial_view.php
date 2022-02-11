<?php
	$i=1;
	$uri_array = explode('-', $_SERVER['HTTP_REFERER']);
	$service_type = end($uri_array);
	$auto_services = ['likes', 'comments', 'views'];

	if(in_array($service_type, $auto_services)) {
		foreach ($user['post_links'] as $key => $value) { ?>
			<div data_id='<?php echo $i?>'>
		    <div class='gallery-image uk-transition-toggle selected_div' tabindex='0'>
				<input type="hidden" name="post_id" id="post_id" class="post_id" value="<?php echo $i?>">
				<input type="hidden" name="per_quantity" id="per_quantity" class="per_quantity" value="0">
				<img class='uk-transition-scale-up uk-transition-opaque' src='<?php echo $value; ?>'>
		        <div class='uk-position-bottom uk-overlay-default get_select' style=''>
		            <p id='quenty_<?php echo $i; ?>' class='uk-h4 uk-margin-remove putquentity'></p>
		        </div>
		    </div>
			</div>
		<?php $i++;
		} 
	}
	else 
	{ ?>
		<div class="folworder">
		  <div class="folworderdta">
		    <div class="flwuser">
		      <div id="profile_overlay" class="profile_overlay">
		        <div uk-spinner="ratio: 2" class="uk-icon uk-spinner" style="display: none"><svg width="60" height="60" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" cx="15" cy="15" r="14" style="stroke-width: 0.5px;"></circle></svg>
		        </div>
		      </div>
		      <div id="ig_profile_thumb" class="ig-pp"></div>
		      <p id="ig-d-fullname" class="numpost uk-margin-remove uk-text-lead">The Rock</p>
		      <p id="ig-d-username" class="ighndl uk-margin-remove uk-text-meta">@therock</p>
		    </div>
		    <div class="uk-column-1-3 uk-column-divider uk-margin-top">
		      <div class="">
		        <p id="ig-post-count" class="numpost uk-margin-small uk-text-bold font-pm">100</p>
		        <p class="nphed uk-margin-remove">Posts</p>
		      </div>
		      <div class="">
		        <p id="ig-followers-count" class="numpost uk-margin-small uk-text-bold font-pm">48.3M</p>
		        <p class="nphed uk-margin-remove">Followers</p>
		      </div>
		      <div class="">
		        <p id="ig-following-count" class="numpost uk-margin-small uk-text-bold font-pm">3</p>
		        <p class="nphed uk-margin-remove">Following</p>
		      </div>
		    </div>
		  </div>
		</div>
<?php } ?>