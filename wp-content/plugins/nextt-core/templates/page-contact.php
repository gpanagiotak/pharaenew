<?php
/*
Template Name: Page: Contact
*/
?>



<?php get_header(); ?>
<?php get_template_part( 'interfaces/headers/header2' ); ?>

<div class="container contact-page">

		<div class="col-md-6">
			<?php get_template_part('interfaces/modules/contact_form'); ?>
		</div>
		<div class="col-md-6">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry">
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
					</div>
				</article>
			<?php endwhile; endif; ?>
		</div>
	
</div>

<?php get_footer(); ?>
