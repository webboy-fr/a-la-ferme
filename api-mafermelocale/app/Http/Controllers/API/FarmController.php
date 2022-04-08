<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Farm as FarmCollection;
use App\Models\Farm;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->allowedIncludes(['address', 'farm_detail'])
            ->allowedFilters('name', 'address.postcode', 'address.city')
            ->allowedSorts('name', 'address.postcode', 'address.city')
            ->paginate(20)
            ->appends(request()->query());

        if($farms->isempty()) {
            return $this->sendError('There is no farms based on your filters.');
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'farm_image' => 'required|image:jpeg,png,jpg|max:2048',
            'address_id' => 'required|integer',
            'farm_details_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect farm or missing parameters.', $validator->errors());
        }

        // Get the image file from the request and store it in the storage
        $uploadFolder = 'mafermelocale/images/farms/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        
        // Create the farm and save it in the database
        $input = $request->all();
        $input['farm_image'] = Storage::url($image_uploaded_path);

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
            return $this->sendError('The farm does not exist.');
        }

        return $this->sendResponse(new FarmCollection($farm), 'Farm retrieved.');
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
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('The farm does not exist.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'farm_image' => 'required|image:jpeg,png,jpg|max:2048',
            'address_id' => 'required|integer',
            'farm_details_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect farm or missing parameters.', $validator->errors());
        }

        //get the farm image path and delete the image from storage
        $farm_image = $farm->farm_image; // get the image path from the farm object 
        Storage::delete($farm_image); // delete the image from storage 

        // upload the new image 
        $uploadFolder = 'mafermelocale/images/farms/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        /**
         * Update the farm object with the new image path
         */
        $input['farm_image'] = Storage::url($image_uploaded_path);

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
            return $this->sendError('The farm does not exist.');
        }

        $farm->delete();

        // Get the farm image path and delete the image from storage
        $farm_image = $farm->farm_image; // Get the image path from the category object 
        Storage::delete($farm_image); // Delete the image from storage 

        return $this->sendResponse([], 'Farm deleted.');
    }

    /**
     * Get all farms within a given radius.
     * 
     * @param  double $longitude
     * @param  double $latitude
     * @param  int $radius
     * 
     * @return \Illuminate\Http\Response
     * 
     */
    public function getFarmsByRadius($longitude, $latitude, $radius)
    {
        if(empty($longitude) || empty($latitude) || empty($radius) || !is_numeric($longitude) || !is_numeric($latitude) || !is_numeric($radius)) {
            return $this->sendError('The given parameters are not valid.');
        }

        $farms = Address::selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lon ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance', [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();

        $farms = QueryBuilder::for(Farm::with('farm_detail')->whereIn('address_id', $farms->pluck('id'))) // Get farms with the same address id as the address with the given radius
            ->allowedFilters('name') // Filter by name, postcode and city
            ->allowedSorts('name') // Sort by name, postcode and city
            ->paginate(20); // Paginate 20 results

        if($farms->isempty()) {
            return $this->sendError('There is no farms based on your filters');
        }

        return $this->sendResponse($farms, 'All farms retrieved.');
    }
}
