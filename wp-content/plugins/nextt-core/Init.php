<?php

/*
Plugin Name: Nextt Core
Plugin URI: http://www.advertek.gr
Description: Nextt core framework plugin, contains the necessary files for the nextt umbrella
Author: Advertek
Version: 3.0
Author URI: http://www.advertek.gr
*/

define( 'NEXTT_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEXTT_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once('NexttCore.php');

$nextt = new NexttCore();
