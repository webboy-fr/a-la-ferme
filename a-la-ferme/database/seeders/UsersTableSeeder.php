<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User as User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $farmerRole = Role::where('name', 'farmer')->first();

        User::truncate();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.fr',
            'password' => bcrypt('password')
        ]);

        $joe = User::create([
            'name' => 'Joe',
            'email' => 'joe@joe.com',
            'password' => bcrypt('password')
        ]);

        $admin->roles()->attach($adminRole);
        $joe->roles()->attach($farmerRole);

    }
}
