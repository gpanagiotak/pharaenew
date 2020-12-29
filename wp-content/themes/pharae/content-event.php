<h2 class="page-title"><span><?php pll_e( 'Events' ); ?></span></h2>

<div id="single-content" class="narrow-content">

	<?php
		$args = array(
			'featured_image' 	=> true,
			'thumbnail_size'	=> 'medium',
			'before_content'	=> '<h2 class="single-post-title">'. $post->post_title .'</h2>',
			'content'			=> true
		);

		genius_events_single_content( $args );
	?>

</div>