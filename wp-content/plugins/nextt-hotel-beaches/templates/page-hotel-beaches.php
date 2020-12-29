<?php
/*
Template Name: Hotel: Beaches
*/
?>

<?php get_header(); ?>

<?php get_template_part( 'interfaces/headers/header2' ); ?>
	<div class="container">

		<div class="col-md-3">
			<?php dynamic_sidebar( 'Main Sidebar' ); ?>
		</div>

		<div class="col-md-9">


			<!-- GET THE POSTS -->
			<?php $args= array('post_type' => array( 'beaches' ),'order'=> 'ASC');$the_query = new WP_Query( $args ); ?>

			<?php while ( $the_query->have_posts() ): ?>

				<?php $the_query->the_post(); ?>

				<a href="<?= get_permalink() ?>">

					<!-- THUMBNAIL -->
					<?php if ( has_post_thumbnail() ): $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $the_query->post->ID ), 'thumbnail_size' );
						$url = $thumb['0'] ?>
						<img src="<?= $url ?>" class="img-responsive" width="100%" height="100%">
					<?php endif; ?>

					<!-- TITLE AND SUBTITLE -->
					<h2>
						<?= nextt_hotel_get_all_beaches_info( $the_query->post->ID )['beaches-title'][0] ?>
						<small>
							<?= nextt_hotel_get_all_beaches_info( $the_query->post->ID )['beaches-subtitle'][0] ?>
						</small>
					</h2>
				</a>

				<!-- IMAGE -->
				<img src="<?= nextt_hotel_get_all_beaches_info( $the_query->post->ID )['beaches-image'][0] ?>"
				     class="img-responsive">

				<!-- GALLERY -->
				<?=
					do_shortcode('[wally cover="http://localhost/nextt/wp-content/uploads/2015/06/Santorini-Greece-low.jpg" category="'.nextt_hotel_get_all_beaches_info( $the_query->post->ID )['beaches-gallery'][0] .'" button="asdf" display="categories" ][/wally]');
				?>


				<br>

				<p><?= the_excerpt(); ?></p>


			<?php endwhile; ?>


			<?php wp_reset_postdata(); ?>


		</div>
	</div>
<?php get_footer(); ?>