<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Currency as CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class CurrencyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = QueryBuilder::for(Currency::class)
            ->allowedFilters('name', 'iso_code')
            ->allowedSorts('name', 'iso_code')
            ->paginate(20)
            ->appends(request()->query());

        if ($currencies->isEmpty()) {
            return $this->sendError('There is no currencies based on your filter.');
        }

        return $this->sendResponse(CurrencyResource::collection($currencies), 'All currencies retrieved.');
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
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect currency or missing parameters.', $validator->errors());
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

            return $this->sendError('The currency does not exist.');
        }

        return $this->sendResponse(new CurrencyResource($currency), 'Currency retrieved.');
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
        $currency = Currency::find($id);

        if (is_null($currency)) {
            return $this->sendError('The currency does not exist.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|max:2',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect currency or missing parameters.', $validator->errors());
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
            return $this->sendError('The currency does not exist.');
        }

        $currency->delete();

        return $this->sendResponse([], 'Currency deleted.');
    }
}
