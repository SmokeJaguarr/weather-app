<?php


namespace App\Controller;


use App\modules\IpLocationApi;
use App\modules\WeatherApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WeatherController extends AbstractController
{
    /**
     * @route("/rest/weather")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        $location_data = IpLocationApi::getUserLocationFromIp($_SERVER['REMOTE_ADDR']);

        if ($location_data['statusCode'] === 200) {
            $weather_data = WeatherApi::getWeatherData($location_data['city']);

            if ($weather_data['statusCode'] !== 200) {
                return new JsonResponse($weather_data, $weather_data['statusCode']);
            }
        }

        return new JsonResponse($location_data, $location_data['statusCode']);

    }

}