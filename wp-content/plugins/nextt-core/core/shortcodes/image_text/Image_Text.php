<?php


/**
 * Class Image_Text
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Image_Text{

    /**
     * Initilize the object
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Initialize the shortcode
     * shortcode type
     * [imagetext text="this is a sample text"][/imagetext]
     */
    public function actions(){
        add_shortcode( 'imagetext', array($this, 'imagetext') );
    }

    /**
     * @param $args
     * @param $content
     * @return string
     */
    public function imagetext($args, $content){
        $html = '';
        $img_url = $args['img'];
        $img_width = $args['imgwidth'];
        $conent_width = $args['contentwidth'];
        $html = $html . '<div class="imagetext"><div class="imagetext_image" style="width:'.$img_width.'; background: url('.$img_url.') no-repeat center center;"></div><div class="imagetext_content" style="width:'.$conent_width.'">'.$content.'</div></div> ';
        return $html;
    }

}