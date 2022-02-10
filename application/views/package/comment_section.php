<!-- <div style="" class="wrap_selected_items" data_id="<?php echo $comments['length']; ?>">
    <h4 class="uk-text-muted">Your Selected Items</h4>
    <div class="selected_items"> -->
        <div id="wrap_selected_items<?php echo $comments['length']; ?>" class="comments_sec">
            <div class="post_area cmntcol">
                <div style="background-image: url(<?php echo $comments['image']; ?>)" class="selected_img" uk-img></div>
            </div>
            <div class="comments_field">
                <div class="wrap_rem_counts uk-clearfix uk-grid">
                    <div class="comments_field-hdr uk-text-muted uk-width-1-2">
                        <span class="comment_length"></span> Comments (1 per line)
                    </div>
                    <div class="comments_field-ftr uk-text-muted uk-width-1-2">
                        Quantity: <span class="count_CQQBSTAlp5s"><?php echo $comments['length']; ?></span> / <span id="comment_quentity<?php echo $comments['length']; ?>" class="total_com"></span>
                    </div>
                </div>
                <textarea placeholder="Write your comments here..." rows="10" cols="50" spellcheck="true" class="com_area com_CQQBSTAlp5s"></textarea>
            </div>
        </div>
    <!-- </div>
</div> -->