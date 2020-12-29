<?php

class Hotel_Travel_Agents_Getter {


	private $hotel_travel_agents;

	function __construct(){
		$this->hotel_travel_agents = new Hotel_Travel_Agents();
	}

	public function get_travel_agents_options(){
		$agents = get_option($this->hotel_travel_agents->store_key);
		if(!$agents) return null;

		$data = [];
		foreach($agents as $key=>$agent){
			$current['text'] = $key;
			$current['data'] = $agent;
			$data[$key] = $current;
		}
		return $data;
	}

}