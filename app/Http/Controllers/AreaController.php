<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Models\Area;
use \App\Http\Traits\LogedTrait;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::with('company')->with('department')->get();

        return $areas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAreaRequest $request)
    {

        if (LogedTrait::admin($request['company_id']) ==  true) {
            $input = $request->all();
            Area::create($input);
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
    public function show(Area $area)
    {

        if (LogedTrait::empresa($area['company_id'])){
            return $area::with('company')->with('department')->find($area['id']);
        }
        else{
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
    public function update(UpdateAreaRequest $request, Area $area)
    {
        if (LogedTrait::admin($request['company_id']) ==  true) {
            $input = $request->all();
            $area->update($input);
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
        if (LogedTrait::admin($id) ==  true) {
            Area::destroy($id);
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
        $area = Area::findOrFail($id);

        if (LogedTrait::empresa($area['company_id'])){
            return $area->users;
        }
        else{
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }

    }

    public function showOutputRequests(int $id)
    {
        $area = Area::findOrFail($id);
        if (LogedTrait::empresa($area['company_id'])){
            return $area->fromArea;
        }
        else{
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }

    }

    public function showInputRequests(int $id)
    {
        $area = Area::findOrFail($id);
        if (LogedTrait::empresa($area['company_id'])){
            return $area->toArea;
        }
        else{
            return response()->json([
                'res' => false,
                'message' => 'You do not have access to the data of that company'
            ], 200);
        }
    }
}
