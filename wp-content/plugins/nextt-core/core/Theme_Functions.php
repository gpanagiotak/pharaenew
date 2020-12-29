<?php

/**
 * Class Theme_functions
 */
class Theme_Functions{

    /**
     * @var array
     */
    private $menus = array();

    /**
     * Initialize the application
     */
    function __construct(){
        $this->menus =  array(
            'header-menu' => __( 'Header Menu' ),
            'extra-menu' => __( 'Secondary Menu' )
        );
        $this->actions();
    }

    /**
     * Fire the class actions methods
     * @return null
     * @params null
    */
    private function actions(){
        add_action( 'init', array($this, 'register_my_menus'));
        show_admin_bar(false);
        add_theme_support( 'post-thumbnails', array('post', 'page'));
        add_action('admin_enqueue_scripts', array($this, 'add_media_to_admin'));
    }

    /**
     * Register the default menus
     * @return null
     * @params null
     */
    public function register_my_menus(){
        register_nav_menus($this->menus);
    }


    /**
     * Enable media to access some javascript functions like media pop up
     */
    public function add_media_to_admin(){
        wp_enqueue_media();
        $this->load_custom_wp_admin_style();
    }

    public function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . '/assets/css/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
    }

}