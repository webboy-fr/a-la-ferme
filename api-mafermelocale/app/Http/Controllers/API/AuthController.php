<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function signin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('MaFermeLocale')->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Signup method for a user
     * 
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['name'] =  $user->first_name;

        return $this->sendResponse($success, 'User created successfully.');
    }

    public function signupAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $admin = Admin::create($input);
        $success['name'] =  $admin->username;

        return $this->sendResponse($success, 'User created successfully.');
    }

    /**
     * Sign in method for admin 
     * 
     * @return \Illuminate\Http\Response
     */
    public function signinAdmin(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $authAdmin = Auth::guard('admin')->user();
            $success['token'] =  $authAdmin->createToken('MaFermeLocaleAdmin')->plainTextToken;
            
            // create an array with the admin data
            $adminData = array(
                'token' => $success['token'],
                'token_type' => 'bearer',
                'admin' => [
                    'id' => $authAdmin->id,
                    'username' => $authAdmin->username,
                    'email' => $authAdmin->email
                ],
            );

            return $this->sendResponse($adminData, 'Admin signed in');
        } else {
            return $this->sendError('The provided credentials does not match our records.', []);
        }
    }

    /**
     * Sign out method for admin
     * 
     * @return \Illuminate\Http\Response
     */
    public function signoutAdmin(Request $request)
    {
        $request->user('sanctum_admin')->currentAccessToken()->delete();
        
        return $this->sendResponse(null, 'Admin signed out.');
    }

    /**
     * Sign out method for user
     * 
     * @return \Illuminate\Http\Response
     */
    public function signoutUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $request->user()->signout();
        
        return $this->sendResponse(null, 'Signed out.');
    }
}
