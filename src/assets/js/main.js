$(document).ready(function () {


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

});


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
