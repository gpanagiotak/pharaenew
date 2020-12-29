/**
 * Created by christospapidas on 160415--.
 */

// Funky Boxes
$ = jQuery
$(document).ready(function(){

    $('.sc_active_box').hover(
        function(e){

            // animate text
            $(this).find('.sc_active_box_content').css("display", "block");
            $(this).find('.sc_active_box_content').addClass("animated fadeInUp");
            $(this).find('.sc_active_box_content').removeClass("fadeOutDown");

            // load photo
            var img = $(this).find('.sc_active_box_big').attr('img');
            $(this).find('.sc_active_box_big').css('background', "linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('"+img+"') no-repeat center center");

            // animate title
            $(this).find('.sc_active_box_image').addClass('animated fadeOutUp');
        },
        function(e){

            // animate text
            $(this).find('.sc_active_box_content').removeClass("animated fadeInUp");
            $(this).find('.sc_active_box_content').addClass("animated fadeOutDown");

            // load photo
            var img = $(this).find('.sc_active_box_big').attr('img');
            $(this).find('.sc_active_box_big').css('background', "url('"+img+"') no-repeat center center");

            // animate title
            $(this).find('.sc_active_box_image').removeClass('animated fadeOutUp');
            $(this).find('.sc_active_box_image').addClass('animated fadeInDown');
        }
    );

    $('.sc_active_box_content').on('click', function(e){

        // Get the link
        var link = $(this).attr('link');
        window.location = link;

    });

})