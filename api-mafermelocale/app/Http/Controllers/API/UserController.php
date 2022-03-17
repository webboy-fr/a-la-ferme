<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Http\Resources\UserResource;
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

        return $this->sendResponse($users, 'All users retrieved.');
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
        
        return $this->sendResponse(new UserResource($user), 'User retrieved');
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

        if (Auth::guard('sanctum_user')->user()->id != $id) {
            return $this->sendError('You can\'t modify another user !', [], 403);
        }

        $user->update($request->all());

        return $this->sendResponse(new UserResource($user), 'User updated.');
    }

    /**
     * Delete a user from the database, using the ID of the user
     * 
     * @param Int ID ID of the user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::guard('sanctum_user')->user()->id != $id) {
            return $this->sendError('You can\'t delete another user !', [], 403);
        }

        $user->delete();

        return $this->sendResponse([], 'User deleted.');
    }
}
