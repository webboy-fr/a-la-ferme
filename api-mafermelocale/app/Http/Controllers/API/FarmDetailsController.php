<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Farm_details as Farm_detailsResource;
use App\Models\Farm_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class FarmDetailsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farmDetails = QueryBuilder::for(Farm_details::with('farm'))
            ->allowedFilters('name', 'description', 'about')
            ->allowedSorts('name', 'description', 'about')
            ->paginate(20)
            ->appends(request()->query());

        if ($farmDetails->isEmpty()) {
            return $this->sendError('There is no farm details based on your filters.');
        }

        return $this->sendResponse(Farm_detailsResource::collection($farmDetails), 'All farm details retrieved.');
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
            'farm_banner' => 'required|image:jpeg,png,jpg|max:2048',
            'about' => 'required|string|max:255',
            'buisness_mail' => 'email',
            'phone' => 'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/|min:10',
            'instagram_id' => 'max:255',
            'facebook_id' => 'max:255',
            'lang_id' => 'required|integer',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Incorrect farm details or missing parameters', $validator->errors());       
        }

        // Get the image file from the request and store it in the storage
        $uploadFolder = 'mafermelocale/images/farms/details/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        
        // Create the farm details and save it in the database
        $input = $request->all();
        $input['farm_banner'] = Storage::url($image_uploaded_path);

        $farm_detail = Farm_details::create($input);
   
        return $this->sendResponse($farm_detail, 'Farm details created.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $farm_detail = Farm_details::find($id);
  
        if (is_null($farm_detail)) {
            return $this->sendError('The farm details does not exist.');
        }
   
        return $this->sendResponse(new Farm_detailsResource($farm_detail), 'Farm details retrieved.');
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
        $farm_detail = Farm_details::find($id);

        $input = $request->all();
   
        $validator = Validator::make($input, [
            'farm_banner' => 'required|image:jpeg,png,jpg|max:2048',
            'about' => 'required|string|max:255',
            'buisness_mail' => 'email',
            'phone' => 'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/|min:10',
            'instagram_id' => 'max:255',
            'facebook_id' => 'max:255',
            'lang_id' => 'required|integer',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Incorrect farm details or missing parameters', $validator->errors());       
        }

        // Get the farm details image path and delete the image from storage
        $farm_detail_banner = $farm_detail->farm_banner; // Get the image path from the farm details object 
        Storage::delete($farm_detail_banner); // Delete the image from storage 

        // Upload the new image 
        $uploadFolder = 'mafermelocale/images/farms/details/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        /**
         * Update the farm details object with the new image path
         */
        $input['farm_banner'] = Storage::url($image_uploaded_path);

        $farm_detail->update($input);
   
        return $this->sendResponse($farm_detail, 'Farm details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $farm_detail = Farm_details::find($id);

        if (is_null($farm_detail)) {
            return $this->sendError('The farm details does not exist.');
        }

        $farm_detail->delete();

        // Get the farm detail banner image path and delete the image from storage
        $farm_banner = $farm_detail->farm_banner; // Get the image path from the category object 
        Storage::delete($farm_banner); // Delete the image from storage 
   
        return $this->sendResponse([], 'Farm details deleted.');
    }
}
