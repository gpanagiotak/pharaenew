<?php

class Hotel_Distances_Getter {

	private $hotel_distances;

	function __construct(){
		$this->hotel_distances = new Hotel_Distances();
	}

	public function get_hotel_distances(){
		$distances = get_option($this->hotel_distances->store_key);
		if(!$distances) return null;
		$data = [];
		foreach($distances as $key=>$distance){
			$current['text'] = $key;
			$current['data'] = $distance;
			$data[$key] = $current;
		}
		return $data;
	}

}