<?php


/**
 * THIS FILE IS RESPONSIBLE TO CREATE THE MCE BUTTONS ONLY AND NOTHING ELSE
 * The only thing you should to do to add a new shortcode is to push the array with method shortcode_pusher() in
 * constructor with right params
 * Class Register_Shortcodes
 */
class Register_Shortcodes
{

    /**
     * The shortcode array
     * @var array
     */
    private $shortcodes = array();

    /**
     * The javascript path
     * @var string
     */
    private $shortcodes_js_file_path = '';

    /**
     * Initialize the class, for each shortcode push the array with shortcode_pusher() method
     * [params {id => the id, option => the shortcode column,}]
     */
    function __construct()
    {
        $this->shortcodes_js_file_path = NEXTT_CORE_URL . '/core/shortcodes/buttons.js';

        $this->shortcode_pusher(array("id" => "col", "option" => "shortcode-col",));
        $this->shortcode_pusher(array("id" => "funky_box", "option" => "shortcode-active-box",));
        $this->shortcode_pusher(array("id" => "drop_cap", "option" => "shortcode-drop-cap",));
        $this->shortcode_pusher(array("id" => "accordion", "option" => "shortcode-accordion",));
        $this->shortcode_pusher(array("id" => "title", "option" => "shortcode-title",));
        $this->shortcode_pusher(array("id" => "div", "option" => "shortcode-div",));
        $this->shortcode_pusher(array("id" => "imagetext", "option" => "shortcode-imagetext",));
        $this->shortcode_pusher(array("id" => "nexttbutton", "option" => "shortcode-button",));
        $this->shortcode_pusher(array("id" => "hidemore", "option" => "shortcode-hidemore",));
        $this->shortcode_pusher(array("id" => "table", "option" => "shortcode-hidemore",));
        $this->shortcode_pusher(array("id" => "hr", "option" => "shortcode-hr",));
        $this->shortcode_pusher(array("id" => "popup", "option" => "shortcode-popup",));

        add_action('plugins_loaded', array($this, 'add_shortcode',), 140);

    }

    /**
     * Register the Shrotcode
     */
    public function add_shortcode()
    {
        add_action('admin_head', array($this, 'my_add_mce_button',));
    }

    /**
     * Push the shortcode
     *
     * @param $new_shortcode
     */
    public function shortcode_pusher($new_shortcode)
    {
        $this->shortcodes[] = $new_shortcode;
    }

    /**
     * Creaate the button for MCE foreach shortcode
     */
    public function my_add_mce_button()
    {
        // CHECK USER PERMISSIONS
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
        {
            return;
        }
        // CHECK IF WYSIWYG IS ENABLED
        if ('true' == get_user_option('rich_editing'))
        {
            add_filter('mce_external_plugins', array($this, 'my_add_tinymce_plugin',));
            add_action('admin_head', 'include_the_theme_options');
            // HERE YOU CAN INCLUDE THE FUNCTIONS BUTTON
            foreach ($this->shortcodes as $shortcode)
            {

                if (get_option($shortcode['option']))

                add_filter('mce_buttons', function ($buttons) use ($shortcode)
                    {
                        array_push($buttons, $shortcode['id']);
                        return $buttons;
                    });
            }
        }
    }

    /**
     * For each shortcode call the javascript file
     *
     * @param $plugin_array
     *
     * @return mixed
     */
    public function my_add_tinymce_plugin($plugin_array)
    {
        // For each shortcode in the array
        foreach ($this->shortcodes as $shortcode)
        {

            // Get the shortcode id
            $shortcode_id = $shortcode['id'];

            // Define the default javascript file
            $shortcodeFilePath = $this->shortcodes_js_file_path;

            // Check if the shortcode has a separate javascript file
            if ($shortcode['js'])
            {
                $shortcodeFilePath = $shortcode['js'];
            }

            $plugin_array[$shortcode_id] = $shortcodeFilePath;
        }

        return $plugin_array;
    }

}