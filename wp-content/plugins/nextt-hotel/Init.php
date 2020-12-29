<?php

/*
Plugin Name: Nextt Hotel
Plugin URI: http://www.advertek.gr
Description: Nextt hotel framework is a full stuck framework created for hotel's needs
Author: Advertek
Version: 2.0
Author URI: http://www.advertek.gr
*/


define( 'NEXTT_HOTEL_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEXTT_HOTEL_URL', plugin_dir_url( __FILE__ ) );

require_once('Nextt_Hotel.php');

$nextt = new Nextt_Hotel();
$nextt->execute();
