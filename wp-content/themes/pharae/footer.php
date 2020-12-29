		</section>
	</main>

	<footer id="document-footer" role="contentinfo">
		<div class="footer-inner">

			<?php genius_theme_footer_contact(); ?>

			<section class="widget">
				<h3 class="widget-title"><?php pll_e( 'Go Social' ); ?></h3>
				<?php
					$args = array(
						'class' => 'footer-social-icons'
					);

					genius_widgets_social_icons( $args );
				?>
			</section>

			<?php genius_widgets_mailjet_subscribe_form(); ?>

			<section class="widget gnto-holder">
				<?php genius_contact_gnto_number(); ?>
			</section>


            <section class="extra-footer-links">

                <?php

                wp_nav_menu(array(
                    'menu' => 'footer_menu',
                    'theme_location' => 'footer-menu',
                    'depth' => 2,
                    'container' => 'div',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => '',
                ));

                ?>

            </section>


		</div>






		<div class="copyright-holder">
			<div class="copyright-inner">

				<span class="copyright-block">
					&nbsp; <?php genius_widgets_copyright(); ?>. All Rights Reserved.
				</span>

				<?php genius_widgets_powered_by(); ?>

			</div>
		</div>
	</footer>

        <div class="the_espa_section">
            <div class="espa_inner">
                <a href="https://www.pharae.gr/espa/" target="_blank">
                    <img src="<?= get_stylesheet_directory_uri().'/images/espa_new.jpg' ?>" width="150" />
                </a>
            </div>
        </div>

	<?php wp_footer(); ?>

	</div>

</body>
</html>