<?php

namespace App\Http\Controllers\BasicSettings;

use App\Http\Controllers\Controller;
use App\Models\CityCorporation;
use Illuminate\Http\Request;

class CityCorporationController extends Controller
{
    public function __construct() {
        $this->middleware('permission:city-corporation-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:city-corporation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:city-corporation-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:city-corporation-delete', ['only' => ['destroy']]);
    }

    public function cityCorporationByDistrict(Request $request, $id)
    {
        $html = '<option value="">Select City Corporation</option>';

        $cityCorporations = CityCorporation::where('district_id', $id)->get();

        if(count($cityCorporations)) {
            foreach ($cityCorporations as $cityCorporation) {
               $html .='<option value="'.$cityCorporation->id.'">'.$cityCorporation->name.'</option>';
            }
        }

        return $html;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cityCorporations'] = CityCorporation::with('District')->latest()->paginate(20);
        return view('backend.pages.basic.citycorporation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // City corporations are preseeded static data.
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
