<?php

/**
 * Interface Meta_Box
 *
 * Inteface contains all require method to have a metabox class
 *
 */
interface Meta_Box{

    /**
     * The constructor
     */
    function __construct();

    /**
     * Display method is the method to display the html code
     * @param $params
     * @param $prfx_stored_meta
     * @return mixed
     */
    public function display($params, $prfx_stored_meta);

    /**
     * Store method, store the meta's data into database
     * @param $params
     * @param $post_id
     * @return mixed
     */
    public function store($params, $post_id);

    /**
     * return the type of meta box
     * @return mixed
     */
    public function get_type();

}