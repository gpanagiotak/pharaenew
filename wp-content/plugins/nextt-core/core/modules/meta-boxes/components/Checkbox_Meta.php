<?php

/**
 * Class Checkbox_Meta
 *
 * This class generate the code to create and storm metabox values
 *
 * This included into Metabox_Selector()
 *
 * Metabox_Selector class contains all metaboxes type like this one
 *
 */
class Checkbox_Meta implements Meta_Box{


    /**
     * This is the type of meta
     * @var string
     */
    private $type = 'checkbox';

    /**
     * Sample constructor
     */
    function __construct()
    {
    }

    /**
     * This method export the code to create the meta
     * @param $current_meta
     * @param $prfx_stored_meta
     */
    public function display($current_meta, $prfx_stored_meta)
    {

        $meta_data = array(
            'meta_id' => $current_meta['properties']['text-id'],
            'title' => $current_meta['title'],
            'description' => $current_meta['description'],
            'unique_meta' => $current_meta['properties']['text-id'],
            'inputs' => $current_meta['inputs']
        );

        $html = "<p>
            <span class='prfx-row-title'>". _e($meta_data['title'], 'prfx-textdomain') ."</span>
        <div class='prfx-row-content'>";

            for ($j = 0; $j < count($meta_data['inputs']); $j++) {

                $meta_box_id = $meta_data['unique_meta'] . '-' . $meta_data['inputs'][$j]['key'];
                $meta_box_value = $meta_data['inputs'][$j]['value'];
                $meta_box_description = $meta_data['inputs'][$j]['description'];
                $prf = '';
                if (isset ($prfx_stored_meta[$meta_box_id])) {
//                    $prf = checked($prfx_stored_meta[$meta_box_id][0], $meta_box_value);
                }
                if(isset($prfx_stored_meta[$meta_box_id][0]) && $prfx_stored_meta[$meta_box_id][0]){


                    $prf = 'checked="checked"';
                }
                $html = $html . " <div class='". $meta_data['unique_meta']."' ><label for='" . $meta_box_id . "'>
                    <input id='".$meta_box_id."' type='checkbox' name='" . $meta_box_id . "' id='" . $meta_box_id . "'
                           value='" . $meta_box_value . "' " .$prf." />
                    " . $meta_box_description . "
                </label> </div>";

             }

        $html = $html . "</div> </p>";

        echo $html;
    }

    /**
     * This method generate the code to store the data of meta
     * @param $current_meta
     * @param $post_id
     */
    public function store($current_meta, $post_id)
    {
        $meta_data = array(
            'meta_id' => $current_meta['properties']['text-id'],
            'title' => $current_meta['title'],
            'description' => $current_meta['description'],
            'unique_meta' => $current_meta['properties']['text-id'],
            'inputs' => $current_meta['inputs']
        );
        for($j=0; $j <count($meta_data['inputs']); $j++) {

            $meta_box_id = $meta_data['unique_meta'] . '-' . $meta_data['inputs'][$j]['key'];
            $meta_box_value = $meta_data['inputs'][$j]['value'];

            if (isset($_POST[$meta_box_id])) {
                update_post_meta($post_id, $meta_box_id, $meta_box_value);
            } else {
                update_post_meta($post_id, $meta_box_id, '');
            }
        }
    }

    /**
     * return the private type
     * @return string
     */
    public function get_type()
    {
        return $this->type;
    }
}