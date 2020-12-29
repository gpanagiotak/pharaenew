<?php

add_filter( 'wpcf7_load_css', '__return_false' );
add_filter( 'wpcf7_load_js', '__return_false' );








/*========================================
=            Global Variables            =
========================================*/

$genius = array(
    'theme_uri' => get_template_directory_uri(),
    'theme_ver' => '1.0'
);


/*==================================================*/
/* Setup
/*==================================================*/

add_action( 'after_setup_theme', 'genius_setup' );

function genius_setup()
{
    // Includes
    include( 'functions/lists.php' );
    include( 'functions/cleanup.php' );
    include( 'functions/components.php' );
    include( 'functions/translations.php' );
    include( 'functions/booking-form.php' );


    // Textdomain
    load_theme_textdomain( 'genius_theme', get_template_directory() . '/includes/languages' );

    // Content Width
    if ( ! isset( $content_width ) ) $content_width = 1600;

    // Theme support
    add_theme_support( 'menus' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );

    // Editor
    add_editor_style( 'stylesheets/editor-style.css' );

    // Images
    add_image_size( 'slider', 600, 850, true );
}


/*==================================================*/
/* Hooks
/*==================================================*/

if( ! is_admin() )
{
    // Headers, footers, body
    add_filter( 'the_generator', 		'remove_wp_version' );
    add_filter( 'body_class', 			'post_categories_body_class' );
    add_action( 'wp_head', 				'add_favicon' );

    // Styles
    add_action( 'wp_enqueue_scripts', 	'register_styles' );
    add_action( 'wp_enqueue_scripts', 	'enqueue_styles', 999 );

    // Scripts
    add_action( 'wp_enqueue_scripts', 	'register_scripts' );
    add_action( 'wp_enqueue_scripts', 	'enqueue_scripts' );
    add_filter( 'script_loader_src',	'remove_style_script_version', 15, 1 );
    add_filter( 'style_loader_src',		'remove_style_script_version', 15, 1 );

    // Excerpt
    add_filter( 'excerpt_length', 		'excerpt_length' );
    add_filter( 'excerpt_more', 		'excerpt_more' );

    // Menu
    add_filter( 'wp_nav_menu_objects', 	'add_extra_menu_classes' );
    add_filter( 'nav_menu_css_class', 	'fix_menu_class', 10, 2 );
}
else
{
    // Styles
    add_action( 'admin_init', 			'register_admin_styles' );
    add_action( 'admin_print_styles', 	'enqueue_admin_styles' );

    // Scripts
    add_action( 'admin_init', 			'register_admin_scripts' );
    add_action( 'admin_enqueue_scripts','enqueue_admin_scripts' );
}

// Menus
add_action( 'init', 				'register_menus' );


/*==================================================*/
/* Headers, footers, body
/*==================================================*/

function remove_wp_version()
{
    return '';
}

