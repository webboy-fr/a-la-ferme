<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LangResource;
use App\Models\Lang;
use Illuminate\Http\Request;

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
            return $this->sendError('There is no languages based on your filter');
        }

        return $this->sendResponse($langs, 'All languages retrieved.');
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
            'code' => 'required',
            'currency_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect languages or missing parameters', $validator->errors());
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
            return $this->sendError('Language not found');
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
            return $this->sendError('Language not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'currency_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect languages or missing parameters', $validator->errors());
        }

        $input = $request->all();

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
            return $this->sendError('Language not found.');
        }

        $lang->delete();

        return $this->sendResponse($lang, 'Language deleted successfully.');

    }
}
