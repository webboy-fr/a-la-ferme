<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::truncate();

        $currency_list = array(
            array("name" => "Euro", "iso_code" => "EUR", "lang_id" => '1')
        );

        foreach ($currency_list as $key => $value) {

            Currency::create($value);

        }
    }
}
