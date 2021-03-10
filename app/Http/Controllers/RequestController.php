<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Traits\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Traits::superadmin()) {
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestRequest $request)
    {
        if (Traits::empresa($request->company_id) || Traits::superadmin()) {

            $make = true;
            while ($make == true) {

                Arr::set($request, 'code', ($request['company_id'] . '-' . Str::random(6)));

                if (\App\Models\Request::where('code', $request->code)->exists()) {
                    $make = true;
                } else {
                    $make = false;
                }

            }
            $input = $request->all();
            \App\Models\Request::create($input);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Request $request)
    {
        if (Traits::empresa($request->company_id) || Traits::superadmin() ) {
            return $request::with('company')->with('status')->with('fromArea')->with('fromDepartment')->with('toArea')->with('toDepartment')->with('type')->with('user')->find($request['id']);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRequest $rqst, \App\Models\Request $request)
    {
        if (Traits::empresa($rqst->company_id) || Traits::superadmin()) {
            $input = $rqst->all();

            $request->update($input);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Traits::empresa(\App\Models\Request::find($id)->company_id) || Traits::superadmin()) {
            \App\Models\Request::destroy($id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You are not admin'
            ], 200);
        }
    }
}
