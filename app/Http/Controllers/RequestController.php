<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Traits\Traits;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Traits::superadmin()){
        $requests = \App\Models\Request::with('company')->with('status')->with('fromArea')->with('fromDepartment')->with('toArea')->with('toDepartment')->with('type')->with('user')->get();;

        return $requests;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestRequest $request)
    {
        $input = $request->all();

        \App\Models\Request::create($input);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Request $request)
    {
        return $request::with('company')->with('status')->with('fromArea')->with('fromDepartment')->with('toArea')->with('toDepartment')->with('type')->with('user')->find($request['id']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRequest $rqst, \App\Models\Request $request)
    {
        $input = $rqst->all();

        $request->update($input);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Models\Request::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }
}
