<?php
/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 020715--
 * Time: 5:23 PM
 */
/**
 * You can get the properties with get_options(<value of $store_key>)
 * included: Generate menu
 */
class Hotel_Setup {

    /**
     * HOTEL FACILITIES
     * (the key to store - retrieve hotel facilities)
     * @var string
     */
    public $store_key = 'hotel_setup';

    /**
     * VIEW FILE
     * The view file (the file contains the form)
     * @var string
     */
    private $view_file = 'View_Hotel_Setup.php';

    /**
     * NAME OF SUBMIT BUTTON
     * Submit button name "should be unique"
     * @var string
     */
    private $submit_button_name = 'save_hotel_setup';


    /**
     * MEDIA OPENER FILER
     * The js file (for loading the popup media)
     * @var string
     */
    private $popup_script = 'popup_script.js';

    /**
     * THE FIELDS
     * Which is the field to store the data
     * @var array
     */
    private $fields = array(
        'hotel_title',
//        'hotel_lat' ,
//        'hotel_long' ,
        'hotel_address' ,
        'hotel_link_to_map' ,
        'hotel_tel_1' ,
        'hotel_tel_2' ,
        'hotel_tel_3',
        'hotel_fax_1',
        'hotel_fax_2',
        'hotel_email_1' ,
        'hotel_email_2' ,
        'hotel_gnto' ,
        'hotel_copyright' ,
        'hotel_short_description',
        'hotel_logo',
    );

    /**
     * Send params to view
     * @var array
     */
    public static $view = array();

    /**
     * Initialize the object
     * Add the popup_script to admin
     */
    function __construct(){
        $this->store_key = $this->store_key.ICL_LANGUAGE_CODE;
	    add_action('admin_enqueue_scripts', array($this, 'load_popup_script'));
    }

    /**
     * Load the functions
     */
    function load(){
        $this->action();
        $this->save();
        $this->load_view();
    }

    /**
     * Set the options according to $fields
     * get values from database
     */
    private function action(){


        Hotel_Setup::$view = get_option($this->store_key);
		$count = count(Hotel_Setup::$view);
	    if(Hotel_Setup::$view == null || $count <= 0){
			$this->define_view_data(null);
	    }

    }

    /**
     * Load the script to open the popup
     */
    public function load_popup_script(){
        wp_enqueue_script('hotel-setup-js',  NEXTT_HOTEL_URL.'/hotel/options/hotel-setup/'.$this->popup_script);
    }

    /**
     * Save the $fields into database
     */
    private function save(){

        // If submit button pressed
        if (isset($_POST[$this->submit_button_name])) {

            // Foreach field get and sasve the data
            foreach($this->fields as $field){
                if(isset($_POST[$field]))
                    Hotel_Setup::$view[$field] = esc_attr($_POST[$field]);
                else
                    Hotel_Setup::$view[$field] = null;
            }

            // Finally update the options
            update_option($this->store_key, Hotel_Setup::$view);


        }

    }

	public function define_view_data($overwrite){

		foreach($this->fields as $field){
			Hotel_Setup::$view[$field] = null;
		}

		if($overwrite){
			Hotel_Setup::$view = $overwrite;
		}
	}

    /**
     * Load the view
     */
    private function load_view(){
        require_once realpath(dirname(__FILE__)).'/'. $this->view_file;
    }


}
