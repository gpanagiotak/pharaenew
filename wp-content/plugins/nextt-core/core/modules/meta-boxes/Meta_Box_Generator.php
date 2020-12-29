<?php
/**
 * Class Meta_Box_Generator
 *
 *
 * THIS IS THE MAIN CLASS TO CREATE METABOXES
 *
 * usage :
 *
* array(
*	array(
*	'id' => 'THE_ID',
*	'title' => 'THE_TITLE', // NO SPACES
*	'assign_to' => 'post', // ASSIGN TO post, pages, custom_post_type_id
*	'data' => array(
*
*		// TEXTBOXES
*		array(
*			'title' => 'Meta Box Title',
*			'description' => 'Example Text Input',
*			'type' => 'text',
*			'properties' => array(
*				'text-id' => 'meta-text' // THIS IS THE ID THAT YOU WILL TAKE VALUES
*			)
*		),
*		// CHECKBOXES THE ID TO GET VALUES IS text-id+'-'+key
 *       //  for example here meta-check-1-textbox1 and meta-check-1-textbox2
*		array(
*			'title' => 'Meta Box Title',
*			'description' => 'Example Text Input',
*			'properties' => array(
*				'text-id' => 'meta-check-1'
*			),
*			'type' => 'checkbox',
*			'inputs' => array(
*				array(
*					'description' => 'this is the first textbox',
*					'key' => 'textbox1',
*					'value' => 'val1'
*				),
*				array(
*					'description' => 'this is the second textbox',
*					'key' => 'textbox2',
*				'   value' => 'val2'
*				)
*			)
*		),
*
*		// COLORPICKER
*		array(
*			'title' => 'COLOR Box Title',
*			'description' => 'Example Text Input',
*			'type' => 'color',
*			'properties' => array(
*				'text-id' => 'meta-color' // THIS IS THE ID THAT YOU WILL TAKE VALUES
*			)
*		),
*
*		// IMAGES
*		array(
*			'title' => 'COLOR Box Title2',
*			'description' => 'Example Text Input2',
*			'assign_to' => 'post',
*			'type' => 'image',
*			'properties' => array(
*				'text-id' => 'meta-imageff' // THIS IS THE ID THAT YOU WILL TAKE VALUES
*			)
*		),
*
*		// RADIO BUTTON
*		array(
*			'title' => 'Meta Box Title',
*				'description' => 'Example Text Input',
*				'properties' => array(
*				'text-id' => 'meta-radio-1' // THIS IS THE ID THAT YOU WILL TAKE VALUES
*			),
*			'type' => 'radio',
*			'inputs' => array(
*				array(
*				'description' => 'this is the first textbox',
*				'value' => 'val1'
*				),
*			array(
*				'description' => 'this is the second textbox',
*				'value' => 'val2'
*				)
*			)
*		),
*
*		// SELECT BUTTON
*		array(
*			'title' => 'Meta Box Title',
*			'description' => 'Example Text Input',
*			'type' => 'select',
*			'properties' => array(
*				'text-id' => 'meta-select-1' // THIS IS THE ID THAT YOU WILL TAKE VALUES
*			),
*			'inputs' => array(
*				array(
*				'description' => 'this is the first textbox',
*				'value' => 'val1'
*			),
*			array(
*				'description' => 'this is the second textbox',
*				'value' => 'val2'
*				)
*			)
*		)
*		)// end data
*	)
*)
*/
class Meta_Box_Generator{

	public static $meta_store = array();

    /**
     * The Object of Meta Selector class which choose the right method (display or store) and the right meta according to
     * meta type
     * @var Meta_Selector
     */
    private $meta_selector;

    /**
     * All meta from /interface/assets_loader.php get_option('generator-meta-box')
     * @var mixed|void
     */
    private $meta;

    /**
     * Initialize the application
     */
    function __construct($meta){
	    self::$meta_store[] = $meta;
        $this->meta_selector = new Meta_Selector();
        $this->meta = $meta;
        $this->actions();
    }

    /**
     * Do all necessary method to initialize the object
     */
    public function actions(){
        add_action('admin_init', array($this, 'display_meta'));
        add_action('save_post', array($this, 'store_meta'));
        $this->meta_settings();
    }

