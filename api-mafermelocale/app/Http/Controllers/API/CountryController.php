<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = QueryBuilder::for(Country::with('currency'))
            ->allowedFilters('name', 'iso_code', 'currency.name')
            ->allowedSorts('name', 'iso_code', 'currency.name')
            ->paginate(20)
            ->appends(request()->query());

        if ($countries->isEmpty()) {
            return $this->sendError('There is no countries based on your filter');
        }

        return $this->sendResponse($countries, 'All countries retrieved.');
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
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|max:2',
            'currency_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect country or missing parameters', $validator->errors());
        }

        $country = Country::create($request->all());

        return $this->sendResponse(new CountryResource($country), 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);

        if (is_null($country)) {
            return $this->sendError('The country does not exist.');
        }

        return $this->sendResponse(new CountryResource($country), 'Country retrieved');
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
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|max:2',
            'currency_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect country or missing parameters', $validator->errors());
        }

        $country = Country::find($id);

        if (is_null($country)) {
            return $this->sendError('The country does not exist.');
        }

        $country->update($request->all());

        return $this->sendResponse(new CountryResource($country), 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);

        if (is_null($country)) {
            return $this->sendError('The country does not exist.');
        }

        $country->delete();

        return $this->sendResponse(null, 'Country deleted successfully.');
    }
}
