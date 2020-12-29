### Nextt Hotel Beaches

With Nextt Hotel Beaches plugin you can add the hotel beaches.

### Installation

 1. Copy paste the plugin folder ***"nextt-hotel-beaches"*** in ***wp-content/plugins*** folder

 2. Then activate the plugin from ***admin-panel->plugins->nextt-hotel-beaches->activate***

 `Nextt Core and Nextt Hotel plugins is required to be installed`


### Usage

After the installation a `Beaches` custom post type have to be appeared in the admin's menu. You can store
 your beaches post there.

Also the plugin give a custom page type that you can add. You can go and create a new page from the admin's menu
 and select the template as ***Hotel: Beaches***


### API

The ***nextt_hotel_get_all_beaches_info($beach_post_id)*** give to you all metaboxes for a beach post

```php
/**
 * Get all post for the beaches
 *
 * @param $post_id
 *
 * @return array
 */
function nextt_hotel_get_all_beaches_info($post_id){
    $hotel_beaches_getter = new Nextt_Hotel_Beaches\Hotel_Beach_Getter();
    return $hotel_beaches_getter->get_hotel_beaches_info($post_id);
}
```





