<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductRessource;
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
            return $this->sendError('There is no products based on your filters.');
        }

        return $this->sendResponse(ProductRessource::collection($products), 'All products retrieved.');
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
            'product_name' => 'required|string|max:255',
            'price' => 'required',
            'product_image' => 'required|string',
            'is_bio' => 'required|boolean',
            'is_aop' => 'required|boolean',
            'is_aoc' => 'required|boolean',
            'is_igp' => 'required|boolean',
            'is_stg' => 'required|boolean',
            'is_labelrouge' => 'required|boolean',
            'category_id' => 'required|integer',
            'farm_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect product or missing parameters.', $validator->errors());
        }

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
            return $this->sendError('The product does not exist.');
        }

        return $this->sendResponse(new ProductRessource($product), 'Product retrieved.');
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
            return $this->sendError('The product does not exist.');
        }
        
        $input = $request->all();  // Get all the request data

        $validator = Validator::make($input, [
            'product_name' => 'required|string|max:255',
            'price' => 'required',
            'product_image' => 'required|string',
            'is_bio' => 'required|boolean',
            'is_aop' => 'required|boolean',
            'is_aoc' => 'required|boolean',
            'is_igp' => 'required|boolean',
            'is_stg' => 'required|boolean',
            'is_labelrouge' => 'required|boolean',
            'category_id' => 'required|integer',
            'farm_id' => 'required|integer',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Incorrect product or missing parameters.', $validator->errors());       
        }

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
            return $this->sendError('The product does not exist.');
        }

        $product->delete();

        return $this->sendResponse([], 'Product deleted.');
    }
}
