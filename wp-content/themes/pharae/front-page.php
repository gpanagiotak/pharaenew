<?php get_header(); ?>



	<section id="stay-dine-section">
		
		<?php genius_theme_home_featured_square(); ?>

		<article id="stay" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<h2 class="page-title left-align"><span><?php pll_e( 'Stay' ); ?></span></h2>

				<div class="page-content">

					<?php genius_theme_page_template_section( 'stay.php', pll__( 'Show all rooms' ) ); ?>

				</div>

			</div>

		</article>

		<article id="dine" <?php post_class( 'post section-content' ); ?>>

			<div class="content-holder">

				<h2 class="page-title left-align"><span><?php pll_e( 'Dine' ); ?></span></h2>

				<div class="page-content">

					<?php genius_theme_page_template_section( 'dine.php', pll__( 'Show roof garden' ) ); ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/loft-logo.png" alt="Loft Lounge" class="loft-logo">

				</div>


			</div>

		</article>

	</section>




    <article id="reviews" <?php post_class( 'post section-content' ); ?>>

        <div class="content-holder">

            <h2 class="page-title"><span>Reviews</span></h2>

            <div id="reviews_content">

                <?php get_template_part('includes/reviews/reviews_home') ?>
            </div>

        </div>

    </article>



	<article id="must-see" <?php post_class( 'post section-content' ); ?>>

		<div class="content-holder">

			<h2 class="page-title"><span><?php pll_e( 'Must see' ); ?></span></h2>

			<div id="must-see-slider">

				<?php genius_theme_must_see_section(); ?>

			</div>

		</div>

	</article>

	<article id="more-info" <?php post_class( 'post section-content' ); ?>>

		<div class="content-holder">

			<h2 class="page-title"><span><?php pll_e( 'Info' ); ?></span></h2>

			<div class="page-content pre-footer-widgets" data-center-top="top:0em;opacity:1" data-bottom-top="top:20em;opacity:0">

				<section class="widget offers-widget">
<!--					<h4 class="widget-title">--><?php //pll_e( 'Offers' ); ?><!--</h4>-->
					<h4 class="widget-title"><?php pll_e( 'Reviews' ); ?></h4>
					<?php genius_theme_offers_widget(); ?>
				</section>

				<section class="widget weather-widget">
					<!-- <h4 class="widget-title"><?php // pll_e( 'Offers' ); ?></h4> -->
					<h4 class="widget-title"><?php pll_e( 'Weather' ); ?></h4>
					<?php
					$weather = get_awesome_weather_openweathermaps( 'Kalamata' );
					$current_temp = awe_f_to_c( $weather->data['current']['temp'] );
					$current_humidity = $weather->data['current']['humidity'].'%';
					$current_desc = '"'.$weather->data['current']['description'].'"';
					$current_icon = $weather->data['current']['icon'];
					$current_temp .='°C';
					?>
					<div id="local-weather">
						<div class="local-weather-temperature"><span class=""><?php echo $current_temp ?></span></div>
						<div class="local-weather-description"><span class=""><?php echo $current_desc ?></span></div>
						<div class="local-weather-humidity"><span class=""><?php echo $current_humidity ?></span></div>
					</div>
					
				</section>

				<section class="widget news-widget">
					 <h4 class="widget-title"><?php pll_e( 'News' ); ?></h4>
					<?php genius_theme_news_widget(); ?>
				</section>

			</div>

		</div>

	</article>


<?php get_footer(); ?>