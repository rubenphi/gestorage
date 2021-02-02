<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientCompanyRequest;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\DeleteClientCompanyRequest;
use App\Http\Requests\UpdateClientCompanyRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return $clients;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        $input = $request->all();

        Client::create($input);
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
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $input = $request->all();
        $client->update($input);
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
        Client::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function showCompanies(int $id)
    {
        $client = Client::findOrFail($id);
        return $client->companies;
    }

    public function addCompanies(CreateClientCompanyRequest $request)
    {

        $client = Client::findOrFail($request->client_id);
        $client->companies()->syncWithoutDetaching ([$request->company_id => ['email' => $request->email,'address' => $request->address, 'active' => $request->active, 'created_at' => date('Y-m-d H:i:s')]]);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }

    public function deleteCompanies(DeleteClientCompanyRequest $request)
    {

        $client = Client::findOrFail($request->client_id);

        $client->companies()->detach($request->company_id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);

    }

    public function updateCompanies(UpdateClientCompanyRequest $request)
    {
        $client = Client::findOrFail($request->client_id);
        $exist = $client->companies()->where('company_id', $request->company_id)->exists();
        if ($exist == true) {
            $client->companies()->updateExistingPivot($request->company_id,['email' => $request->email,'address' => $request->address, 'active' => $request->active, 'created_at' => date('Y-m-d H:i:s')]);
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
}
