<?php

/**
 * Class Actions_Shortcodes
 *
 * Ad shortocde actions
 *
 * usage: new Actions_Shortcode()
 */
class Actions_Shortcodes{

    private $shortcodes = array();

    /**
     * The shortcode css for buttons (path)
    */
    private $shortcode_css_icon_path ;

    function __construct(){

        $this->shortcode_css_icon_path = NEXTT_CORE_URL.'/core/shortcodes/icons.css';

        $accordion = new Accordion_Shortcode();
        $action_box = new Action_Box_Shortcode();
        $column = new Column();
        $title = new Title();
        $div = new Div();
        $imageText = new Image_Text();
        $button = new Button();
        $hide_more = new Hide_More();
        $table = new Table();
        $hr = new Hr();
        $popup = new Popup();

        $this->shortcode_pusher(array('option'=> 'shortcode-col', 'object'=> $column));
        $this->shortcode_pusher(array('option'=> 'shortcode-active-box', 'object'=> $action_box));
        $this->shortcode_pusher(array('option'=> 'shortcode-accordion', 'object'=> $accordion));
        $this->shortcode_pusher(array('option'=> 'shortcode-title', 'object'=> $title));
        $this->shortcode_pusher(array('option'=> 'shortcode-div', 'object'=> $div));
        $this->shortcode_pusher(array('option'=> 'shortcode-imagetext', 'object'=> $imageText));
        $this->shortcode_pusher(array('option'=> 'shortcode-button', 'object'=> $button));
        $this->shortcode_pusher(array('option'=> 'shortcode-hidemore', 'object'=> $hide_more));
        $this->shortcode_pusher(array('option'=> 'shortcode-table', 'object'=> $table));
        $this->shortcode_pusher(array('option'=> 'shortcode-hr', 'object'=> $hr));
        $this->shortcode_pusher(array('option'=> 'shortcode-popup', 'object'=> $popup));

        add_action( 'plugins_loaded', array($this, 'actions'), 140 );

    }

    public function shortcode_pusher($new_shortcode){
        $this->shortcodes[] = $new_shortcode;
    }

    /**
     * Load the other methods
     * @return null
     * @args null
     */
    public function actions(){
        $this->load_shortcodes();
        add_action( 'admin_enqueue_scripts', array($this, 'tiny_mce_custom_icon_css') );
    }

    /**
     * Load the shortcodes php logic scripts
     * @return null
     * @args null
     */
    function load_shortcodes(){
        new Accordion_Shortcode();
        foreach($this->shortcodes as $shortcode){
            if(get_option($shortcode['option'])){
                $shortcode['object']->actions();
            }
        }
    }

    /**
     * Include the custom css for tinymce buttons
     * @return null
     * @args null
     */
    public function tiny_mce_custom_icon_css(){
        wp_enqueue_style( 'custom-wally-mce-style', $this->shortcode_css_icon_path );
    }

}
