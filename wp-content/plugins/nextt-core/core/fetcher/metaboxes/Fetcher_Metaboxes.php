<?php

class Fetcher_Metaboxes {

	function __construct(){

	}

	public function get_metaboxes($post_type, $post_id, $with_value = false){
		$data = array();
		$metaboxes = Meta_Box_Generator::$meta_store;
		if($with_value){

			foreach($metaboxes as $meta){
				foreach($meta as $group){
					if($group['assign_to'] == $post_type){
						foreach($group['data'] as $input){
							$data[$input['properties']['text-id']] = array(
								'title' => $input['title'],
								'value' => get_post_meta($post_id, $input['properties']['text-id'], true)
							);
						}
					}
				}
			}
		}else{
			foreach($metaboxes as $meta){
				foreach($meta as $group){
					if($group['assign_to'] == $post_type){
						foreach($group['data'] as $input){
							$data[] = array(
								'title' => $input['title'],
								'value' => get_post_meta($post_id, $input['properties']['text-id'], true)
							);
						}
					}
				}
			}
		}

		return $data;
	}

}