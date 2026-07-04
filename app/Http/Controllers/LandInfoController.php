<?php

namespace App\Http\Controllers;

use App\Models\LandInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['user'] = User::with('lands')->find($id);
        return view('backend.pages.farmer.tabs.lands', $data);
    }

     public function addNew()
    {
        $data['land'] = null;
        return view('backend.pages.farmer.tabs.land_single', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $land_types = $request->land_type;
        $land_quantities = $request->land_quantity;
        $divisions = $request->division;
        $districts = $request->district;
        $thanas = $request->thana;
        $mouzas = $request->mouza;
        $dag_nos = $request->dag_no;
        $khatiyan_no = $request->khatiyan_no;

        DB::beginTransaction();
        try {
            LandInfo::where('user_id', $request->user_id)->delete();
            if (!empty($land_types)) {
                foreach ($land_types as $key => $land_type) {
                    $land = new LandInfo();
                    $land->user_id = $request->user_id;
                    $land->land_type = $land_type;
                    $land->land_quantity = $land_quantities[$key] ?? "0.00" ;
                    $land->division = $divisions[$key] ?? '';
                    $land->district = $districts[$key] ?? '';
                    $land->thana = $thanas[$key] ?? '';
                    $land->mouza = $mouzas[$key] ?? '';
                    $land->dag_no = $dag_nos[$key] ?? '';
                    $land->khatiyan_no = $khatiyan_no[$key] ?? '';
                    $land->save();
                }
            }
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'Saved Successfully';
            $data['redirect_url'] = route('farmer.classification', $request->user_id);
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['message'] = $th->getMessage();
            return response()->json($data, 500);
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LandInfo  $landInfo
     * @return \Illuminate\Http\Response
     */
    public function show(LandInfo $landInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LandInfo  $landInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(LandInfo $landInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LandInfo  $landInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LandInfo $landInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LandInfo  $landInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LandInfo $landInfo)
    {
        //
    }
}
