<?php

/**
 * Class Fetcher
 */
class Fetcher{

	/**
	 * Initialize the object
	 */
	function __construct(){

	}

	/**
	 * Get theme options data
	 * @return array
	 */
	public static function get_theme_options($with_value = false){
		return (new Fetch_Theme_Options())->reconstruction_data($with_value);
	}

	/**
	 * Get the metaboxes values
	 * @return array
	 */
	public static function get_metaboxes($post_type, $post_id, $with_value = false){
		return (new Fetcher_Metaboxes())->get_metaboxes($post_type, $post_id, $with_value);
	}

	/**
	 * Return the page url
	 * REQUIRE WPML PLUGIN !!!
	 * @param $id
	 * @param $type
	 * @param $params
	 *
	 * @return string
	 */
	public static function get_url($id, $type, $params){
        $page_id = icl_object_id($id, $type,false);
        $page_url = add_query_arg('page_id', $page_id, get_site_url());
		foreach($params as $param){
			$page_url = add_query_arg($param['key'], $param['value'], $page_url);
		}
		return $page_url;
   }

	/**
	 * Get the url params
	 * @param $param
	 *
	 * @return string|void
	 */
	public static function get_url_params($param){
		return esc_attr($_GET[$param]);
	}

}