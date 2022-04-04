<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect role or missing parameters', $validator->errors());
        }

        $input = $request->all();
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
            return $this->sendError('Role not found');
        }

        return $this->sendResponse($role, 'Role retrieved.');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect role or missing parameters', $validator->errors());  
        }

        $role = Role::find($id); // find the role

        // if the role is not found
        if (is_null($role)) {
            return $this->sendError('Role not found'); // return error message that role is not found 
        }

        $input = $request->all(); // get all the input from the request
        $role->update($input); // update the role with the input

        return $this->sendResponse($role, 'Role updated successfully.'); // return success message that role is updated
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
            return $this->sendError('Role not found'); // return error message that role is not found
        }

        $role->delete(); // delete the role

        return $this->sendResponse($role, 'Role deleted successfully.'); // return success message that role is deleted
    }
}
