<?php

/*
Plugin Name: Nextt Hotel Rooms
Plugin URI: http://www.advertek.gr
Description: Nextt Hotel Rooms implements feature about hotel's rooms type
Author: Advertek
Version: 2.0
Author URI: http://www.advertek.gr
*/

define('NEXTT_HOTEL_ROOMS_PATH', plugin_dir_path(__FILE__));
define('NEXTT_HOTEL_ROOMS_URL', plugin_dir_url(__FILE__));


require_once "Hotel_Rooms.php";
require_once "Room_Facilities_Getter.php";


function initialize_hotel_rooms_box()
{
    $hotel_rooms = new \Nextt_Hotel_Room_Type\Hotel_Rooms();
    $hotel_rooms->execute();
}

function nextt_hotel_get_room_facilities($post_id)
{
    return (new Nextt_Hotel_Room_Type\Room_Facilities_Getter())->get_room($post_id);
}

function nextt_hotel_get_room_info($post_id)
{
    return (new Nextt_Hotel_Room_Type\Room_Facilities_Getter())->get_room_info($post_id);
}

add_action('plugins_loaded', 'initialize_hotel_rooms_box', 101);
