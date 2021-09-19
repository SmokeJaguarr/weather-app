<?php


namespace App\modules;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class IpLocationApi
{
    public const IPSTACK_API_KEY      = '4ad0e02fbf2e1a55a886b65c9d4a7644';
    public const IPSTACK_API_BASE_URL = 'http://api.ipstack.com/';

    /**
     * @param $ip
     * @return array
     */
    public static function getUserLocationFromIp($ip): array
    {

        $response = [];

        try {
            $client          = HttpClient::create();
            $ipStackResponse = $client->request('GET',
                self::IPSTACK_API_BASE_URL.$ip.'?access_key='.self::IPSTACK_API_KEY)->toArray();

            if (isset($ipStackResponse['success'])) {
                $response['statusCode'] = 400;
                $response['message']    = $ipStackResponse['error']['info'];

                return $response;
            }

            if ($ipStackResponse['city'] === null) {
                $response['statusCode'] = 400;
                $response['message']    = 'Could not find ip location';

                return $response;
            }

            $response['statusCode']   = 200;
            $response['country_name'] = $ipStackResponse['country_name'];
            $response['city']         = $ipStackResponse['city'];

            return $response;
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            $response['statusCode'] = 500;
            $response['message']    = 'Server error';

            return $response;
        }
    }

}