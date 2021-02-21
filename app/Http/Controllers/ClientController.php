<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientCompanyRequest;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\DeleteClientCompanyRequest;
use App\Http\Requests\UpdateClientCompanyRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Traits\LogedTrait;
use App\Models\Client;
use Illuminate\Support\Arr;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with('company')->get();
        return $clients;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        Arr::add($request, 'documentInCompany', ($request['company_id'].'-'.$request['document']));
        $request->validate([
            'documentInCompany' => ['unique:clients,companyDocument']
        ]);
        $input = $request->all();

        if (LogedTrait::loged()) {
            Client::create($input);
            return response()->json([
                'res' => true,
                'message' => 'success operation'
            ], 200);
        } else {
            return response()->json([
                'res' => true,
                'message' => 'access denied'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $client::with('company')->find($client['id']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        Arr::add($request, 'documentInCompany', ($request['company_id'].'-'.$request['document']));
       $request->validate([
           'documentInCompany' => ['unique:clients,companyDocument,' . $client->id ]
       ]);
       $input = $request->all();
       $client->update($input);
        return response()->json([
            'res' => true,
            'message' => 'success operation',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ], 200);
    }



}
