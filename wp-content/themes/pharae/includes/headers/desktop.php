
    <div class="header-hero">
        <div class="header-inner">

            <a href="<?php echo home_url(); ?>" class="logo icon-logo">
                <h1 id="page-title" class="hidden">
                    <?php bloginfo( 'name' ); ?>
                    <span>
							<?php the_title(); ?>
						</span>
                </h1>
            </a>


            <div class="languages-availability">


                <div class="adv_phone_no">
                    <a class="desktop" href="tel:+302721094420">T: +(30) 2721094420-4</a>
                    <?php
                    $settings = get_option( 'genius_contact' );
                    $address  	= isset( $settings['office_address'] ) ? $settings['office_address'] : '';
                    echo '<p>'.$address.'</p>';
                    ?>
                    <a class="mobile" href="tel:+302721094420">&nbsp;</a>
                </div>


                <?php genius_theme_get_language_list(); ?>

                <span id="close-booking-form">
						<?php pll_e( 'Close' ); ?>
                    <span>X</span>
					</span>

                <a id="open-booking-form" class="button check-availability">
					   <span class="check-text">
					   		<?php pll_e( 'Check availability' ); ?>
					   </span>
                </a>

            </div>

        </div>
    </div>

    <div class="header-navigation">
        <div class="navigation-inner">
            <?php genius_theme_primary_menu(); ?>
        </div>
        <span id="toggle-menu">Menu</span>
    </div>
