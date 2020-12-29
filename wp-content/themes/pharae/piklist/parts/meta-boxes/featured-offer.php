<?php
/*
Title: Featured
Post Type: offer
Order: 2
Context: side
*/

piklist('field', array(
	'type' 				=> 'radio',
	'field' 			=> 'featured_offer',
	'description' 		=> __( 'Choose enable to show this offer on home page slider.', 'genius_theme' ),
	'choices'			=> array(
		'on' => 'Enable',
		'off' => 'Disable'
	),
	'value'				=> 'off'
));