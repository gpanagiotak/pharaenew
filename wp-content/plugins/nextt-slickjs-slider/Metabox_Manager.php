<?php

namespace Nextt_SLICKJS_Slider;


class Metabox_Manager
{


    /**
     * Post type name
     * @var string
     */
    private $post_type = '';


    /**
     * Metaboxes structure
     * @var array
     */
    private $metaboxes = array();

    /**
     * Give the name {string} of post type
     *Initialize the object
     *
     * @param $post_type
     */
    function __construct($post_type)
    {
        $this->set_post_type($post_type);
    }

    /**
     * Add wordpress actions
     */
    public function actions()
    {
        $this->define_metaboxes(null);
        new \Meta_Box_Generator($this->metaboxes);
    }

    /**
     * Create the metaboxes structure according to $post_type field
     *
     * @param $overwrite
     */
    private function define_metaboxes($overwrite)
    {

        // define the post id
        $id = "slick-" . $this->get_post_type();
        $this->metaboxes = array(

            array(
                'id' => $id,
                'title' => 'Slick Meta',
                'assign_to' => $this->get_post_type(),
                'data' => array(

                    // TEXTBOXES
                    array(
                        'title' => 'Slick Title',
                        'description' => 'Slick Title',
                        'type' => 'text',
                        'properties' => array('text-id' => 'slick_meta_title')
                    ),
                    // TEXTBOXES
                    array(
                        'title' => 'Slick SubTitle',
                        'description' => 'Slick SubTitle',
                        'type' => 'text',
                        'properties' => array('text-id' => 'slick_meta_subtitle')
                    ),
                    array(
                        'title' => 'Href',
                        'description' => 'Href',
                        'type' => 'text',
                        'properties' => array('text-id' => 'slick_meta_link')
                    ),
                )
            )
        );

        if ($overwrite)
        {
            $this->metaboxes = $overwrite;
        }

    }

    /**
     * Get the post type
     * @return mixed
     */
    public function get_post_type()
    {
        return $this->post_type;
    }

    /**
     * Set the post type
     *
     * @param mixed $post_type
     */
    public function set_post_type($post_type)
    {
        $this->post_type = $post_type;
    }

}