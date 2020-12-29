<?php

namespace Nextt_Hotel_Beaches;

/**
 * Class Page_Pattern_Manager
 * Create a custom post type with Pattern
 * usage: new Hotel_Beach()
 * include: Hotel.php
 */
class Page_Pattern_Manager {


	public static $PATTERN_PREF = array(
		'key' => 'beaches',
		'post_type_title'=> 'Beaches'
	);

	public static $PATTERN_PARAMS;

	private $page_pattern;

	function __construct(){
		self::$PATTERN_PARAMS = \Page_Pattern::define_pref(self::$PATTERN_PREF);
	}

	public function actions(){
		$this->page_pattern = new \Page_Pattern(self::$PATTERN_PREF);
		
		$this->page_pattern->actions();
	}

}