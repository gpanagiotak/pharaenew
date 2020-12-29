<?php

namespace Nextt_SLICKJS_Slider;


/**
 * Class Assets_Loader
 * @package Nextt_SLICKJS_Slider
 * Load the assets (css and js) for bx slider plugin
 */
class SLICKJS_Assets_Loader
{

    /**
     * Assets_Loader constructor.
     */
    public function __construct()
    {
        
    }

    /**
     * Initialize the aciton
     */
    public function actions()
    {
        add_action( 'wp_enqueue_scripts', array($this, 'load_scripts'), 1, 1);
        add_action( 'wp_enqueue_scripts', array($this, 'load_styles'), 1);

    }

    /**
     * -- Action Function --
     * Load all the javascript files for the bx slider
     */
    public function load_scripts()
    {
        wp_enqueue_script( 'slick-js', NEXTT_SLICKJS_SLIDER_URL.'assets/js/slick.min.js', array('jquery'), '1.0.1', true );
        wp_enqueue_script( 'slick-init-js', NEXTT_SLICKJS_SLIDER_URL.'assets/js/init.js', array(), '1.0.1', true );
    }

    /**
     * -- Action Function --
     * Load all the CSS files for the bx slider
     */
    public function load_styles()
    {
        wp_enqueue_style( 'slick-css', NEXTT_SLICKJS_SLIDER_URL.'assets/css/slick.css' );
        wp_enqueue_style( 'slick-theme-css', NEXTT_SLICKJS_SLIDER_URL.'assets/css/slick-theme.css' );
    }


}