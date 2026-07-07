<?php

namespace App\Http\Controllers;

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
     * @param  \App\Models\CityCorporation  $cityCorporation
     * @return \Illuminate\Http\Response
     */
    public function show(CityCorporation $cityCorporation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CityCorporation  $cityCorporation
     * @return \Illuminate\Http\Response
     */
    public function edit(CityCorporation $cityCorporation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CityCorporation  $cityCorporation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CityCorporation $cityCorporation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CityCorporation  $cityCorporation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityCorporation $cityCorporation)
    {
        //
    }

    
}
