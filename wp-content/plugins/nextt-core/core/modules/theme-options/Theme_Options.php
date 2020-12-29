<?php

    /**
     *
     * // ------------------------------------- Generate theme options
     *
     *  Crete the main menu
     * array(
     * 'title'    => 'Theme Options',
     * 'slug'     => 'theme_options',
     * 'position' => 24,
     * 'function' => 'theme_options',
     * 'inputs'   => array(
     * // ------------------------------------- Add inputs for main menu
     * array(
     * 'title'       => 'Subtitle 1',
     * 'description' => 'Subtitle 1',
     * 'type'        => 'text',
     * 'properties'  => array(
     * 'text-id' => 'houses_subtitle_1',
     * 'value'   => 'this is a text box'
     * )
     * )
     * ), //------------------------------------- Add the submenu
     * 'submenu'  => array(
     * array(
     * 'title'     => 'General Options',
     * 'slug'      => 'general_options',
     * 'function'  => 'general_options',
     * 'assign_to' => 'theme_options',
     * //------------------------------------- Add the inputs fields
     * 'inputs'    => array(
     * array(
     * 'title'       => 'Subtitle 1',
     * 'description' => 'Subtitle 1',
     * 'type'        => 'text',
     * 'properties'  => array(
     * 'text-id' => 'houses_subtitle_1',
     * 'value'   => 'this is a text box'
     * )
     * )
     * )
     * ),// ------------------------------------- Add another submenu
     * array(
     * 'title'     => 'General Options 4',
     * 'slug'      => 'general_options4',
     * 'function'  => 'general_options4',
     * 'assign_to' => 'theme_options',
     * 'inputs'    => array(
     * // ------------------------------------- Add submenu inputs
     * array(
     * 'title'       => 'Subtitle 4',
     * 'description' => 'Subtitle 4',
     * 'type'        => 'text', // ------------------------------------- Text input
     * 'properties'  => array(
     * 'text-id' => 'houses_subtitle_44',
     * 'value'   => 'this is a text box'
     * )
     * ),
     * array(
     * 'title'       => 'Checkbox',
     * 'description' => 'Checkbox1',
     * 'type'        => 'checkbox', // ------------------------------------- Checkbox input
     * 'properties'  => array(
     * 'text-id'  => 'houses_checkbox',
     * 'defvalue' => 'thisisatestvalue',
     * 'value'    => ''
     * ),
     * ),
     * array(
     * 'title'       => 'COLOR Box Title',
     * 'description' => 'Example Text Input',
     * 'type'        => 'color', // ------------------------------------- Color input
     * 'properties'  => array(
     * 'text-id' => 'meta-color',
     * 'value'   => ''
     * )
     * ),
     * array(
     * 'title'       => 'Meta Box Title',
     * 'description' => 'Example Text Input',
     * 'type'        => 'radio', // ------------------------------------- Radio input
     * 'properties'  => array(
     * 'text-id' => 'meta-radio-1',
     * 'value'   => ''
     * ),
     * 'inputs'      => array(
     * array(
     * 'description' => 'this is the first textbox',
     * 'value'       => 'val1'
     * ),
     * array(
     * 'description' => 'this is the second textbox',
     * 'value'       => 'val2'
     * )
     * )
     * ),
     * // IMAGES
     * array(
     * 'title'       => 'COLOR Box Title2',
     * 'description' => 'Example Text Input2',
     * 'assign_to'   => 'post',
     * 'type'        => 'image', // ------------------------------------- Image input
     * 'properties'  => array(
     * 'text-id' => 'meta-imageff',
     * 'value'   => ''
     * )
     * ),
     * // SELECT BUTTON
     * array(
     * 'title'       => 'Meta Box Title',
     * 'description' => 'Example Text Input',
     * 'type'        => 'select', // ------------------------------------- Select input
     * 'properties'  => array(
     * 'text-id' => 'meta-select-1',
     * 'value'   => ''
     * ),
     * 'inputs'      => array(
     * array(
     * 'description' => 'this is the first textbox',
     * 'value'       => 'val1'
     * ),
     * array(
     * 'description' => 'this is the second textbox',
     * 'value'       => 'val2'
     * )
     * )
     * )
     * )
     * )
     * )
     * )
     */
    class Theme_Options
    {

        /**
         * Store key prefix
         *
         * @var string
         */
        public static $store_key_prefix = 'theme_options_';

        /**
         * Main menu Pref (Default from wordpress)
         *
         * @var
         */
        private $main_menu_pref = 'edit_posts';

        /**
         * Sub Main menu Pref (Default from wordpress)
         *
         * @var
         */
        private $sub_menu_pref = 'manage_options';


        /**
         * The view page
         *
         * @var string
         */
        private $view_file = 'View_Theme_Options.php';


        /**
         * Set up the main menus (you can add a new menus just push this array)
         *
         * @var
         */
        private $struct;

        /**
         * Store the inputs of views with slug as key
         *
         * @var array
         */
        private $inputs = array();

        /**
         * Store the slugs
         *
         * @var array
         */
        static $slugs = array();

        /**
         * Initialize the Object
         */
        function __construct($struct)
        {

            if(isset($struct[0])) {
                $this->struct = $struct;
                $this->push_slugs();
                $this->actions();
            }
        }

        /**
         * Theme options page
         *
         * @return string
         */
        public function theme_options()
        {
            if(!current_user_can($this->main_menu_pref)) {
                wp_die('You do not have sufficient permissions to access this page.');
            }
            $this->save();
            require_once realpath(dirname(__FILE__)) . '/' . $this->view_file;
        }


        /**
         * Add wordpress actions
         */
        public function actions()
        {
            add_action('admin_enqueue_scripts', array($this, 'color_js',), 100);
            add_action('admin_menu', array($this, 'crate_theme_options',));
            add_action('admin_enqueue_scripts', array($this, 'image_script',), 100);

        }


        /**
         * Generate all menus
         */
        public function crate_theme_options()
        {

            // Create the main menus
            foreach ($this->struct as $parent) {

                add_menu_page($parent['title'], $parent['title'], $this->main_menu_pref, $parent['slug'], array($this, 'theme_options',), '', $parent['position']);

                $this->inputs[ $parent['slug'] ]['inputs'] = $parent['inputs'];
                $this->inputs[ $parent['slug'] ]['title'] = $parent['title'];
                $this->inputs[ $parent['slug'] ]['slug'] = $parent['slug'];
                $this->inputs[ $parent['slug'] ]['lang'] = ICL_LANGUAGE_CODE;

                self::$slugs[] = $parent['slug'];

            }


            // Create the sub menus
            foreach ($this->struct as $parent) {
                foreach ($parent['submenu'] as $child) {
                    add_submenu_page($child['assign_to'], $child['title'], $child['title'], $this->sub_menu_pref, $child['slug'], array($this, 'theme_options'));
                    $this->inputs[ $child['slug'] ]['inputs'] = $child['inputs'];
                    $this->inputs[ $child['slug'] ]['title'] = $child['title'];
                    $this->inputs[ $child['slug'] ]['slug'] = $child['slug'];
                    $this->inputs[ $parent['slug'] ]['lang'] = ICL_LANGUAGE_CODE;
                    self::$slugs[] = $parent['slug'];
                }
            }

            if($this->check_page()) {
                $this->load_values();
            }

        }


        /**
         * Save the data when submit button pressed
         */
        public function save()
        {
            if(!isset($this->find_inputs_by_slug(null)['slug'])) {
                return;
            }
            if(isset($_POST[ $this->find_inputs_by_slug(null)['slug'] ])) {
                $inputs = array();
                foreach ($this->find_inputs_by_slug(null)['inputs'] as $input) {

                    if(isset($_POST[ $input['properties']['text-id'] ])) {

                        if($input['type'] == 'text' || $input['type'] == 'color' || $input['type'] == 'radio' || $input['type'] == 'image' || $input['type'] == 'select') {
                            $input['properties']['value'] = esc_attr($_POST[ $input['properties']['text-id'] ]);
                        }

                        if($input['type'] == 'checkbox') {
                            $input['properties']['value'] = esc_attr($_POST[ $input['properties']['text-id'] ]);
                        }


                    } else {
                        $input['properties']['value'] = null;
                    }
                    $inputs[] = $input;
                }
                $this->inputs[ $this->find_the_slug() ]['inputs'] = $inputs;

                update_option(Theme_Options::$store_key_prefix . $this->find_inputs_by_slug(null)['slug'] . ICL_LANGUAGE_CODE, $this->inputs[ $this->find_the_slug() ]);

                $this->load_values();
            }
        }


        /**
         * Return the data according to current slug page
         *
         * @param $slug
         *
         * @return mixed
         */
        private function find_inputs_by_slug($slug)
        {
            if($slug == null && isset($_GET['page'])) {
                $slug = esc_attr($_GET['page']);
            }
            if(!isset($this->inputs[ $slug ])) {
                return null;
            }

            return $this->inputs[ $slug ];
        }

        /**
         * Return the current slug
         *
         * @return string|void
         */
        private function find_the_slug()
        {
            return esc_attr($_GET['page']);
        }

        /**
         * Get the values form database
         */
        private function load_values()
        {
            $store_data = get_option(Theme_Options::$store_key_prefix . $this->find_inputs_by_slug(null)['slug'] . ICL_LANGUAGE_CODE);

            if(count($store_data['inputs']) != count($this->inputs[ $this->find_the_slug() ]['inputs'])) {
                foreach ($this->inputs[ $this->find_the_slug() ]['inputs'] as $k => $input) {
                    if(isset($store_data['inputs'])) {
                        foreach ($store_data['inputs'] as $data) {

                            if($input['properties']['text-id'] == $data['properties']['text-id']) {

                                if($data['type'] == 'text' || $data['type'] == 'color' || $data['type'] == 'radio' || $data['type'] == 'image' || $data['type'] == 'select') {
                                    $this->inputs[ $this->find_the_slug() ]['inputs'][ $k ]['properties']['value'] = $data['properties']['value'];
                                }

                                if($data['type'] == 'checkbox') {
                                    $this->inputs[ $this->find_the_slug() ]['inputs'][ $k ]['properties']['value'] = $data['properties']['value'];
                                }
                            }
                        }
                    }
                }
                update_option(Theme_Options::$store_key_prefix . $this->find_inputs_by_slug(null)['slug'] . ICL_LANGUAGE_CODE, $this->inputs[ $this->find_the_slug() ]);

            } else {
                $this->inputs[ $this->find_the_slug() ] = $store_data;
            }

        }

        public function color_js()
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('meta-box-color-js', NEXTT_CORE_URL . '/core/modules/meta-boxes/assets/meta-box-color.js', array('wp-color-picker'));
        }

        /**
         * Load the image script for the each meta image
         */
        public function image_script()
        {

            if(!$this->find_inputs_by_slug(null)['inputs']) {
                return;
            }

            if(function_exists('admin_inline_js')) {
                return;
            }

            wp_enqueue_media();

            add_action('admin_print_scripts', function() {

                foreach ($this->find_inputs_by_slug(null)['inputs'] as $input) {

                    echo "<script type='text/javascript'> jQuery(document).ready(function(jQuery){var meta_image_frame;" . " /* " . $input['properties']['text-id'] . " */
                        jQuery('#" . $input['properties']['text-id'] . "-button').click(function(e){
                            console.log('#" . $input['properties']['text-id'] . "-button');
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

                                jQuery('#" . $input['properties']['text-id'] . "-input').val(media_attachment.url);
                                jQuery('.image-container-" . $input['properties']['text-id'] . "').attr('src', media_attachment.url);
                                console.log('after', '#" . $input['properties']['text-id'] . "-input');
                                meta_image_frame = null;
                            });

                            meta_image_frame.open();
                        });" . "});</script>";
                }
            }, 100);
        }


        /**
         * Push the slugs
         */
        public function push_slugs()
        {
            // Create the main menus
            foreach ($this->struct as $parent) {
                self::$slugs[] = $parent['slug'];
            }

            // Create the sub menus
            foreach ($this->struct as $parent) {
                foreach ($parent['submenu'] as $child) {
                    self::$slugs[] = $child['slug'];
                }
            }
        }

        private function check_page()
        {
            if(isset($_GET['page'])) {
                foreach (self::$slugs as $slug) {
                    if($_GET['page'] == $slug) {
                        return true;
                    }
                }
            }

            return false;
        }
    }


