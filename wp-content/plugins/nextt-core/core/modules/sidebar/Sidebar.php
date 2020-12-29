<?php
/*
 * THIS FILE IS RESPONSIBLE TO GENERATE CUSTOM SIDE BARS
 * ENABLE THIS IN INTERFACES/ASSETS_LOADER.PHP
 */

/**
 * Class Sidebar
 *
 * Create multiple sidebars
 *
 * usage: new Sidebar(array('Sidebar 1', 'Sidebar 2'))
 *
 */
class Sidebar{

    /**
     * @var array
     */
    private $sidebars = array();

    /**
     * @var array
    */
    private $side_params = array();

    /**
     *
     */
    function __construct($meta){
        if($meta == null){
            $this->side_params = array();
        }else{
            $this->side_params = $meta;
        }
        $this->sidebar_creator();
        $this->main_sidebar();
        $this->footer_sidebar();
        $this->actions();
    }

    /**
     * Register the action into wordpress
     */
    public function actions(){
        add_action('widgets_init', array($this, 'sidebar_generator'));
    }

    /**
     * Pusher the array fo sidebars[]
     * @param $new_sidebar
     */
    public function sidebar_pusher($new_sidebar){
        $this->sidebars[] = $new_sidebar;
    }

    /**
     * The registretion of sidebar, for each sidebar call the wordpress function register_sidebar
     */
    public function sidebar_generator(){
        foreach($this->sidebars as $sidebar){
            register_sidebar($sidebar);
        }
    }

    /**
     * The build of sidebar, get all data from assets_loaders.php and loop for each loader and generate the sidebar
     */
    public function sidebar_creator(){
        $sidebars = $this->side_params;
        foreach ($sidebars as $key => $sidebar) {
            $this->sidebar_pusher(array(
                'name' => $sidebar,
                'id' => 'sidebar-' . $key,
                'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
                'before_widget' => '<li id="%1$s" class="widget %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h2 class="' . $sidebar . '">',
                'after_title' => '</h2>',
            ));
        }
    }

    /**
     * Generate the main Sidebar
     */
    public function main_sidebar(){
        if(get_option('main-sidebar'))
            $this->sidebar_pusher(array(
                'name' => 'Main Sidebar',
                'id' => 'sidebar-main',
                'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
                'before_widget' => '<li id="%1$s" class="widget %2$s">',
                'after_widget'  => '</li>',
                'before_title'  => '<h2 class="widgettitle">',
                'after_title'   => '</h2>',
            ));
    }

    /**
     * Push the sidevar_pusher and create 4 different widgets for the footer
     */
    public function footer_sidebar(){
        if(get_option('4-widgets-footer')){
            $this->sidebar_pusher(array(
                'name' => '1 Footer Widget',
                'id' => '1-footer-widget',
                'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
                'before_widget' => '<li id="%1$s" class="widget-4-footer %2$s">',
                'after_widget'  => '</li>',
                'before_title'  => '<h2 class="widget-4-footer-title">',
                'after_title'   => '</h2>',
            ));
            $this->sidebar_pusher(array(
                'name' => '2 Footer Widget',
                'id' => '2-footer-widget',
                'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
                'before_widget' => '<li id="%1$s" class="widget-4-footer %2$s">',
                'after_widget'  => '</li>',
                'before_title'  => '<h2 class="widget-4-footer-title">',
                'after_title'   => '</h2>',
            ) );
            $this->sidebar_pusher( array(
                'name' => '3 Footer Widget',
                'id' => '3-footer-widget',
                'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
                'before_widget' => '<li id="%1$s" class="widget-4-footer %2$s">',
                'after_widget'  => '</li>',
                'before_title'  => '<h2 class="widget-4-footer-title">',
                'after_title'   => '</h2>',
            ) );
            $this->sidebar_pusher(array(
                'name' => '4 Footer Widget',
                'id' => '4-footer-widget',
                'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
                'before_widget' => '<li id="%1$s" class="widget-4-footer %2$s">',
                'after_widget'  => '</li>',
                'before_title'  => '<h2 class="widget-4-footer-title">',
                'after_title'   => '</h2>',
            ) );
        }
    }

}