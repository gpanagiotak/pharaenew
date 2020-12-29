### Next Hotel

Nextt Hotel is a plugin that help the user creates hotel's sites

 Nextt Hotel offers to you the abilities:

 1. to add facilities

 2. to add your travel agents

 3. to add your social networks

 4. to add phones and contact options

 5. to add distances

 6. to add google analytics, lat and long

 you can enable and disable those features

### Installation

 1. Copy paste the plugin folder ***"nextt-core"*** in ***wp-content/plugins*** folder

 2. Then activate the plugin from ***admin-panel->plugins->nextt-core->activate***

 `The Nextt Core plugin is required`

### Configuration

 In your `assets_loader.php` file you can enable and disable some of the basics features of nextt-hotel plguin

 ```php

 update_option('hotel', array(
         'basics_features' => true,
         'facilities'=>true,
         'agents'=>true,
         'socials_networks'=>true,
         'phones'=>true,
         'distances'=>true,
         'google_setup'=>true,
     )
 );

 ```

### API


You have to the API via Getter::

```php
/**
 * Class Getter
 *
 * Getter is responsible to get hotel data
 *
 * usage: Getter::some_method()
 *
 * included: Hotel.php
 */
class Getter
{

    /**
     * Initialize the object
     */
    function __construct()
    {

    }

    /**
     * Get the hotel facilities
     * @return mixed
     */
    public static function get_hotel_facilities()
    {
        return (new Hotel_Facilities_Getter())->get_hotel_facilities();
    }

    /**
     * Get the hotel options
     * @return mixed
     */
    public static function get_hotel_options()
    {
        return (new Hotel_Option_Getter())->get_options();
    }

    /**
     * Get hotel google setup theme options
     * @return mixed|void
     */
    public static function get_hotel_google_setup()
    {
        return (new Hotel_Google_Setup_Getter())->get_google_options();
    }

    /**
     * Get travel agents options
     * @return mixed|void
     */
    public static function get_travel_agents_options()
    {
        return (new Hotel_Travel_Agents_Getter())->get_travel_agents_options();
    }

    /**
     * Get hotel socials options
     * @return mixed|void
     */
    public static function get_hotel_socials()
    {
        return (new Hotel_Socials_Getter())->get_hotel_socials();
    }

    /**
     * Get hotel useful phones options
     * @return mixed|void
     */
    public static function get_hotel_useful_phones()
    {
        return (new Hotel_Useful_Phones_Getter())->get_hotel_useful_phones();
    }

    /**
     * Get hotel distances options
     * @return mixed|void
     */
    public static function get_hotel_distances()
    {
        return (new Hotel_Distances_Getter())->get_hotel_distances();
    }

}
```