<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Traits\LogedTrait;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (LogedTrait::superadmin()) {
            $types = Type::with('company')->get();
            return $types;
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
    public function store(CreateTypeRequest $request)
    {
        if (LogedTrait::admin($request->company_id) || LogedTrait::superadmin()) {
            Arr::add($request, 'companyType', ($request['company_id'] . '-' . $request['name']));
            $request->validate([
                'companyType' => ['unique:types,companyType']]);
            $input = $request->all();

            Type::create($input);
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
    public function show(Type $type)
    {
        if (LogedTrait::empresa($type->company_id) || LogedTrait::superadmin()) {
            return $type::with('company')->find($type['id']);
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
    public function update(UpdateTypeRequest $request, Type $type)
    {
        if (LogedTrait::admin($request->company_id) || LogedTrait::superadmin()) {
            Arr::add($request, 'companyType', ($request['company_id'] . '-' . $request['name']));
            $request->validate([
                'companyType' => ['unique:types,companyType' . $type->id]]);
        $input = $request->all();

        $type->update($input);
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
        if (LogedTrait::admin(Type::find($id)->company_id) || LogedTrait::superadmin()) {
        Type::destroy($id);
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

    public function showRequests(int $id)
    {
        if (LogedTrait::empresa(Type::find($id)->company_id) || LogedTrait::superadmin()) {
        $type = Type::find($id);
        return $type->requests;
        }
        else {
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }
}
