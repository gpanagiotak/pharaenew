<?php

namespace Nextt_Hotel_Beaches;

require_once "Page_Pattern_Manager.php";
require_once "Hotel_Beaches_Settings.php";

/**
 * Class Hotel_Beaches
 * @package Nextt_Hotel_Beaches
 *          Main call of Hotel Beaches
 */
class Hotel_Beaches 
{
    /**
     * @var Page_Pattern_Manager
     */
    private $page_pattern_manager;

    /**
     * @var Hotel_Beaches_Settings
     */
    private $settings;

    /**
     * Hotel_Beaches constructor.
     */
    public function __construct()
    {
        $this->settings = new Hotel_Beaches_Settings();
        $this->page_pattern_manager = new Page_Pattern_Manager();
    }

    /**
     * Execute the plugin
     */
    public function execute()
    {

        // Check if the nextt core plugin is activated
        if(!$this->settings->associations()) {
            return;
        }
        
        \Page_Templater::get_instance(NEXTT_HOTEL_BEACHES_PATH, array('/templates/page-hotel-beaches.php' => 'Hotel Beaches'));

        $this->page_pattern_manager->actions();
    }

    /**
     * Get hotel beaches info
     * @param $post_id
     *
     * @return array
     */
    public static function get_hotel_beach_info($post_id){
        return (new Hotel_Beach_Getter())->get_hotel_beaches_info($post_id);
    }


}