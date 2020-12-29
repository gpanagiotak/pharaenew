<?php
/*
Setting: genius_theme
*/

piklist('field', array(
	'type' 			=> 'file',
	'field' 		=> 'default_page_slider',
	'label' 		=> __( 'Default Slider Images', 'genius_theme' )
));

piklist('field', array(
	'type'			=> 'text',
	'field'			=> 'random_text',
	'label' 		=> __( 'Enter text', 'genius_theme' ),
	'help' 			=> __( 'Enter text.', 'genius_theme' ),
));

piklist('field', array(
	'type'			=> 'file',
	'field'			=> 'attached_file',
	'label' 		=> __( 'Upload a file', 'genius_theme' ),
	'help' 			=> __( 'Add your file.', 'genius_theme' )
));