<?php
/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 160415--
 * Time: 8:16 PM
 */

/**
 * Class Column
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Column{

    /**
     * Initialize the application
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Register the shortcode
     */
    public function actions(){
        add_shortcode( 'col', array($this, 'column_shortcode') );
    }

    /**
     * For this shortcode print the html
     * @param $attr
     * @param $content
     * @return string
     */
    public function column_shortcode($attr, $content){
        $html = '';
        if($attr['first']=='true'){
            $html = $html.'<div class="col-md-12">';
        }
        $html = $html.'<div class="col-'.$attr['type'].'-'.$attr['length'].'">'.do_shortcode($content).'</div>';
        if($attr['last']=='true'){
            $html = $html.'</div>';
        }
        return $html;
    }

}