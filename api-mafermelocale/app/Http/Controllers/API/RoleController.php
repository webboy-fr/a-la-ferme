<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role as RoleRessource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = QueryBuilder::for(Role::class)
        ->allowedFilters('name')
        ->allowedSorts('name')
        ->get();

        if ($roles->isempty()) {
            return $this->sendError('There is no roles based on your filter');
        }

        return $this->sendResponse($roles, 'All roles retrieved.');
        return $this->sendResponse(RoleRessource::collection($roles), 'All roles retrieved.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'lang_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect role or missing parameters.', $validator->errors());
        }

        $role = Role::create($input);

        return $this->sendResponse($role, 'Role created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (is_null($role)) {
            return $this->sendError('The role does not exist.');
        }

        return $this->sendResponse(new RoleRessource($role), 'Role retrieved.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id); // find the role

        // if the role is not found
        if (is_null($role)) {
            return $this->sendError('The role does not exist.'); // return error message that role is not found 
        }

        $input = $request->all(); // get all the input from the request

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'lang_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect role or missing parameters.', $validator->errors());  
        }

        $role->update($input); // update the role with the input

        return $this->sendResponse($role, 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id); // find the role

        if (is_null($role)) {
            return $this->sendError('The role does not exist.'); // return error message that role is not found
        }

        $role->delete(); // delete the role

        return $this->sendResponse([], 'Role deleted.');
    }
}
