<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Farm as FarmResource;
use App\Models\Farm;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User as UserResource;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends BaseController
{
    /**
     * Index method, to get all the users paginated
     * 
     * @return JSON Return a JSON Response with all the users
     */
    public function index()
    {
        $users = QueryBuilder::for(User::with('role'))
            ->allowedFilters('first_name', 'last_name', 'email', 'username', 'role.name', 'role_id')
            ->allowedSorts('first_name', 'last_name')
            ->paginate(20)
            ->appends(request()->query());

        if($users->isempty()) {
            return $this->sendError('There is no users based on your filter');
        }

        return $this->sendResponse(UserResource::collection($users), 'All users retrieved.');
    }

    /**
     * Show method, to get a specific user
     * 
     * @return JSON The specific user in JSON format
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('The user does not exist.');
        }
        
        return $this->sendResponse(new UserResource($user), 'User retrieved.');
    }

    public function showFarm($id, Farm $farm)
    {
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('The farm does not exist.');
        }

        return $this->sendResponse(new FarmResource($farm), 'Farm retrieved');
    }

    /**
     * Update the specified user with the requested parameters
     * 
     * @return JSON Return a JSON Response with the current user updated
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('The user does not exist.');
        }

        if (Auth::guard('sanctum_user')->user()->id != $id) { // If the user is not the same as the authenticated user (the one who is trying to update the user)
            return $this->sendError('You can\'t modify another user !', [], 403); // Forbidden !
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) { // if the validator fails 
            return $this->sendError('Incorrect user or missing parameters', $validator->errors()); // return error message that role is not found 
        }

        $user->update($request->all()); // Update the user with the requested parameters

        return $this->sendResponse($user, 'User updated successfully.'); // Return the updated user
    }

    /**
     * Delete a user from the database, using the ID of the user
     * 
     * @param Int ID ID of the user
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) { 
            return $this->sendError('The user does not exist.'); // Return error if user not found 
        }
 
        if (Auth::guard('sanctum_user')->user()->id != $id) { // If the user is not the same as the authenticated user (the one who is trying to delete the user)
            return $this->sendError('You can\'t delete another user !', [], 403); // Forbidden !
        }

        $user->delete(); // Delete the user

        return $this->sendResponse([], 'User deleted.');
    }
}
