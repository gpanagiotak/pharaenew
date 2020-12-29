<?php
/*
Setting: genius_book_online_now
*/

piklist('field', array(
	'type' 			=> 'text',
	'field' 		=> 'hotel_link',
	'label' 		=> __( 'Hotel Link', 'genius_theme' ),
	'description' 	=> __( 'Enter hotel link for Book Online Now Booking engine.', 'genius_theme' ),
	'value'			=> 'https://pharae.book-onlinenow.net/index.aspx',
	'columns'		=> 6
));


piklist('field', array(
	'type' 			=> 'radio',
	'field' 		=> 'form_labels',
	'list'			=> false,
	'label' 		=> __( 'Labels', 'genius_theme' ),
	'description' 	=> __( 'Show labels instead of placeholders in booking form.', 'genius_theme' ),
	'choices'		=> array(
		'on'	=> __( 'On', 'genius_theme' ),
		'off'	=> __( 'Off', 'genius_theme' ),
	),
	'value'			=> 'off'
));


piklist('field', array(
	'type' 			=> 'radio',
	'field' 		=> 'form_checkin',
	'list'			=> false,
	'label' 		=> __( 'Check In', 'genius_theme' ),
	'description' 	=> __( 'Show check in field in booking form.', 'genius_theme' ),
	'choices'		=> array(
		'on'	=> __( 'On', 'genius_theme' ),
		'off'	=> __( 'Off', 'genius_theme' ),
	),
	'value'			=> 'on'
));


piklist('field', array(
	'type' 			=> 'radio',
	'field' 		=> 'form_checkout',
	'list'			=> false,
	'label' 		=> __( 'Check Out', 'genius_theme' ),
	'description' 	=> __( 'Show check out field in booking form.', 'genius_theme' ),
	'choices'		=> array(
		'on'	=> __( 'On', 'genius_theme' ),
		'off'	=> __( 'Off', 'genius_theme' ),
	),
	'value'			=> 'on'
));


piklist('field', array(
	'type' 			=> 'text',
	'field' 		=> 'form_rooms',
	'list'			=> false,
	'label' 		=> __( 'Rooms', 'genius_theme' ),
	'description' 	=> __( 'Maximum number of rooms. Use 0 to disable the field.', 'genius_theme' ),
	'value'			=> 5,
	'attributes'	=> array(
		'class' => 'small-text'
	)
));


piklist('field', array(
	'type' 			=> 'text',
	'field' 		=> 'form_adults',
	'list'			=> false,
	'label' 		=> __( 'Adults', 'genius_theme' ),
	'description' 	=> __( 'Maximum number of adults. Use 0 to disable the field.', 'genius_theme' ),
	'value'			=> 5,
	'attributes'	=> array(
		'class' => 'small-text'
	)
));


piklist('field', array(
	'type' 			=> 'text',
	'field' 		=> 'form_children',
	'list'			=> false,
	'label' 		=> __( 'Children', 'genius_theme' ),
	'description' 	=> __( 'Maximum number of children. Use 0 to disable the field.', 'genius_theme' ),
	'value'			=> 5,
	'attributes'	=> array(
		'class' => 'small-text'
	)
));


piklist('field', array(
	'type' 			=> 'text',
	'field' 		=> 'form_button',
	'list'			=> false,
	'label' 		=> __( 'Button Text', 'genius_theme' ),
	'description' 	=> __( 'Text for the form button.', 'genius_theme' ),
	'value'			=> 'Check Availability'
));