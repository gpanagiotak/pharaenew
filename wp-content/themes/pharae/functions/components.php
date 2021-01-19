<?php

/**
*
* Pharae Website components
*
**/


// Top Menu

//function genius_theme_primary_menu()
//{
//	$args = array(
//		'theme_location' => 'primary-menu',
//		'menu' => 'primary-menu',
//		'container' => 'nav',
//		'container_class' => 'primary-menu-container',
//		'menu_class' => 'menu',
//	);
//
//	wp_nav_menu( $args );
//}

// Language list

function genius_theme_get_language_list()
{
	?>
		<div class="language-list">
			<span class="language-toggle">
				<?php echo pll_current_language( 'name' ); ?>
			</span>
			<ul class="languages">
				<?php pll_the_languages( array( 'hide_current' => 1 ) ); ?>
			</ul>
		</div>

	<?php
}

// Page Slider

function genius_theme_slider()
{
	global $post;

	$images = get_post_meta( $post->ID, 'images', false );

	if( ! $images ) {
		$option = get_option( 'genius_theme' );
		$images = $option['default_page_slider'];
	}

	if( ! is_array( $images ) ) {
		$images = array( $images );
	}

	$slides = array();

	foreach ( $images as $image ) {
		$url = wp_get_attachment_image_src( $image, 'slider' );

		if( $url[0] ) $slides[] = $url[0];
	}

	$custom_query = array(
		'post_type' => 'offer',
		'posts_per_page' => 1,
		'meta_key' => 'featured_offer',
		'meta_value' => 'on'
	);

	$offers = get_posts( $custom_query );
	$offer = get_post( $offers[0] );

	echo '<div class="slider-slogan"><span>Stay</span><span>&</span><span>Dine</span><span>Experience</span></div>';

	echo '<ul class="sequence-canvas">';
	
//	var_dump($offers);
//        	var_dump($slides);
//    var_dump($bullets);
	
//	die();

	if( $offers ) {
		$slides = array_chunk( $slides, 2 );
		$bullets = count( $slides );
		if( $bullets > 3 ) $bullets = 4;
	}
	else {
		$slides = array_chunk( $slides, 2 );
		$bullets = count( $slides );
		if( $bullets > 3 ) $bullets = 4;
        else if ( $bullets == 3 ) $bullets = 3;
        else if ( $bullets == 2 ) $bullets = 2;
	}

	for ( $i = 0; $i < $bullets; $i++ ) {

		$slide = $slides[$i];

		echo '<li>';

		echo '<div class="square-position-1" data--200-top-top="transform:translateX(0px)" data--500-top-top="transform:translateX(-100px)"><div class="square-image" style="background-image:url('. $slide[0] .');" data--200-top-top="opacity:1" data--500-top-top="opacity:0"><img src="'. $slide[0] .'"></div></div>';
		echo '<div class="square-position-2" data--150-top-top="transform:translateX(0px)" data--350-top-top="transform:translateX(100px)"><div class="square-image" style="background-image:url('. $slide[1] .');" data--150-top-top="opacity:1" data--350-top-top="opacity:0"><img src="'. $slide[1] .'"></div></div>';
		echo '<div class="square-position-3" data-100-top-top="transform:translateX(0px)" data--100-top-top="transform:translateX(100px)"><div class="square-offer" data-100-top-top="opacity:1" data--100-top-top="opacity:0"><a href="'. get_local_offers_link() .'" target="_blank"><h4 class="offer-title">Special Offers</h4><h5 class="slider-offer">View All <br> Offers</h5></div></a></div>';

		echo '</li>';
	}

	echo '</ul>';

	echo '<ul class="sequence-pagination">';

	for ( $i = 0; $i < $bullets; $i++ ) {
		echo '<li><span></span></li>';
	}

	echo '</ul>';
}


// Featured square

