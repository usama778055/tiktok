<?php
$i=1;
foreach ($user['post_links'] as $key => $value): ?>

	<input type="hidden" name="post_id" id="post_id" class="post_id" value="<?php echo $i?>">
	<input type="hidden" name="per_quantity" id="per_quantity" class="per_quantity" value="0">
    <div data_id='<?php echo $i?>'>
    <div class='gallery-image uk-transition-toggle selected_div' tabindex='0'>
        <img class='uk-transition-scale-up uk-transition-opaque' src='<?php echo $value; ?>'>
        <div class='uk-position-bottom uk-overlay-default get_select' style=''>
            <p id='quenty_<?php echo $key; ?>' data_id='<?php echo $key; ?>' class='uk-h4 uk-margin-remove putquentity'></p>
        </div>
    </div>
</div>
<?php $i++;endforeach ?>
<!--  -->
