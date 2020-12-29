<?php

class Hotel_Socials_Getter {

	private $hotel_social;

	function __construct(){
		$this->hotel_social = new Hotel_Socials();
	}

	public function get_hotel_socials(){
		$socials = get_option($this->hotel_social->store_key);
		if(!$socials) return null;

		$data = [];
		foreach($socials as $key=>$social){
			$current['text'] = $key;
			$current['data'] = $social;
			$data[$key] = $current;
		}
		return $data;
	}

}