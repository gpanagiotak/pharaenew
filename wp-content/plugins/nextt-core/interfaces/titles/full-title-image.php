<?php
if ( has_post_thumbnail() ) {
    $att_img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full-size')[0];
}
?>
<div class="title-full-img-header_full_img" style="background: url(<?=$att_img_url?>) no-repeat center center;-webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">

    <div class="title-full-img-center_header_title">
        <div class="title-full-img-center_header_title_head">
            <h1><?=the_title()?></h1>
        </div>
        <div class="title-full-img-center_header_title_sub_title">
            <p><?=get_post_meta( get_the_ID(), 'sub_title', true );?></p>
        </div>
    </div>

</div>
