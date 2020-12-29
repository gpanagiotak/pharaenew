<?php
/*
Plugin Name: Nextt SlickJs Slider
Plugin URI: http://www.advertek.gr
Description: Nextt SlickJs Slider is a custom post type based slider plugin for wordpress
Author: Advertek
Version: 2.0
Author URI: http://www.advertek.gr
*/

define( 'NEXTT_SLICKJS_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEXTT_SLICKJS_SLIDER_URL', plugin_dir_url( __FILE__ ) );

require_once "SLICKJS_Slider_Settings.php";
require_once "SLICKJS_Slider.php";

function initialize_slick_slider()
{



//    /* check dependencies first */
    $settings = new \Nextt_SLICKJS_Slider\SLICKJS_Slider_Settings();
    $settings->associations();

//    echo 'hello';
//    die();

    /* initialize slider */
    $slick_slider = new SLICKJS_Slider();
    $slick_slider->execute();

}




function make_it_statically_callable(){

    /* this is required in order to be able to access its public (static) methods from the theme */
//    require_once('Fetch_SLICKJS_Slider.php');
    require_once('SLICKJS_Slider.php');
    require_once('Mobile_Detect.php');
}

function create_slider_image_size(){

    add_image_size('slider_main', 1920, 800, true);
    add_image_size('slider_mobile', 992, 700, true);

}




add_action( 'init', 'create_slider_image_size', 101 );
add_action( 'plugins_loaded', 'initialize_slick_slider', 101 );
add_action( 'wp_loaded', 'make_it_statically_callable', 101 );



// REMOVE SUPPORTS FROM CUSTOM POST TYPE

//add_action( 'wp_loaded', 'my_remove_post_type_support', 10 );
//function my_remove_post_type_support() {
//    remove_post_type_support( 'slickjs', 'editor' );
//}