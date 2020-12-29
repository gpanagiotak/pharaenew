<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<h2 class="page-title"><span><?php the_title(); ?></span></h2>

				<div id="single-content" class="two-thirds-page scrollable">

					<h2 class="single-page-title"><?php the_title(); ?></h2>
                    <div class="hidden_desktop">
                        <?= get_the_post_thumbnail(get_the_ID(), 'medium')  ?>
                    </div>
<!--					<div class="text-scroller">-->
<!--						<div class="slidee">-->
						<div class="">
							<?php the_content(); ?>
						</div>
<!--						<div class="scrollbar">-->
<!--							<div class="handle">-->
<!--								<span class="handle-square"></span>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->

				</div>

				<?php genius_theme_featured_double_squares(); ?>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

<?php get_footer(); ?>