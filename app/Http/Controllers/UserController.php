<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateAreaUserRequest;
use App\Http\Requests\CreateCompanyUserRequest;
use App\Http\Requests\CreateDepartmentUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteAreaUserRequest;
use App\Http\Requests\DeleteCompanyUserRequest;
use App\Http\Requests\DeleteDepartmentUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateAreaUserRequest;
use App\Http\Requests\UpdateCompanyUserRequest;
use App\Http\Requests\UpdateDepartmentUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Area;
use App\Models\Department;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\Traits;

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
        if (Traits::superadmin()) {

            $users = User::all();
            return $users;

        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }


    }

    public function logeduser(\Illuminate\Http\Request $request)
    {
        return Traits::loged();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        Arr::set($request, 'superadmin', false);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        User::create($input);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('contactos')->accessToken;
            $user->save();
            return response()->json([
                'res' => true,
                'token' => $token,
                'message' => "success login"
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => "login fail"
            ], 200);
        }
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $user->token()->revoke();
        return response()->json([
            'res' => true,
            'message' => 'Logout success'
        ], 200);
    }

    public function logoutAll()
    {

        $user = auth()->user();
        $user->tokens->each(function ($token, $key) {
            $token->revoke();
        });
        $user->save();

        return response()->json([
            'res' => true,
            'message' => 'Logout success on all services'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (Traits::coworker($user)) {
            return $user;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
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
    public function update(UpdateUserRequest $request, User $user)
    {
        if (Traits::mismo($user->id)) {
            $input = $request->all();
            $input['password'] = Hash::make($request->password);
            $user->update($input);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
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
        if (Traits::superadmin()) {
            User::destroy($id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function showCompanies(int $id)
    {
        if (Traits::mismo($id)) {
            $user = User::findOrFail($id);
            return $user->companies;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function addCompanies(CreateCompanyUserRequest $request)
    {
        if (Traits::mismo($request->user_id) && Traits::invitation($request->code, $request->company_id) || Traits::admin($request->company_id) || Traits::superadmin()) {
            if (Traits::admin($request->company_id) == false && Traits::superadmin() == false) {
                Arr::set($request, 'rol', 'user');
            }
            Arr::set($request, 'companyUser', ($request->company_id . '-' . $request->user_id));
            $request->validate([
                'companyUser' => ['unique:company_user,companyUser']
            ]);
            $user = User::findOrFail($request->user_id);
            $user->companies()->syncWithoutDetaching([$request->company_id => ['rol' => $request->rol, 'active' => $request->active, 'companyUser' => $request->companyUser, 'created_at' => date('Y-m-d H:i:s')]]);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function deleteCompanies(DeleteCompanyUserRequest $request)
    {
        if (Traits::superadmin($request->company_id) || Traits::superadmin() || Traits::mismo($request->user_id)) {
            $user = User::findOrFail($request->user_id);

            $user->companies()->detach($request->company_id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }

    }

    public function updateCompanies(UpdateCompanyUserRequest $request)
    {
        if (Traits::superadmin($request->company_id) || Traits::superadmin() || Traits::mismo($request->user_id)) {
            if (Traits::admin($request->company_id) == false && Traits::superadmin() == false) {
                Arr::set($request, 'rol', 'user');
            }
            $user = User::findOrFail($request->user_id);
            $exist = $user->companies()->where('company_id', $request->company_id)->exists();
            Arr::add($request, 'companyUser', ($request->company_id . '-' . $request->user_id));
            $request->validate([
                'companyUser' => ['unique:company_user,companyUser,' . $user->companies()->where('company_id', $request->company_id)->first()->pivot->id]
            ]);

            if ($exist == true) {
                $user->companies()->updateExistingPivot($request->company_id, ['rol' => $request->rol, 'active' => $request->active, 'companyUser' => $request->companyUser, 'updated_at' => date('Y-m-d H:i:s')]);
                return response()->json([
                    'res' => true,
                    'message' => 'success operation',
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => "does not exist relation"
                ], 200);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }


    }

    public function showAreas(int $id)
    {
        if (Traits::mismo($id)) {
            $user = User::findOrFail($id);
            return $user->areas;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function addAreas(CreateAreaUserRequest $request)
    {
        if (Traits::admin(Area::findOrFail($request->area_id)->company_id) || Traits::superadmin()) {
            Arr::add($request, 'areaUser', ($request->area_id . '-' . $request->user_id));
            $request->validate([
                'areaUser' => ['unique:area_user,areaUser']
            ]);
            $user = User::findOrFail($request->user_id);
            $user->areas()->syncWithoutDetaching([$request->area_id => ['rol' => $request->rol, 'active' => $request->active, 'areaUser' => $request->areaUser, 'created_at' => date('Y-m-d H:i:s')]]);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }


    }

    public function deleteAreas(DeleteAreaUserRequest $request)
    {
        if (Traits::admin(Area::findOrFail($request->area_id)->company_id) || Traits::superadmin()) {
            $user = User::findOrFail($request->user_id);
            $user->areas()->detach($request->area_id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }


    }

    public function updateAreas(UpdateAreaUserRequest $request)
    {
        if (Traits::admin(Area::findOrFail($request->area_id)->company_id) || Traits::superadmin()) {
            $user = User::findOrFail($request->user_id);
            $exist = $user->areas()->where('area_id', $request->area_id)->exists();

            Arr::add($request, 'areaUser', ($request->area_id . '-' . $request->user_id));
            $request->validate([
                'areaUser' => ['unique:area_user,areaUser,' . $user->areas()->where('area_id', $request->area_id)->first()->pivot->id]
            ]);

            if ($exist == true) {
                $user->areas()->updateExistingPivot($request->area_id, ['rol' => $request->rol, 'active' => $request->active, 'areaUser' => $request->areaUser, 'updated_at' => date('Y-m-d H:i:s')]);
                return response()->json([
                    'res' => true,
                    'message' => 'success operation'
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => "does not exist relation"
                ], 200);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function showDepartments(int $id)
    {
        if (Traits::mismo($id)) {
            $user = User::findOrFail($id);
            return $user->departments;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function addDepartments(CreateDepartmentUserRequest $request)
    {
        if (Traits::admin(Department::findOrFail($request->department_id)->company_id) || Traits::superadmin()) {
            Arr::add($request, 'departmentUser', ($request->department_id . '-' . $request->user_id));
            $request->validate([
                'departmentUser' => ['unique:department_user,departmentUser']
            ]);
            $user = User::findOrFail($request->user_id);
            $user->departments()->syncWithoutDetaching([$request->department_id => ['rol' => $request->rol, 'active' => $request->active, 'departmentUser' => $request->departmentUser, 'created_at' => date('Y-m-d H:i:s')]]);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function deleteDepartments(DeleteDepartmentUserRequest $request)
    {
        if (Traits::admin(Department::findOrFail($request->department_id)->company_id) || Traits::superadmin()) {
            $user = User::findOrFail($request->user_id);

            $user->departments()->detach($request->department_id);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }

    }

    public function updateDepartments(UpdateDepartmentUserRequest $request)
    {
        if (Traits::admin(Department::findOrFail($request->department_id)->company_id) || Traits::superadmin()) {
            $user = User::findOrFail($request->user_id);
            $exist = $user->departments()->where('department_id', $request->department_id)->exists();

            Arr::add($request, 'departmentUser', ($request->area_id . '-' . $request->user_id));
            $request->validate([
                'departmentUser' => ['unique:department_user,departmentUser,' . $user->departments()->where('department_id', $request->department_id)->first()->pivot->id]
            ]);

            if ($exist == true) {
                $user->departments()->updateExistingPivot($request->department_id, ['rol' => $request->rol, 'active' => $request->active, 'departmentUser' => $request->departmentUser, 'updated_at' => date('Y-m-d H:i:s')]);
                return response()->json([
                    'res' => true,
                    'message' => 'success operation'
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => "does not exist relation"
                ], 200);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }

    public function showRequests(int $id)
    {
        if (Traits::mismo($id)) {
            $user = User::findOrFail($id);
            return $user->requests;
        } else {
            return response()->json([
                'res' => false,
                'message' => 'access denied'
            ], 200);
        }
    }


}
