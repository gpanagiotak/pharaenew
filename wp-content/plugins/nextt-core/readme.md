# Nextt Core Plugin

Nextt core is a wordpress plugin that contains some basic features for programmer mainly. You can think that nextt core
 is a framework or middleware that help us to create custom post types or meta boxes. Nextt core is necessary to be
 installed if you want to use another nextt plugins like Nextt-Hotel


### Installation

1. Copy paste the plugin folder ***"nextt-core"*** in ***wp-content/plugins*** folder

2. Then activate the plugin from ***admin-panel->plugins->nextt-core->activate***

3. Copy and paste the file ***wp-content/plugin/nextt-core/interfaces/assets_loader*** this is the configuration file in
which you can create custom post type, metaboxes, etc...

### Features

A list of nextt core features and how we can use them

### Add Image Category

Add categories to images, by default wordpress images has not categories, with module add image categories you can
add categories

`assets_load.php`

```php
 update_option('add-image-to-categories', array('category', 'types'));
```

___

### Create a Custom Post Type

Nextt allow to you create post type very easlly. To create a new custom post type to file

`assets_loader.php`

```php
<?php

/**
 * * * * * POST TYPE * * * * *
 *
 * SET A NEW POST TYPE:
 *          ARRAY(
 *              ARRAY('POST TYPE KEY', 'SAMPLE POST TYPE' , TAXONOMIES(ARRAY), CATEGORIES),
 *          ... )
 * SET THE TAXONOMIES: ARRAY('TAXONOMY 1', 'TAXONOMY 2' ...)
 */
update_option('post-types', array(
        array(
           'key'  => 'sample_post_type',
           'name' => 'Sample post type',
           'taxonomies' => array('sample taxonomy 1', 'sample taxonomy'),
           'categories' => false
        )
    )
);
```

1. `key`: the unique key for this post type (no spaces)

2. `name`: the name of this post type (no spaces)

3. `taxonomies`: taxonomy is a private category for this post type, you can create you own taxonomies by push the array ex. array(‘sample 1 ‘, ‘sample 2′); // you created 2 taxonomies

4. `categories`: if you want you custom post type share the default wordpress taxonomies (category) set this field equal to true


___

### Generate Meta Boxes

To create you metaboxes visit your `assets_loader.php`

To create a block of metabox define an array with following struck.

```php
<?php
array(
        array(
            'id' => 'asdfff',
            'title' => 'generator',
            'assign_to' => 'page',
            'data' => array( /* here will store you meta boxes of this block */)
        ),
 array(
            'id' => 'asdfff2',
            'title' => 'generator2',
            'assign_to' => 'page',
            'data' => array( /* here will store you meta boxes of this block */)
        )
);
```

`id`: The id should be unique (no uppercase, no spaces)

`title`: The title is just a title but no uppercase, no spaces

`assign_to`: Assign this block to page, post or you custom post type name

`data`: Here will live you meta boxes for each block ( the metaboxes should has always a unique id)


***Textbox***

```php
<?php
// TEXTBOXES
array(
    'title' => 'Meta Box Title',
    'description' => 'Example Text Input',
    'type' => 'text',
    'properties' => array(
        'text-id' => 'meta-text'
    )
),
```



***Checkboxes***
Get value in your page: get_post_meta( get_the_ID(), ‘meta-text’, true );
```php
<?php
// CHECKBOXES
array(
    'title' => 'Meta Box Title',
    'description' => 'Example Text Input',
    'properties' => array(
        'text-id' => 'meta-check-1'
    ),
    'type' => 'checkbox',
    'inputs' => array(
        array(
            'description' => 'this is the first textbox',
            'key' => 'textbox1',
            'value' => 'val1'
        ),
        array(
            'description' => 'this is the second textbox',
            'key' => 'textbox2',
            'value' => 'val2'
        )
    )
),
```
Get value in your page: get_post_meta( get_the_ID(), ‘meta-check-1-textbox1′, true );

