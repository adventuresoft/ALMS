<?php

namespace App\Http\Controllers;

use App\Models\ClassificationInfo;
use App\Models\Crop;
use App\Models\CultivationInfo;
use App\Models\Division;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CultivationInfoController extends Controller
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
        $data['user'] = User::with('cultivations', 'classificationInfo')->find($id);
        $data['crops'] = Crop::where('status', true)->get();
        return view('backend.pages.farmer.tabs.cultivation', $data);
    }

    public function addNew()
    {
        $data['crops'] = Crop::where('status', true)->get();
        $data['cultivation'] = null;
        return view('backend.pages.farmer.tabs.cultivation_single', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $crops = $request->crop;
        $land_owners = $request->land_owner;
        $quantities = $request->quantity;
        $addresses = $request->address;
        $descriptions = $request->description;


        DB::beginTransaction();
        try {
            Farmer::updateOrCreate(['user_id' => $request->user_id],['is_agriculture_card' => $request->is_agriculture_card, 'agriculture_card_number' => $request->agriculture_card_number]);
            CultivationInfo::where('user_id', $request->user_id)->delete();
            if (!empty($crops)) {
                foreach ($crops as $key => $crop) {
                    $cultivation = new CultivationInfo();
                    $cultivation->user_id = $request->user_id;
                    $cultivation->crop = $crop;
                    $cultivation->land_owner = $land_owners[$key] ?? "own" ;
                    $cultivation->quantity = $quantities[$key] ?? '';
                    $cultivation->address = $addresses[$key] ?? '';
                    $cultivation->description = $descriptions[$key] ?? '';
                    $cultivation->save();
                }
            }
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'Saved Successfully';
            $data['redirect_url'] = route('farmer.land', $request->user_id);
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
     * @param  \App\Models\CultivationInfo  $cultivationInfo
     * @return \Illuminate\Http\Response
     */
    public function show(CultivationInfo $cultivationInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CultivationInfo  $cultivationInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(CultivationInfo $cultivationInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CultivationInfo  $cultivationInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CultivationInfo $cultivationInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CultivationInfo  $cultivationInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CultivationInfo $cultivationInfo)
    {
        //
    }
}
