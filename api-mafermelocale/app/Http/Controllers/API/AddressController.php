<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AddressFinder;
use App\Http\Resources\AddressCollection;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class AddressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = QueryBuilder::for(Address::class)
        ->allowedFilters('address', 'postcode', 'city')
        ->allowedSorts('address', 'postcode')
        ->get();

        if($addresses->isempty()) {
            return $this->sendError('There is no users based on your filter');
        }

        return $this->sendResponse(AddressCollection::collection($addresses), 'All users retrieved.');
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
            'address' => 'required',
            'postcode' => 'required',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect address or missing parameters', $validator->errors());
        }

        $input = $request->all();
        $coordinates = new AddressFinder($input['address'], $input['postcode'], $input['city']);

        $input['lon'] = $coordinates->toCoordinates()['lon'];
        $input['lat'] = $coordinates->toCoordinates()['lat'];

        if(empty($input['lon']) || empty($input['lat'])) {
            return $this->sendError('The input address is not valid', [], 400);
        }

        $address = Address::create($input);

        return $this->sendResponse($address, 'Address created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return $this->sendError('The address does not exist.');
        }
        
        return $this->sendResponse(new AddressCollection($address), 'Address retrieved');
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
        $address = Address::find($id);

        if (is_null($address)) {
            return $this->sendError('The address does not exist.');
        }
 
        if(Auth::guard('sanctum_user')->id() !== $address->user_id) { 
            return $this->sendError('You are not allowed to update this address', [], 403); // 403 forbidden
        }

        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'postcode' => 'required',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect address or missing parameters', $validator->errors());
        }

        $input = $request->all();
        $coordinates = new AddressFinder($input['address'], $input['postcode'], $input['city']);

        $input['lon'] = $coordinates->toCoordinates()['lon'];
        $input['lat'] = $coordinates->toCoordinates()['lat'];

        if(empty($input['lon']) || empty($input['lat'])) {
            return $this->sendError('The input address is not valid', [], 400);
        }
        
        $address->update($input);

        return $this->sendResponse($address, 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return $this->sendError('The address does not exist.');
        }
        
        if($address->user_id != Auth::guard('sanctum_user')->id()) { // if the address id is not the same as the authenticated user id, return an error
            return $this->sendError('You are not authorized to delete this address.', [], 403); // 403 forbidden
        }
        
        return $this->sendResponse([], 'Address deleted');
    }
}
