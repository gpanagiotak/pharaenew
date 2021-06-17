

    <div class="mobile_header_inner clearfix">

        <a href="javascript:void(0)" class="toggle_mobile_menu">
            <img src="<?= get_stylesheet_directory_uri().'/images/mobile_menu.png' ?>" width="35" />
        </a>


        <a href="<?php echo home_url(); ?>" class="mobile_logo clearfix">
            <img src="<?= get_stylesheet_directory_uri().'/images/mobile_logo.png' ?>" alt="pharae palace" width="70" />
        </a>

        <div class="language_switcher">
            <?php genius_theme_get_language_list(); ?>
        </div>



        <div class="mobile_book">
             <span id="mobile-close-booking-form">
                <?php pll_e( 'Close' ); ?>
                        <span>X</span>
            </span>

            <a id="mobile-open-booking-form" class="button check-availability">
               <span class="book-text">
                    <?php pll_e( 'Book' ); ?>
               </span>
            </a>
        </div>

        <div class="adv_phone_no">
            <a class="mobile" href="tel:+302721094420">&nbsp;</a>
        </div>

    </div>


    <div class="mobile-navigation">
        <div class="navigation-inner">
            <?php genius_theme_primary_menu(); ?>
        </div>
    </div>


