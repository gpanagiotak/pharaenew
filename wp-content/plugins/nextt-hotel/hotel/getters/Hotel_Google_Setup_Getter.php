<?php
/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 100715--
 * Time: 7:26 PM
 */

class Hotel_Google_Setup_Getter {

	private $hotel_google_setup;

	function __construct(){
		$this->hotel_google_setup = new Hotel_Google_Setup();
	}

	public function get_google_options(){
		return get_option($this->hotel_google_setup->store_key);
	}

}