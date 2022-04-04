<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\FarmCollection;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class FarmController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farms = QueryBuilder::for(Farm::class)
            ->allowedFilters('name', 'address.postcode', 'address.city')
            ->allowedSorts('name', 'address.postcode', 'address.city')
            ->paginate(20)
            ->appends(request()->query());

        if($farms->isempty()) {
            return $this->sendError('There is no farms based on your filters');
        }

        return $this->sendResponse(FarmCollection::collection($farms), 'All farms retrieved.');
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
            'address_id' => 'required',
            'farm_details_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect farm or missing parameters', $validator->errors());
        }

        $input = $request->all();

        $farm = Farm::create($input);

        return $this->sendResponse($farm, 'Farm created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('Farm not found.');
        }

        return $this->sendResponse($farm, 'Farm retrieved successfully.');
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
            'address_id' => 'required',
            'farm_details_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect farm or missing parameters', $validator->errors());
        }

        $input = $request->all();

        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('Farm not found.');
        }

        $farm->update($input);

        return $this->sendResponse($farm, 'Farm updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('Farm not found.');
        }

        $farm->delete();

        return $this->sendResponse($farm, 'Farm deleted successfully.');
    }
}
