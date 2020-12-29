<?php

if($post->post_parent)
    $children = get_pages("title_li=&child_of=".$post->post_parent."&echo=0");
else
    $children = get_pages("title_li=&child_of=".$post->ID."&echo=0");
?>


<?php
if ($children): foreach($children as $child): ?>

    <?php if($thumb = wp_get_attachment_image_src( get_post_thumbnail_id($child->ID), 'large' )): ?>
        <a class="get_children_of_parent_link" href="<?=$child->guid?>">
            <div class="row get_children_of_parent">
                <div class="col-sm-4">
                    <img  class="img-responsive get_children_of_parent_img" src="<?=$thumb['0']; ?>">
                </div>
                <div class="col-sm-8 get_children_of_parent_title">
                    <?= $child->post_title?>
                </div>
            </div>
        </a>
        <br>

    <?php else: ?>

        <a href="<?=$child->guid?>">
            <div class="row get_children_of_parent">
                <div class="col-sm-4">
                    <img  class="img-responsive get_children_of_parent_img" src="<?=$thumb['0']; ?>">
                </div>
                <div class="col-sm-8 get_children_of_parent_title">
                    <?= $child->post_title?>
                </div>
            </div>
        </a>
        <br>

    <?php endif; ?>



<?php endforeach; endif; ?>
