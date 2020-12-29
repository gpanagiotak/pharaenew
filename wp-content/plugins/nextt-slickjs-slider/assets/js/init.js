$(document).ready(function () {

    var slick_desktop = $('.single-item_gallery');


    if( slick_desktop.length > 0){
        slick_desktop.each(function(){
            $(this).slick({
                dots: true,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true
            });
        });
    }




});


