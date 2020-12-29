<?php
/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 020715--
 * Time: 5:23 PM
 */
/**
 * You can get the properties with get_options(<value of $store_key>)
 * included: Generate_Menu.php
 */
class Hotel_Facilities {

    /**
     * HOTEL FACILITIES
     * (the key to store - retrieve hotel facilities)
     * @var string
     */
    public $store_key = 'hotel_facilities';

    /**
     * VIEW FILE
     * (The view file the file contains the form)
     * @var string
     */
    private $view_file = 'View_Hotel_Facilities.php';

    /**
     * ICON CSS FILE
     * (The icons with hotel facilities)
     * @var string
     */
    private $icon_css = 'hotel_icons.css';

    /**
     * NAME OF SUBMIT BUTTON
     * (Submit button name "should be unique")
     * @var string
     */
    private $submit_button_name = 'save_hotel_facilities';


    /**
     * THE FIELDS
     * (Which is the field to store the data)
     * @var array
     */
    private $fields;


    /**
     * Send params to view
     * @var array
     */
    public static $view = array();

    /**
     * Initialize the object
     */
    function __construct(){

        $this->store_key = $this->store_key.ICL_LANGUAGE_CODE;

        $this->set_fields();
//        update_option($this->store_key, array());
        Hotel_Facilities::$view['display'] = $this->fields;
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
        if(count(get_option($this->store_key)) > 0)
            Hotel_Facilities::$view['has'] = get_option($this->store_key);
    }


    /**
     * Save the $fields into database
     */
    private function save(){

        if (isset($_POST[$this->submit_button_name])) {

            Hotel_Facilities::$view['has'] = array();

            foreach($this->fields as $field){
                if(isset($_POST[$field['key']])) {
//                    Hotel_Facilities::$view[$field] = esc_attr($_POST[$field]);
                    Hotel_Facilities::$view['has'][] = array(
                        'class'=> $field['class'],
                        'check' => esc_attr($_POST[$field['key']]),
                        'text' => $field['text'],
                        'key' => $field['key']
                    );
                }else{
                    Hotel_Facilities::$view['has'][] = array(
                        'class'=> $field['class'],
                        'check' => null,
                        'text' => $field['text'],
                        'key' => $field['key']
                    );
                }
            }
            update_option($this->store_key, Hotel_Facilities::$view['has']);

        }

    }

    /**
     * Get the fields (facilities)
     * @return array
     */
    public function get_fields(){
        return $this->fields;
    }


    /**
     * Load the view
     */
    private function load_view(){
        require_once realpath(dirname(__FILE__)).'/'. $this->view_file;
    }

    /**
     * Set the fields
     */
    public function set_fields(){

        global $hotel_facilities_metaboxes;

        $data = [];

        if(defined('ICL_LANGUAGE_CODE')){
            if (isset($hotel_facilities_metaboxes[ICL_LANGUAGE_CODE])){
                $data = $hotel_facilities_metaboxes[ICL_LANGUAGE_CODE];
            }else{
                $data = $hotel_facilities_metaboxes['en'];
            }
        }

        $this->fields = $data;
    }


}
