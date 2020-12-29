<?php

/**
 * Class Assets
 * usge: new Assets()
 */
class Assets{

    /**
     * Initialize the object
     */
    function __construct(){
        $this->actions();
    }


    /**
     * Load wordpress actions
     */
    public function actions(){
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script'), 1, 1);
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_style'), 1);
    }


    /**
     * Include the required css assets and libs
     * @return null
     * @args null
    */
    public function enqueue_style(){

        if(get_option('load-css-jquery-ui'))
            wp_enqueue_style( 'jquery-ui-css', NEXTT_CORE_URL.'core/assets/css/jquery/jquery-ui.css' );

        if(get_option('load-css-bootstrap'))
            wp_enqueue_style( 'bootstrap-css', NEXTT_CORE_URL.'core/assets/css/bootstrap/bootstrap.min.css' );

        if(get_option('load-css-contactform7'))
            wp_enqueue_style( 'contactform7-css', NEXTT_CORE_URL.'core/assets/css/contactform7/contactform7.css' );

        if(get_option('load-css-font-awesome'))
            wp_enqueue_style( 'font-awesome-css', NEXTT_CORE_URL.'core/assets/css/font-awesome/css/font-awesome.css' );

        wp_enqueue_style( 'advertek-icons-css', NEXTT_CORE_URL.'core/assets/css/advertek-icons/icons_css.css' );
        
        wp_enqueue_style('nextt_menu_css', enqueue_this('/assets/css/mobile_menu/nextt_menu_mobile.min.css') );

    }

    /**
     * Include the required javascript assets and libs
     * @return null
     * @args null
     */
    public function enqueue_script() {

        if(get_option('load-js-jquery'))
            wp_enqueue_script( 'jquery-js', NEXTT_CORE_URL.'core/assets/js/jquery/jquery.js', array(), '1.0.0', true );

        if(get_option('load-js-jquery-migrate'))
            wp_enqueue_script( 'jquery-migrate-js', NEXTT_CORE_URL.'core/assets/js/jquery/migrate-jq.js', array('jquery-js'), '1.0.0', true );

        if(get_option('load-js-jquery-ui'))
            wp_enqueue_script( 'jquery-ui-js', NEXTT_CORE_URL.'core/assets/js/jquery/jquery-ui.js', array(), '1.0.0', true );

        if(get_option('load-js-bootstrap'))
            wp_enqueue_script( 'bootstrap-js', NEXTT_CORE_URL.'core/assets/js/bootstrap/bootstrap.bundle.min.js', array(), '1.0.0', true );

        wp_enqueue_script('nextt_menu_js', enqueue_this('/assets/js/mobile_menu/nextt_menu_mobile.min.js'), array(), '0.0.2', true);

    }

}
