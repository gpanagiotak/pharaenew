$(document).ready(function () {

    $(".sliding_gallery .lightgallery").slick({
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $(".header-booking-form").slideUp();

    $(".mobile-navigation").slideUp();
    $("body").removeClass('no-overflow');

    $("#open-booking-form").on("click", function () {
        $(".header-booking-form").show();
    });

    $(".toggle_mobile_menu").on("click", function () {
        $(".mobile-navigation").slideToggle();
        $("body").toggleClass('no-overflow');
    });

    $("#mobile-open-booking-form").on("click", function () {
        $(".header-booking-form").slideDown();
        $(this).hide();
        $("#mobile-close-booking-form").show();
    });

    $("#mobile-close-booking-form").on("click", function () {
        $(".header-booking-form").slideUp();

        $(this).hide();
        $("#mobile-open-booking-form").show();
    });

    $("#mobile-toggle-menu").on("click", function () {
        $('.header-navigation').toggleClass("active");
    });

    let check_in_ready = 0;
    let check_out_ready = 0;

    $('.checkout').on('change', function () {
        check_out_ready = 1;

        console.log('check_out_ready: ', check_out_ready);
        console.log('check_in_ready: ', check_in_ready);

        if (check_in_ready === 1 && check_out_ready === 1) {
            $('.checksubmit').prop("disabled", false);
        }
        else {
            $('.checksubmit').prop("disabled", true);
        }
    });

    $('.checkin').on('change', function () {
        check_in_ready = 1;

        if (check_in_ready === 1 && check_out_ready === 1) {
            $('.checksubmit').prop("disabled", false);
        }
        else {
            $('.checksubmit').prop("disabled", true);
        }
    });


    $('.checksubmit').on("click", function () {
        if (check_in_ready !== 1 || check_out_ready !== 1) {
            alert('not ready to click');
        }
    });

    $(document).bookingFormToggle();

    $(".primary-menu-container").toggleMainMenu();

});

$.fn.bookingFormToggle = function () {
    $("#open-booking-form").on("click", function () {
        $(".header-booking-form").addClass("active");
        $(".languages-availability").addClass("opened-form");
        if ($(".header-navigation").hasClass("active")) {
            return $(".header-navigation").removeClass("active");
        }
    });
    return $("#close-booking-form").on("click", function () {
        $(".header-booking-form").removeClass("active");
        return $(".languages-availability").removeClass("opened-form");
    });
};

$.fn.toggleMainMenu = function () {
    let $menu, resizeMenu;

    console.log("hello &&&&&&&&&&&&&&&&&&&&&&&&&");

    resizeMenu = function () {
        var $header, $viewport;
        $header = $("#document-header").height();
        $viewport = $(window).height();
        return $(".navigation-inner").css("max-height", $viewport - $header * 2 + 30);
    };
    resizeMenu();
    $menu = $(".header-navigation");
    $("#toggle-menu").on("click", function () {
        $menu.toggleClass("active");
        if ($(".header-booking-form").hasClass("active")) {
            $("#close-booking-form").trigger("click");
        }
        if ($(window).width() < 1024) {
            return $("body").toggleClass("no-overflow");
        }
    });
    $(window).on("scroll", function () {
        if ($(document).scrollTop() > 50) {
            return $menu.removeClass("active");
        }
    });
    return $(window).resize(function () {
        return resizeMenu();
    });
};

// TODO: Create a new account and change the APPID
if (!getCookie("weatherTemp")) {

    fetch('https://api.openweathermap.org/data/2.5/weather?q=Kalamata,gr&APPID=dbc330112bd5ff4e8f968e82b113ddcb&units=metric', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            setCookie("weatherTemp", data.main.temp);
            setCookie("weatherIcon", data.weather[0].icon);

        })
        .catch((error) => {
            console.error('Error:', error);
        });
}


function setCookie(name, value) {
    let now = new Date();
    let time = now.getTime();
    time += 4 * 3600 * 1000;
    now.setTime(time);
    let expires = "; expires=" + now.toUTCString();
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
