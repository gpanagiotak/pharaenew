<?php
/*
Plugin Name: Nextt Wally Gallery
Plugin URI: http://www.advertek.gr
Description: Nextt Wally Gallery is a custom post type based gallery plugin for wordpress
Author: Advertek
Version: 2.0
Author URI: http://www.advertek.gr
*/

define( 'NEXTT_WALLY_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEXTT_WALLY_URL', plugin_dir_url( __FILE__ ) );

require_once "Wally.php";

use Nextt_Wally\Wally;

function initialize_wally()
{
    $wally = new Wally();
    $wally->execute();
}

add_action( 'plugins_loaded', 'initialize_wally', 101 );



function wally_create_slider_image_size(){

    add_image_size('gallery_main', 1920, 800, false);
}

add_action( 'init', 'wally_create_slider_image_size', 101 );