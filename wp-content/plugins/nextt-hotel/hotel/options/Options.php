<?php

/**
 * Class Options
 *
 * included: Hotel.php
 */
class Options {

    /**
     * Generate the hotel's options menu
     * @var \Generate_Menu
     */
    private $generate_menu;


    /**
     * Initialize the Object
     */
    function __construct(){



    }

    /**
     * Fire the hotel's modules
     */
    public function actions(){
        $this->generate_menu = new Generate_Menu();
        $this->generate_menu->actions();
    }




}