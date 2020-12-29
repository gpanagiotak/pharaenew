<?php

class Hotel_Useful_Phones_Getter {


	private $hotel_useful_phones;

	function __construct(){
		$this->hotel_useful_phones = new Hotel_Useful_Phones();
	}

	public function get_hotel_useful_phones(){
		$data = [];
		$phones = get_option($this->hotel_useful_phones->store_key);
		if(!$phones) return null;

		foreach($phones as $key=>$phone){
			$current_phone['text'] = $key;
			$current_phone['data'] = explode(',', $phone);
			$data[$key] = $current_phone;
		}
		return $data;
	}

}