function remove_style_script_version( $src )
{
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// Post category name in body class
function post_categories_body_class( $classes )
{
    if( is_single() )
    {
        global $post;
        foreach( ( get_the_category( $post->ID ) ) as $category )
            $classes[] = 'term-' . $category->category_nicename;
    }

    return $classes;
}

// Favicon
function add_favicon()
{
    global $genius;

    echo '<link rel="shortcut icon" href="' . $genius['theme_uri'] . '/images/favicon.png" type="image/x-icon">';
}


/*==================================================*/
/* Styles
/*==================================================*/

// Register styles
function register_styles()
{
    global $genius;

    wp_register_style( 'tinos', 'https://fonts.googleapis.com/css?family=Tinos:400,400italic,700,700italic&subset=latin,greek', null, null, 'screen' );
    // wp_register_style( 'style', $genius['theme_uri'] . '/style.css', null, null, 'screen' );
    wp_register_style( 'theme-styles-new', $genius['theme_uri'] . '/style_new.css?t=61', null, null, 'screen' );

}

// Enqueue styles
function enqueue_styles()
{
    wp_enqueue_style( 'tinos' );
    // wp_enqueue_style( 'style' );
    wp_enqueue_style( 'theme-styles-new');

}

// Register admin styles
function register_admin_styles()
{
    global $genius;

    wp_register_style( 'admin-style', $genius['theme_uri'] . '/includes/stylesheets/admin.css', '', $genius['theme_ver'], 'screen' );
}

// Enqueue / Print admin styles
function enqueue_admin_styles()
{
    wp_enqueue_style( 'admin-style' );
}


/*==================================================*/
/* Scripts
/*==================================================*/

// Register scripts
function register_scripts()
{
    global $genius;

    wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', null, null, true );
    wp_register_script( 'theme', $genius['theme_uri'] . '/javascripts/theme.js?t=12', array( 'jquery' ), $genius['theme_ver'], true );
}

// Enqueue scripts
function enqueue_scripts()
{
    wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js?sensor=false', null, null, true );
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script( 'theme' );

    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply', null, null, true );

    localize_scripts();
}

function register_admin_scripts()
{
    global $genius;

    wp_register_script( 'admin', $genius['theme_uri'] . '/includes/javascripts/admin.js' );
}

function enqueue_admin_scripts()
{
    wp_enqueue_script( 'admin' );
}

// Localise scripts
function localize_scripts()
{
    global $genius;

    $option 	= get_option( 'genius_book_online_now' );
    $hotel_link = isset( $option['hotel_link'] ) ? $option['hotel_link'] : '';

    wp_localize_script( 'theme', 'genius_theme', array(
        'theme_uri'			=> $genius['theme_uri'],
        'home_url'			=> get_home_url(),
        'ajax_url'			=> admin_url( 'admin-ajax.php' ),
        'hotel_link'		=> $hotel_link
    ) );
}


/*==================================================*/
/*  Menu
/*==================================================*/

// Register menus
function register_menus()
{
    register_nav_menus(
        array(
            'primary-menu'		=> __( 'Primary Menu', 'genius_theme' ),
            'footer-menu'		=> __( 'Footer Menu', 'genius_theme' ),
        )
    );
}

// Add extra (first, last) classes to menu items
function add_extra_menu_classes( $objects )
{
    $objects[1]->classes[] = 'first';
    $objects[count( $objects )]->classes[] = 'last';

    return $objects;
}

// Fix menu, so the page_for_posts page won't highlight on post type archive
function fix_menu_class( $classes = array(), $item = false )
{
    $post_types = get_post_types( array( '_builtin' => false ) );
    $home 		= get_option( 'page_for_posts' );

    if ( is_singular( $post_types ) || is_post_type_archive( $post_types ) || is_author() || is_404() )
    {
        if( $home == $item->object_id )
        {
            if( in_array( 'current_page_parent', $classes ) )
                unset( $classes[array_search( 'current_page_parent', $classes )] );
        }

        if( is_singular() )
        {
            global $post;
            $post_type = get_post_type( $post->ID );

            if( in_array( 'archive_' . $post_type, $classes ) )
            {
                $classes[] = 'current_page_parent';
            }
        }
    }

    return $classes;
}

/*==================================================*/
/* Excerpt
/*==================================================*/

function excerpt_length( $length )
{
    return 500;
}

function excerpt_more( $more )
{
    return '';
}


/*==================================================*/
/* Admin
/*==================================================*/

// Remove unnecessary pages
function remove_menu_pages()
{
    remove_menu_page( 'link-manager.php' );
}


/*==================================================*/
/* Pagination
/*==================================================*/

// Pagination helper function
function pagination( $pages = '', $range = 2 )
{
    $showitems = ( $range * 2 ) + 1;

    global $paged;
    if( empty( $paged ) ) $paged = 1;

    if( $pages == '' )
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if( ! $pages )
        {
            $pages = 1;
        }
    }

    if( 1 != $pages )
    {
        echo '<div class="pagination">';
        if( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) echo '<a href="' . get_pagenum_link( 1 ) . '">&laquo;</a>';
        if( $paged > 1 && $showitems < $pages) echo '<a href="' . get_pagenum_link( $paged - 1 ) . '">&lsaquo;</a>';

        for ( $i = 1; $i <= $pages; $i++ )
        {
            if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ))
            {
                echo ( $paged == $i ) ? '<span class="current">' . $i . '</span>'
                    : '<a href="' . get_pagenum_link( $i ) . '" class="inactive" >' . $i . '</a>';
            }
        }

        if ( $paged < $pages && $showitems < $pages) echo '<a href="' . get_pagenum_link( $paged + 1 ) . '">&rsaquo;</a>';
        if ( $paged < $pages - 1 && $paged+$range - 1 < $pages && $showitems < $pages )
            echo '<a href="' . get_pagenum_link($pages) . '">&raquo;</a>';
        echo '</div>';
    }
}


