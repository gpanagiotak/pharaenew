<?php


/*
Plugin Name: Nextt Hotel Beaches
Plugin URI: http://www.advertek.gr
Description: Nextt hotel plugin for beaches
Author: Advertek
Version: 2.0
Author URI: http://www.advertek.gr
*/

define( 'NEXTT_HOTEL_BEACHES_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEXTT_HOTEL_BEACHES_URL', plugin_dir_url( __FILE__ ) );

require_once "Hotel_Beaches.php";
require_once "Hotel_Beach_Getter.php";

function initialize_hotel_beaches_box()
{
    $hotel_beaches = new \Nextt_Hotel_Beaches\Hotel_Beaches();
    $hotel_beaches->execute();
}

/**
 * Get all post for the beaches
 * 
 * @param $post_id
 *
 * @return array
 */
function nextt_hotel_get_all_beaches_info($post_id){
    $hotel_beaches_getter = new Nextt_Hotel_Beaches\Hotel_Beach_Getter();
    return $hotel_beaches_getter->get_hotel_beaches_info($post_id);
}

add_action( 'plugins_loaded', 'initialize_hotel_beaches_box', 101 );

