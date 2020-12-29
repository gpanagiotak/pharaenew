<?php


/**
 * * * * MENU * * * * *
 * Custom styles for menu
 */
update_option('load-css-menu', false);


/**
 * * * * JQUERY * * * * *
 * Replace the wordpress jq
 */
update_option('load-js-jquery', true);
update_option('load-css-jquery-ui', true);
update_option('load-js-jquery-migrate', true);
update_option('load-js-jquery-ui', true);


/**
 * * * * BOOTSTRAP * * * * *
 * Some shortcodes and some pages
 * require bootstrap css and js
 */
update_option('load-css-bootstrap', true);
update_option('load-js-bootstrap', true);


/**
 * * * * WOW - ANIMATION  * * * * *
 * For custom animation
 */
update_option('load-js-wow', true);
update_option('load-css-animate', true);


/**
 * * * * CONTACT FORM 7  * * * * *
 * Custom styling for plugin "constant form 7"
 */
update_option('load-css-contactform7', true);


/**
 * * * * CUSTOM SCROLL BAR * * * * *
 * Custom Scroll Bar
 */
update_option('load-css-scroll-bar', true);
update_option('load-js-scroll-bar', true);


/**
 * * * * * FONT AWESOME * * * * *
 * font-awesome icons
 */
update_option('load-css-font-awesome', true);

/**
 * * * * SETTINGS * * * * *
 */
// Remove the auto p from tinymce
update_option('setting-remove-auto-p', false);
// Add copyright text
update_option('copyright-text', 'COPYRIGHT 2015 interfaces/assets_loader.php file ');
// Enable the 4-widgets-footer
update_option('4-widgets-footer', true);

//    Add Image to Categories params array('category', 'anothe taxonomy')
//update_option('add-image-to-categories', array('category', 'types'));


/**
 * * * * SHORTCODE  * * * * *
 * Require for shortcodes DON'T DISABLE THOSE OPTIONS
 */
// The assets
update_option('load-css-shortcodes', true);
update_option('load-js-shortcodes', true);
// The shortcodes modules
update_option('shortcode-col', true); // REQUIRED BOOTSTRAP
update_option('shortcode-active-box', true);
update_option('shortcode-drop-cap', true);
update_option('shortcode-accordion', true);
update_option('shortcode-title', true);
update_option('shortcode-div', true);
update_option('shortcode-gallery', true); // REQUIRE LIGHTTBOX GALLERY MODULE
update_option('shortcode-imagetext', true);
update_option('shortcode-button', true);
update_option('shortcode-hidemore', true);
update_option('shortcode-table', true);
update_option('shortcode-image-lightbox', true);
update_option('shortcode-hr', true);
update_option('shortcode-popup', true);
update_option('shortcode-wally', true);


/**
 * * * * * SIDEBAR * * * * *
 * SET UP SIDEBAR: ARRAY('SIDEBAR 1', 'SIDEBAR 2 ', ...)
 */
update_option('main-sidebar', true);
update_option('sidebars', array(//   'sidebar-1'
    ));


/***********************************************    PAGES   ***********************************************************/



/*********************************************    GOOGLE     **********************************************************/

/**
 * * * * * GOOGLE MAP * * * * *
 * LAT: FLOAT REQUIRED
 * LONG: FLOAT REQUIRED
 * ZOOM: INT (DEFAULT IS 6)
 * ID: STRING (DEFAULT IS MAP)
 */
update_option('load-js-google-map', true);
update_option('google-map', array(
    'lat'  => 36.868704,
    'long' => 22.246492,
    'zoom' => 6,
    'id'   => 'map',
));

/*********************************************   BX-SLIDER  ************************************************************/

/**
 * * * * BX-SLIDER * * * * *
 * Our Slider use those dependencies
 */
update_option('load-js-bxslider', true);
update_option('load-css-bxslider', true);
update_option('load-css-bxslider-custom-styles', true);


/**
 * * * * * * BX-SLIDER SET UP * * * * * *
 * ARRAY()
 * DISABLE THE BX SLIDER update_option('bx-slider',  array('enable' => false, 'js-options' => '{mode: "fade", captions: true, autoControls: true}', 'add'=> array()));
 * ENABLE THEM BX SLIDER update_option('bx-slider',  array('enable' => true, 'js-options' => '{mode: "fade", captions: true, autoControls: true}', 'add'=> array()));
 * ENABLE THEM BX SLIDER update_option('bx-slider',  array('enable' => true, 'add'=> array('new_1', 'js-options' => '{mode: "fade", captions: true, autoControls: true}', 'new_2')));
 * DEFAULT IS default bx slider
 */
update_option('bx-slider', array(
    'enable'     => false,
    'js-options' => '{mode: "fade", captions: false, autoControls: false, onSliderLoad: function() { jQuery(".bxslider").css("visibility", "visible");}}',
    'add'        => array(),
));


/******************************************     LIGHT BOX    **********************************************************/


/**
 * * * * LIGHT BOX * * * * *
 * We have a post type "gallery"
 */
