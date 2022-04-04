<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = QueryBuilder::for(Product::with('category'))
            ->allowedFilters('name', 'category.name')
            ->allowedSorts('name', 'category.name')
            ->paginate(20)
            ->appends(request()->query());

        if($products->isempty()) {
            return $this->sendError('There is no products based on your filters');
        }

        return $this->sendResponse(Product::collection($products), 'All products retrieved.');
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
            'product_name' => 'required',
            'price' => 'required',
            'product_image' => 'required',
            'is_bio' => 'required',
            'is_aop' => 'required',
            'is_aoc' => 'required',
            'is_igp' => 'required',
            'is_stg' => 'required',
            'is_labelrouge' => 'required',
            'category_id' => 'required',
            'farm_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect product or missing parameters', $validator->errors());
        }

        $input = $request->all();

        $product = Product::create($input);

        return $this->sendResponse($product, 'Product created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product, 'Product retrieved successfully.');
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
        $product = Product::find($id); // Find product by id

        if (is_null($product)) {
            return $this->sendError('Product not found'); // Return error if product not found
        }

        $input = $request->all();  // Get all the request data

        $product->update($input);

        return $this->sendResponse($product, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendResponse($product, 'Product deleted successfully.');
    }
}
