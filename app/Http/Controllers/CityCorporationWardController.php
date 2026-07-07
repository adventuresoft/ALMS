<?php

namespace App\Http\Controllers;

use App\Models\CityCorporationWard;
use Illuminate\Http\Request;

class CityCorporationWardController extends Controller
{
    public function __construct() {
        $this->middleware('permission:city-corporation-ward-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:city-corporation-ward-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:city-corporation-ward-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:city-corporation-ward-delete', ['only' => ['destroy']]);
    }

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CityCorporationWard  $cityCorporationWard
     * @return \Illuminate\Http\Response
     */
    public function show(CityCorporationWard $cityCorporationWard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CityCorporationWard  $cityCorporationWard
     * @return \Illuminate\Http\Response
     */
    public function edit(CityCorporationWard $cityCorporationWard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CityCorporationWard  $cityCorporationWard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CityCorporationWard $cityCorporationWard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CityCorporationWard  $cityCorporationWard
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityCorporationWard $cityCorporationWard)
    {
        //
    }
}
