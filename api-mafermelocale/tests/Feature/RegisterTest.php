<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A register user test (required field).
     *
     * @return void
     */
    public function testsUserRequiresPasswordEmailAndName()
    {
        $this->json('POST', 'api/register')
            ->assertStatus(400)
            ->assertJson([
                "success" => false,
                "message" => "Error validation",
                "data" => [
                    "first_name" => ["The first name field is required."],
                    "last_name" => ["The last name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."], 
                    "confirm_password" => ["The confirm password field is required."]
                ]
            ]);
    }

    /**
     * A register admin test (required field).
     *
     * @return void
     */
    public function testsAdminRequiresPasswordEmailAndName()
    {
        $this->json('POST', 'api/registeradmin')
            ->assertStatus(400)
            ->assertJson([
                "success" => false,
                "message" => "Error validation",
                "data" => [
                    "username" => ["The username field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."], 
                    "confirm_password" => ["The confirm password field is required."]
                ]
            ]);
    }

    /**
     * A register user test (password confirmation).
     *
     * @return void
     */
    public function testsRequirePasswordConfirmation()
    {
        $headers = ['Accept' => 'application/json'];
        $userTest = [
            'first_name' => 'Test',
            'last_name' => 'Login',
            'email' => 'testlogin@user.com',
            'password' => 'User123',
            'confirm_password' => 'User'
        ];

        $this->json('POST', 'api/register', $userTest, $headers)
            ->assertStatus(400)
            ->assertJson([
                "success" => false,
                "message" => "Error validation",
                "data" => [
                    "confirm_password" => ["The confirm password and password must match."]
                ]
            ]);
    }

    /**
     * A register admin test (password confirmation).
     *
     * @return void
     */
    public function testsAdminRequirePasswordConfirmation()
    {
        $headers = ['Accept' => 'application/json'];
        $userTest = [
            'username' => 'Test Login',
            'email' => 'testlogin@admin.com',
            'password' => 'Admin123',
            'confirm_password' => 'Admin'
        ];

        $this->json('POST', 'api/register', $userTest, $headers)
            ->assertStatus(400)
            ->assertJson([
                "success" => false,
                "message" => "Error validation",
                "data" => [
                    "confirm_password" => ["The confirm password and password must match."]
                ]
            ]);
    }

    /**
     * A register user test (successfully).
     *
     * @return void
     */
    public function testsUserRegistersSuccessfully()
    {
        $headers = ['Accept' => 'application/json'];
        $userTest = [
            'first_name' => 'Test',
            'last_name' => 'Login',
            'email' => 'testlogin@user.com',
            'password' => 'User123',
            'confirm_password' => 'User123',
        ];

        $this->json('POST', 'api/register', $userTest, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'created_at',
                    'updated_at',
                    'id'
                ],
            ]);;

        User::where('email', 'testlogin@user.com')->delete();
    }

    /**
     * A register admin test (successfully).
     *
     * @return void
     */
    public function testsAdminRegistersSuccessfully()
    {
        $headers = ['Accept' => 'application/json'];
        $adminTest = [
            'username' => 'Test Login',
            'email' => 'testlogin@admin.com',
            'password' => 'Admin123',
            'confirm_password' => 'Admin123',
        ];

        $this->json('POST', 'api/registeradmin', $adminTest, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'username',
                    'email',
                    'created_at',
                    'updated_at',
                    'id'
                ],
            ]);;
        
        Admin::where('email', 'testlogin@admin.com')->delete();  
    }
}