pattern to get the value is properties_text_id + “-” + “checkbox_key” for our case is

properties_text_id: meta-check-1

checkbox_key: textbox1

so we have get_post_meta( get_the_ID(), ‘meta-check-1-textbox1′, true );


***Color Picker***
```php
<?php
// COLORPICKER
array(
    'title' => 'COLOR Box Title',
    'description' => 'Example Text Input',
    'type' => 'color',
    'properties' => array(
        'text-id' => 'meta-color'
    )
),
```
Get value in you page: get_post_meta( get_the_ID(), ‘meta-color’, true );


***Images***
```php
<?php
// IMAGES
array(
    'title' => 'COLOR Box Title2',
    'description' => 'Example Text Input2',
    'assign_to' => 'post',
    'type' => 'image',
    'properties' => array(
        'text-id' => 'meta-imageff'
    )
),
```
Get value in you page: get_post_meta( get_the_ID(), ‘meta-imageff’, true );


***Radio Box***
```php
<?php


// RADIO BUTTON
array(
    'title' => 'Meta Box Title',
    'description' => 'Example Text Input',
    'properties' => array(
        'text-id' => 'meta-radio-1'
    ),
    'type' => 'radio',
    'inputs' => array(
        array(
            'description' => 'this is the first textbox',
            'value' => 'val1'
        ),
        array(
            'description' => 'this is the second textbox',
            'value' => 'val2'
        )
    )
),
```
Get value in you page: get_post_meta( get_the_ID(), ‘meta-radio-1′, true );


***Select***
```php
<?php

array(
    'title' => 'Meta Box Title',
    'description' => 'Example Text Input',
    'type' => 'select',
    'properties' => array(
        'text-id' => 'meta-select-1'
    ),
    'inputs' => array(
        array(
            'description' => 'this is the first textbox',
            'value' => 'val1'
        ),
        array(
            'description' => 'this is the second textbox',
            'value' => 'val2'
        )
    )
)
```
Get value in you page: get_post_meta( get_the_ID(), ‘meta-select-1′, true );


***Full Example***
```php
<?php
update_option('generator-meta-boxes',
    array(
        array(
            'id' => 'asdfff',
            'title' => 'generator',
            'assign_to' => 'page',
            'generator' => true,
            'data' => array(

                // TEXTBOXES
                array(
                    'title' => 'Meta Box Title',
                    'description' => 'Example Text Input',
                    'type' => 'text',
                    'properties' => array(
                        'text-id' => 'meta-text'
                    )
                ),
                //CHECKBOXES
                array(
                    'title' => 'Meta Box Title',
                    'description' => 'Example Text Input',
                    'properties' => array(
                        'text-id' => 'meta-check-1-s'
                    ),
                    'type' => 'checkbox',
                    'inputs' => array(
                        array(
                            'description' => 'this is the first textbox',
                            'key' => 'textbox1',
                            'value' => 'val1'
                        ),
                        array(
                            'description' => 'this is the second textbox',
                            'key' => 'textbox2',
                            'value' => 'val2'
                        )
                    )
                ),

                // COLORPICKER
                array(
                    'title' => 'COLOR Box Title',
                    'description' => 'Example Text Input',
                    'type' => 'color',
                    'properties' => array(
                        'text-id' => 'meta-color'
                    )
                ),

                // IMAGES
                array(
                    'title' => 'COLOR Box Title2',
                    'description' => 'Example Text Input2',
                    'assign_to' => 'post',
                    'type' => 'image',
                    'properties' => array(
                        'text-id' => 'meta-imageff'
                    )
                ),
                array(
                    'title' => 'COLOR Box Title2',
                    'description' => 'Example Text Input2',
                    'type' => 'image',
                    'properties' => array(
                        'text-id' => 'meta-imagffff'
                    )
                ),

                // RADIO BUTTON
                array(
                    'title' => 'Meta Box Title',
                    'description' => 'Example Text Input',
                    'properties' => array(
                        'text-id' => 'meta-radio-1'
                    ),
                    'type' => 'radio',
                    'inputs' => array(
                        array(
                            'description' => 'this is the first textbox',
                            'value' => 'val1'
                        ),
                        array(
                            'description' => 'this is the second textbox',
                            'value' => 'val2'
                        )
                    )
                ),

                // SELECT BUTTON
                array(
                    'title' => 'Meta Box Title',
                    'description' => 'Example Text Input',
                    'type' => 'select',
                    'properties' => array(
                        'text-id' => 'meta-select-1'
                    ),
                    'inputs' => array(
                        array(
                            'description' => 'this is the first textbox',
                            'value' => 'val1'
                        ),
                        array(
                            'description' => 'this is the second textbox',
                            'value' => 'val2'
                        )
                    )
                )
            )// end data
        )
    )
);
```

