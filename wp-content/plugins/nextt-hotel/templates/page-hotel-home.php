<?php
/*
Template Name: Hotel: Home Page
*/
?>

<?php get_header(); ?>

<?php get_template_part('interfaces/headers/header2'); ?>

<?php

// HOTEL FACILITIES
foreach (Getter::get_hotel_facilities() as $fas)
{
    if ($fas['check'] == 'checked')
    {
    }
}

// ROOMS
if (function_exists('nextt_hotel_get_room_info')):
    $rooms_args = array('post_type' => array('room'), 'order' => 'ASC');
    $rooms = new WP_Query($rooms_args);
    while ($rooms->have_posts()):
        nextt_hotel_get_room_info($rooms->post->ID);
    endwhile;
endif;

// BEACHES
if (function_exists('nextt_hotel_get_all_beaches_info')):
    $beaches_args = array('post_type' => array('room'), 'order' => 'ASC');
    $beaches = new WP_Query($beaches_args);
    while ($beaches->have_posts()):
        nextt_hotel_get_all_beaches_info($beaches->post->ID);
    endwhile;
endif;

// SIGHTS
if (function_exists('nextt_hotel_get_all_sights_info')):

    $sights_args = array('post_type' => array('room'), 'order' => 'ASC');
    $sights = new WP_Query($sights_args);
    while ($sights->have_posts()):
        nextt_hotel_get_all_sights_info($sights->post->ID);
    endwhile;
endif;
// HOTEL OPTIONS
Getter::get_hotel_options();

?>


<?php get_footer(); ?>