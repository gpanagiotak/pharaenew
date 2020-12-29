<?php

/**
*
* Book Online Booking Form
*
**/

// Genius Book Online settings page

function genius_book_online_now_settings_page( $pages )
{
	$pages[] = array(
		'page_title'	=> 'Book Online Settings',
		'menu_title'	=> 'Book Online',
		'sub_menu'		=> 'options-general.php',
		'capability'	=> 'administrator',
		'menu_slug'		=> 'bookonlinenow-settings',
		'setting'		=> 'genius_book_online_now',
		'icon'			=> 'options-general',
		'save'			=> true,
		'save_text'		=> __( 'Save Book Online Settings', 'genius_theme' ),
	);

	return $pages;
}

add_filter( 'piklist_admin_pages', 'genius_book_online_now_settings_page' );


function get_genius_book_online_now_link()
{
	$settings = get_option( 'genius_book_online_now' );
	$hotel_link = isset( $settings['hotel_link'] ) ? $settings['hotel_link'] : '';

	$language = pll_current_language();

	if( $language == 'el' ) {
		$lang = 'el-GR';
	}
	elseif( $language == 'de' ) {
		$lang = 'de-DE';
	}
	else {
		$lang = 'en-US';
	}

	$link = $hotel_link .'?lan_id='. $lang;

	return esc_url( $link );
}

function genius_book_online_now_link()
{
	echo get_genius_book_online_now_link();
}

function get_genius_book_online_now_single_link()
{
	global $post;

	$settings = get_option( 'genius_book_online_now' );
	$hotel_link = isset( $settings['hotel_link'] ) ? $settings['hotel_link'] : '';

	$language = pll_current_language();

	if( $language == 'el' ) {
		$lang = 'el-GR';
	}
	elseif( $language == 'de' ) {
		$lang = 'de-DE';
	}
	else {
		$lang = 'en-US';
	}

	$link = get_post_meta( $post->ID, 'booking_link', true );
	$link = str_replace( array( 'lan_id=el-GR', 'lan_id=en-US', 'lan_id=en-US' ), 'lan_id='. $lang, $link );

	if( ! $link ) {
		$link = $hotel_link .'?lan_id='. $lang;
	}

	return esc_url( $link );
}

function genius_book_online_now_single_link()
{
	echo get_genius_book_online_now_single_link();
}

