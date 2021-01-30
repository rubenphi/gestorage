<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAreaUserRequest;
use App\Http\Requests\CreateCompanyUserRequest;
use App\Http\Requests\CreateDepartmentUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteAreaUserRequest;
use App\Http\Requests\DeleteCompanyUserRequest;
use App\Http\Requests\DeleteDepartmentUserRequest;
use App\Http\Requests\UpdateAreaUserRequest;
use App\Http\Requests\UpdateCompanyUserRequest;
use App\Http\Requests\UpdateDepartmentUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //GET listar todos los usuarios
    public function index()
    {
                $users = User::all();

    return $users;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        User::create($input);
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
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->all();
        $user->update($input);
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
        User::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function showCompanies(int $id)
    {
        $user = User::findOrFail($id);
        return $user->companies;
    }

    public function addCompanies(CreateCompanyUserRequest $request)
    {

        $user = User::findOrFail($request->user_id);
        $user->companies()->syncWithoutDetaching ([$request->company_id => ['rol' => $request->rol, 'active' => $request->active, 'created_at' => date('Y-m-d H:i:s')]]);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function deleteCompanies(DeleteCompanyUserRequest $request)
    {

        $user = User::findOrFail($request->user_id);

            $user->companies()->detach($request->company_id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ],200);

    }

    public function updateCompanies(UpdateCompanyUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $exist = $user->companies()->where('company_id', $request->company_id)->exists();
        if ($exist == true) {
            $user->companies()->updateExistingPivot($request->company_id,['rol' => $request->rol, 'active' => $request->active, 'updated_at' => date('Y-m-d H:i:s')]);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ],200);
        }
        else{
            return response()->json([
                'res' => false,
                'message' => "does not exist relation"
            ],200);
        }

    }

    public function showAreas(int $id)
    {
        $user = User::findOrFail($id);
        return $user->areas;
    }

    public function addAreas(CreateAreaUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->areas()->syncWithoutDetaching([$request->area_id => ['rol' => $request->rol, 'active' => $request->active, 'created_at' => date('Y-m-d H:i:s')]]);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function deleteAreas(DeleteAreaUserRequest $request)
    {

        $user = User::findOrFail($request->user_id);
            $user->areas()->detach($request->area_id);
             return response()->json([
                'res' => true,
                'message' => 'success operation'
            ],200);



    }

    public function updateAreas(UpdateAreaUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $exist = $user->areas()->where('area_id', $request->area_id)->exists();
        if ($exist == true) {
            $user->areas()->updateExistingPivot($request->area_id,['rol' => $request->rol, 'active' => $request->active, 'updated_at' => date('Y-m-d H:i:s')]);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ],200);
        }
        else{
            return response()->json([
                'res' => false,
                'message' => "does not exist relation"
            ],200);
        }
    }

    public function showDepartments(int $id)
    {
        $user = User::findOrFail($id);
        return $user->departments;
    }

    public function addDepartments(CreateDepartmentUserRequest $request)
    {

        $user = User::findOrFail($request->user_id);
        $user->departments()->syncWithoutDetaching ([$request->department_id => ['rol' => $request->rol, 'active' => $request->active], 'created_at' => date('Y-m-d H:i:s')]);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function deleteDepartments(DeleteDepartmentUserRequest $request)
    {

        $user = User::findOrFail($request->user_id);

            $user->departments()->detach($request->department_id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ],200);

    }

    public function updateDepartments(UpdateDepartmentUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $exist = $user->departments()->where('department_id', $request->department_id)->exists();
        if ($exist == true) {
            $user->departments()->updateExistingPivot($request->department_id,['rol' => $request->rol, 'active' => $request->active, 'updated_at' => date('Y-m-d H:i:s')]);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ],200);
        }
        else{
            return response()->json([
                'res' => false,
                'message' => "does not exist relation"
            ],200);
        }
    }

    public function showRequests(int $id)
    {
        $user = User::findOrFail($id);
        return $user->requests;
    }

}
