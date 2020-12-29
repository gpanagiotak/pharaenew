<?php

class Hotel_Useful_Phones
{

	/**
	 * NAME OF SUBMIT BUTTON
	 * Submit button name "should be unique"
	 * @var string
	 */
	public static $submit_button_name = 'save_useful_phones';

	/**
	 * Send params to view
	 *
	 * @var array
	 */
	public static $view = array();


	/**
	 * HOTEL USEFUL PHONE NUMBERS
	 * (the key to store - retrieve hotel travel agents)
	 *
	 * @var string
	 */
	public $store_key = 'hotel_useful_phones';


	/**
	 * VIEW FILE
	 * The view file (the file contains the form)
	 *
	 * @var string
	 */
	private $view_file = 'View_Hotel_Useful_Phones.php';


	/**
	 * THE FIELDS
	 * Which is the field to store the data
	 *
	 * @var array
	 */
	private $fields = array(
		'taxi',
		'doctor',
		'hospital',
		'dentist',
		'municipality'
	);


	/**
	 * Initialize the object
	 */
	function __construct() {

	}


	/**
	 * Load the functions
	 */
	function load() {
		$this->actions();
		$this->save();
		$this->load_view();
	}


	/**
	 * Set the options according to $fields
	 * get values from database
	 */
	private function actions() {
		self::$view = get_option( $this->store_key );
		$count = count( self::$view );
		if ( self::$view == null || $count <= 0 ) {
			$this->define_view_data( null );
		}
	}


	/**
	 * Define the fields
	 *
	 * @param $overwrite
	 */
	public function define_view_data( $overwrite ) {
		if ( $overwrite ) {
			self::$view = $overwrite;
			return;
		}
		foreach ( $this->fields as $field ) {
			self::$view[ $field ] = null;
		}
	}


	/**
	 * Save the $fields into database
	 */
	private function save() {

		// If submit button pressed
		if ( isset( $_POST[ self::$submit_button_name ] ) ) {

			// Foreach field get and save the data
			foreach ( $this->fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					self::$view[ $field ] = esc_attr( $_POST[ $field ] );
				} else {
					self::$view[ $field ] = null;
				}
			}

			// Finally update the options
			update_option( $this->store_key, self::$view );
		}
	}


	/**
	 * Load the view
	 */
	private function load_view() {
		require_once realpath( dirname( __FILE__ ) ) . '/' . $this->view_file;
	}

}