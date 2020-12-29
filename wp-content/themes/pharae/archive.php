<?php get_header(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

		<div class="content-holder">

			<h2 class="page-title"><span><?php post_type_archive_title(); ?></span></h2>

			<div id="page-content">

				<?php
					$args = array(
						'class'				=> 'general-list',
						'before_item'		=> '',
						'after_item'		=> '',
						'item_class'		=> '',
						'title'				=> true,
						'title_class'		=> '',
						'title_position'	=> 'before_image',
						'title_link'		=> true,
						'excerpt'			=> true,
						'excerpt_class'		=> '',
						'excerpt_length'	=> 14,
						'read_more'			=> true,
						'read_more_text'	=> pll__( 'Read more' ),
						'thumbnail'			=> true,
						'thumbnail_class'	=> '',
						'thumbnail_size'	=> 'medium',
						'thumbnail_link'	=> true
					);

					$custom_query = array(

						'post_type'	=> get_post_type( get_the_id() )
					);

					genius_cms_post_type_list( $args, $custom_query );
				?>

			</div>

		</div>

	</article>


<?php get_footer(); ?>