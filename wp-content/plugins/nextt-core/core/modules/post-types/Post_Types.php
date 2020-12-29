<?php
/**
 *  THIS IS RESPONSIBLE ABOUT GENERATE CUSTOM POST TYPE
 *  WITH PRIVATE TAXONOMIES.
 *  ENABLE THIS IN INTERFACES/ASSETS_LOADER.PHP
 */

/**
 * Class Post_Types
 *
 * Create a new custom post type
 *
 * useage: new Post_Types(array('enable' => false, 'add'=> array()))
 *
 */
class Post_Types{

    /**
     * @var mixed|void
     */
    private $post_types_definition;
    static $post_types_names;

	public static $default_icon = 'dashicons-screenoptions';


    /**
     * Initialize the class
     */
    function __construct($meta){

        Post_Types::$post_types_names = array('post', 'page');
        if($meta == null){
            $this->post_types_definition = array();
        }else{
            $this->post_types_definition = $meta;
        }
        $this->actions();

    }

    /**
     * Add action to wordpress
     */
    public function actions(){
        $post_types_definition = $this->post_types_definition;

        if(count($post_types_definition) > 0){
            add_action( 'init', array($this, 'my_register_post_type') );
            add_action( 'admin_menu', array($this, 'register_post_type_settings') );
        }
    }

    /**
     * Register a post type, loop for each data in options and then call the method get_args_array()
     * To register the post type
     */
    public function my_register_post_type(){

//        add_action ('admin_menu', function($post_type){
//            add_submenu_page('edit.php?post_type='.$post_type['key'], $post_type['name'].' Settings Page', 'Custom Settings', 'edit_posts', $post_type['key'], array($this, 'custom_post_type_settings'));
//        }, 10, 1 );


        foreach($this->post_types_definition as $post_type){


            $key = $post_type['key'];
            $name = $post_type['name'];
	        $icon = self::$default_icon;
            if(isset($post_type['icon'])){
                $icon = $post_type['icon'];
            }

            if(isset($post_type['publicly_queryable'])){
                $publicly_queryable = $post_type['publicly_queryable'];
            }

            $show_in_menu = false;
            if(isset($post_type['show_in_nav_menus'])){
                $show_in_menu = $post_type['show_in_nav_menus'];
            }
            Post_Types::$post_types_names[]=$key;

            // this is the native wordpress function
            register_post_type( $key, $this->get_args_array($name, $show_in_menu, $icon, $publicly_queryable));

            $this->register_taxonomies($post_type);
        }
        add_theme_support( 'post-thumbnails', Post_Types::$post_types_names );

    }


// GEORGIOS STAFF
    public function register_post_type_settings(){
        foreach($this->post_types_definition as $post_type){
            add_submenu_page('edit.php?post_type='.$post_type['key'], $post_type['name'].' Settings Page', 'Custom Settings', 'edit_posts', $post_type['key'], array($this, 'custom_post_type_settings'));
        }
    }




// GEORGIOS STAFF

    public function custom_post_type_settings(){
//        print_r($this);

        $vars = get_object_vars($this);

        echo '<br><br><br>';

        $myvars = $vars['post_types_definition'][0];

        echo $myvars['key'];
        echo '<br><br><br>';

        echo $myvars['name'];
        echo '<br><br><br>';

        var_dump($myvars['settings']) ;



//        print_r($vars);

    }


    /**
     * For each post type check if has taxonomies and call the method create_taxonomies() to register the taxonomy
     * @param $current_post_type
     */
    public function register_taxonomies($current_post_type){
//        if(!isset($current_post_type['taxonomies'])){
//            die('you should set up before you continue');
//        }
        $taxonomies = $current_post_type['taxonomies'];
        foreach($taxonomies as $taxonomy){

            $taxonomy_value = $taxonomy[1];
            $taxonomy_key = $taxonomy[0];

            // var_dump($taxonomy);
            // die();

            if($taxonomy[2] == '0'){
                $tax_publicly_queryable = $taxonomy[2];
            }else{
                $tax_publicly_queryable = true;
            }

            $taxonomy_args = $this->setup_taxonomy_args($taxonomy_value, $taxonomy_key, $tax_publicly_queryable);
//            $taxonomy_args = $this->setup_taxonomy_args($taxonomy,$taxonomy);
            register_taxonomy( $taxonomy_key, array( $current_post_type['key'] ), $taxonomy_args);
        }
    }


    /**
     * Create a Single post type data (just set up the array of data), this method's parent is register_post_type() in this class
     * @param $post_type_name
     * @return array
     */
    public function get_args_array($post_type_name, $show_in_menu, $icon, $publicly_queryable = true){
         $post_type = array(
            'labels' => array(
                'name' => __( $post_type_name ),
                'singular_name' => __( $post_type_name )
            ),
            'menu_icon' => $icon,
            'public' => true,
            'show_in_nav_menus' => $show_in_menu,
            'hierarchical' => true,
            'show_in_rest'      => true, //enables gutenberg support
            'publicly_queryable' => $publicly_queryable,
            'has_archive' => true,
            'rewrite' => array( 'with_front' => false),

//            'rewrite' => false,
//            'with_front' => 'with_front',
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'excerpt')
        );
        return $post_type;
    }

    /**
     * Create a new taxonomy data (just set up the data), this method's parent is register_taxonomies() in this class
     * @param $taxonomy
     * @return array
     */
    public function setup_taxonomy_args($taxonomy_value, $taxonomy_key, $publicly_queryable){


// var_dump((bool)$publicly_queryable);
// die();

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name'              => _x( $taxonomy_value, 'taxonomy general name' ),
            'singular_name'     => _x( $taxonomy_value, 'taxonomy singular name' ),
            'search_items'      => __( 'Search Team' ),
            'all_items'         => __( 'All '.$taxonomy_value ),
            'parent_item'       => __( 'Parent '.$taxonomy_value ),
            'parent_item_colon' => __( 'Parent '.$taxonomy_value ),
            'edit_item'         => __( 'Edit '.$taxonomy_value ),
            'update_item'       => __( 'Update '.$taxonomy_value ),
            'add_new_item'      => __( 'Add New '.$taxonomy_value ),
            'new_item_name'     => __( 'New '.$taxonomy_value.' Name' ),
            'menu_name'         => __( $taxonomy_value ),

        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'public'            => true,
            'show_ui'           => true,
            'show_in_rest'      => true, //enables gutenberg support
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => $taxonomy_key ),
            'show_in_nav_menus' => true,
            'publicly_queryable' => (bool)$publicly_queryable

        );

        return $args;
    }



}


