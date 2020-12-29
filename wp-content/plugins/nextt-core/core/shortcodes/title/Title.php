<?php

/**
 * Class Title
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Title {

    /**
     * Initialize the object
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Add shortcode to wordpress
     */
    public function actions(){
        add_shortcode( 'title', array($this, 'title') );
    }

    /**
     * Generate a shortcode according to this pattern
     * [title
     * type="h1"
     * classes="general_title title_type_1"
     * sub="Sub Title"
     * sub-classes="the-class"
     * sub-type="small"
     * sub-pos="start, end, start-out, end-out"]
     * @param $args
     * @param $content
     * @return string
     */
    public function title($args, $content){

        $html = '';

        // Create the main Title
        $title_start = '<'.$args['type'].' class="'.$args['classes'].'">';
        $title_content = do_shortcode($content);
        $title_end = '</'.$args['type'].'>';

        // Create the sub title
        if($args['subtype']){

            $sub_title_start = '<'.$args['subtype'].' class="'.$args['subclass'].'">';
            $sub_title_content = $args['sub'];
            $sub_title_end = '</'.$args['subtype'].'>';
        }else{

            $sub_title_start = '';
            $sub_title_content = '';
            $sub_title_end = '';
        }


        if($args['subpos'] == 'start'){
            $html = $title_start.$sub_title_start.$sub_title_content.$sub_title_end.$title_content.$title_end;
        }elseif($args['subpos'] == 'end'){
            echo $content;
            $html = $title_start.$title_content.$sub_title_start.$sub_title_content.$sub_title_end.$title_end;
        }elseif($args['subpos']=='start_out'){
            $html = $sub_title_start.$sub_title_content.$sub_title_end.$title_start.$title_content.$title_end;
        }elseif($args['subpos']=='end_out'){
            $html = $title_start.$title_content.$title_end.$sub_title_start.$sub_title_content.$sub_title_end;
        }

        return $html;

    }

}