<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
     /**
     * A logout user test
     *
     * @return void
     */
    public function testUserIsLoggedOutProperly()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Login',
            'email' => 'testlogin@user.com',
            'password' => Hash::make('User123'),
            'role_id' => 2,
            'address_id' => 1
        ]);

        $headers = ['Accept' => 'application/json'];
        $userTest = ['email' => 'testlogin@user.com', 'password' => 'User123'];

        $this->json('POST', 'api/login', $userTest, $headers)->assertStatus(200);

        $token = $user->generateToken();
        $header = ['Authorization' => "Bearer $token"];

        $this->json('POST', 'api/logout', $header)
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "message" => "User Signed out.",
                "data" => null
            ]);

        User::where('email', 'testlogin@user.com')->delete();
    }

    /**
     * A logout admin test
     *
     * @return void
     */
    public function testAdminIsLoggedOutProperly()
    {
        $admin = Admin::create([
            'username' => 'Test Login',
            'email' => 'testlogin@admin.com',
            'password' => Hash::make('Admin123')
        ]);

        $headers = ['Accept' => 'application/json'];
        $adminTest = ['email' => 'testlogin@admin.com', 'password' => 'Admin123'];

        $this->json('POST', 'api/loginadmin', $adminTest, $headers)->assertStatus(200);

        $token = $admin->generateToken();
        $header = ['Authorization' => "Bearer $token"];

        $this->json('POST', 'api/logoutadmin', $header)
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "message" => "Admin signed out.",
                "data" => null
            ]);

        Admin::where('email', 'testlogin@admin.com')->delete();
    }

    /**
     * A logout admin test and test access of files
     *
     * @return void
     */
    public function testAdminWithNullToken()
    {
        // Simulating login
        $admin = Admin::create([
            'username' => 'Test Login',
            'email' => 'testlogin@admin.com',
            'password' => Hash::make('Admin123')
        ]);

        $headers = ['Accept' => 'application/json'];
        $adminTest = ['email' => 'testlogin@admin.com', 'password' => 'Admin123'];

        $token = $admin->generateToken();
        $header = ['Authorization' => "Bearer $token"];

        $this->json('POST', 'api/loginadmin', $adminTest, $headers)->assertStatus(200);
        $this->json('POST', 'api/logoutadmin', $header)->assertStatus(200);

        $this->json('GET', 'api/roles', [], $headers)->assertStatus(401);

        Admin::where('email', 'testlogin@admin.com')->delete();
    }
}
