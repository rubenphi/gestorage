<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientCompanyRequest;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\DeleteClientCompanyRequest;
use App\Http\Requests\UpdateClientCompanyRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Traits\Traits;
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
        if (Traits::superadmin() == true) {
            $clients = Client::with('company')->get();
            return $clients;
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
    public function store(CreateClientRequest $request)
    {
        Arr::add($request, 'companyDocument', ($request['company_id'] . '-' . $request['document']));
        $request->validate([
            'companyDocument' => ['unique:clients,companyDocument']
        ]);
        $input = $request->all();

        if (Traits::empresa($request->company_id) || Traits::superadmin()) {
            Client::create($input);
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
    public function show(Client $client)
    {
        if (Traits::empresa($client['company_id']) || Traits::superadmin()) {
            return $client::with('company')->find($client['id']);
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
    public function update(UpdateClientRequest $request, Client $client)
    {
        if (Traits::empresa($request->company_id) || Traits::admin()) {
            Arr::add($request, 'companyDocument', ($request['company_id'] . '-' . $request['document']));
            $request->validate([
                'companyDocument' => ['unique:clients,companyDocument,' . $client->id]
            ]);
            $input = $request->all();
            $client->update($input);
            return response()->json([
                'res' => true,
                'message' => 'success operation',
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
        if (Traits::admin(Client::find($id)->company_id) || Traits::superadmin()) {
            Client::destroy($id);
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
