<?php

/**
 * Created by PhpStorm.
 * User: christospapidas
 * Date: 080715--
 * Time: 11:04 AM
 */

/**
 *
 * Description
 * This module create a custom post type with some basic metaboxes
 * you can call it like new Page_Pattern(array('key' => 'your key', 'post_type_title' => 'Your Post Type Title'))
 *
 * How can i have acces to metaboxes ?
 *
 * if key is foo then the post type category will be foo-category
 *
 * metabox title = key + '-title'
 * matabox subtitle = key + '-subtitle'
 * metabox image = key + '-image'
 * metabox gallery = key + '-gallery'
 *
 * Class Page_Pattern
 */
class Page_Pattern
{

    /**
     * @var
     */
    private $prefs;

    /**
     * @var
     */
    private $post_type;

    /**
     * @var
     */
    private $metaboxes;


    /**
     * Initialize the object
     *
     * @param $pref array [key => string, post_type_title => string]
     */
    function __construct($pref)
    {
        $this->set_prefs($pref);
        $this->define_posttype(null);
    }

    /**
     * Add actions to wordpress
     */
    public function actions()
    {
        $posttype_object = new Post_Types($this->post_type);
        add_action('wp_loaded', array($this, 'add_metaboxes'));
        // Crate seo fields
        $current_post_type = $this->prefs['key'];
    }

    /**
     * Add the metaboxes
     */
    public function add_metaboxes()
    {
        $this->define_metaboxes(null);
        $metabox_object = new Meta_Box_Generator($this->metaboxes);


    }

    /**
     * Set up the params
     * metabox title = key + '-title'
     * matabox subtitle = key + '-subtitle'
     * metabox image = key + '-image'
     * metabox gallery = key + '-gallery'
     *
     * @param $param
     */
    public function set_prefs($param)
    {
        $this->prefs = array(
            'key' => $param['key'],
            'category' => $param['key'] . '-category',
            'post_type_title' => $param['post_type_title'],
            'meta_title' => $param['key'] . '-title',
            'meta_subtitle' => $param['key'] . '-subtitle',
            'meta_image' => $param['key'] . '-image',
            'meta_gallery' => $param['key'] . '-gallery'
        );
    }

    /**
     * STATIC METHOD
     *
     * Set up the params
     * metabox title = key + '-title'
     * matabox subtitle = key + '-subtitle'
     * metabox image = key + '-image'
     *
     * @param $param
     *
     * @return array
     */
    public static function define_pref($param)
    {
        return array(
            'key' => $param['key'],
            'category' => $param['key'] . '-category',
            'post_type_title' => $param['post_type_title'],
            'meta_title' => $param['key'] . '-title',
            'meta_subtitle' => $param['key'] . '-subtitle',
            'meta_image' => $param['key'] . '-image',
            'meta_gallery' => $param['key'] . '-gallery'
        );
    }

    /**
     * Define the post type
     *
     * @param $overwrite
     */
    public function define_posttype($overwrite)
    {

        $this->post_type = array(
            array(
                'key' => $this->prefs['key'],
                'name' => $this->prefs['post_type_title'],
                'taxonomies' => array(array($this->prefs['category'],$this->prefs['category'])),
                'categories' => false,
                'show_in_nav_menus' => true
            )
        );

        if ($overwrite)
        {
            $this->post_type = $overwrite;
        }

    }

    /**
     * Define the metaboxes
     *
     * @param $overwrire
     */
    public function define_metaboxes($overwrire)
    {

        $this->metaboxes = array(
            array(
                'id' => 'sights_metabox',
                'title' => __('Description', 'nextt'),
                'assign_to' => $this->prefs['key'],
                'data' => array(
                    array(
                        'title' => __('Title', 'nextt'),
                        'description' => __('Title', 'nextt'),
                        'type' => 'text',
                        'properties' => array(
                            'text-id' => $this->prefs['meta_title']
                        )
                    ),
                    array(
                        'title' => __('Subtitle', 'nextt'),
                        'description' => __('Subtitle', 'nextt'),
                        'type' => 'text',
                        'properties' => array(
                            'text-id' => $this->prefs['meta_subtitle']
                        )
                    ),
                    array(
                        'title' => __('Image', 'nextt'),
                        'description' => __('Image', 'nextt'),
                        'type' => 'image',
                        'properties' => array(
                            'text-id' => $this->prefs['meta_image']
                        )
                    )
                )
            )
        );

        if (class_exists('Wally\Post_Type_Manager'))
        {

            $gallery_categories = get_categories(array(
                'type' => Nextt_Wally\Post_Type_Manager::$POST_TYPE_KEY,
                'taxonomy' => Nextt_Wally\Post_Type_Manager::$POST_TYPE_CATEGORY
            ));

            $wally_list = array(
                array(
                    'description' => 'none',
                    'value' => null
                )
            );
            foreach ($gallery_categories as $gl)
            {
                $wally_list[] = array(
                    'description' => $gl->name,
                    'value' => $gl->name
                );
            }
            $wally_support = array(
                'title' => __('Select Gallery', 'nextt'),
                'description' => __('Select Gallery', 'nextt'),
                'type' => 'select',
                'properties' => array(
                    'text-id' => $this->prefs['meta_gallery']
                ),
                'inputs' => $wally_list
            );

            $this->metaboxes[0]['data'][] = $wally_support;

        }


        if ($overwrire)
        {
            $this->metaboxes = $overwrire;
        }

    }

    /**
     * Get the $prefs
     * @return mixed
     */
    public function get_prefs()
    {
        return $this->prefs;
    }

}