    /**
     * Set up the settings for each meta
     * First build the data, then call from selector the method meta_settings
    */
    public function meta_settings(){
        $data_settings = [];
        $k = 0;
        $all_meta_container = count($this->meta);
        // Loop for each group of metas in options
        while($k != $all_meta_container) {
            // Get the current meta
            $current_meta = $this->meta[$k];
            // Build the data
            $meta_data = $this->build_meta_data($current_meta);

            // Load the method display meta action -> display_meta_items which loop for each group all metas

            $meta_all_data = $meta_data['data'];
            $number_of_meta = count($meta_all_data);
            $i = 0;
            // Loop for each meta in group (the group is $meta_data param)
            while ($i != $number_of_meta) {

                // Get the current meta
                $current_meta = $meta_all_data[$i];

                // -----------------------------------------
                //          HERE IS THE PROPERTIES        //
                // -----------------------------------------
                if($current_meta['type'] == 'image')
                    $data_settings[] = $current_meta['properties']['text-id'];

                $i++;
            }

            $k++;
        }
        $this->meta_selector->meta_settings('image', $data_settings);
    }

    /**
     * Loop for each group of meta and call the method display_meta_action -> display_meta_items which loop and add (add_action) each meta
     */
    public function display_meta(){
        $k = 0;
        $all_meta_container = count($this->meta);
        // Loop for each group of metas in options
        while($k != $all_meta_container) {
            // Get the current meta
            $current_meta = $this->meta[$k];
            // Build the data
            $meta_data = $this->build_meta_data($current_meta);

            // Load the method display meta action -> display_meta_items which loop for each group all metas
            $this->display_meta_action($meta_data);

            $k++;
        }
    }

    /**
     * The definition of function array($this, 'display_meta_items') do all stuff the display_meta_action only
     * activate the wordpress method to add the meta
     * @param $meta_data
     */
    public function display_meta_action($meta_data){
        add_meta_box($meta_data['unique_meta'], __($meta_data['title'], $meta_data['unique_meta']),
            array($this, 'display_meta_items'),$meta_data['assign_to'], 'advanced', 'core', $meta_data);
    }

    /**
     * Display_meta_items which loop and add (add_action) each meta the call the display selector from Meta_Selector
     * go choose the right method (store or display) and choose the right meta ('text', 'image', 'select', ...)
     * according to meta's type ($current_meta['type']) which is set in options file (assets_loader.php)
     * @param $post
     * @param $meta_data
     */
    public function display_meta_items($post, $meta_data){
        $meta_all_data = $meta_data['args']['data'];
        $number_of_meta = count($meta_all_data);
        $i = 0;

        // Loop for each meta in group (the group is $meta_data param)
        while ($i != $number_of_meta) {

            // Get the current meta
            $current_meta = $meta_all_data[$i];
            wp_nonce_field(basename(__FILE__), 'prfx_nonce');
            $prfx_stored_meta = get_post_meta($post->ID);

            // Call the display selector from Meta_Selector
            // go choose the right method (store or display) and choose the right meta ('text', 'image', 'select', ...)
            // according to meta's type ($current_meta['type']) which is set in options file (assets_loader.php)
            $this->meta_selector->display_selector($current_meta['type'], $current_meta, $prfx_stored_meta);
            $i++;
        }
    }

    /**
     * Loop all the data then call the store_meta_item to loop for each group the metas
     * @param $post_id
     */
    public function store_meta($post_id){
        $k = 0;
        $all_meta_container = count($this->meta);

        // Loop for each group
        while($k != $all_meta_container){

            $i = 0;

            // Get all metas from private var
            $meta = $this->meta;

            // Get the current meta (loop)
            $current_meta = $meta[$k];

            // Build the meta structure according to current meta
            $meta_all_data = $this->build_meta_data($current_meta);

            // Get the number of metas for this grouop
            $number_of_meta = count($current_meta['data']);

            // Call the store_meta_item to loop for each group the metas
            $this->store_meta_item($number_of_meta, $i, $meta_all_data, $post_id);

            $k++;
        }
    }

    /**
     * For each meta in current_group ($meta_all_data) loop and the call the store_selectore to
     * choose the right meta box according to its type
     * @param $number_of_meta
     * @param $i
     * @param $meta_all_data
     * @param $post_id
     */
    public function store_meta_item($number_of_meta, $i, $meta_all_data, $post_id){
        while($i != $number_of_meta) {

            $current_meta = $meta_all_data['data'][$i];

            // Call the store_selectore to
            // hoose the right meta box according to its type
            $this->meta_selector->store_selector($current_meta['type'], $current_meta, $post_id);

            $i++;
        }
    }

    /**
     * Build the right structure for the $current_meta
     * @param $current_meta
     * @return array
     */
    public function build_meta_data($current_meta){
        return array(
            'unique_meta' => $current_meta['id'],
            'title' => $current_meta['title'],
            'assign_to' => $current_meta['assign_to'],
            'data' => $current_meta['data']
        );
    }


}

