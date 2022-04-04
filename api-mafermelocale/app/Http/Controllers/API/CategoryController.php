<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{

    /**
     * Index method, to get all the categories
     * 
     * @return JSON Return a JSON Response with all the categories
     */
    public function index() {

        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters('name')
            ->allowedSorts('name')
            ->paginate(20)
            ->appends(request()->query());

        if($categories->isempty()) {
            return $this->sendError('There is no categories based on your filter');
        }

        return $this->sendResponse($categories, 'All categories retrieved.');
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
            'description' => 'required',
            'image' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        // Get the image file from the request and store it in the storage
        $uploadFolder = 'mafermelocale/images/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        

        // Create the category and save it in the database
        $input = $request->all();
        $input['image_path'] = Storage::url($image_uploaded_path);
        $category = Category::create($input);

        // Create an array with the category and the image path
        $uploadedImageResponse = array(
            "name" => $category->name,
            "description" => $category->description,
            "image" => array(
                "image_name" => basename($image_uploaded_path),
                "image_path" => Storage::url($image_uploaded_path),
                "mime" => $image->getClientMimeType()
            )
        );

        // Return the response with the category created and the image path in the response body
        return $this->sendResponse($uploadedImageResponse, 200);
    }

    /**
     * Show method, to get a specific user
     * 
     * @return JSON The specific user in JSON format
     */
    public function show($id) {

        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('The category does not exist.');
        }

        return $this->sendResponse(CategoryCollection::collection($category), 'Category retrieved');
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
            'description' => 'required',
            'image' => 'image:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('The category does not exist.');
        }

        //get the category image path and delete the image from storage
        $image_path = $category->image_path; // get the image path from the category object 
        Storage::delete($image_path); // delete the image from storage 

        // upload the new image 
        $uploadFolder = 'mafermelocale/images/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        /**
         * Update the category object with the new image path
         */
        $input = $request->all();
        $input['image_path'] = Storage::url($image_uploaded_path);
        $category->update($input);

        $uploadedImageResponse = array(
            "name" => $category->name,
            "description" => $category->description,
            "image" => array(
                "image_name" => basename($image_uploaded_path),
                "image_path" => Storage::url($image_uploaded_path),
                "mime" => $image->getClientMimeType()
            )
        );

        return $this->sendResponse($uploadedImageResponse, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('The category does not exist.');
        }

        //get the category image path and delete the image from storage
        $image_path = $category->image_path; // get the image path from the category object 
        Storage::delete($image_path); // delete the image from storage 

        $category->delete();

        return $this->sendResponse($category, 'Category deleted');
    }
}
