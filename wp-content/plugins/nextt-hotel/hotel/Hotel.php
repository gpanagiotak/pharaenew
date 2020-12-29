<?php
//include_once  TEMPLATEPATH.'/core/autoload.php';
//load(array('Options', 'Room_Types'));


/**
 * Class Hotel
 */
class Hotel
{
    
    /**
     * The Option pages aboutthe hotel
     * @var \Options
     */
    private $options;
    
    /**
     * Initialize the class' objects
     */
    function __construct($data)
    {

        if(!$data['basics_features']) {
            return;
        }

        add_action('admin_enqueue_scripts', array(
            $this,
            'general_hotel_css',
        ));

        $this->options = new Options();
        $this->options->actions();
        
    }

    public function general_hotel_css()
    {
        wp_enqueue_style('hotel-general-css', NEXTT_HOTEL_URL.'/hotel/hotel-assets/hotel.css');
        wp_enqueue_style('hotel-facilities-icon-css', NEXTT_HOTEL_URL.'/hotel/hotel-assets/hotel-facilities.css');
        wp_enqueue_style('hotel-icon-css', NEXTT_HOTEL_URL.'/hotel/hotel-assets/icons_css.css');

    }


}