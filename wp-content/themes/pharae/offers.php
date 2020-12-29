<?php

/**
*
* Template Name: Offers
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
			'class'				=> 'offers-list',
			'item_class'		=> 'offer-item',
			'title'				=> true,
			'title_class'		=> 'offer-title',
			'title_position'	=> 'after_image',
			'content'			=> true,
			'content_class'		=> 'offer-content',
			'booking_link'		=> true,
			'booking_link_text'	=> pll__( 'Book now!' )
		);

		$custom_query = array(
			'post_type' => 'offer',
			'posts_per_page' => -1
		);

		genius_theme_post_type_list( $args, $custom_query );
	?>

<?php get_footer(); ?>