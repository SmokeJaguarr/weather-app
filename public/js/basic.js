const DATA_EXPIRY_IN_MINUTES = 5;
const LOCAL_STORAGE_WEATHER_NAME = 'weatherData';

$(document).ready(function () {
    let weatherData = JSON.parse(localStorage.getItem(LOCAL_STORAGE_WEATHER_NAME)) !== null ? getWeatherDataLocalStorage() : null;
    if (weatherData !== null) {
        fillTemplateWithData(weatherDataLocalStorage);
        console.log('Data From local storage');
    } else {
        requestAndStoreWeatherData();
        console.log('Data From API Request');
    }
});
$('#reload-data').click(function () {
    requestAndStoreWeatherData();
});

function fillTemplateWithData(data) {
    var d = new Date();
    $('#temperature').text(data.temp);
    $('#city-name').text(data.city_name);
    $('#time').text(d.toLocaleTimeString());
    $('#wind-speed').text(data.speed);
    $('#humidity').text(data.humidity);
}

function getWeatherDataLocalStorage() {
    data = JSON.parse(localStorage.getItem(LOCAL_STORAGE_WEATHER_NAME));
    console.log(data);
    if (data.expiryDate < +new Date()) {
        return data = null;

    } else {
        console.log(+new Date());
        console.log('data ok');
        return data;
    }
}

function requestAndStoreWeatherData() {

    $.ajax({
        type: "GET",
        contentType: "application/json",
        url: "/rest/weather",
        dataType: "json",
        success: function (data) {
            data.expiryDate = +new Date(new Date().getTime() + DATA_EXPIRY_IN_MINUTES * 60000);
            localStorage.setItem(LOCAL_STORAGE_WEATHER_NAME, JSON.stringify(data));
            fillTemplateWithData(data);
        },
        error: function (result) {
            alert(result.responseJSON.message);
        }
    });


}