___


### Theme Options

In you `assets_loader.php` file you can create a theme options page

```php
<?php
update_option('generator-theme-options', array(

        // START ADDING THE PAGES

        // FIRST PAGE
        array(
          'title'    => 'General Options',
          'slug'     => 'theme_options_custom',
          'position' => 24,
          'function' => 'theme_options',

          // MAIN PAGE OPTIONS
          'inputs'   => array(

              // HERE WE ARE ADDING A TEXT FIELD
              array(
                  'title'       => 'Hotel Location',
                  'description' => 'Hotel Location',
                  'type'        => 'text',
                  'properties'  => array(
                      'text-id' => 'hotel_location',
                      'value'   => '',
                  ),
              ),
          ),

          // WE CAN ADD SUB PAGES TOO
          'submenu'  => array(

          )

        )

    )
);
```

***FULL EXAMPLE***

```php
<?php
update_option('generator-theme-options', array(
        // MAIN PAGE
        array(
            'title'    => 'General Options',
            'slug'     => 'theme_options_custom',
            'position' => 24,
            'function' => 'theme_options',
            // MAIN PAGE OPTIONS
            'inputs'   => array(
                array(
                    'title'       => 'Hotel Location',
                    'description' => 'Hotel Location',
                    'type'        => 'text',
                    'properties'  => array(
                        'text-id' => 'hotel_location',
                        'value'   => '',
                    ),
                ),
            ),
            // ADD SUBMENUS #1
            'submenu'  => array(
              array(
                  'title'     => 'General Options',
                  'slug'      => 'general_options',
                  'function'  => 'general_options',
                  'assign_to' => 'theme_options',
                  // SUBMENU #1 SAMPLE TEXT INPUT
                  'inputs'    => array(
                      // INPUT TYPE TEXT
                      array(
                          'title'       => 'Subtitle 4',
                          'description' => 'Subtitle 4',
                          'type'        => 'text',
                          'properties'  => array(
                              'text-id' => 'houses_subtitle_44',
                              'value'   => 'this is a text box'
                          )
                      ),
                      // INPUT TYPE CHECKBOX
                      array(
                          'title'       => 'Checkbox',
                          'description' => 'Checkbox1',
                          'type'        => 'checkbox',
                          'properties'  => array(
                              'text-id'  => 'houses_checkbox',
                              'defvalue' => 'thisisatestvalue',
                              'value'    => ''
                          ),
                      ),
                      // INPUT TYPE COLOR BOX
                      array(
                          'title'       => 'COLOR Box Title',
                          'description' => 'Example Text Input',
                          'type'        => 'color',
                          'properties'  => array(
                              'text-id' => 'meta-color',
                              'value'   => ''
                          )
                      ),
                      // INPUT TYPE RADIO
                      array(
                          'title'       => 'Meta Box Title',
                          'description' => 'Example Text Input',
                          'type'        => 'radio',
                          'properties'  => array(
                              'text-id' => 'meta-radio-1',
                              'value'   => ''
                          ),
                          'inputs'      => array(
                              array(
                                  'description' => 'this is the first textbox',
                                  'value'       => 'val1'
                              ),
                              array(
                                  'description' => 'this is the second textbox',
                                  'value'       => 'val2'
                              )
                          )
                      ),
                      // INPUT TYPE IMAGE
                      array(
                          'title'       => 'COLOR Box Title2',
                          'description' => 'Example Text Input2',
                          'assign_to'   => 'post',
                          'type'        => 'image',
                          'properties'  => array(
                              'text-id' => 'meta-imageff',
                              'value'   => ''
                          )
                      ),
                      // INPUT TYPE SELECT
                      array(
                          'title'       => 'Meta Box Title',
                          'description' => 'Example Text Input',
                          'type'        => 'select',
                          'properties'  => array(
                              'text-id' => 'meta-select-1',
                              'value'   => ''
                          ),
                          'inputs'      => array(
                              array(
                                  'description' => 'this is the first textbox',
                                  'value'       => 'val1'
                              ),
                              array(
                                  'description' => 'this is the second textbox',
                                  'value'       => 'val2'
                              )
                          )
                      )
                  )
              )
            ),
        ),
    )
 );
```

