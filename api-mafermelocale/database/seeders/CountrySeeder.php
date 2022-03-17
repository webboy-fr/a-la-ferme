<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();

        $countries = [
            ['name' => 'France', 'iso_code' => 'FR', 'currency_id' => '1', 'lang_id' => '1'],
        ];

        foreach ($countries as $key => $value) {
            Country::create($value);
        }
    }
}
