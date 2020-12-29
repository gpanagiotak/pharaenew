<?php

/**
*
* Template Name: Galleries
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
			'class'				=> 'galleries-list',
			'item_class'		=> 'gallery-item',
			'title'				=> true,
			'title_class'		=> 'gallery-title',
			'title_position'	=> 'after_image',
			'thumbnail'			=> true,
			'thumbnail_class'	=> 'gallery-image',
			'thumbnail_size'	=> 'medium'
		);

		genius_galleries_list( $args );
	?>

	<div class="gallery-container"></div>

<?php get_footer(); ?>