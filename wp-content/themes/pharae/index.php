<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<h2 class="page-title"><span><?php the_title(); ?></span></h2>
				
				<div id="single-content">
					<?php the_content(); ?>
				</div>

			</div>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

<?php get_footer(); ?>