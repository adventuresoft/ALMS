<?php

namespace App\Http\Controllers;

use App\Models\Subsidy;
use App\Models\Division;
use App\Models\SubsidyType;
use Illuminate\Http\Request;

class SubsidyController extends Controller
{
    public function __construct() {
        $this->middleware('permission:subsidy-view-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:subsidy-view-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subsidy-view-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subsidy-view-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subsidy::with([
            'user.addressInfo.presentDivision',
            'user.addressInfo.presentDistrict',
            'user.addressInfo.presentThana',
            'user.addressInfo.presentUnion',
            'user.farmer'
        ]);
    
        // 🔍 SEARCH (User name, phone, NID, Subsidy ID/Code)
        if ($request->filled('search')) {
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
                $q->where('subsidy_code', 'like', "%{$search}%") // optional field
                  ->orWhere('subsidy_id', 'like', "%{$search}%") // optional field
                  ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                           ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user.farmer', function ($q3) use ($search) {
                        $q3->where('nid', 'like', "%{$search}%");
                  });
            });
        }
    
        // 🌍 FILTERS — Division
        if ($request->filled('division_id')) {
            $query->whereHas('user.addressInfo.presentDivision', function ($q) use ($request) {
                $q->where('id', $request->division_id);
            });
        }
    
        // 🏢 District
        if ($request->filled('district_id')) {
            $query->whereHas('user.addressInfo.presentDistrict', function ($q) use ($request) {
                $q->where('id', $request->district_id);
            });
        }
    
        // 🏙️ Thana/Upazila
        if ($request->filled('thana_id')) {
            $query->whereHas('user.addressInfo.presentThana', function ($q) use ($request) {
                $q->where('id', $request->thana_id);
            });
        }
    
        // 🏘️ Union
        if ($request->filled('union_id')) {
            $query->whereHas('user.addressInfo.presentUnion', function ($q) use ($request) {
                $q->where('id', $request->union_id);
            });
        }
    
        // 📄 Pagination (same as Farmers/Loans)
        $subsidies = $query->latest()
                           ->paginate(50)
                           ->withQueryString();
        $data['subsidies'] = $subsidies;
        $data['divisions'] = Division::orderBy('name','asc')->get();
        return view('backend.pages.subsidy.index', $data);
    }

     
    // public function index()
    // {
    //     $data['subsidies'] = Subsidy::with('user.addressInfo', 'user.farmer')->latest()->paginate(100);
    //     return view('backend.pages.subsidy.index', $data);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subsidy_types'] = SubsidyType::where('status', true)->latest()->get();
        return view('backend.pages.subsidy.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            if ($request->id) {
                $subsidy =  Subsidy::find($request->id);
            } else {
                $subsidy = new Subsidy();
                $subsidy->user_id = $request->user_id;
            }

            $subsidy->financial_year = $request->financial_year;
            $subsidy->type_id = $request->type_id;
            $subsidy->amount = $request->amount;
            $subsidy->status = $request->status;
            $subsidy->save();

            $data['subsidy'] = $subsidy;
            $data['status'] = true;
            $data['message'] = "Subsidy created successfully!";
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $data['status'] = false;
            $data['message'] = "Failed to created subsidy";
            $data['error'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subsidy  $subsidy
     * @return \Illuminate\Http\Response
     */
    public function show(Subsidy $subsidy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subsidy  $subsidy
     * @return \Illuminate\Http\Response
     */
    public function edit(Subsidy $subsidy)
    {
        $subsidy->load( 'user.farmer', 'user.addressInfo');
        $data['subsidy'] = $subsidy;
        $data['subsidy_types'] = SubsidyType::where('status', true)->latest()->get();
        return view('backend.pages.subsidy.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subsidy  $subsidy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subsidy $subsidy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subsidy  $subsidy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subsidy $subsidy)
    {
         try {
            $subsidy->delete();
            $data['status'] = true;
            $data['message'] = "Deleted Successfully!";
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $data['status'] = false;
            $data['message'] = "Failed to delete";
            $data['errors'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }
}
