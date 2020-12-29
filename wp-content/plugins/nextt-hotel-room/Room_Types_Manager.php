<?php

namespace Nextt_Hotel_Room_Type;

/**
 * Class Room_Types
 */
class Room_Types_Manager {

    public static $POST_TYPE_CATEGORY = 'room-category';


    private $post_type_params;


    /**
     * Set the prefix of metaboxes ($pref + 'key' = the metaboxes id)
     * @var string
     */
    public $meta_boxes_facilities_key_pref = 'room-facilities';

    /**
     * Set the metaboxes checkbox inputs
     * @var array
     */
    public $meta_boxes_facilities_inputs ;

    /**
     * Structure of metaboxes
     * @var array
     */
    private $metabox_generator_params;

    /**
     * Meta Box Generator Object
     * @var
     */
    private $metabox_generator;

    /**
     * General Metaboxes
     * @var
     */
    private $general_metaboxes;

    private $general_metaboxes_pref = array(
        'title' => 'room_title',
        'subtitle' => 'room_subtitle',
        'room_image' => 'room_image',
        'room_gallery' => 'room_gallery',
        'room_sec_gallery' => 'room_sec_gallery'
    );

	public static $post_type_key = 'room';

    /**
     * Initialize the Object
     */
    function __construct(){

		$this->post_type_key = $this->post_type_key.ICL_LANGUAGE_CODE;

	    $this->post_type_params = array(
		    array(
			    'key'  => self::$post_type_key,
			    'name' =>  __('Rooms Types', 'nextt'),
//			    'taxonomies' => array('room-categories'),
                'taxonomies' => array(array(self::$POST_TYPE_CATEGORY, 'Room Types Categories')),

                'categories' => false,
			    'show_in_nav_menus' => true
		    )
	    );

        // Define the inputs (icons) metaboxes
        $this->define_facilities_inputs();

        // Define the metaboxes facilities
        $this->define_metaboxes_facilities();

    }

    /**
     * Add hooks to wordpress
     */
    function actions(){
        $this->post_types = new \Post_Types($this->post_type_params);
        $this->metabox_generator = new \Meta_Box_Generator($this->metabox_generator_params);
       	// Call it on load because we want to load the categories of wally
        add_action('wp_loaded', function(){
            // Define general metaboxes
            $this->define_general_metaboxes();
            $this->metabox_generator = new \Meta_Box_Generator($this->general_metaboxes);
        });
    }

    /**
     * Return the metaboxes fields
     * @return array
     */
    public function get_fields(){
        return $this->metabox_generator_params;
    }

    /**
     * Get the facilities inputs
     * @return array
     */
    public function get_facilities_inputs(){
        return $this->meta_boxes_facilities_inputs;
    }

    /**
     * Get the general metaboxes
     * @return mixed
     */
    public function get_general_metaboxes(){
        return $this->general_metaboxes;
    }

    /**
     * Get General Metaboxes Pref
     * @return array
     */
    public function get_general_metaboxes_pref(){
        return $this->general_metaboxes_pref;
    }

    /**
     * Get the general metaboxes
     * (title, subtitle, cover_image)
     * @return array
     */
    private function define_general_metaboxes(){

        $gallery_categories = get_categories (array( 'type'  => 'wally-gallery', 'taxonomy' => 'wally-category' ));

        $wally_list = array(
            array(
                'description' => 'none',
                'value' => null
            )
        );

        foreach($gallery_categories as $gl){
            $wally_list[] = array(
                'description' => $gl->name,
                'value' => $gl->name
            );
        }

        $this->general_metaboxes = array(
            array(
                'id' => 'room_title',
                'title' => __('Room Description', 'nextt'),
                'assign_to' => 'room',
                'generator' => true,
                'data' => array(
                    array(
                        'title' => __('Room Title', 'nextt'),
                        'description' => __('Room Title', 'nextt'),
                        'type' => 'text',
                        'properties' => array(
                            'text-id' => $this->general_metaboxes_pref['title']
                        )
                    ),
                    array(
                        'title' => __('Room Subtitle', 'nextt'),
                        'description' => __('Room Subtitle', 'nextt'),
                        'type' => 'text',
                        'properties' => array(
                            'text-id' => $this->general_metaboxes_pref['subtitle']
                        )
                    ),
                    array(
                        'title' => __('Room Image', 'nextt'),
                        'description' => __('Room Image', 'nextt'),
                        'type' => 'image',
                        'properties' => array(
                            'text-id' => $this->general_metaboxes_pref['room_image']
                        )
                    ),
                    array(
                        'title' => __('Select Gallery', 'nextt'),
                        'description' => __('Select Gallery', 'nextt'),
                        'type' => 'select',
                        'properties' => array(
                            'text-id' => $this->general_metaboxes_pref['room_gallery']
                        ),
                        'inputs' => $wally_list
                    ),
                    array(
                        'title' => __('Select Secondary Gallery', 'nextt'),
                        'description' => __('Select Secondary Gallery', 'nextt'),
                        'type' => 'select',
                        'properties' => array(
                            'text-id' => $this->general_metaboxes_pref['room_sec_gallery']
                        ),
                        'inputs' => $wally_list
                    )
                )
            )
        );
    }

    /**
     * Set the metaboxes facilities
     */
    private function define_metaboxes_facilities(){
        $this->metabox_generator_params  = array(
            array(
                'id' => 'room_facilities',
                'title' => 'Room Facilities',
                'assign_to' => 'room',
                'generator' => true,
                'data' => array(

                    array(
                        'title' => 'Select Room Facilities',
                        'description' => 'Select Room Facilities',
                        'properties' => array(
                            'text-id' => $this->meta_boxes_facilities_key_pref
                        ),
                        'type' => 'checkbox',
                        'inputs' => $this->meta_boxes_facilities_inputs
                ),
                )
            )
        );
    }

    /**
     * Define the metaboxes facilities inputs
     */
    private function define_facilities_inputs(){

		global $rooms_facilities_metaboxes;

		$data = [];

		if(defined('ICL_LANGUAGE_CODE')){
			if (isset($rooms_facilities_metaboxes[ICL_LANGUAGE_CODE])){
				$data = $rooms_facilities_metaboxes[ICL_LANGUAGE_CODE];
			}else{
				$data = $rooms_facilities_metaboxes['en'];
			}
		}

		$this->meta_boxes_facilities_inputs = $data;
    }


}