/*==================================================*/
/* Post list array
/*==================================================*/

function get_genius_theme_post_list_array( $post_type )
{
    $default_lang = pll_default_language( 'slug' );
    $choices = array();

    foreach ( $post_type as $item ) {
        $posts = get_posts( array( 'post_type' => $item, 'lang' => $default_lang, 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) );

        foreach ( $posts as $post ) {
            $id = $post->ID;
            $title = $post->post_title;
            $choices[$id] = $title;
        }
    }

    return $choices;
}

/*==================================================*/
/* Theme Settings Page
/*==================================================*/

function genius_theme_settings_page( $pages )
{
    $pages[] = array(
        'page_title'	=> 'Theme Settings',
        'menu_title'	=> 'Settings',
        'sub_menu'		=> 'themes.php',
        'capability'	=> 'administrator',
        'menu_slug'		=> 'theme-settings',
        'setting'		=> 'genius_theme',
        'icon'			=> 'options-general',
        'save'			=> true,
        'save_text'		=> __( 'Save Theme Settings', 'genius_theme' )
    );

    return $pages;
}

add_filter('piklist_admin_pages', 'genius_theme_settings_page');

// Extra Metaboxes

function genius_theme_offers_extra_metaboxes( $metaboxes )
{
    $metaboxes[] = 'piklist_meta_featured_offer';

    return $metaboxes;
}

add_filter( 'genius_offers_details_workflow', 'genius_theme_offers_extra_metaboxes' );


// Syncronize Polylang Custom Fields

function genius_theme_copy_post_metas( $metas )
{
    return array_merge( $metas, array( 'featured_offer' ) );
}

add_filter( 'pll_copy_post_metas', 'genius_theme_copy_post_metas' );





