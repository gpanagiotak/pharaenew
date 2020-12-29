<?php

/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 100715--
 * Time: 1:25 PM
 */
class Hotel_Google_Setup {

	/**
	 * NAME OF SUBMIT BUTTON
	 * Submit button name "should be unique"
	 *
	 * @var string
	 */
	public static $submit_button_name = 'save_hotel_google_setup';
	/**
	 * Send params to view
	 *
	 * @var array
	 */
	public static $view = array();
	/**
	 * HOTEL GOOGLE SETUP
	 * (the key to store - retrieve hotel google setup)
	 *
	 * @var string
	 */
	public $store_key = 'hotel_google_setup';
	/**
	 * VIEW FILE
	 * The view file (the file contains the form)
	 *
	 * @var string
	 */
	private $view_file = 'View_Hotel_Google_Setup.php';
	/**
	 * THE FIELDS
	 * Which is the field to store the data
	 *
	 * @var array
	 */
	private $fields = array(
		'hotel_google_lat',
		'hotel_google_long',
		'hotel_google_analytics',
	);

	/**
	 * Initialize the object
	 * Add the popup_script to admin
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


		Hotel_Google_Setup::$view = get_option( $this->store_key );

		$count = count( Hotel_Google_Setup::$view );

		if ( Hotel_Google_Setup::$view == null || $count <= 0 ) {
			$this->define_view_data( null );
		}

	}

	/**
	 * Define the fields
	 *
	 * @param $overwrite
	 */
	public function define_view_data( $overwrite ) {

		foreach ( $this->fields as $field ) {
			Hotel_Google_Setup::$view[ $field ] = null;
		}

		if ( $overwrite ) {
			Hotel_Google_Setup::$view = $overwrite;
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
					Hotel_Google_Setup::$view[ $field ] = esc_attr( $_POST[ $field ] );
				} else {
					Hotel_Google_Setup::$view[ $field ] = null;
				}
			}

			// Finally update the options
			update_option( $this->store_key, Hotel_Google_Setup::$view );


		}

	}

	/**
	 * Load the view
	 */
	private function load_view() {
		require_once realpath( dirname( __FILE__ ) ) . '/' . $this->view_file;
	}


}