<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
//use App\Models\Role as Roll;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'farmer']);
    }
}
