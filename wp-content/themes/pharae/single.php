<?php get_header(); ?>

	<?php genius_theme_featured_square(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<?php get_template_part( 'content', get_post_type( get_the_id() ) ); ?>

			</div>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

<?php get_footer(); ?>