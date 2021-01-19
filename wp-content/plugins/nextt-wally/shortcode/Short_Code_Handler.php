<?php

namespace Nextt_Wally\ShortCode;

/**
 * Class Wally
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Short_Code_Handler
{

    /**
     * @var string
     */
    private $wally_post_type = 'wally-gallery';

    /**
     * @var string
     */
    private $wally_default_taxonomy = 'wally-category';

    /**
     * class intializer
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Add wordpress actions
     */
    public function actions(){
        add_shortcode( 'wally', array($this, 'wally') );
    }

    /**
     * -- Action Function --
     * Generate the shortcode
     * @param $args
     * @param $content
     * @return string
     */
    public function wally($args, $content){

        $html = '';

        // ARGS
        $category = $args['category'];

        $heading = $args['button'];
        $sec_heading = $args['sec_heading'];
        $cover_image = $args['cover'];
        $display = $args['display'];

        // Get all images from custom post type
        // Create the query to get all posts from gallery custom post type
        if($category != null){


            $args = array(
                'post_type' => array($this->wally_post_type),
                'posts_per_page' => 10000,
                'orderby'     => 'menu_order',
                'order'     => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'wally-category',
                        'field' => 'slug',
                        'terms' => array($category)
                    )
                )
            );

            $the_query = new \WP_Query( $args );

        }else{

            return null;

        }


//        <div id="lightgallery">
//  <a href="img/img1.jpg">
//      <img src="img/thumb1.jpg" />
//  </a>
//  <a href="img/img2.jpg">
//      <img src="img/thumb2.jpg" />
//  </a>
//  ...
//</div>
        // Loop and get the posts from custom post type
        if ($the_query->have_posts()){


            $category_id = $category;

            $html = $html . '<div id="lightgallery_'.$category_id.'" class="lightgallery" >';


            while ( $the_query->have_posts() ) {


                // THIS LINE STAY ALWAYS HERE AT TOP
                // activate the current post
                $the_query->the_post();

                        // Get thumnail url
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->post->ID), 'gallery_main' );
                $medium = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->post->ID), 'medium' );

                $url = $thumb['0'];

                $img_id = get_post_thumbnail_id(get_the_ID());
                $img_alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $html = $html . '<a href="'.$thumb[0].'" data-sub-html="'.$the_query->post->post_title.'"  >';
                $html = $html . '<div class="gallery_box" style="background: url('.$medium[0].')">';
                //$html = $html . '<div class="gallery_img_holder">';
                //$html = $html . '<img src="'.$medium[0].'" alt="'.$img_alt_text.'" />';
                //$html = $html . '<span class="hoverlay"><i class="fa fa-link"></i> </span>';
                //$html = $html . '</div>';
                //$html = $html . '<span class="caption">'.get_the_title().'</span>';
                $html = $html . '</div>';
                $html = $html . '</a>';

//                $html = $html . '<div
//                     class="'.$category_id.' wally-img"
//                     src="'.$url.'"
//                     title="'.$the_query->post->post_title.'"></div>';


            }
            wp_reset_postdata();
        }

        $html = $html.'</div>';
        return $html;

    }

}