add_action( 'init', 'reviews_post_type' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function reviews_post_type() {
    $labels = array(
        'name'               => _x( 'Reviews', 'post type general name', 'advertek_textdomain' ),
        'singular_name'      => _x( 'Review', 'post type singular name', 'advertek_textdomain' ),
        'menu_name'          => _x( 'Reviews', 'admin menu', 'advertek_textdomain' ),
        'name_admin_bar'     => _x( 'Review', 'add new on admin bar', 'advertek_textdomain' ),
        'add_new'            => _x( 'Add New', 'book', 'advertek_textdomain' ),
        'add_new_item'       => __( 'Add New Review', 'advertek_textdomain' ),
        'new_item'           => __( 'New Review', 'advertek_textdomain' ),
        'edit_item'          => __( 'Edit Review', 'advertek_textdomain' ),
        'view_item'          => __( 'View Review', 'advertek_textdomain' ),
        'all_items'          => __( 'All Reviews', 'advertek_textdomain' ),
        'search_items'       => __( 'Search Reviews', 'advertek_textdomain' ),
        'parent_item_colon'  => __( 'Parent Reviews:', 'advertek_textdomain' ),
        'not_found'          => __( 'No Reviews found.', 'advertek_textdomain' ),
        'not_found_in_trash' => __( 'No Reviews found in Trash.', 'advertek_textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'advertek_textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'our-reviews' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
    );

    register_post_type( 'our-reviews', $args );
}



add_action( 'add_meta_boxes', 'adding_custom_meta_boxes', 10, 2 );
add_action('save_post', 'store_reviews_meta');

function adding_custom_meta_boxes(  ) {
    add_meta_box(
        'reviews_meta',
        __( 'Reviews Info' ),
        'render_reviews_meta',
        'our-reviews',
        'normal',
        'default'
    );
}


function render_reviews_meta($post) {

//    echo 'post is: '.$post->ID;
    $author_name = get_post_meta( $post->ID, 'review_author', true );
    $author_location = get_post_meta( $post->ID, 'review_author_location', true );
    $review_date = get_post_meta( $post->ID, 'review_date', true );
    $review_rating = get_post_meta( $post->ID, 'review_rating', true );
    $review_source = get_post_meta( $post->ID, 'review_source', true );


    $outline = '<label for="review_source" style="width:150px; display:inline-block;">'. esc_html__('Review Source', 'advertek_domain') .'</label>';
//    $outline .= '<input type="text" name="review_source" id="review_source" class="review_source" value="'. esc_attr($review_source) .'" style="width:300px;"/> <br> <br>';

    $outline .= '<select name="review_source" id="review_source">';
    $outline .= '<option disabled value> Select an option... </option>';
    $outline .= '<option value="booking" '.check_selected( $review_source, 'booking' ).'>Booking</option>';
    $outline .= '<option value="tripadvisor" '.check_selected( $review_source, 'tripadvisor' ).'>Trip Advisor</option>';
    $outline .= '<option value="trivago" '.check_selected( $review_source, 'trivago' ).'>Trivago</option>';
    $outline .= '<option value="expedia" '.check_selected( $review_source, 'expedia' ).'>Expedia</option>';
    $outline .= '<option value="email" '.check_selected( $review_source, 'email' ).'>Email</option>';
    $outline .= '</select>';

    $outline .= '<br><br>';

    $outline .= '<label for="review_author" style="width:150px; display:inline-block;">'. esc_html__('Author Name', 'advertek_domain') .'</label>';
    $outline .= '<input type="text" name="review_author" id="review_author" class="review_author" value="'. esc_attr($author_name) .'" style="width:300px;"/> <br> <br>';

    $outline .= '<label for="review_author_location" style="width:150px; display:inline-block;">'. esc_html__('Author Location', 'advertek_domain') .'</label>';
    $outline .= '<input type="text" name="review_author_location" id="review_author_location" class="review_author_location" value="'. esc_attr($author_location) .'" style="width:300px;"/> <br> <br>';

    $outline .= '<label for="review_date" style="width:150px; display:inline-block;">'. esc_html__('Review Date', 'advertek_domain') .'</label>';
    $outline .= '<input type="date" name="review_date" id="review_date" class="review_date" value="'. esc_attr($review_date) .'" style="width:300px;"/> <br> <br>';

    $outline .= '<label for="review_rating" style="width:150px; display:inline-block;">'. esc_html__('Rating', 'advertek_domain') .'</label>';
    $outline .= '<input type="text" name="review_rating" id="review_rating" class="review_rating" value="'. esc_attr($review_rating) .'" style="width:300px;"/> <br> <br>';

    $outline .= wp_nonce_field(basename(__FILE__), 'my_nonce_adv');
//    $outline .= wp_nonce_field( 'saving_post_'.get_the_ID() );
//


    echo $outline;
}

function store_reviews_meta($post_id){
    $is_valid_nonce = (isset($_POST['my_nonce_adv']) && wp_verify_nonce($_POST['my_nonce_adv'], basename(__FILE__))) ? 'true' : 'false';

//    echo 'valid_nonce: '.$is_valid_nonce;

    // Exits script depending on save status
    if (!$is_valid_nonce) {
        return;
    }


    update_post_meta( $post_id, 'review_author', sanitize_text_field($_POST['review_author']));
    update_post_meta( $post_id, 'review_author_location', sanitize_text_field($_POST['review_author_location']));
    update_post_meta( $post_id, 'review_date', sanitize_text_field($_POST['review_date']));
    update_post_meta( $post_id, 'review_rating', sanitize_text_field($_POST['review_rating']));
    update_post_meta( $post_id, 'review_source', sanitize_text_field($_POST['review_source']));



//   $referrer = check_admin_referer( 'saving_post_'.get_the_ID() );


}

function check_selected($first, $second){

    if($first == $second){
        return 'selected';
    }else{
        return '';
    }
}
