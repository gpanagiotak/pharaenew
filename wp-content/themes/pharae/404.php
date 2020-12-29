<?php get_header(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

		<div class="content-holder">

			<h2 class="page-title"><span><?php pll_e( '404: Page not found' ); ?></span></h2>

			<div id="single-content">
				<?php pll_e( 'Sorry, but the page you are looking for, does not exist. Try checking the URL for errors.' ); ?>
			</div>

		</div>

	</article>

<?php get_footer(); ?>