<?php

/**
 * Class Functions_js
 * Initialize the javascript theme functions
 */
class Functions_js
{

    /**
     * Initialize the Application
     */
    function __construct()
    {
        $this->insert_inline_js();
    }

    /**
     * Include the javascript file inline to wordpress
     */
    private function insert_inline_js()
    {
        add_action('wp_footer', array($this, 'load_custom_javascript'), 100);
    }

    /**
     * Print the javascript file
     */
    public function load_custom_javascript()
    {

        $script = '<script type="text/javascript">';

//        $script .= '$ = jQuery;';

        $script .= '$(document).ready(function(){';

        // Add the stylesheet url
        $script .= 'var style_path = "' . get_stylesheet_directory_uri() . '";';


        // Load wow js
        if (get_option('load-js-wow')) {
            $script .='new WOW().init();';
        }


        // Load the slider
        //        if(get_option('load-js-bxslider')){
        //            $script = $script.'$(".bxslider").bxSlider('.get_option('bx-slider')['js-options'].');';
        //        }


        if (get_option('shortcode-hidemore')) {
            $script .= '
                jQuery(".hidemore-button").click(function(e) {
                    e.preventDefault();
                    var attr_hidemore = jQuery(this).attr("hidethe");
                    jQuery( "."+attr_hidemore ).slideToggle( "slow", function() {
                        // Animation complete.
                    });
                });
            ';
        }

        // Load the slider
//        $script = $script . 'jQuery(".home-bxslider .bxslider").bxSlider(' . get_option('bx-slider')['js-options'] . ');';

        $script .= ' });';

        $script = $script . '</script>';


        echo $script;

    }
}