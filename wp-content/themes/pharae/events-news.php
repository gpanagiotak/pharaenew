<?php

/**
*
* Template Name: Events & News
*
**/

get_header();

?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<h2 class="page-title"><span><?php the_title(); ?></span></h2>
				
				<div id="page-content">
					<?php the_content(); ?>
				</div>

			</div>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

	<?php
		$args = array(
			'class'				=> 'events-posts-list',
			'item_class'		=> 'event-post-item',
			'title'				=> true,
			'title_class'		=> 'event-post-title',
			'title_position'	=> 'after_image',
			'title_link'		=> true,
			'post_meta'			=> false,
			'excerpt'			=> true,
			'excerpt_class'		=> 'event-post-excerpt',
			'excerpt_length'	=> 30,
			'read_more'			=> true,
			'read_more_text'	=> pll__( 'Read more' ),
			'thumbnail'			=> true,
			'thumbnail_class'	=> '',
			'thumbnail_size'	=> 'medium',
			'thumbnail_link'	=> true,
		);

		$custom_query = array(
			'post_type'	=> array( 'post', 'event' ),
			'posts_per_page' => -1
		);

		genius_cms_post_type_list( $args, $custom_query );
	?>

<?php get_footer(); ?>