___


### Create Sidebar
Module Side Bar Allow to you create sidebars

To enable the sidebar to go `assets_loader.php`

```php
<?php
/**
 * * * * * SIDEBAR * * * * *
 *
 * SET UP SIDEBAR: ARRAY('SIDEBAR 1', 'SIDEBAR 2 ', ...)
 */
update_option('main-sidebar', true);
update_option('sidebars',
    array(
        //   'sidebar-1'
    )
);
```

By default the Main Siderbar is created

___


### Interface 4 Widget Footer


To enable the ***4 widgets footer*** add the line in `assets_load.php`

```php
<?php

update_option('4-widgets-footer', true);
```

Then you can call the footer interfaces with

```php
<?php
 require_once NEXTT_CORE_PATH."/interfaces/footers/4-widgets-footer/bx-slider.php" ?>
```

___

### Interface Copyright


Copyright interfaces leaves in ***nextt-core/interfaces/copyright/*** folder.
 Contains a text and advertek link image from s3 amazon.

```php
<?php

update_option('copyright-text',  'COPYRIGHT 2015 interfaces/assets_loader.php file ');
```

Then you can call the footer interfaces with

```php
<?php
 require_once NEXTT_CORE_PATH."/interfaces/copyright/copyright-dark.php" ?>
```

___

### Interface Headers 1,2 and 3


You can call a header file

```php
<?php
 require_once NEXTT_CORE_PATH."/interfaces/headers/headerX.php" ?>
```

where x the header number

___

### MODULE Page Templater

Page Templater give you the ability to add a custom page from plugin folder to the theme.

You can use the page templater like:

```php
<?php
     Page_Templater::get_instance(plugin_dir_path( __FILE__ ), array('/templates/my-custom-page.php' => 'custom-page');

```


### MODULE Page Patterns

Page pattern creates a custom post type with some stander features like title, subtitle and wally metaboxes. You can
use this module if you want to create a custom post type very fast

```php
<?php
/**
 * Class Page_Pattern_Manager
 * Create a custom post type with Pattern
 * usage: new Hotel_Beach()
 * include: Hotel.php
 */
class Page_Pattern_Manager {


	public static $PATTERN_PREF = array(
		'key' => 'beaches',
		'post_type_title'=> 'Beaches'
	);

	public static $PATTERN_PARAMS;

	private $page_pattern;

	function __construct(){
		self::$PATTERN_PARAMS = \Page_Pattern::define_pref(self::$PATTERN_PREF);
	}

	public function actions(){
		$this->page_pattern = new \Page_Pattern(self::$PATTERN_PREF);

		$this->page_pattern->actions();
	}

}

$page_pattern = new Page_Pattern_Manager();
$page_pattern->actions();
```
