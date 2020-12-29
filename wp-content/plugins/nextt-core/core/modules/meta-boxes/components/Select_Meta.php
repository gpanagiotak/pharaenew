<?php


/**
 * Class Select_Meta
 *
 *
 * This class generate the code to create and storm metabox values
 *
 * This included into Metabox_Selector()
 *
 * Metabox_Selector class contains all metaboxes type like this one
 *
 */
class Select_Meta implements Meta_Box{

    /**
     * The type of current meta
     * @var string
     */
    private $type = 'select';

    /**
     * Return the type of current meta
     * @return string
     */
    public function get_type()
    {
        return $this->type;
    }


    /**
     * Do all necessary method to generate the meta
     */
    function __construct()
    {
    }

    /**
     * Display meta html code
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
        $meta_box_id = $meta_data['unique_meta'];
        $html = "<p><span class='prfx-row-title'>". _e($meta_data['title'], 'prfx-textdomain')."</span><div class='prfx-row-content'>
        <select name='". $meta_box_id ."' id='". $meta_box_id ."'>";

        for ($j = 0; $j < count($meta_data['inputs']); $j++){
            $meta_box_id = $meta_data['unique_meta'];
            $meta_box_value = $meta_data['inputs'][$j]['value'];
            $meta_box_description = $meta_data['inputs'][$j]['description'];
            $pref = '';

            if (isset ($prfx_stored_meta[$meta_box_id][0]) && $prfx_stored_meta[$meta_box_id][0] == $meta_box_value){
                $pref = "selected='selected'";
            }
            $html = $html . "<option value='". $meta_box_value ."' ".$pref.">". $meta_box_description."</option>'";

        }
        $html = $html."</select></div></p>";
        echo $html;
    }

    /**
     * Store the meta value into database
     * @param $current_meta
     * @param $post_id
     */
    public function store($current_meta, $post_id)
    {

        $meta_data = array(
            'meta_id' => $current_meta['properties']['text-id'],
            'title' => $current_meta['title'],
            'description' => $current_meta['description'],
            'unique_meta' =>  $current_meta['properties']['text-id'],
            'inputs' => $current_meta['inputs']
        );
        $meta_box_id = $meta_data['unique_meta'];
        for($j=0; $j < count($meta_data['inputs']); $j++) {
            $meta_box_id = $meta_data['unique_meta'];
            if( isset( $_POST[ $meta_box_id ] ) ) {
                update_post_meta( $post_id, $meta_box_id, $_POST[ $meta_box_id ] );
            }
        }
    }
}