function genius_theme_booking_form()
{
	$option 	= get_option( 'genius_book_online_now' );
	$link 		= isset( $option['hotel_link'] ) ? $option['hotel_link'] : '';
	$checkin 	= isset( $option['form_checkin'] ) ? $option['form_checkin'] : 'on';
	$checkout 	= isset( $option['form_checkout'] ) ? $option['form_checkout'] : 'off';
	$rooms 		= isset( $option['form_rooms'] ) ? $option['form_rooms'] : 5;
	$adults 	= isset( $option['form_adults'] ) ? $option['form_adults'] : 5;
	$children 	= isset( $option['form_children'] ) ? $option['form_children'] : 0;
	$button 	= isset( $option['form_button'] ) ? $option['form_button'] : 'Book now';
	$labels 	= isset( $option['form_labels'] ) ? $option['form_labels'] : 'off';

	$language = pll_current_language();

	if( $language == 'el' ) {
		$lang = 'el-GR';
	}
	elseif( $language == 'de' ) {
		$lang = 'de-DE';
	}
	else {
		$lang = 'en-US';
	}

	?>
		<form id="booking-form" action="<?php echo esc_url( $link ); ?>" target="_blank" method="post" name="BookOnline">
			<input type="hidden" name="lan_id" value="<?php echo $lang; ?>">
			<input type="hidden" name="Page" value="19">
			<input type="hidden" name="kid1" value="-1">
			<input type="hidden" name="kid2" value="1">
			<input type="hidden" name="kid3" value="-1">
			<input type="hidden" name="extra" value="0">
			<input type="hidden" name="cot" value="0">
			<input type="hidden" name="src" value="">
			<input type="hidden" name="promo" value="">

			<ul class="booking-fields">

				<?php if( $checkin == 'on' ): ?>
					<li class="booking-field checkin">

						<?php if( $labels == 'on' ) echo '<label>'. pll__( 'Check In' ) .'</label>'; ?>
<!--						<input type="text" readonly id="arrival" class="datefield" name="arrival" placeholder="--><?php //if( $labels == 'off' ) pll_e( 'Check In' ); else pll_e( 'Check In' ); ?><!--">-->
						<input type="text" readonly id="arrival" class="datefield" name="fromd" placeholder="<?php if( $labels == 'off' ) pll_e( 'Check In' ); else pll_e( 'Check In' ); ?>">








					</li>
				<?php endif; ?>

				<?php if( $checkout == 'on' ): ?>
					<li class="booking-field checkout">

						<?php if( $labels == 'on' ) echo '<label>'. pll__( 'Check Out' ) .'</label>'; ?>
<!--						<input type="text" readonly id="departure" class="datefield" name="departure" placeholder="--><?php //if( $labels == 'off' ) pll_e( 'Check Out' ); else pll_e( 'Check Out' ); ?><!--">-->


                        <select id="nights" name="nights" class="checkout">
                            <option selected="selected" value="1">1 <?php if( $labels == 'off' ) pll_e( 'Night' ); ?></option>
                            <option value="2">2 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="3">3 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="4">4 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="5">5 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="6">6 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="7">7 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="8">8 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="9">9 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="10">10 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="11">11 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="12">12 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="13">13 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="14">14 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="15">15 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="16">16 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="17">17 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                            <option value="18">18 <?php if( $labels == 'off' ) pll_e( 'Nights' ); ?></option>
                        </select>


					</li>
				<?php endif; ?>

				<?php if( $rooms > 0 ): ?>
					<li class="booking-field rooms">

						<?php if( $labels == 'on' ) echo '<label>'. pll__( 'Rooms' ) .'</label>'; ?>
						<select id="rooms" name="rooms">
							<option selected="selected" value="1">1 <?php if( $labels == 'off' ) pll_e( 'Room' ); ?></option>
							<?php
								for ($i=2; $i < $rooms + 1; $i++) {

									if( $labels == 'off' ) {
										echo '<option value="'. $i .'">'. $i .' '. pll__( 'Rooms' ) .'</option>';
									} else {
										echo '<option value="'. $i .'">'. $i .'</option>';
									}
								}
							?>
						</select>

					</li>
				<?php endif; ?>

				<?php if( $adults > 0 ): ?>
					<li class="booking-field adults">

						<?php if( $labels == 'on' ) echo '<label>'. pll__( 'Adults' ) .'</label>'; ?>
						<select id="adults" name="adults">
							<option selected="selected" value="1">1 <?php if( $labels == 'off' ) pll_e( 'Adult' ); ?></option>
							<?php
								for ($i=2; $i < $adults + 1; $i++) {

									if( $labels == 'off' ) {
										echo '<option value="'. $i .'">'. $i .' '. pll__( 'Adults' ) .'</option>';
									} else {
										echo '<option value="'. $i .'">'. $i .'</option>';
									}
								}
							?>
						</select>

					</li>
				<?php endif; ?>

				<?php if( $children > 0 ): ?>
					<li class="booking-field children">

						<?php if( $labels == 'on' ) echo '<label>'. pll__( 'Children' ) .'</label>'; ?>
						<select id="children" name="children">
							<option selected="selected" value="0">0  <?php if( $labels == 'off' ) pll_e( 'Children' ); ?></option>
							<option value="1">1  <?php if( $labels == 'off' ) pll_e( 'Child' ); ?></option>
							<?php
								for ($i=2; $i < $children + 1; $i++) {

									if( $labels == 'off' ) {
										echo '<option value="'. $i .'">'. $i .' '. pll__( 'Children' ) .'</option>';
									} else {
										echo '<option value="'. $i .'">'. $i .'</option>';
									}
								}
							?>
						</select>

					</li>
				<?php endif; ?>

				<li class="booking-field submit">
<!--					<button disabled="disabled" class="checksubmit button" type="submit" name="Check">--><?php //pll_e( $button ); ?><!--</button>-->
					<button class="button" type="submit" name="Check"><?php pll_e( $button ); ?></button>
				</li>
			</ul>

		</form>
	<?php
}



// ADDED BY ADVERTEK - GEORGIOS
function get_local_offers_link(){
    if (pll_current_language('slug') == 'en'){
        return 'http://www.pharae.gr/offers-kalamata/';
    }
    else if (pll_current_language('slug') == 'el')   {
        return 'http://www.pharae.gr/prosfores-diamonis-kalamata/';
    }
    else if (pll_current_language('slug') == 'de')   {
        return 'http://www.pharae.gr/offers-in-kalamata/';
    }
    else{
        return 'http://www.pharae.gr/prosfores-diamonis-kalamata/';
    }
}




?>
