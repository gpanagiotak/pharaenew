<?php


namespace Nextt_Hotel_Room_Type;

require_once "Hotel_Rooms_Settings.php";

/**
 * Class Hotel_Rooms
 * @package Nextt_Hotel_Room_Type
 *          Main plugin class
 */
class Hotel_Rooms
{

    /**
     * @var Hotel_Rooms_Settings
     */
    private $settings;

    /**
     * @var Room_Types_Manager
     */
    private $room_manager;

    /**
     * Hotel_Rooms constructor.
     */
    public function __construct()
    {
        $this->settings = new Hotel_Rooms_Settings();
        $this->room_manager = new Room_Types_Manager();

        \Page_Templater::get_instance(NEXTT_HOTEL_ROOMS_PATH, array(
            '/templates/page-hotel-rooms.php' => 'Hotel Rooms'
        ));

    }

    /**
     * Execute the plugin
     */
    public function execute()
    {
        if (!$this->settings->associations())
        {
            return;
        }

        $this->room_manager->actions();
    }
}