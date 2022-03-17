<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
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
    public function index(Request $request) {

        $category = Category::all();

        return $this->sendResponse($category, 'All categories retrieved.');
    }

    /**
     * Store function to create a brand new category of product
     * 
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

        $uploadFolder = 'mafermelocale/images/' . date('Y') . '/' . date('m');
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        

        $input = $request->all();
        $input['image_path'] = Storage::url($image_uploaded_path);
        $category = Category::create($input);

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
}
