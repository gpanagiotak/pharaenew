<?php

/**
 * Class Radio_Meta
 *
 * This class generate the code to create and storm metabox values
 *
 * This included into Metabox_Selector()
 *
 * Metabox_Selector class contains all metaboxes type like this one
 */
class Radio_Meta implements Meta_Box{

    /**
     * The type of current meta
     * @var string
     */
    private $type = 'radio';

    /**
     * Return the type of current meta
     * @return string
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * Initialize the class
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
        $html = "<p><span class='prfx-row-title'>". _e($meta_data['title'], 'prfx-textdomain')."</span><div class='prfx-row-content'>";
                            
        for ($j = 0; $j < count($meta_data['inputs']); $j++){
            $meta_box_id = $meta_data['unique_meta'];
            $meta_box_value = $meta_data['inputs'][$j]['value'];
            $meta_box_description = $meta_data['inputs'][$j]['description'];
            $pref = '';
            if (isset ($prfx_stored_meta[$meta_box_id])) $pref =checked($prfx_stored_meta[$meta_box_id][0], $meta_box_value);

            $html = $html . "
            <label for='". $meta_box_id ."'>
                <input type='radio' name='". $meta_box_id ."' id='". $meta_box_id ."'
                       value='". $meta_box_value ."' ". $pref .">
                ". $meta_box_description ."
            </label>";
        }
        $html = $html."</div></p>";
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

        for($j=0; $j <count($meta_data['inputs']); $j++) {
            $meta_box_id = $meta_data['unique_meta'];

            if ($current_meta['type'] == 'radio') {

                if( isset( $_POST[ $meta_box_id ] ) ) {
                    update_post_meta( $post_id, $meta_box_id, $_POST[ $meta_box_id ] );
                }
            }
        }
    }
}