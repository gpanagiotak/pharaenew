<?php

/**
 * Class Hr
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Hr{

    /**
     * Initialize the class
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Add wordpress actions
     */
    public function actions(){
        add_shortcode( 'hr', array($this, 'hr') );
    }

    /**
     * @param $args
     * @param $content
     * @return string
     */
    public function hr($args, $content){
        $html = '<hr>';
        return $html;
    }

}