update_option('load-css-lightbox', true);
update_option('load-js-lightbox', true);

/**
 * * * * *  Gallery * * * *
 * array
 *  enable = true/false
 *  add = the taxonomy taname array('tax1', 'tax2')
 */
update_option('lightbox-gallery', array(
    'enable' => false,
    'add'    => array(),
));


/******************************************     WALLY    **********************************************************/


/**
 * * * * WALLY * * * * *
 * We have a post type "gallery"
 */
update_option('load-css-wally', true);
update_option('load-js-wally', true);

/**
 * * * * *  Gallery * * * *
 * array
 *  enable = true/false
 *  add = the taxonomy taname array('tax1', 'tax2')
 */
update_option('wally-gallery', array(
    'enable' => true,
    'add'    => array(),
));


/****************************************   POST TYPE   ****************************************************************/


/**
 * * * * * POST TYPE * * * * *
 * SET A NEW POST TYPE:
 *          ARRAY(
 *              ARRAY('POST TYPE KEY', 'SAMPLE POST TYPE' , TAXONOMIES(ARRAY), CATEGORIES),
 *          ... )
 * SET THE TAXONOMIES: ARRAY('TAXONOMY 1', 'TAXONOMY 2' ...)
 */
update_option('post-types', array(
    //        array(
    //            'key'  => 'sample_post_type',
    //            'name' => 'Sample post type',
    //            'taxonomies' => array('sample taxonomy 1', 'sample taxonomy'),
    //            'categories' => false,
    //            'show_in_nav_menus' => true,
    //	        'icon' => ''
    //        )
));


/*******************************************     HOTEL MODULES      ****************************************************/
update_option('hotel', true);


/*******************************************     METABOXES   **********************************************************/

update_option('generator-meta-boxes', array(
        //        array(
        //            'id' => 'asdf',
        //            'title' => 'generator',
        //            'assign_to' => 'post',
        //            'generator' => true,
        //            'data' => array(
        //
        //                // TEXTBOXES
        //                    array(
        //                    'title' => 'Meta Box Title',
        //                    'description' => 'Example Text Input',
        //                    'type' => 'text',
        //                    'properties' => array(
        //                        'text-id' => 'meta-text'
        //                    )
        //                ),
        //                // CHECKBOXES
        //                array(
        //                    'title' => 'Meta Box Title',
        //                    'description' => 'Example Text Input',
        //                    'properties' => array(
        //                        'text-id' => 'meta-check-1'
        //                    ),
        //                    'type' => 'checkbox',
        //                    'inputs' => array(
        //                        array(
        //                            'description' => 'this is the first textbox',
        //                            'key' => 'textbox1',
        //                            'value' => 'val1'
        //                        ),
        //                        array(
        //                            'description' => 'this is the second textbox',
        //                            'key' => 'textbox2',
        //                            'value' => 'val2'
        //                        )
        //                    )
        //                ),
        //
        //                // COLORPICKER
        //                array(
        //                    'title' => 'COLOR Box Title',
        //                    'description' => 'Example Text Input',
        //                    'type' => 'color',
        //                    'properties' => array(
        //                        'text-id' => 'meta-color'
        //                    )
        //                ),
        //
        //                // IMAGES
        //                array(
        //                    'title' => 'COLOR Box Title2',
        //                    'description' => 'Example Text Input2',
        //                    'assign_to' => 'post',
        //                    'type' => 'image',
        //                    'properties' => array(
        //                        'text-id' => 'meta-imageff'
        //                    )
        //                ),
        //                array(
        //                    'title' => 'COLOR Box Title2',
        //                    'description' => 'Example Text Input2',
        //                    'type' => 'image',
        //                    'properties' => array(
        //                        'text-id' => 'meta-imagffff'
        //                    )
        //                ),
        //
        //                // RADIO BUTTON
        //                array(
        //                    'title' => 'Meta Box Title',
        //                    'description' => 'Example Text Input',
        //                    'properties' => array(
        //                        'text-id' => 'meta-radio-1'
        //                    ),
        //                    'type' => 'radio',
        //                    'inputs' => array(
        //                        array(
        //                            'description' => 'this is the first textbox',
        //                            'value' => 'val1'
        //                        ),
        //                        array(
        //                            'description' => 'this is the second textbox',
        //                            'value' => 'val2'
        //                        )
        //                    )
        //                ),
        //
        //                // SELECT BUTTON
        //                array(
        //                    'title' => 'Meta Box Title',
        //                    'description' => 'Example Text Input',
        //                    'type' => 'select',
        //                    'properties' => array(
        //                        'text-id' => 'meta-select-1'
        //                    ),
        //                    'inputs' => array(
        //                        array(
        //                            'description' => 'this is the first textbox',
        //                            'value' => 'val1'
        //                        ),
        //                        array(
        //                            'description' => 'this is the second textbox',
        //                            'value' => 'val2'
        //                        )
        //                    )
        //                )
        //            )// end data
        //        )
    ));












