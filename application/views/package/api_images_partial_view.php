<?php foreach ($api_images as $key => $value): ?>
    
    <div>
    <div class='gallery-image uk-transition-toggle selected_div' tabindex='0'>
        <img id="img_api_<?php echo $key; ?>" data_id='<?php echo $key; ?>' class='uk-transition-scale-up uk-transition-opaque' src='<?php print_r($value); ?>'>
        <div class='uk-position-bottom uk-overlay-default get_select' style=''>
            <p id='quenty_<?php echo $key; ?>' class='uk-h4 uk-margin-remove putquentity'></p>
        </div>
    </div>
</div>
<?php endforeach ?>
<!--  -->
