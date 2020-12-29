<?php

namespace Nextt_Wally;

/**
 * Class LoadAssets
 * @package Wally
 *          Load The javascript and css file that required wally gallery
 */
class Load_Assets
{

    public function __construct()
    {
        // nothing yet
    }

    /**
     * Call the wordpress actions
     */
    public function actions()
    {
        add_action('wp_enqueue_scripts', array($this, 'load_wally_JS'));
        add_action('admin_enqueue_scripts', array($this, 'load_shortcode_css'));
        add_action('wp_enqueue_scripts', array($this, 'load_CSS',), 1);

    }

    /**
     * -- Action Function --
     * Load the javascript files
     */
    public function load_wally_JS()
    {
//        wp_enqueue_script('wally-js', NEXTT_WALLY_URL . 'assets/js/wally.js', array('jquery-js'), '1.0.0', false);
//        wp_enqueue_script('wally-init-js', NEXTT_WALLY_URL . 'assets/js/wallyInit.js', array('jquery-js'), '1.0.0', false);
        wp_enqueue_script('lightgallery-js',  NEXTT_WALLY_URL . '/assets/js/lightgallery.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('lightgallery-call',  NEXTT_WALLY_URL . '/assets/js/call.js', array('jquery'), '1.0.0', true);

    }

    /**
     * -- Action Function --
     * Load the css for shortcode
     */
    public function load_shortcode_css()
    {
        wp_enqueue_style('custom-mce-style', NEXTT_WALLY_URL . 'assets/css/wally_shortcode.css');
    }

    /**
     * -- Action Function --
     * Load the CSS files
     */
    public function load_CSS()
    {
//        wp_enqueue_style('wally-03-css', NEXTT_WALLY_URL . 'assets/css/wally0.3.css');
        wp_enqueue_style('lightgallery-css',  NEXTT_WALLY_URL . 'assets/css/lightgallery.css');

    }

}