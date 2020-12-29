<?php


namespace Nextt_Hotel_Beaches;

require_once "Page_Pattern_Manager.php";

/**
 * Class Hotel_Beach_Getter
 *
 * Define what data to get
 *
 * include Getter.php
 *
 */
class Hotel_Beach_Getter
{


    /**
     * Initialize the object
     */
    function __construct()
    {

    }

    /**
     * @param $post_id
     *
     * @return array
     */
    public function get_hotel_beaches_info($post_id)
    {

        // Get the options keys
        $prefs = Page_Pattern_Manager::$PATTERN_PARAMS;


        $inputs = get_post_custom($post_id);
        if (!$inputs)
            return null;


        $general_info = array();

        // set up the return structure
        if (isset($inputs[$prefs['meta_title']]))
        {
            $general_info[$prefs['meta_title']] = $inputs[$prefs['meta_title']];

        } else
        {
            $general_info[$prefs['meta_title']] = null;
        }

        if (isset($inputs[$prefs['meta_subtitle']]))
        {
            $general_info[$prefs['meta_subtitle']] = $inputs[$prefs['meta_subtitle']];

        } else
        {
            $general_info[$prefs['meta_subtitle']] = null;

        }

        if (isset($inputs[$prefs['meta_image']]))
        {
            $general_info[$prefs['meta_image']] = $inputs[$prefs['meta_image']];

        } else
        {
            $general_info[$prefs['meta_image']] = null;

        }

        if (isset($inputs[$prefs['meta_gallery']]))
        {
            $general_info[$prefs['meta_gallery']] = $inputs[$prefs['meta_gallery']];

        } else
        {
            $general_info[$prefs['meta_gallery']] = null;

        }

        return $general_info;

    }
    //


}