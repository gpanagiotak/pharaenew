
<?php if ($query_results->have_posts()): ?>
    <div class="single-item_gallery image-container">
        <?php while ($query_results->have_posts()): $query_results->the_post(); ?>

            <?php
            $detect = new Mobile_Detect;

            // Any mobile device (phones or tablets).
            if ( $detect->isMobile() ) {
                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $mobile_slide_size);
            }
            else{
                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $slide_size);
            }

            ?>

            <?php $url = $thumb['0']; ?>
            <div style="background-image:url('<?= $url ?>') ">
                <div class="overlay"></div>
                <img src="<?php echo $url ?>" class="" style="visibility: hidden;" />
                <?php if ((get_post_meta(get_the_ID(),'slick_meta_title',true)) != '') { ?>
                    <div class="image-text">
                            <a href="<?= get_post_meta(get_the_ID(),'slick_meta_link',true); ?>">
                                <?= get_post_meta(get_the_ID(),'slick_meta_title',true); ?>
                            </a>
                    </div>
                <?php } ?>
            </div>

        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
<?php endif; ?>