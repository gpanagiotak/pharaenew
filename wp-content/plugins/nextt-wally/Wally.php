<?php

namespace Nextt_Wally;

require_once "Wally_Settings.php";
require_once "Post_Type_Manager.php";
require_once "Load_Assets.php";
require_once "shortcode/Short_Code_Manager.php";

use Nextt_Wally\ShortCode\Short_Code_Manager;

/**
 * Class Wally
 * @package Wally
 */
class Wally
{

    /**
     * @var Wally_Settings
     */
    private $settings;

    /**
     * @var Post_Type_Manager
     */
    private $post_type_manager;

    /**
     * @var Load_Assets
     */
    private $load_assets;

    /**
     * @var Short_Code_Manager
     */
    private $short_code_manager;

    /**
     * Wally constructor.
     */
    public function __construct()
    {
        $this->settings = new Wally_Settings();
        $this->post_type_manager = new Post_Type_Manager(get_option('wally-gallery'));
        $this->load_assets = new Load_Assets();
        $this->short_code_manager = new Short_Code_Manager();
    }

    /**
     * Initialize the plugin
     */
    public function execute()
    {

        // Check if the nextt core plugin is activated
        if(!$this->settings->associations()) {
            return;
        }

        // Load the scripts
        $this->load_assets->actions();

        // Initialize the wally gallery
        $this->post_type_manager->actions();

        // Create the shortcode
        $this->short_code_manager->addShortCode();

    }

}