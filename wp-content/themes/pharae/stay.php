<?php

/**
*
* Template Name: Stay
*
**/

get_header();

?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>



			<div class="content-holder">

				<h2 class="page-title"><span><?php the_title(); ?></span></h2>
                <div class="hidden_desktop">
                    <?= get_the_post_thumbnail(get_the_ID(), 'medium')  ?>
                </div>
				<div id="page-content">
					<?php the_content(); ?>
				</div>

			</div>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

	<?php
		$args = array(
			'class'				=> 'rooms-list',
			'item_class'		=> 'room-item',
			'title'				=> true,
			'title_class'		=> 'room-title',
			'title_position'	=> 'before_image',
			'title_link'		=> true,
			'excerpt'			=> true,
			'excerpt_class'		=> 'room-excerpt',
			'excerpt_length'	=> 20,
			'read_more'			=> true,
			'read_more_text'	=> pll__( 'View room' ),
			'price'				=> true,
			'booking_link'		=> true,
			'booking_link_text'	=> pll__( 'Book now!' ),
			'thumbnail'			=> true,
			'thumbnail_class'	=> 'room-image',
			'thumbnail_size'	=> 'medium',
			'thumbnail_link'	=> true
		);

		$custom_query = array(
			'post_type' => 'room',
			'posts_per_page' => -1,
			'orderby' => 'menu_order'
		);

		genius_theme_post_type_list( $args, $custom_query );
	?>

<?php get_footer(); ?>