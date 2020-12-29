<?php

class Nextt_Hotel{

    public function execute(){
        add_action( 'plugins_loaded', array($this, 'initialize'), 100 );
    }

    /**
     * Execute the core modules of nextt
     */
    public function initialize()
    {

        require_once('hotel/autoload.php');

        hotel_static_load();

        $settings = new Hotel_Settings();

        \Page_Templater::get_instance(NEXTT_HOTEL_PATH, array('/templates/page-hotel-home.php' => 'Hotel Home Page'));

        if (!$settings->associations()){
            return;
        };

        new Hotel(get_option('hotel'));

    }

}



