<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
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
        $companies = Company::all();

        return $companies;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanyRequest $request)
    {
        $input = $request->all();

        Company::create($input);
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
    public function show(Company $company)
    {
        return $company;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $input = $request->all();
        $company->update($input);
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
        Company::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function  showUsers(int $id){
        $company = Company::findOrFail($id);
        return $company->users;
    }
    public function  showClients(int $id){
        $company = Company::findOrFail($id);
        return $company->clients;
    }
    public function  showAreas(int $id){
        $company = Company::findOrFail($id);
        return $company->areas;
    }
    public function  showDepartments(int $id){
        $company = Company::findOrFail($id);
        return $company->departments;
    }
    public function  showTypes(int $id){
        $company = Company::find($id);
        return $company->types;
    }
    public function  showStatuses(int $id){
        $company = Company::find($id);
        return $company->statuses;
    }
    public function  showInvitations(int $id){
        $company = Company::find($id);
        return $company->invitations;
    }
    public function  showRequests(int $id){
        $company = Company::find($id);
        return $company->resquests;
    }
}
