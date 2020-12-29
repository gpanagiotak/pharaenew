<?php

//namespace Nextt_SLICKJS_Slider;

require_once "SLICKJS_Assets_Loader.php";
require_once "Metabox_Manager.php";

use Nextt_SLICKJS_Slider\SLICKJS_Assets_Loader;
use Nextt_SLICKJS_Slider\Metabox_Manager;

/**
 * Class Nextt_SLICKJS_Slider
 * @package Nextt_SLICKJS_Slider
 * Main class for SLICKJS Slider plugin
 */
class SLICKJS_Slider
{

    /* arguments to create the custom post type */
    private $args;

    /**
     * @var \Nextt_SLICKJS_Slider\SLICKJS_Assets_Loader
     */
    private $assets_loader;

    private static $post_type_key = 'slickjs';
    private static $post_type_name = 'Slick Slider';
    private static $post_type_taxomomy = 'slick_category';

    /**
     * BX_Slider constructor.
     */
    public function __construct()
    {
        $this->assets_loader = new SLICKJS_Assets_Loader();

        $this->args = array(
            array(
                'key' => self::$post_type_key,
                'name' => self::$post_type_name,
                'taxonomies' => array(array(self::$post_type_taxomomy, 'Categories')),
                'publicly_queryable' => false,
                'show_in_nav_menus' => true,
                'supports' => array('title')
            ));


    }

    /**
     * Execute the bx slider
     */
    public function execute()
    {
        $this->assets_loader->actions();
        new \Post_Types($this->args);


        $meta_boxes = new \Nextt_SLICKJS_Slider\Metabox_Manager(self::$post_type_key);
        $meta_boxes->actions();

    }


    private static function loadslides($the_category)
    {
        $args = array(
            'post_type' => self::$post_type_key,
            'posts_per_page' => 10000,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => self::$post_type_taxomomy,
                    'field' => 'name',
                    'terms' => array($the_category)
                )
            )
        );
        $the_query = new \WP_Query($args);

        return $the_query;
    }


    public static function get_slider_by_category_id($category = '', $template = '', $slide_size = 'slider_main', $mobile_slide_size = 'slider_mobile')
    {

        $slide_size = $slide_size;
        $mobile_slide_size = $mobile_slide_size;
        $query_results = self::loadslides($category);

        if ($template == '') {
            require(NEXTT_SLICKJS_SLIDER_PATH . '/templates/slick.php');
        } else {
            require($template);
        }
    }
}