<?php

/**
 * Class Settings
 * Configure all the settings
 */
class Settings
{

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->actions();
    }

    /**
     * Check if the associations is already installed in wordpress
     */
    public function actions()
    {
        if(!class_exists('SitePress')){
            add_action('admin_notices', array( $this, 'WPMLError'));
            return true;
        }
        return false;
    }

    /**
     * Display an error message at admin panel
     */
    public function WPMLError()
    {
        ?>
        <div class="notice notice-error is-dismissible">
            <p>You have to install WPML plugin </p>
        </div>
        <?php
    }

}