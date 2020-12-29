<?php

/**
*
* Template Name: Contact
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

				<div class="contact-page-office">
					<?php genius_contact_main_office( false ); ?>
				</div>

				<?php
					$args = array(
						'class' 		=> 'contact-form',
						'before_fields' => '<ul class="form-fields">',
						'after_fields' 	=> '</ul>',
						'before_field' 	=> '<li class="form-field">',
						'after_field' 	=> '</li>',
						'placeholder' 	=> true,
						'button_text' 	=> pll__( 'Send' ),
						'button_class' 	=> 'button'
					);

					genius_contact_form( $args );
				?>

			</div>

			<?php genius_contact_map(); ?>

		</article>

	<?php endwhile; endif; wp_reset_query(); ?>

<?php get_footer(); ?>