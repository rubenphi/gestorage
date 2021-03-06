<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use App\Http\Traits\Traits;
use App\Models\Invitation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Traits::superadmin()) {
            $invitations = Invitation::with('company')->get();
            return $invitations;
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
    public function store(CreateInvitationRequest $request)
    {

        if (Traits::empresa($request->company_id) || Traits::superadmin()) {
            $make = true;
            while ($make == true) {
                Arr::set($request, 'code', Str::random(6));
                Arr::set($request, 'companyInvitation', ($request['company_id'] . '-' . $request['code']));

                if (Invitation::where('companyInvitation', $request->companyInvitation)->exists()) {
                    $make = true;
                } else {
                    $make = false;
                }

            }
            $request->validate([
                'companyInvitation' => ['unique:invitations,companyInvitation']
            ]);
            $input = $request->all();

            Invitation::create($input);
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
    public function show(Invitation $invitation)
    {
        if (Traits::admin($invitation->company_id) || Traits::superadmin()) {
            return $invitation::with('company')->find($invitation['id']);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'You are not admin'
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
    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        if (Traits::admin($invitation->company_id) || Traits::superadmin()) {
            Arr::set($request, 'companyInvitation', ($request['company_id'] . '-' . $request['code']));
            $request->validate([
                'companyInvitation' => ['unique:invitations,companyInvitation,' . $invitation->id]
            ]);
            $input = $request->all();

            $invitation->update($input);
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
        if (Traits::admin(Invitation::find($id)->company_id) || Traits::superadmin()) {
            Invitation::destroy($id);
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
