<?php
/**
 * Created by PhpStorm.
 * User: jaroslavlomecki
 * Date: 04/08/2018
 * Time: 07:41
 */

namespace App\Services;

use GuzzleHttp\Client as Client;

class AddressService
{
    public function GetAddress($lat, $lon)
    {
        $client = new Client();
        $response = $client->get('https://nominatim.openstreetmap.org/reverse?format=json&lat='.$lat.'&lon='.$lon.'&addressdetails=1');
        $result = json_decode($response->getBody()->getContents());
        $address = $result->display_name;
        return $address;
    }

}