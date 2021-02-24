<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Traits\LogedTrait;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (LogedTrait::superadmin()) {
            $departments = Department::with('company')->get();
            return $departments;
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
    public function store(CreateDepartmentRequest $request)
    {
        if (LogedTrait::admin($request->company_id) || LogedTrait::superadmin()) {
            $input = $request->all();

            Department::create($input);
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
    public function show(Department $department)
    {
        if (LogedTrait::empresa($department->company_id) || LogedTrait::superadmin()) {
            return $department::with('company')->find($department['id']);
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
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        if (LogedTrait::admin($request->company_id) || LogedTrait::superadmin()) {
            $input = $request->all();
            $department->update($input);
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

        if (LogedTrait::admin(Department::find($id)->company_id) || LogedTrait::superadmin()) {
            Department::destroy($id);
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

    public function showAreas(int $id)
    {
        $department = Department::findOrFail($id);
        if (LogedTrait::empresa($department->company_id) || LogedTrait::superadmin()) {
            return $department->areas;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showUsers(int $id)
    {
        $department = Department::findOrFail($id);
        if (LogedTrait::empresa($department->company_id) || LogedTrait::superadmin()) {
            return $department->users;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showOutputRequests(int $id)
    {
        $department = Department::findOrFail($id);
        if (LogedTrait::empresa($department->company_id) || LogedTrait::superadmin()) {
            return $department->fromDepartment;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showInputRequests(int $id)
    {
        $department = Department::findOrFail($id);
        if (LogedTrait::empresa($department->company_id) || LogedTrait::superadmin()) {
            return $department->toDepartment;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

}
