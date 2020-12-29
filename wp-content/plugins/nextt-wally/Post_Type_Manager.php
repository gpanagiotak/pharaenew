<?php

namespace Nextt_Wally;

/**
 * Class Post_Type_Manager
 * @package Wally
 *          Create the post type
 */
class Post_Type_Manager
{

    /**
     * @var string
     */
    public static $POST_TYPE_KEY = 'wally-gallery';

    /**
     * @var string
     */
    public static $POST_TYPE_CATEGORY = 'wally-category';

    /**
     * Keep the post types
     * @var array
     */
    private $post_types = array();

    /**
     * Initialize the object
     * @param $params
     */
    public function __construct($params){
        $this->set_properties($params['add']);
    }
    
    /**
     * The hurt of class
     */
    public function actions(){
        $this->create_post_type();
        $this->add_custom_post_type();
    }

    /**
     * Set the properties
     * @param mixed $properties
     */
    private function set_properties($properties) {
        foreach($properties as $property){
            $this->properties[] = $property;
        }
    }

    /**
     * Set the post type private type
     */
    private function create_post_type(){
        $this->post_types = array(
            array(
                'key'  => self::$POST_TYPE_KEY,
                'name' => __('Wally Gallery', 'nextt'),
                'taxonomies' => array(array(self::$POST_TYPE_CATEGORY, 'Wally Categories')),
                'categories' => false,
                'publicly_queryable' => false
            )
        );
    }

    /**
     * Add post types
     */
    private function add_custom_post_type(){
        new \Post_Types($this->post_types);
    }

}