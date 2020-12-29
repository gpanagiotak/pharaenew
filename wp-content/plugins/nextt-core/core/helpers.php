<?php

    /**
     * check if the file exist in child theme directory
     * and include it, if the file not exist in stylesheet
     * then include it from parent theme
     */
    function include_this($path){

        if($path == '') return;

        if(file_exists(get_stylesheet_directory().$path)){
            $path = get_stylesheet_directory().$path;
            include_once($path);
        }
        elseif(file_exists(get_template_directory().$path)){
            $path = get_template_directory().$path;
            include_once($path);
        }
        elseif(file_exists(NEXTT_CORE_PATH.$path)){
            $path = NEXTT_CORE_PATH.$path;
            include_once($path);
        }
    }

    function require_this($path){
        if($path == '') return;

        if(file_exists(get_stylesheet_directory().$path)){
            $path = get_stylesheet_directory().$path;
            require_once($path);
        }
        elseif(file_exists(get_template_directory().$path)){
            $path = get_template_directory().$path;
            require_once($path);
        }
        elseif(file_exists(NEXTT_CORE_PATH.$path)){
            $path = NEXTT_CORE_PATH.$path;
            require_once($path);
        }

    }

    /**
     * return the path of the existed file as a string so it can be enqueued
     */
    function enqueue_this($path){
        if($path == '') return;
        if(file_exists(get_stylesheet_directory().$path)){
            $path = get_stylesheet_directory_uri().$path;
            return $path;
        }
        // elseif(file_exists(get_template_directory().$path)){
        //     $path = get_template_directory().$path;
        //     return $path;
        // }
        elseif(file_exists(plugin_dir_path(__FILE__).$path)){
            $path = NEXTT_CORE_URL."core".$path;
            return $path;
        }
    }

    /**
     * Check if the file exist and return the path
     * from parent or the child theme
     */
    function return_the_path($file){
        if($file == '') return;
        $file = NEXTT_CORE_URL.$file;
        return $file;
    }

    

    function create_nextt_mobile_menu($nextt_mobile_menu_name,$nextt_mobile_menu_location){ ?>
        <div id="nextt-mobile-menu">
            <?php wp_nav_menu(array(
            'menu' => $nextt_mobile_menu_name,
            'theme_location' => $nextt_mobile_menu_location,
            'depth' => 4,
            'container' => 'div',
            'container_class' => '',
            'container_id' => '',
            'menu_class' => '',
            'fallback_cb' => 'false',
        )); ?>
    </div>
    <?php }



