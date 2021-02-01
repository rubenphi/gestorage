<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use App\Models\Invitation;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = Invitation::with('company')->get();
        return $invitations;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInvitationRequest $request)
    {
        $input = $request->all();

        Invitation::create($input);
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
    public function show(Invitation $invitation)
    {
        return $invitation::with('company')->find($invitation['id']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        $input = $request->all();

        $invitation->update($input);
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
        Invitation::destroy($id);
        return response()->json([
            'res' => true,
            'message' => 'success operation'
        ],200);
    }
}
