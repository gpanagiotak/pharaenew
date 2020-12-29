<?php

/**
 * Class Button
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Button{

    /**
     *
     */
    function __construct(){
        $this->actions();
    }

    /**
     *
     */
    public function actions(){
        add_shortcode( 'nexttbutton', array($this, 'nexttbutton') );
    }

    /**
     * @param $args
     * @param $content
     * @return string
     */
    public function nexttbutton($args, $content){
        $html = '';
        $class = $args['class'];
        $link = $args['link'];
	    if($args['target']){
		    $html = $html.'<a class="nextt-button '.$class.'" href="'.$link.'" target="'.$args['target'].'">'.$content.'</a>';
	    }else{
		    $html = $html.'<a class="nextt-button '.$class.'" href="'.$link.'">'.$content.'</a>';

	    }
        return $html;
    }

}