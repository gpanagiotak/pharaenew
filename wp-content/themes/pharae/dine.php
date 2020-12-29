<?php

/**
*
* Template Name: Dine
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
			'class'				=> 'facilities-list',
			'item_class'		=> 'facility-item',
			'title'				=> true,
			'title_class'		=> 'facility-title',
			'title_position'	=> 'before_image',
			'title_link'		=> true,
			'excerpt'			=> true,
			'excerpt_class'		=> 'facility-excerpt',
			'excerpt_length'	=> 20,
			'read_more'			=> true,
			'read_more_text'	=> pll__( 'Read more' ),
			'thumbnail'			=> true,
			'thumbnail_class'	=> 'facility-image',
			'thumbnail_size'	=> 'medium',
			'thumbnail_link'	=> true
		);

		$custom_query = array(
			'post_type' => 'facility',
			'posts_per_page' => -1,
			'orderby' => 'menu_order'
		);

		genius_theme_post_type_list( $args, $custom_query );
	?>


<div class="single-gallery-holder">

    <h4 class="single-carousel-title">
        Restaurant Menu
        <?php // pll_e( 'Photo gallery' ); ?>
    </h4>

    <div class="gallery-carousel-holder">
        <span class="gallery-carousel-prev"></span>
        <div id="single-gallery-carousel">
            <?php genius_theme_attached_images(); ?>
        </div>
        <span class="gallery-carousel-next"></span>
    </div>

</div>

<?php get_footer(); ?>





