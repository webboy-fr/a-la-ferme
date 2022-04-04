<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AdressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = 'https://api-adresse.data.gouv.fr/search/?';

        // Adresses
        $adresses = '34 rue Paul Valéry, 31200 Toulouse';

        // Géocodage
        $params = http_build_query(array('q' => $adresses, 'format' => 'json'));
        $appel_api = file_get_contents($url . $params);
        $resultats = json_decode($appel_api);
        $lon = $resultats->features[0]->geometry->coordinates[0];
        $lat = $resultats->features[0]->geometry->coordinates[1];

        Address::create([
            "address" => "34 rue Paul Valéry",
            "postcode" => "31200",
            "city" => "Toulouse",
            "lon" => $lon,
            "lat" => $lat
        ]);

    }
}
