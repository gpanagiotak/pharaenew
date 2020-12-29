<?php

class NexttCore
{

    public static $ActionsShortCodes;
    public static $RegisterShortCodes;


//  this is the constructor of the Class.
//  it runs when we create a new instance of the class
    public function __construct(){
        add_action('plugins_loaded', array(
            $this,
            'initialize',
        ), 99);

    }


    /**
     * Execute the core modules of nextt
     */
    public function initialize()
    {

        require_once('core/helpers.php');

        require_once('core/autoload.php');

        require_this('/interfaces/assets_loader.php');

        static_load();

        new Settings();
        new Assets();
        new Theme_Functions();
        new Nextt_Dynamic_Code();


        NexttCore::$ActionsShortCodes = new Actions_Shortcodes();
        NexttCore::$RegisterShortCodes = new Register_Shortcodes();

        new Post_Types(get_option('post-types'));
        new Meta_Box_Generator(get_option('generator-meta-boxes'));
        new Image_Categories(get_option('add-image-to-categories'));
        new Theme_Options(get_option('generator-theme-options'));
    }

}



