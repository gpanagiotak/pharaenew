<?php

namespace Nextt_Hotel_Room_Type;

class Hotel_Rooms_Settings
{
    /**
     * Settings constructor.
     */
    public function __construct()
    {
        // nothing yet
    }

    /**
     * Initialize the wordpress methods
     */
    public function actions()
    {
    }

    /**
     * Check if the associations is already installed in wordpress
     */
    public function associations()
    {
        if (!class_exists('NexttCore'))
        {
            add_action('admin_notices', array($this, 'WPMLError'));
            return false;
        }

        if (!class_exists('Hotel'))
        {
            add_action('admin_notices', array($this, 'WPMLError'));
            return false;
        }

        return true;
    }

    /**
     * -- Action Function --
     * Display an error message at admin panel
     */
    public function WPMLError()
    {
        ?>
        <div class="notice notice-error is-dismissible">
            <p> Nextt Hotel Plugin: You have to install Nextt Core and Nextt Hotel plugins </p>
        </div>
        <?php
    }
    
}