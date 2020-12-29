<?php

/**
*
* Template Name: Conferences
*
**/

get_header();

?>
	<?php genius_theme_featured_square(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<h2 class="page-title"><span><?php pll_e( 'Conferences' ); ?></span></h2>
                <div class="hidden_desktop">
                    <?= get_the_post_thumbnail(get_the_ID(), 'medium')  ?>
                </div>
				<div id="single-content" class="half-page scrollable">

					<h2 class="single-page-title"><?php the_title(); ?></h2>

					<div class="text-scroller">
						<div class="slidee">
							<?php the_content(); ?>
						</div>
						<div class="scrollbar">
							<div class="handle">
								<span class="handle-square"></span>
							</div>
						</div>
					</div>

				</div>

				<div class="single-gallery-holder">

					<h4 class="single-carousel-title">
						<?php pll_e( 'Photo gallery' ); ?>
					</h4>

					<div class="gallery-carousel-holder">
						<span class="gallery-carousel-prev"></span>
						<div id="single-gallery-carousel">
							<?php genius_theme_attached_images(); ?>
						</div>
						<span class="gallery-carousel-next"></span>
					</div>

				</div>

			</div>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

<?php get_footer(); ?>