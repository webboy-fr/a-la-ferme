<?php

namespace App\Http\Controllers;

class AddressFinder
{

    private string $address, $postcode, $city;
    private string $url = "https://api-adresse.data.gouv.fr/search/?";

    function __construct($address, $postcode, $city) {
        $this->address = $address;
        $this->postcode = $postcode;
        $this->city = $city;
    }

    /**
     * Retrieve the coordinates of the address in the constructor
     * 
     * @return Array coordinates The coordinates (longitude, latitude) of the address
     */
    public static function toCoordinates() {

        $addressComplete = self::$address.' '.self::$postcode.' '.self::$city;
        $appel_api = file_get_contents(self::$url . http_build_query(array('q' => $addressComplete, 'format' => 'json')));
        $resultats = json_decode($appel_api);

        if(isset($resultats->features[0]->geometry->coordinates[0]) && isset($resultats->features[0]->geometry->coordinates[1])) {
            $coordinates = array('lon' => $resultats->features[0]->geometry->coordinates[0], 'lat' => $resultats->features[0]->geometry->coordinates[1]);
        }
        else {
            $coordinates = array('lon' => '', 'lat' => '');
        }

        return $coordinates;

    }
}
