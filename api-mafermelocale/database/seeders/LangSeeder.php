<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lang::truncate();

        $countries = [
            ['name' => 'Français (French)', 'iso_code' => 'FR', 'langage_locale' => 'fr-FR', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
        ];

        foreach ($countries as $key => $value) {
            Lang::create($value);
        }
    }
}
