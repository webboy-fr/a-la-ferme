<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lang as LangResource;
use App\Models\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $langs = QueryBuilder::for(Lang::with('currency'))
            ->allowedFilters('name', 'code', 'currency.name', 'currency_id')
            ->allowedSorts('name', 'code', 'currency.name')
            ->paginate(20)
            ->appends(request()->query());

        if($langs->isempty()) {
            return $this->sendError('There is no languages based on your filter.');
        }

        return $this->sendResponse(LangResource::collection($langs), 'All languages retrieved.');
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
            'langage_locale' => 'required|string|max:5',
            'date_format_lite' => 'required|',
            'date_format_full' => 'required|'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect language or missing parameters.', $validator->errors());
        }

        $input = $request->all();

        $lang = Lang::create($input);

        return $this->sendResponse($lang, 'Language created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lang = Lang::find($id);

        if (is_null($lang)) {
            return $this->sendError('The language does not exist.');
        }

        return $this->sendResponse(new LangResource($lang), 'Language retrieved.');
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
        $lang = Lang::find($id);

        if (is_null($lang)) {
            return $this->sendError('The language does not exist.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'code' => 'required',
            'currency_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect language or missing parameters.', $validator->errors());
        }

        $lang->update($input);

        return $this->sendResponse($lang, 'Language updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lang = Lang::find($id);

        if (is_null($lang)) {
            return $this->sendError('The language does not exist.');
        }

        $lang->delete();

        return $this->sendResponse([], 'Language deleted.');
    }
}
