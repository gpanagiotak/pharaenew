<?php
/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 040715--
 * Time: 12:34 PM
 */

/**
 * Class Hotel_Facilities_Grabber
 * Define what data to get
 * include Getter.php
 */
class Hotel_Facilities_Getter
{

    /**
     * Hotel Facilities Object
     * @var \Hotel_Facilities
     */
    private $hotel_facilities;


    /**
     * Initialize the object
     */
    function __construct()
    {
        $this->hotel_facilities = new Hotel_Facilities();
    }


    /**
     * Get the option via store key
     * @return mixed|void
     */
    public function get_hotel_facilities()
    {
        $data = [];
        $hotel_fas = get_option($this->hotel_facilities->store_key);
        if(isset($hotel_fas) && $hotel_fas != null) {
            foreach ($hotel_fas as $fas) {
                if($fas['check'] == 'checked') {
                    $fas['icon'] = "<span class='hotel_icon " . $fas['class'] . "'></span> " . $fas['text'];
                    $data[] = $fas;
                }
            }
        }

        return $data;
    }


}