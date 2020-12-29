<?php

/**
 * Class Hotel_Option_Grabber
 *
 * Define what data to get
 *
 * include Getter.php
 */
class Hotel_Option_Getter {

	/**
	 * "Store the Hotel Setup object
	 *
	 * @var \Hotel_Setup
	 */
	private $hotel_options;

	/**
	 * Initialize the Object
	 */
	function __construct() {
		$this->hotel_options = new Hotel_Setup();
	}


	/**
	 * Get the Hotel Setup options
	 *
	 * @return mixed|void
	 */
	public function get_options() {
		return get_option( $this->hotel_options->store_key );
	}

}