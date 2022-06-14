<?php

namespace Tests\Feature;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthenticateMiddlewareTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A test for the redirectIfAuthenticated middleware.
     *
     * @return void
     */
    public function testRedirectedIfNotAuthenticated()
    {
        // Create a new instance of the middleware
        $middleware = new RedirectIfAuthenticated;

        //create a fake user
        $user = User::factory()->create();

        //set the user as the current user
        $this->actingAs($user);

        // Create a fake request
        $request = Request::create('/api/users', 'GET');

        // Run the middleware
        $response = $middleware->handle($request, function () {
            return response('Hello World');
        });

        // Assert the response is a redirect
        $this->assertEquals(302, $response->getStatusCode());

        // Delete the user
        $user->delete();
    }

}