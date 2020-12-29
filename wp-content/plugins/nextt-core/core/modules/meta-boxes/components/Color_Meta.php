<?php


/**
 * Class Color_Meta
 *  
 * This class generate the code to create and storm metabox values
 *
 * This included into Metabox_Selector()
 *
 * Metabox_Selector class contains all metaboxes type like this one
 */
class Color_Meta implements Meta_Box{

    /**
     * The to path to js color picker
     * @var string
     */
    private $path_to_js_color;

    /**
     * The type of this meta class
     * @var string
     */
    private $type = 'color';

    /**
     * Get the type of this meta
     * @return string
     */
    public function get_type()
    {
        return $this->type;
    }


    /**
     * Generate the application
     */
    function __construct()
    {
        $this->path_to_js_color = NEXTT_CORE_URL.'/core/modules/meta-boxes/assets/meta-box-color.js';
        $this->actions();
    }

    /**
     * Do all necessary method to generate the meta
     */
    public function actions(){
        add_action( 'admin_enqueue_scripts', array($this, 'color_js'), 100);
    }

    /**
     * Display the meta html
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
         if (isset ($prfx_stored_meta[$meta_data['meta_id']])) $pref = $prfx_stored_meta[$meta_data['meta_id']][0]; 
            

        $html = "<p>
            <label
                for='". $meta_data['meta_id'] ."'>"._e($meta_data['description'], 'prfx-textdomain') ."</label>
            <input name='". $meta_data['meta_id'] ."' type='text'
                   value='".$pref."'
                   class='". 'meta-color' ."'/>
        </p>";

        echo $html;

    }

    /**
     * Store the meta
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
     * Include the color javascript file to enable the color picker
     */
    public function color_js(){
        if(!get_option('generator-meta-boxes')){
            return ;
        }
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'meta-box-color-js', $this->path_to_js_color,  array( 'wp-color-picker' ));
    }


}

