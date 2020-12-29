<?php

namespace Nextt_SLICKJS_Slider;


/**
 * Class BX_Slider_Settings
 */
class SLICKJS_Slider_Settings{

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
        if(!class_exists('NexttCore')){
            add_action('admin_notices', array( $this, 'NexttCoreError'));
            return false;
        }

        return true;
    }

    /**
     * -- Action Function --
     * Display an error message at admin panel
     */
    public function NexttCoreError()
    {
        ?>
        <div class="notice notice-error is-dismissible">
            <p> Nextt SlickJs Plugin requires Nextt Core Plugin  </p>
        </div>
        <?php
    }
    
}