<?php

/**
 * Class Accordion_Shortcode
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Accordion_Shortcode{

    /**
     * @var string
     */
    private $accordion_css;
    /**
     * @var string
     */
    private $accordion_js;


    /**
     * Initialize the class
     */
    function __construct(){
        $this->accordion_css = '/core/shortcodes/accordion/accordion.css';
        $this->accordion_js = '/core/shortcodes/accordion/accordion.js';
    }

    /**
     * Call the actions for wordpress
     */
    public function actions(){
        add_shortcode( 'accordion', array($this,'accordion_html') );
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_style_accordion'), 10, 1);
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_script_accordion'));
    }

    /**
     * Register the css styles for accordions
     */
    public function enqueue_style_accordion() {
        wp_enqueue_style( 'accordion-shortcode-css', return_the_path($this->accordion_css) );
    }

    /**
     * Register the javascript file for accordions
     */
    public function enqueue_script_accordion() {
        wp_enqueue_script( 'accordion-shortcode-js', return_the_path($this->accordion_js), array(), '1.0.0', true );
    }


    /**
     * Print the html for accordion shortcode
     * @param $attr
     * @param $content
     * @return string
     */
    public function accordion_html($attr, $content){
        $html = '';

        // if this accordion is the first
        if($attr['first'] == 'true'){
            $html = $html.'<div class="accordion">';
        }

        $html = $html.'<h3 class="accordion_header">'.do_shortcode($attr['title']).'</h3>';
        $html = $html.'<div class="accordion_content">'.do_shortcode($content).'</div>';

        // if this accordion is last
        if($attr['last'] == 'true'){
            $html = $html.'</div>';
        }

        return $html;

    }

}