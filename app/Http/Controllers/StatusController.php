<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatusRequest;
use App\Http\Traits\LogedTrait;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (LogedTrait::superadmin()) {
            $statuses = Status::with('company')->get();
            return $statuses;
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
    public function store(CreateStatusRequest $request)
    {
        if (LogedTrait::admin($request->company_id) || LogedTrait::superadmin()) {
            Arr::add($request, 'companyStatus', ($request['company_id'] . '-' . $request['name']));
            $request->validate([
                'companyStatus' => ['unique:statuses,companyStatus']]);
            $input = $request->all();

            Status::create($input);
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        if (LogedTrait::empresa($status->company_id) || LogedTrait::superadmin()) {
            return $status::with('company')->find($status['id']);
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
    public function update(Request $request, Status $status)
    {
        if (LogedTrait::admin($request->company_id) || LogedTrait::superadmin()) {
            Arr::add($request, 'companyStatus', ($request['company_id'] . '-' . $request['name']));
            $request->validate([
                'companyStatus' => ['unique:statuses,companyStatus' . $status->id]]);
            $input = $request->all();

            $status->update($input);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (LogedTrait::admin(Status::find($id)->company_id) || LogedTrait::superadmin()) {
            Status::destroy($id);
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
