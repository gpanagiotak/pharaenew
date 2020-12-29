<?php

namespace Nextt_Wally\ShortCode;

require_once "Short_Code_Handler.php";

/**
 * Class ShortCodeManager
 * @package Wally\ShortCode
 *          Add the wally short code
 */
class Short_Code_Manager
{


    /**
     * Short_Code_Manager constructor.
     */
    public function __construct()
    {
        // nothing yet
    }

    /**
     * Add the short codes
     */
    public function addShortCode()
    {

        \NexttCore::$ActionsShortCodes->shortcode_pusher(array(
            'option' => 'shortcode-wally',
            'object' => new Short_Code_Handler(),
        ));
        \NexttCore::$RegisterShortCodes->shortcode_pusher(array(
            "id" => "wally",
            "option" => "shortcode-wally",
            "js" => NEXTT_WALLY_URL.'assets/js/wally_short_code.js'
        ));

    }

}