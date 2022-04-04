<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'name' => 'required',
            'iso_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect currency or missing parameters', $validator->errors());
        }

        $input = $request->all();

        $currency = Currency::create($input);

        return $this->sendResponse($currency, 'Currency created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currency = Currency::find($id);

        if (is_null($currency)) {

            return $this->sendError('Currency not found.');
        }

        return $this->sendResponse($currency, 'Currency retrieved successfully.');
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
            'name' => 'required',
            'iso_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect currency or missing parameters', $validator->errors());
        }

        $input = $request->all();

        $currency = Currency::find($id);

        if (is_null($currency)) {

            return $this->sendError('Currency not found.');
        }

        $currency->update($input);

        return $this->sendResponse($currency, 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = Currency::find($id);

        if (is_null($currency)) {

            return $this->sendError('Currency not found.');
        }

        $currency->delete();

        return $this->sendResponse($currency, 'Currency deleted successfully.');
    }
}
