<?php

/**
 * Class Div
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Div{

    function __construct(){
        $this->actions();
    }

    public function actions(){
        add_shortcode( 'div', array($this, 'div') );
    }

    public function div($args, $content){
        $class = '';
        $id = '';
        if(isset($args['id']))
            $id = $args['id'];
        if(isset($args['class']))
            $class = $args['class'];
        $html = '<div class="'.$class.'" id="'.$id.'">'.do_shortcode($content).'</div>';
        return $html;
    }

}