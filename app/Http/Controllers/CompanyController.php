<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Traits\LogedTrait;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (LogedTrait::superadmin()) {
            $companies = Company::all();

            return $companies;
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
    public function store(CreateCompanyRequest $request)
    {

        if (LogedTrait::loged() || LogedTrait::superadmin()) {
            $input = $request->all();

            Company::create($input);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You are not loged'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        if (LogedTrait::empresa($company) || LogedTrait::superadmin()) {
            return $company;
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
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        if (LogedTrait::admin($company) || LogedTrait::superadmin()) {
            $input = $request->all();
            $company->update($input);
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
        if (LogedTrait::admin($id) || LogedTrait::superadmin()) {
            Company::destroy($id);
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

    public function showUsers(int $id)
    {
        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
            $company = Company::findOrFail($id);
            return $company->users;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showClients(int $id)
    {
        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::findOrFail($id);
        return $company->clients;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showAreas(int $id)
    {

        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::findOrFail($id);
        return $company->areas;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showDepartments(int $id)
    {

        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::findOrFail($id);
        return $company->departments;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showTypes(int $id)
    {

        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::find($id);
        return $company->types;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showStatuses(int $id)
    {

        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::find($id);
        return $company->statuses;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showInvitations(int $id)
    {

        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::find($id);
        return $company->invitations;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }

    public function showRequests(int $id)
    {

        if (LogedTrait::empresa($id) || LogedTrait::superadmin()) {
        $company = Company::find($id);
        return $company->requests;
        }else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }
}
