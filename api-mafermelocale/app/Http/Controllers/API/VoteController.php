<?php

namespace App\Http\Controllers\API;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Sanctum;
use Spatie\QueryBuilder\QueryBuilder;

class VoteController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $votes = QueryBuilder::for(Vote::class)
        ->allowedFilters('id', 'user_id', 'farm_id')
        ->allowedSorts('id', 'user_id', 'farm_id')
        ->get();

        if ($votes->isempty()) {
            return $this->sendError('There is no votes based on your filter');
        }

        return $this->sendResponse($votes, 'All votes retrieved.');
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
            'user_id' => 'required',
            'farm_id' => 'required',
            'vote' => 'required|min:1|max:5'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect vote or missing parameters', $validator->errors());
        }

        $input = $request->all();
        $vote = Vote::create($input);

        return $this->sendResponse($vote, 'Vote created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vote = Vote::find($id);

        if (is_null($vote)) {
            return $this->sendError('Vote not found');
        }

        return $this->sendResponse($vote, 'Vote retrieved successfully.');
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
        $vote = Vote::find($id);

        if (is_null($vote)) {
            return $this->sendError('Vote not found');
        }

        //if the user_id is not the same as the authenticated user, return error
        if ($vote->user_id != Auth::guard('sanctum_user')->id()) {
            return $this->sendError('You are not authorized to edit this vote');
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'farm_id' => 'required',
            'vote' => 'required|min:1|max:5'
        ]);

        if ($validator->fails()) { // if the validator fails 
            return $this->sendError('Incorrect vote or missing parameters', $validator->errors()); // return error message that role is not found 
        }

        $input = $request->all();
        
        $vote->update($input);

        return $this->sendResponse($vote, 'Vote updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vote = Vote::find($id);

        if (is_null($vote)) {
            return $this->sendError('Vote not found');
        }

        if (Auth::guard('sanctum_user')->user()->id != $id) {
            return $this->sendError('You are not allowed to delete this vote', [], 403);
        }

        $vote->delete();

        return $this->sendResponse($vote, 'Vote deleted successfully.');
    }
}
