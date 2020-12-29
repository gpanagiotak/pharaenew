<?php

/**
 * Class Text_Meta
 *
 *
 * This class generate the code to create and storm metabox values
 *
 * This included into Metabox_Selector()
 *
 * Metabox_Selector class contains all metaboxes type like this one
 *
 */
class Textarea_Meta implements Meta_Box{

    /**
     * The type of current meta
     * @var string
     */
    private $type = 'textarea';

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
            'type' => $current_meta['type'],
            'unique_meta' => $current_meta['properties']['text-id'],
            'inputs' => isset($current_meta['inputs'])
        );

        $pref = "";
        if(isset ($prfx_stored_meta[$meta_data['meta_id']]))
        {$pref =  $prfx_stored_meta[$meta_data['meta_id']][0];}

        $html = "
        <p>
            <label for='meta-text'
                   class='prfx-row-title'>".$meta_data['description']."</label>
            <textarea name='". $meta_data['meta_id'] ."'
                   id='". $meta_data['meta_id'] ."'>".$pref."</textarea>
        </p>
        ";
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
            'type' => $current_meta['type'],
            'unique_meta' => $current_meta['properties']['text-id']
        );

        // Checks save status
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['prfx_nonce']) && wp_verify_nonce($_POST['prfx_nonce'], basename(__FILE__))) ? 'true' : 'false';

        // Exits script depending on save status
        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        // Checks for input and sanitizes/saves if needed
        if (isset($_POST[$meta_data['meta_id']])) {
            update_post_meta($post_id, $meta_data['meta_id'], sanitize_text_field($_POST[$meta_data['meta_id']]));
        }
    }
}

