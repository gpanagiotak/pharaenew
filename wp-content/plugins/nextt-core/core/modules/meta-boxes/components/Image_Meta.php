<?php

/**
 * Class Image_Meta
 *
 * This class generate the code to create and storm metabox values
 *
 * This included into Metabox_Selector()
 *
 * Metabox_Selector class contains all metaboxes type like this one
 *
 */
class Image_Meta implements Meta_Box{

    /**
     * The type of current meta
     * @var string
     */
    private $type = 'image';

    private $meta_id = array();

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
     * Do all necessary method to generate the meta
     */
    public function actions($meta_id){
        $this->meta_id = $meta_id;

        add_action( 'admin_enqueue_scripts', array($this, 'image_script'), 100);

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
            'unique_meta' => $current_meta['properties']['text-id']
        );

        $pref = '';
        if (isset ($prfx_stored_meta[$meta_data['meta_id']]))
            $pref = $prfx_stored_meta[$meta_data['meta_id']][0];
        $html = "
        <p>
            <label for='". $meta_data['meta_id'] ."'
                   class='prfx-row-title'>". _e($meta_data['description'], 'prfx-textdomain') ."</label>
            <img class='image-container-".$meta_data['meta_id']."' height='150' width='150' src='". $pref ."'>
            <input type='hidden' name='". $meta_data['meta_id'] ."'
                   id='". $meta_data['meta_id'] . '-input' ."'
                   value='". $pref ."'/>
            <input type='button' id='". $meta_data['meta_id'] . '-button' ."' class='button'
                   the-meta-id='". $meta_data['meta_id'] ."'
                   value='". 'Upload an Image'."'/>
        </p>";
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
            'unique_meta' =>  $current_meta['properties']['text-id']
        );

        // Checks for input and sanitizes/saves if needed
        if (isset($_POST[$meta_data['meta_id']])) {
            update_post_meta( $post_id, $meta_data['meta_id'], $_POST[ $meta_data['meta_id'] ] );
        }
    }

    /**
     * Load the image script for the each meta image
     */
    public function image_script(){

        if (function_exists('admin_inline_js')){
            return;
        }

        wp_enqueue_media();

        add_action( 'admin_print_scripts', function () {

            foreach($this->meta_id as $meta_id){

            echo '<script type="text/javascript"> jQuery(document).ready(function(jQuery){var meta_image_frame;';
                        echo " /* ".$meta_id." */
                        jQuery('#" . $meta_id . "-button').click(function(e){
                            console.log('#" . $meta_id . "-button');
                            e.preventDefault();

                            if ( meta_image_frame ) {
                                meta_image_frame.open();
                                return;
                            }
                            meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                                title: 'select image',
                                button: { text: 'select image' },
                                library: { type: 'image' }
                            });

                            meta_image_frame.on('select', function(){

                                var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                                jQuery('#" . $meta_id . "-input').val(media_attachment.url);
                                jQuery('.image-container-" . $meta_id . "').attr('src', media_attachment.url);
                                console.log('after', '#" .$meta_id . "-input');
                                meta_image_frame = null;
                            });

                            meta_image_frame.open();
                        });";

                    echo "});</script>";
            }
        }, 100 );


    }
}


