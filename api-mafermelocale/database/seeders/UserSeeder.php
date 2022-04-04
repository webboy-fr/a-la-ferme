<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Agriculteur',
            'lang_id' => '1'
        ]);

        Role::create([
            'name' => 'Utilisateur',
            'lang_id' => '1'
        ]);

    }
}