function genius_theme_home_featured_square()
{
	$pages = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'stay.php'
	));

	$page = reset( $pages );
	$id = pll_get_post( $page->ID );

	$stay = get_post( $id );

	$stay_image = get_post_thumbnail_id( $stay->ID );
	$stay_url = wp_get_attachment_image_src( $stay_image, 'large' );

	$pages = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'dine.php'
	));

	$page = reset( $pages );
	$id = pll_get_post( $page->ID );

	$dine = get_post( $id );

	$dine_image = get_post_thumbnail_id( $dine->ID );
	$dine_url = wp_get_attachment_image_src( $dine_image, 'large' );

	echo '<div class="featured-square">';
	
		echo '<div class="top-half">';
			echo '<div class="square-image grayscale" style="background-image:url('. $stay_url[0] .');"></div>';
			echo '<div class="square-image color" style="background-image:url('. $stay_url[0] .');" data-150-top-top="opacity:1" data-center-bottom="opacity:0"></div>';
		echo '</div>';

		echo '<div class="bottom-half">';
			echo '<div class="square-image grayscale" style="background-image:url('. $dine_url[0] .');"></div>';
			echo '<div class="square-image color" style="background-image:url('. $dine_url[0] .');" data-150-center-top="opacity:0" data-400-center-center="opacity:1"></div>';
		echo '</div>';

	echo '</div>';
}


function genius_theme_featured_square()
{
	if( ! is_singular( array( 'post', 'event' ) ) ) {

		global $post;

		$image = get_post_thumbnail_id( $post->ID );
		$url = wp_get_attachment_image_src( $image, 'large' );

		echo '<div class="featured-square">';

		echo '<div class="square-image grayscale" style="background-image:url('. $url[0] .');" data-center-center="opacity:1" data-top-bottom="opacity:0.5"></div>';
		echo '<div class="square-image color" style="background-image:url('. $url[0] .');" data-center-center="opacity:1" data-200-top-center="opacity:0"></div>';

		echo '</div>';

		$title = strtolower( $post->post_title );
		$words = explode( ' ', $title );

		if( in_array( 'lounge', $words ) ) {
			echo '<img src="'. get_template_directory_uri() .'/images/loft-logo.png" alt="Loft Lounge" class="loft-logo">';
		}
	}
}


function genius_theme_featured_double_squares()
{
	global $post;

	$image = get_post_thumbnail_id( $post->ID );
	$featured = wp_get_attachment_image_src( $image, 'slider' );

	$images = get_post_meta( $post->ID, 'images', false );

	foreach ( $images as $image ) {
		$attachment = wp_get_attachment_image_src( $image, 'slider' );

		if( $attachment[0] ) {
			break;
		}
	}

	echo '<div class="featured-double-square">';
	
	echo '<div class="featured-squares small"><div class="square-image" style="background-image:url('. $featured[0] .');"><img src="'. $featured[0] .'"></div></div>';
	echo '<div class="featured-squares tiny"><div class="square-image" style="background-image:url('. $attachment[0] .');"><img src="'. $attachment[0] .'"></div></div>';

	echo '</div>';
}



function genius_theme_featured_small_squares()
{
    global $post;

    $image = get_post_thumbnail_id( $post->ID );
    $featured = wp_get_attachment_image_src( $image, 'slider' );

    echo '<div class="featured-double-square">';

    echo '<div class="featured-squares small"><div class="square-image" style="background-image:url('. $featured[0] .');"><img src="'. $featured[0] .'"></div></div>';

    echo '</div>';
}



// Home page elements

function genius_theme_page_template_section( $template = 'stay.php', $button = 'Show all' )
{
	$pages = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $template
	));

	$page = reset( $pages );
	$id = pll_get_post( $page->ID );

	$post = get_post( $id );

	$image = get_post_thumbnail_id( $post->ID );
	$url = wp_get_attachment_image_src( $image, 'medium' );

	$content = $post->post_content;
	$content = strip_shortcodes( $content );
	$content = wp_trim_words( $content, 100 );

	$excerpt = get_post_meta( $post->ID, 'manual_excerpt', true );

	if( $excerpt ) {
		$excerpt = apply_filters( 'the_content', $excerpt );
	} else {
		$excerpt = apply_filters( 'the_content', $content );
	}

	echo '<div id="header-slider" class="grid-slider">';

	echo '<div class="featured-image home-sections" style="background-image:url('. $url[0] .')"></div>';

	echo apply_filters( 'the_content', $excerpt );
	
	if( $template == 'dine.php' ) {
		echo '<a class="button" href="'. genius_theme_roof_garden_link() .'">'. $button .'</a>';
	}
	else {
		echo '<a class="button" href="'. get_permalink( $post->ID ) .'">'. $button .'</a>';
	}
}


