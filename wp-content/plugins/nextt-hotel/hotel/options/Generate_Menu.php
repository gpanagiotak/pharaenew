<?php

/**
 *
 * Generate theme options menu
 *
 * included: Options
 * If you want to add a new menu will need
 * 1. push the private $main_menu_build or private $submenus
 * 2. get the object from constructor ex($this->hotel_setup = new Hotel_Setup();)
 * 3. create a public function ($main_menu_build or $submenus has a property "function" this will be the name)
 * 4. and of course push the load function array load(array('Hotel_Setup', '.....'));
 * Class Generate_Menu
 */
class Generate_Menu
{

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
    private $view_file = 'Options_View.php';


    /**
     * Set up the main menus (you can add a new menus just push this array)
     *
     * @var
     */
    private $main_menu_build = array(
        array(
            'title' => 'Hotel',
            'slug' => 'hotel',
            'position' => 24,
            'function' => 'hotel_main'
        )
    );


    /**
     * Set up the sub main menus (you can add a new menus just push this array)
     *
     * @var
     */
    private $submenus = array();

    private $hotel_setup;
    private $hotel_facilities;
    private $hotel_travel_agents;
    private $hotel_google_setup;
    private $hotel_mail_setup;
    private $hotel_social_networks;
    private $hotel_useful_phones;
    private $hotel_distances;

    /**
     * Initialize the Object
     */
    function __construct()
    {

        $this->submenus[] = array(
            'title' => 'Hotel Setup',
            'slug' => 'hotel_setup',
            'function' => 'hotel_setup',
            'assign_to' => 'hotel'
        );

        if (get_option('hotel')['facilities'])
        {
            $this->submenus[] = array(
                'title' => 'Hotel Facilities',
                'slug' => 'hotel_facilities',
                'function' => 'hotel_facilities',
                'assign_to' => 'hotel'
            );
        }

        if (get_option('hotel')['agents'])
        {
            $this->submenus[] = array(
                'title' => 'Travel Agents',
                'slug' => 'hotel_travel_agents',
                'function' => 'hotel_travel_agents',
                'assign_to' => 'hotel'
            );
        }

        if (get_option('hotel')['socials_networks'])
        {
            $this->submenus[] = array(
                'title' => 'Social Networks',
                'slug' => 'hotel_social_networks',
                'function' => 'hotel_social_networks',
                'assign_to' => 'hotel'
            );
        }

        if (get_option('hotel')['phones'])
        {
            $this->submenus[] = array(
                'title' => 'Useful Phone Numbers',
                'slug' => 'hotel_useful_phones',
                'function' => 'hotel_useful_phones',
                'assign_to' => 'hotel'
            );
        }

        if (get_option('hotel')['distances'])
        {
            $this->submenus[] = array(
                'title' => 'Hotel Distances',
                'slug' => 'hotel_distances',
                'function' => 'hotel_distances',
                'assign_to' => 'hotel'
            );
        }

        if (get_option('hotel')['google_setup'])
        {
            $this->submenus[] = array(
                'title' => 'Google Setup',
                'slug' => 'hotel_google_setup',
                'function' => 'hotel_google_setup',
                'assign_to' => 'hotel'
            );
        }
        

        $this->hotel_setup = new Hotel_Setup();
        $this->hotel_facilities = new Hotel_Facilities();
        $this->hotel_travel_agents = new Hotel_Travel_Agents();
        $this->hotel_google_setup = new Hotel_Google_Setup();
        $this->hotel_social_networks = new Hotel_Socials();
        $this->hotel_useful_phones = new Hotel_Useful_Phones();
        $this->hotel_distances = new Hotel_Distances();


    }


    /**
     * Call for hotel menu
     */
    public function hotel_main()
    {
        if (!current_user_can($this->main_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        require_once realpath(dirname(__FILE__)) . '/' . $this->view_file;
    }

    /**
     * Call for hotel setup menu
     */
    public function hotel_setup()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_setup->load();
    }

    /**
     * Call for hotel facilities menu
     */
    public function hotel_facilities()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_facilities->load();
    }


    /**
     * Call for hotel tracael agents menu
     */
    public function hotel_travel_agents()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_travel_agents->load();
    }

    /**
     * Call for hotel social networks menu
     */
    public function hotel_social_networks()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_social_networks->load();
    }

    /**
     * Call for hotel useful phones menu
     */
    public function hotel_useful_phones()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_useful_phones->load();
    }

    /**
     * Call for hotel distances menu
     */
    public function hotel_distances()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_distances->load();
    }


    /**
     * Call for hotel google setup
     */
    public function hotel_google_setup()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_google_setup->load();
    }

    /**
     * Call for hotel email setup
     */
    public function hotel_mail_setup()
    {
        if (!current_user_can($this->sub_menu_pref))
        {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $this->hotel_mail_setup->load();
    }


    /**
     * Add hooks to wordpress
     */
    public function actions()
    {
        add_action('admin_menu', array($this, 'generate_menu'));
    }


    /**
     * Generate all menus
     */
    public function generate_menu()
    {

        // Create the main menus
        foreach ($this->main_menu_build as $main_menu)
        {

            add_menu_page($main_menu['title'], $main_menu['title'], $this->main_menu_pref, $main_menu['slug'], array(
                $this,
                $main_menu['function']
            ), '', $main_menu['position']);

        }

        // Create the sub menus
        foreach ($this->submenus as $submenus)
        {
            add_submenu_page($submenus['assign_to'], $submenus['title'], $submenus['title'], $this->sub_menu_pref, $submenus['slug'], array(
                $this,
                $submenus['function']
            ));
        }

    }


}