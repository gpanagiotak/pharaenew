<?php


/**
 * Class Supersized
 *
 * Full slider custom post type
 *
 * if you want to add it check pattern template into interfaces titles
 *
 * usage: new Supersized( array('enable' => true, 'add'=> array()))
 *
 */
class Supersized{

    /**
     * Custom post type structure
     * @var
     */
    private $custom_post_type;

    /**
     * The properties for the slider
     * @var array
     */
    private $properties = array();

    /**
     * Initialize the object
     * @param $params
     */
    function __construct($params){
//        var_dump($params);
//        die();
        if($params['enable'] == false){
            return;
        }
        $this->setProperties(array('supersized-default'));
        $this->pushProperties($params['add']);
        $this->actions();
    }

    /**
     * Create the structure of custom post type and the structure of meta box
     */
    public function actions(){
        $custom_post_type = array(
            array(
                'key'  => 'supersized',
                'name' => __('Supersized Slider', 'nextt'),
                'taxonomies' => $this->properties,
                'categories' => false
            )
        );
        $meta_box = array(
            array(
                'id' => 'supersized-category',
                'title' => 'supersized-category',
                'assign_to' => 'page',
                'generator' => true,
                'data' => array(
                    // TEXTBOXES
                    array(
                        'title' => __('Supersized Category', 'nextt'),
                        'description' => __('Supersized Category', 'nextt'),
                        'type' => 'text',
                        'properties' => array(
                            'text-id' => 'supersized-category'
                        )
                    ),
                )
            )
        );
        $this->create_custom_post_types($custom_post_type);
        $this->create_meta_box($meta_box);
    }

    /**
     * Initialize the custom post type
     * @param $custom_post_type
     */
    public function create_custom_post_types($custom_post_type){
        new Post_Types($custom_post_type);
    }

    /**
     * Initialize the meta box
     * @param $meta_box
     */
    public function create_meta_box($meta_box){
        new Meta_Box_Generator($meta_box);
    }

    /**
     * Set the custom post type
     * @param array $custom_post_type
     */
    public function setCustomPostType($custom_post_type) {
        $this->custom_post_type = $custom_post_type;
    }

    /**
     * Set the properties
     * @param array $properties
     */
    public function setProperties($properties) {
        $this->properties = $properties;
    }

    /**
     * Push the Properties
     * @param $properties
     */
    public function pushProperties($properties){
        foreach($properties as $property){
            $this->properties[] = $property;
        }
    }

}