function genius_theme_roof_garden_link()
{
	$posts = get_posts( array(
		'post_type' => 'facility',
		'posts_per_page' => -1
	));

	foreach ( $posts as $post ) {
		
		$title = strtolower( $post->post_title );
		$words = explode( ' ', $title );

		if( in_array( 'lounge', $words ) ) {
			$id = $post->ID;
			break;
		}
	}

	return get_permalink( $post->ID );
}


function genius_theme_must_see_section()
{
	$args = array(
		'class'				=> 'sequence-canvas',
		'thumbnail'			=> true,
		'thumbnail_size'	=> 'medium',
		'thumbnail_link'	=> true
	);

	$custom_query = array(
		'post_type'	=> 'page',
		'orderby'	=> 'menu_order',
		'meta_key' => '_wp_page_template',
		'meta_value' => 'location.php'
	);

	echo '<div class="slider-holder" data-center-top="transform:translate(0%)" data-bottom-top="transform:translate(44.7%)">';

	genius_cms_post_type_list( $args, $custom_query );

	echo '</div>';

	$args = array(
		'class'				=> 'sequence-pagination',
		'title'				=> true,
		'title_link'		=> true,
		'excerpt'			=> true,
		'excerpt_length'	=> 10
	);

	echo '<div class="pagination-holder" data-center-top="transform:translate(0%)" data-bottom-top="transform:translate(-44.7%)">';

	genius_cms_post_type_list( $args, $custom_query );

	echo '</div>';
}


function genius_theme_offers_widget()
{
	$args = array(
		'class'				=> 'sequence-canvas',
		'title'				=> true,
		'title_link'		=> false,
		'excerpt'			=> true,
		'excerpt_length'	=> 40,
		'before_item'		=> '<div class="slide">',
		'after_item'		=> '</div>'

	);

	$custom_query = array(
//		'post_type'	=> 'news',
		'post_type'	=> 'our-reviews',
		'orderby'	=> 'date',
		'posts_per_page' => 4
	);



    $the_args = array(
        'post_type' => 'our-reviews',
//    'orderby' => 'rand',
        'posts_per_page' => '4',
    );
    $query = new WP_Query( $args );




	echo '<div id="offers-widget-slider">';

	genius_cms_post_type_list( $args, $custom_query );

	$args = array(
		'class'	=> 'sequence-pagination'
	);

	genius_cms_post_type_list( $args, $custom_query );




    echo '</div>';

	$pages = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'offers.php'
	));

	$page = reset( $pages );
	$id = pll_get_post( $page->ID );

	$post = get_post( $id );





//	echo '<a class="button" href="'. get_permalink( $post->ID ) .'">'. pll__( 'View all offers' ) .'</a>';
}


function genius_theme_news_widget()
{
	$args = array(
		'class'				=> 'sequence-canvas',
		'title'				=> true,
		'title_link'		=> true,
		'title_position'	=> 'after_image',
		'excerpt'			=> true,
		'excerpt_length'	=> 16,
		'thumbnail'			=> true,
		'thumbnail_size'	=> 'medium',
		'before_item'		=> '<div class="slide">',
		'after_item'		=> '</div>'

	);

	$custom_query = array(
		'post_type'	=> 'post',
		'orderby'	=> 'date',
		'posts_per_page' => 4
	);

	echo '<div id="news-widget-slider">';

	genius_cms_post_type_list( $args, $custom_query );

	$args = array(
		'class'	=> 'sequence-pagination'
	);

	genius_cms_post_type_list( $args, $custom_query );

	echo '</div>';

	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'events-news.php'
	));

	$option = reset( $pages );

	$page = get_post( $option );
	$id = pll_get_post( $page->ID );

	$post = get_post( $id );

	echo '<a class="button" href="'. get_permalink( $post->ID ) .'">'. pll__( 'Visit our blog' ) .'</a>';
}


// In page menu

function genius_theme_in_page_menu( $post_type = 'post' )
{
	global $post;

	$custom_query = array(
		'post_type'	=> $post_type,
		'posts_per_page' => -1,
		'orderby'	=> 'menu_order'
	);

	$items = get_posts( $custom_query );

	$menu = '<ul class="in-page-menu-items">';

	foreach ( $items as $item ) {

		if( $post->ID == $item->ID ) {
			$active = 'active';
		}
		else {
			$active = '';
		}

		$menu .= '<li class="in-page-menu-item '. $active .'"><a href="'. get_permalink( $item->ID ) .'" class="in-page-menu-title">'. $item->post_title .'</a></li>';
	}

	$menu .= '</ul>';

	?>
		<div class="in-page-menu-holder">
			<div class="in-page-menu">
				<span class="in-page-menu-label">
					<?php pll_e( 'Select' ); ?>:
				</span>
				<?php echo $menu; ?>
			</div>
		</div>
	<?php
}


