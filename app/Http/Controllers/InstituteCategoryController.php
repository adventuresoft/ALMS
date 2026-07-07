<?php

namespace App\Http\Controllers;

use App\Models\InstituteCategory;
use Illuminate\Http\Request;

class InstituteCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('permission:institute-category-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:institute-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:institute-category-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:institute-category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.institute.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.institute.category.create');
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
     * @param  \App\Models\InstituteCategory  $instituteCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backend.pages.institute.category.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstituteCategory  $instituteCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.pages.institute.category.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstituteCategory  $instituteCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstituteCategory  $instituteCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
