<?php

/**
*
* Post List
*
**/

// Get a list from a Post Type
function get_genius_theme_post_type_list( $args = null, $custom_query = null )
{
	global $post;

	if( $args == null ) {
		// Post Type List function options
		$args = array(
			'class'				=> '',
			'before_item'		=> '',
			'after_item'		=> '',
			'item_class'		=> '',
			'title'				=> true,
			'title_class'		=> '',
			'title_position'	=> 'before_image',
			'title_link'		=> true,
			'content'			=> false,
			'content_class'		=> '',
			'excerpt'			=> true,
			'excerpt_class'		=> '',
			'excerpt_length'	=> 30,
			'post_meta'			=> false,
			'read_more'			=> true,
			'read_more_text'	=> 'Explore',
			'price'				=> true,
			'booking_link'		=> true,
			'booking_link_text'	=> 'Check Availability',
			'thumbnail'			=> true,
			'thumbnail_class'	=> '',
			'thumbnail_size'	=> 'medium',
			'thumbnail_link'	=> true
		);
	}

	if( $custom_query == null ) {
		// Custom Query options
		$custom_query = array(

			'post_type'	=> 'any',
			'order'		=> 'DESC',
			'orderby'	=> 'date'
		);
	}

	// Custom post query
	$query = new WP_Query( $custom_query );

	// Start items list
	$post_list = '<ul class="post-list '. (isset( $args['class'] ) ? $args['class'] : '') .'">';

	// Start custom post query
	if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();

		// Get attached images metabox value
		$image = get_post_thumbnail_id( $post->ID );

		if( $image ) {
			$image_src = wp_get_attachment_image_src( $image, (isset( $args['thumbnail_size'] ) ? $args['thumbnail_size'] : 'medium') );

		} else {

			$images = get_post_meta( $post->ID, 'images', false );

			// Get the first attached image - check if image exists
			foreach ( $images as $image ) {
				$image_src = wp_get_attachment_image_src( $image, (isset( $args['thumbnail_size'] ) ? $args['thumbnail_size'] : 'medium') );
				if( $image_src ) {
					break;
				} else {
					$image_src = '';
				}
			}
		}

		// Make items variables
		$item_title = '';
		$item_thumbnail = '';
		$item_text = '';
		$price = '';
		$item_meta = '';
		$read_more = '';
		$booking_link = '';

		// Start item
		$post_list .= '<li data-id="'. $post->ID .'" class="post-list-item '. (isset( $args['item_class'] ) ? $args['item_class'] : '') .'">'. (isset( $args['before_item'] ) ? $args['before_item']: '');

		// Get the title
		if( isset( $args['title'] ) ) {

			// Title link
			if( isset( $args['title_link'] ) ) {
				$item_title = '<h3 class="post-item-title '. (isset( $args['title_class'] ) ? $args['title_class'] : '') .'"><a href="'. get_permalink() .'">'. get_the_title() .'</a></h3>';
			} else {
				$item_title = '<h3 class="post-item-title '. (isset( $args['title_class'] ) ? $args['title_class'] : '') .'">'. get_the_title() .'</h3>';
			}
		}

		// Get post meta
		if( isset( $args['post_meta'] ) ) {
			$item_meta = '<div class="post-meta"><span class="date">'. get_the_date() .'</span> '. __( 'at', 'genius_theme' ) .' <span class="time">'. get_the_time() .'</span></div>';
		}

		// Get the thumbnail
		if( isset( $args['thumbnail'] ) ) {

			// Thumbnail link
			if( isset( $args['thumbnail_link'] ) ) {
				$item_thumbnail = '<a class="post-item-image-link" href="'. get_permalink() .'"><div class="post-item-image '. (isset( $args['thumbnail_class'] ) ? $args['thumbnail_class'] : '') .'" style="background-image: url('. $image_src[0] .')"></div></a>';
			} else {
				$item_thumbnail = '<div class="post-item-image '. (isset( $args['thumbnail_class'] ) ? $args['thumbnail_class'] : '') .'" style="background-image: url('. $image_src[0] .')"></div>';
			}
		}

		// Price
		if( isset( $args['price'] ) ) {
			$meta = get_post_meta( $post->ID, 'price', true );

			if( $meta ) {
				$price = '<span class="booking-price"><span class="from">'. pll__( 'From' ) .' </span>'. $meta .'€</span>';
			} else {
				$price = '';
			}
		}

		// Get the excerpt
		if( isset( $args['excerpt'] ) ) {
			// Get excerpt and trim it
			$excerpt = get_post_meta( $post->ID, 'manual_excerpt', true );

			if( ! $excerpt ) {
				$excerpt = get_the_content();
				$excerpt = strip_shortcodes( $excerpt );
				$excerpt = wp_trim_words( $excerpt, (isset( $args['excerpt_length'] ) ? $args['excerpt_length'] : '') );
			}

			$excerpt = apply_filters( 'the_content', $excerpt );

			$item_text = '<div class="post-item-excerpt '. (isset( $args['excerpt_class'] ) ? $args['excerpt_class'] : '') .'"><span class="description-label">'. pll__( 'Description' ) .':</span>'. $excerpt .'</div>';
		}

		// Get the content
		if( isset( $args['content'] ) ) {
			// Get content
			$content = get_the_content();
			$content = strip_shortcodes( $content );
			$content = apply_filters( 'the_content', $content );

			$item_text = '<div class="post-item-content '. (isset( $args['content_class'] ) ? $args['content_class'] : '') .'"><span class="description-label">'. pll__( 'Description' ) .':</span>'. $content .'</div>';
		}

		// Read more
		if( isset( $args['read_more'] ) ) {
			$read_more = '<a href="'. get_permalink() .'" class="button read-more">'. (isset( $args['read_more_text'] ) ? $args['read_more_text'] : '') .'</a>';
		}

		// Booking Link
		if( isset( $args['booking_link'] ) ) {
			$booking_link = '<a href="'. get_genius_book_online_now_single_link() .'" target="_blank" class="button booking-link">'. (isset( $args['booking_link_text'] ) ? $args['booking_link_text'] : '') .'</a>';
		}

		// Print items
		if( isset( $args['title_position'] ) && $args['title_position'] == 'before_image' ) {
			$post_list .= $item_title . $item_meta . $item_thumbnail;
		} else {
			$post_list .= $item_thumbnail . $item_title . $item_meta;
		}

		$post_list .= $item_text . $price . $read_more . $booking_link;

		$post_list .= (isset( $args['after_item'] ) ? $args['after_item'] : '') .'</li>';

	endwhile; endif; wp_reset_query();

	$post_list .= '</ul>';

	// Return post list
	return $post_list;
}


// Echo post list
function genius_theme_post_type_list( $args, $custom_query )
{
	$post_list = get_genius_theme_post_type_list( $args, $custom_query );

	// Echo post list
	echo $post_list;
}


?>