// Same template pages menu

function genius_theme_same_template_pages_menu( $template = 'location.php' )
{
	global $post;

	$pages = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'location.php',
		'orderby' => 'menu_order',
		'posts_per_page' => -1
	));

	$menu = '<ul class="in-page-menu-items">';

	foreach ( $pages as $item ) {

		if( $post->ID == $item->ID ) {
			$active = 'active';
		}
		else {
			$active = '';
		}

		$menu .= '<li class="in-page-menu-item '. $active .'"><a href="'. get_permalink( $item->ID ) .'" class="in-page-menu-title">'. $item->post_title .'</a></li>';
	}

	$menu .= '</ul>';

	?>
		<div class="in-page-menu-holder">
			<div class="in-page-menu">
				<span class="in-page-menu-label">
					<?php pll_e( 'Select' ); ?>:
				</span>
				<?php echo $menu; ?>
			</div>
		</div>
	<?php
}


// Page template title

function genius_theme_page_template_title( $template = 'dine.php' )
{
	$pages = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $template
	));

	$page = reset( $pages );
	$id = pll_get_post( $page->ID );

	$page = get_post( $id );

	echo $page->post_title;
}


// Footer contact

function genius_theme_footer_contact()
{
	echo '<section class="widget contact">';

	?>
		<h3 class="widget-title">
			<?php pll_e( 'Contact' ); ?>
		</h3>
	<?php

	echo '<div class="widget-content">';

	genius_contact_main_office( false );

	genius_contact_google_maps_link( false );

	echo '</div></section>';
}


// Galleries

function genius_theme_attached_images()
{
	global $post;

	$attachments = get_post_meta( $post->ID, 'images', false );
		
	echo '<ul class="image-attachments gallery-carousel-items">';

	foreach ( $attachments as $attachment ) {

		$post = get_post( $attachment );

		$thumb = wp_get_attachment_image_src( $attachment, 'thumbnail' );
		$medium = wp_get_attachment_image_src( $attachment, 'medium' );
		$large = wp_get_attachment_image_src( $attachment, 'large' );

		if( $medium[0] ) {

			echo '<li data-src="'. $large[0] .'" data-title="'. $post->post_title .'" data-exthumbimage="'. $thumb[0] .'"><div class="slide" style="background-image:url('. $medium[0] .');"></div></li>';
		}

	}
	
	echo '</ul>';
}


function genius_theme_photo_gallery()
{
	$ajax_id = $_GET['id'];

	$attachments = get_post_meta( $ajax_id, 'images', false );

	$gallery  = '<span id="close-gallery">'. pll__( 'Back' ) .'</span>';
	$gallery .= '<ul class="gallery-grid">';

	foreach ( $attachments as $attachment ) {

		$post = get_post( $attachment );

		$thumb = wp_get_attachment_image_src( $attachment, 'thumbnail' );
		$medium = wp_get_attachment_image_src( $attachment, 'medium' );
		$large = wp_get_attachment_image_src( $attachment, 'large' );

		if( $medium[0] ) {

			$gallery .= '<li class="gallery-grid-item" data-src="'. $large[0] .'" data-title="'. $post->post_title .'" data-exthumbimage="'. $thumb[0] .'"><div class="gallery-grid-image" style="background-image:url('. $medium[0] .');"></div></li>';
		}

	}

	$gallery .= '</ul>';

	echo $gallery;

	?>
		<script>
			jQuery(document).ready(function ($) {
				$('.gallery-grid').lightGallery({
					caption: true,
					hideControlOnEnd: true,
					exThumbImage: 'data-exthumbimage'
				});
			});
		</script>
	<?php

	die(1);
}

add_action( 'wp_ajax_genius_theme_photo_gallery', 'genius_theme_photo_gallery' );
add_action( 'wp_ajax_nopriv_genius_theme_photo_gallery', 'genius_theme_photo_gallery' );


?>
