<?php
// basic
//include_once('helpers.php');

function static_load()
{
    $values = array(

        '/core/modules/image-categories/Image_Categories.php',

        '/core/modules/meta-boxes/Meta_Selector.php',
        '/core/modules/meta-boxes/Meta_Box_Generator.php',
        '/core/modules/meta-boxes/Meta_Box.php',

        '/core/modules/meta-boxes/components/Checkbox_Meta.php',
        '/core/modules/meta-boxes/components/Color_Meta.php',
        '/core/modules/meta-boxes/components/Image_Meta.php',
        '/core/modules/meta-boxes/components/Radio_Meta.php',
        '/core/modules/meta-boxes/components/Text_Meta.php',
        '/core/modules/meta-boxes/components/Select_Meta.php',
        '/core/modules/meta-boxes/components/Textarea_Meta.php',

        '/core/modules/post-types/Post_Types.php',
        '/core/modules/theme-options/Theme_Options.php',
        '/core/modules/page-templater/Page_Templater.php',
        '/core/modules/page_patterns/Page_Pattern.php',

        '/core/shortcodes/accordion/Accordion_Shortcode.php',
        '/core/shortcodes/actions_box/Action_Box_Shortcode.php',
        '/core/shortcodes/column/Column.php',
        '/core/shortcodes/button/Button.php',
        '/core/shortcodes/div/Div.php',
        '/core/shortcodes/hide_more/Hide_More.php',
        '/core/shortcodes/hr/Hr.php',
        '/core/shortcodes/image_text/Image_Text.php',
        '/core/shortcodes/Popup/Popup.php',
        '/core/shortcodes/table/Table.php',
        '/core/shortcodes/title/Title.php',
        '/core/shortcodes/Actions_Shortcodes.php',
        '/core/shortcodes/Register_Shortcodes.php',
        '/core/Assets.php',
        '/core/Theme_Functions.php',
        'core/Nextt_Dynamic_Code.php',

        '/core/fetcher/theme-options/Fetch_Theme_Options.php',
        '/core/fetcher/metaboxes/Fetcher_Metaboxes.php',
        '/core/fetcher/Fetcher.php',

        '/core/Settings.php'
    );


    foreach ($values as $value)
    {
        //see if the file exsists
        if (file_exists(get_stylesheet_directory() . $value))
        {
            require_once(get_stylesheet_directory() . $value);
        } elseif (file_exists(get_template_directory() . $value))
        {
            require_once(get_template_directory() . $value);
        } elseif (file_exists(NEXTT_CORE_PATH . $value))
        {
            require_once(NEXTT_CORE_PATH . $value);
        } else
        {
            echo  "Error: File not found " . $value . " <br>";
        }

    }
}


