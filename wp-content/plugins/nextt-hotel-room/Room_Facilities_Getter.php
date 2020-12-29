<?php

namespace Nextt_Hotel_Room_Type;

require_once "Room_Types_Manager.php";

/**
 * Class Room_Facilities_Getter
 *
 * Define what data to get
 *
 * include Getter.php
 */
class Room_Facilities_Getter {


    /**
     * @var Room_Types_Manager
     */
    private $room;

    /**
     * Initialize the object
     */
    function __construct(){
        $this->room = new Room_Types_Manager();
    }

    /**
     * Create an array of room facilities
     * Add only checked facilities
     * @param $post_id
     * @return array
     */
    public function get_room($post_id){

        // Get the prefix of metaboxes ($pref + 'key' = the metaboxes id)
        // the .'-' is set from Metaboxe_Generator automaticaly
        $pref = $this->room->meta_boxes_facilities_key_pref.'-';

        // Get only the checkboxes from metaboxes params
        $room_inputs = $this->room->get_facilities_inputs();

        // Get facilities from database
        $stored_facilities = get_post_custom( $post_id );
	    if(!$stored_facilities) return null;

	    $room_checked_facilities = array();

        // For each facility check if hotel has it and push the array room_check_facilities
        foreach($room_inputs as $field){
            $current_key = $pref.$field['key'];

            if(isset($stored_facilities[$current_key]) && $stored_facilities[$current_key][0] == 'checked'){
                $room_checked_facilities[] = $field;
            }
        }

        // Return the room facilities
        return $room_checked_facilities;


    }

    /**
     * Get general post meta
     * @param $post_id
     * @return array
     */
    public function get_room_info($post_id){

        // Get the options keys
        $prefs = $this->room->get_general_metaboxes_pref();

        $inputs = get_post_custom( $post_id );
	    if(isset($inputs) && !$inputs) return null;

        $general_info = array();
	    $general_info[$prefs['title']] = null;
	    $general_info[$prefs['subtitle']]  = null;
	    $general_info[$prefs['room_image']] = null;
	    $general_info[$prefs['room_gallery']] = null;
	    $general_info[$prefs['room_sec_gallery']] = null;

        // set up the return structure
	    if(isset($inputs[$prefs['title']]))
        $general_info[$prefs['title']] = $inputs[$prefs['title']];
	    if(isset($inputs[$prefs['subtitle']]))
        $general_info[$prefs['subtitle']] = $inputs[$prefs['subtitle']];
	    if(isset($inputs[$prefs['room_image']]))
        $general_info[$prefs['room_image']] = $inputs[$prefs['room_image']];
        if(isset($inputs[$prefs['room_gallery']]))
            $general_info[$prefs['room_gallery']] = $inputs[$prefs['room_gallery']];
        if(isset($inputs[$prefs['room_sec_gallery']]))
            $general_info[$prefs['room_sec_gallery']] = $inputs[$prefs['room_sec_gallery']];

        return $general_info;

    }

}