# Nextt hotel Room

With Nextt Hotel Room you can store the hotel rooms


### Installation


 1. Copy paste the plugin folder ***"nextt-hotel-rooms"*** in ***wp-content/plugins*** folder

 2. Then activate the plugin from ***admin-panel->plugins->nextt-hotel-rooms->activate***

 `Nextt Core plugin is required to be installed`


### Usage

 Store your rooms types in the new custom post type ***Room Types***. Next add you can create a new page
 and select the template as Hotel: Rooms in order to display the rooms

 Also you can copy and paste from ***wp-content/plugins/nextt-hotel-room/templates/page-hotel-rooms.php***
 in your theme main folder.


### API


***nextt_hotel_get_room_facilities($post_id)*** get all facilities for the room

```php
function nextt_hotel_get_room_facilities($post_id)
{
    return (new Nextt_Hotel_Room_Type\Room_Facilities_Getter())->get_room_types($post_id);
}
```


***nextt_hotel_get_room_info($post_id)*** get room type info

```php
function nextt_hotel_get_room_info($post_id)
{
    return (new Nextt_Hotel_Room_Type\Room_Facilities_Getter())->get_room_info($post_id);
}

```
