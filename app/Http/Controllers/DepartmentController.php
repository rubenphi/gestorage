<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
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
        $departments = Department::with('company')->get();
        return $departments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        Department::create($input);
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
    public function show(Department $department)
    {
       return $department::with('company')->find($department['id']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $input = $request->all();
        $department->update($input);
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
        Department::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function  showAreas(int $id){
        $department = Department::findOrFail($id);
        return $department->areas;
    }

    public function  showUsers(int $id){
        $department = Department::findOrFail($id);
        return $department->users;
    }

    public function showOutputRequests(int $id)
    {
        $department = Department::findOrFail($id);
        return $department->fromDepartment;
    }

    public function showInputRequests(int $id)
    {
        $department = Department::findOrFail($id);
        return $department->toDepartment;
    }

}
