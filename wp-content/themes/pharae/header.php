<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <link href="https://plus.google.com/b/104446232514472547377/104446232514472547377" rel="publisher" />
    <link rel="icon"
          type="image/png"
          href="<?php echo get_template_directory_uri().'/images/favicon.png' ?>">

	<title><?php wp_title( '|', true, 'right' ); ?></title>






    <script type="application/javascript">

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }



    </script>
	
	<link rel="stylesheet" type="text/css" 
href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" 
/>
     <script 
src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
     <script>
         window.addEventListener("load", function(){
             window.cookieconsent.initialise({
                 "palette": {
                     "popup": {
                         "background": "#645349",
                         "text": "#F4F4F4"
                     },
                     "button": {
                         "background": "#645349",
                         "text": "#F4F4F4",
                         "border": "#29CBDA"
                     }
                 },
                 "content": {
                     "message": " <?php if(ICL_LANGUAGE_CODE == 'el') {
                         echo 'Αυτή η ιστοσελίδα χρησιμοποιεί cookies για να έχετε την καλύτερη δυνατή εμπειρία.';
                     } else {
                     echo 'This website uses cookies to ensure you get the best experience on our website';
                     } ?>
                     ",
                     "dismiss": " <?php if(ICL_LANGUAGE_CODE == 'el') {
                         echo 'Το κατάλαβα!';
                     } else {
                     echo 'Got it!';
                     } ?>",
                     "link": "<?php if(ICL_LANGUAGE_CODE == 'el') {
                         echo 'Μάθε περισσότερα';
                     } else {
                     echo 'Learn More';
                     } ?>",
                     "href": "<?php
						if (ICL_LANGUAGE_CODE == 'de') {
                        echo get_site_url().'/cookies-de/'; 
                    }else if (ICL_LANGUAGE_CODE == 'en') {
                        echo get_site_url().'/cookies-en/'; 
                     }else {
                        echo get_site_url().'/cookies/'; 
                     }
                      ?>"
                 }
             })});
     </script>

	

	<?php wp_head(); ?>
</head>

<?php global $post; ?>

<body <?php body_class(); ?>>



<?php $current_id = get_the_ID();  ?>
<?php $de_lang_id = pll_get_post($current_id, 'de');  ?>
<?php $en_lang_id = pll_get_post($current_id, 'en');  ?>
<?php $el_lang_id = pll_get_post($current_id, 'el');  ?>

<?php $de_url = get_permalink($de_lang_id) ?>
<?php $en_url = get_permalink($en_lang_id) ?>
<?php $el_url = get_permalink($el_lang_id) ?>

<?php  // echo 'current id: '.$current_id; ?>
<?php  // echo '$de_lang_id: '.$de_lang_id; ?>
<?php  // echo '$en_lang_id: '.$en_lang_id; ?>
<?php  // echo '$el_lang_id: '.$el_lang_id; ?>

<?php  // echo '$de_url: '.$de_url; ?>
<?php  // echo '$en_url: '.$en_url; ?>
<?php  // echo '$el_url: '.$el_url; ?>



<script type="application/javascript">


    jQuery(document).ready(function($) {
        var langRedirect = getCookie('langRedirections');


        // console.log('langRedirect: '+langRedirect);

        if (langRedirect != '1') {
            // $.getJSON("http://api.db-ip.com/v2/free/self").then(function(addrInfo) {
            $.getJSON("https://ip-api.com/json").then(function(addrInfo) {

                // console.log('addrInfo.countryCode: ', addrInfo.countryCode);

                if (addrInfo.countryCode == "GR") {
                    document.location = '<?= $el_url; ?>';
                } else if (addrInfo.countryCode == "DE") {
                    document.location = '<?= $de_url; ?>';
                }else{
                        document.location = '<?= $en_url; ?>';
                }
            });
            setCookie('langRedirections', '1', 1);
        };

    });



</script>





<script>
    // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    //     (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    //     m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    // })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    //
    // ga('create', 'UA-50451900-1', 'auto');
    // ga('send', 'pageview');

</script>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TBC4VC"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TBC4VC');</script>
<!-- End Google Tag Manager-->


<!--<div class="mainbgimage" style="background: url('http://localhost/phr/wp-content/uploads/2014/04/PHARAE-PALACE-06901-1920x1277.jpg')">-->
<!--    <img src="http://via.placeholder.com/1920x300" style="visibility: hidden;" />-->
<!--    <img src="http://localhost/phr/wp-content/uploads/2014/04/PHARAE-PALACE-06901-1920x1277.jpg" style="visibility: hidden;" />-->
<!--</div>-->







<div id="skrollr-body">



    <header id="document-header" class="mobile" role="banner">

            <div class="header-booking-form">
                <div class="form-container">

                    <?php genius_theme_booking_form(); ?>

                    <ul class="header-contact-details">
                        <li class="contact-item"><i class="icon-mail"></i><?php genius_contact_reservation_email( false ); ?></li>
                        <li class="contact-item"><i class="icon-phone"></i><?php genius_contact_reservation_phone( false ); ?></li>
                    </ul>

                </div>
            </div>



            <div class="desktop_header">
                <?php get_template_part('includes/headers/desktop');  ?>
            </div>


            <div class="mobile_header">
                <?php get_template_part('includes/headers/mobile');  ?>
            </div>

        </header>



    <?php
//
//    if ($theid != $el_id) {
//        wp_redirect( $url );
//        exit;
//    }




//    if ( wp_redirect( $url ) ) {
//        exit;
//    }


    ?>



    <main role="main">

		<?php if( is_front_page() ) : ?>
			<section id="page-slider">
				<?php genius_theme_slider(); ?>
			</section>
		<?php endif; ?>

		<section id="content">
