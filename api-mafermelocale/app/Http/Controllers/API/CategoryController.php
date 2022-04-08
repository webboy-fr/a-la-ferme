<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

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
            return $this->sendError('There is no categories based on your filter.');
        }

        return $this->sendResponse(CategoryResource::collection($categories), 'All categories retrieved.');
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
            'category_image' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect category or missing parameters.', $validator->errors());
        }

        // Get the image file from the request and store it in the storage
        $uploadFolder = 'mafermelocale/images/categories/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        
        // Create the category and save it in the database
        $input = $request->all();
        $input['category_image'] = Storage::url($image_uploaded_path);

        $category = Category::create($input);

        return $this->sendResponse($category, 'Categroy created successfully.', 201);
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

        return $this->sendResponse(new CategoryResource($category), 'Category retrieved.');
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
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('The category does not exist.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'category_image' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect category or missing parameters.', $validator->errors());
        }

        // Get the category image path and delete the image from storage
        $category_image = $category->category_image; // get the image path from the category object 
        Storage::delete($category_image); // delete the image from storage 

        // upload the new image 
        $uploadFolder = 'mafermelocale/images/categories/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        /**
         * Update the category object with the new image path
         */
        $input['category_image'] = Storage::url($image_uploaded_path);

        $category->update($input);

        return $this->sendResponse($category, 'Address updated successfully.');
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

        // Get the category image path and delete the image from storage
        $category_image = $category->category_image; // Get the image path from the category object 
        Storage::delete($category_image); // Delete the image from storage 

        $category->delete();

        return $this->sendResponse([], 'Category deleted.');
    }
}
