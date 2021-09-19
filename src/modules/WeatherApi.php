<?php


namespace App\modules;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class WeatherApi
{
    public const OPENWEATHERMAP_API_KEY      = '26e29aa16ee3a3a8af761f4dd0410824';
    public const OPENWEATHERMAP_API_BASE_URL = 'https://api.openweathermap.org/data/2.5/';

    public static function getWeatherData($city): array
    {
        $response = [];

        try {
            $client                 = HttpClient::create();
            $openWeatherMapResponse = $client->request('GET', self::OPENWEATHERMAP_API_BASE_URL.'weather?q='.$city.
                '&appid='.self::OPENWEATHERMAP_API_KEY.'&units=metric')->toArray();

            $response['statusCode']      = 200;
            $response['city_name']       = $openWeatherMapResponse['name'];
            $response['temp']            = $openWeatherMapResponse['main']['temp'];
            $response['temp_feels_like'] = $openWeatherMapResponse['main']['feels_like'];
            $response['temp_min']        = $openWeatherMapResponse['main']['temp_min'];
            $response['temp_max']        = $openWeatherMapResponse['main']['temp_max'];
            $response['pressure']        = $openWeatherMapResponse['main']['pressure'];
            $response['humidity']        = $openWeatherMapResponse['main']['humidity'];
            $response['speed']           = $openWeatherMapResponse['wind']['speed'];
            $response['deg']             = $openWeatherMapResponse['wind']['deg'];
            $response['timezone']        = $openWeatherMapResponse['timezone'];

            return $response;
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            $response['statusCode'] = 500;
            $response['message']    = 'Something went wrong';

            return $response;
        }

    }

}