<?php
// basic
//include_once('helpers.php');

function hotel_static_load()
{
    $values = array(

        '/interfaces/translates/Hotel_Facilities_Translation.php',
        '/interfaces/translates/Rooms_Facilities_Translation.php',

        '/hotel/getters/Getter.php',
        '/hotel/getters/Hotel_Facilities_Getter.php',
        '/hotel/getters/Hotel_Option_Getter.php',
        '/hotel/getters/Hotel_Google_Setup_Getter.php',
        '/hotel/getters/Hotel_Travel_Agents_Getter.php',
        '/hotel/getters/Hotel_Socials_Getter.php',
        '/hotel/getters/Hotel_Useful_Phones_Getter.php',
        '/hotel/getters/Hotel_Distances_Getter.php',

        '/hotel/options/hotel-setup/Hotel_Setup.php',
        '/hotel/options/hotel-facilities/Hotel_Facilities.php',
        '/hotel/options/google-setup/Hotel_Google_Setup.php',
        '/hotel/options/hotel-travel-agents/Hotel_Travel_Agents.php',
        '/hotel/options/hotel-socials/Hotel_Socials.php',
        '/hotel/options/hotel-useful-phones/Hotel_Useful_Phones.php',
        '/hotel/options/hotel-distances/Hotel_Distances.php',
        '/hotel/options/Generate_Menu.php',

        '/hotel/options/Options.php',

        '/hotel/Hotel.php',

        '/Hotel_Settings.php',

        '/Nextt_Hotel.php'

    );
    foreach ($values as $value)
    {
        //see if the file exsists
        if (file_exists(get_stylesheet_directory() . '/../' . wp_get_theme() . '/' . $value))
        {
            require_once(get_stylesheet_directory() . '/../' . wp_get_theme() . '/' . $value);
        } elseif (file_exists(get_template_directory() . $value))
        {
            require_once(get_template_directory() . $value);
        } elseif (file_exists(NEXTT_HOTEL_PATH . $value))
        {
            require_once(NEXTT_HOTEL_PATH . $value);
        } else
        {
            echo  "Error: File not found " . $value . " <br>";
        }
    }

}