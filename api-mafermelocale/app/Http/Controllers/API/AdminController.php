<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Http\Resources\Admin as AdminResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = QueryBuilder::for(Admin::class)
        ->allowedFilters('admin', 'username', 'email')
        ->allowedSorts('admin', 'username')
        ->get();

        if($admins->isempty()) {
            return $this->sendError('There is no admins based on your filter');
        }

        return $this->sendResponse(AdminResource::collection($admins), 'All admins retrieved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
  
        if (is_null($admin)) {
            return $this->sendError('The admin does not exist.');
        }
   
        return $this->sendResponse(new AdminResource($admin), 'Admin retrieved.');
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
        $admin = Admin::find($id);

        if (is_null($admin)) {
            return $this->sendError('The admin does not exist.');
        }

        $input = $request->all();
   
        $validator = Validator::make($input, [
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Incorrect admin or missing parameters', $validator->errors());
        }
   
        $admin->username = $input['username'];
        $admin->email = $input['email'];
        $admin->password = $input['password'];
        $admin->save();
   
        return $this->sendResponse($admin, 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (is_null($admin)) {
            return $this->sendError('The admin does not exist.');
        }

        $admin->delete();
   
        return $this->sendResponse([], 'Admin deleted.');
    }
}