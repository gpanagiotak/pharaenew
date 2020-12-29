<?php

/**
 * Class Hide_More
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Hide_More{

    /**
     * Initialize the class
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Add the action in wordpress
     */
    public function actions(){
        add_shortcode( 'hidemore', array($this, 'hidemore') );
    }

    /**
     * Create the logic for hide_more
     * @param $args
     * @param $content
     * @return string
     */
    public function hidemore($args, $content){
        // $args
        $title = $args['title'];
        $name = $args['name'];
        $html = '';
        $html = $html . '
            <div class="hidemore">
                <a href="" class="hidemore-button" hidethe="'.$name.'">'.$title.'</a>
                <div class="hidemore-text '.$name.'">'.do_shortcode($content).'</div>
            </div>
        ';
        return $html;
    }

}