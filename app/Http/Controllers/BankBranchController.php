<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankBranchController extends Controller
{
    public function __construct() {
        $this->middleware('permission:bank-branch-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:bank-branch-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:bank-branch-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bank-branch-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['bank_branches'] = BankBranch::latest()->get();
        return view('backend.pages.bank.branches.index', $data);
    }

    public function options($bank_id)
    {
        $data['branches'] = BankBranch::where('bank_id', $bank_id)->get();
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['banks'] = Bank::latest()->get();
        $data['districts'] = District::orderBy('name','asc')->get();
        return view('backend.pages.bank.branches.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bank_id' => 'required',
            'district_id' => 'required',
            'en_name' => 'required|max:190',
            'bn_name' => 'required|max:190',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        try {
            $save_data= [];
            $save_data['bank_id'] = $request->bank_id;
            $save_data['district_id'] = $request->district_id;
            $save_data['en_name'] = $request->en_name;
            $save_data['bn_name'] = $request->bn_name;

            if ($request->id) {
                $save_data['updated_by'] = Auth::user()->id;
                $bank = BankBranch::where('id', $request->id)->update( $save_data );
            } else {
                $save_data['created_by'] = Auth::user()->id;
                $bank = BankBranch::create($save_data);
            }

            $data['status'] = true;
            $data['message'] = "Bank branch information saved successfully!";
            $data['result'] = $bank;
            $data['code'] = 200;
            $data['redirect_url'] = route('bank-branch.index');
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th->getMessage();
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BankBranch $bankBranch)
    {
        $data['branch'] = $bankBranch;
        $data['banks'] = Bank::latest()->get();
        $data['districts'] = District::orderBy('name','asc')->get();
        return view('backend.pages.bank.branches.edit', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankBranch $bankBranch)
    {
        try {
            $bankBranch->delete();
            $data['status'] = true;
            $data['message'] = 'Branch deleted successfully';
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = 'Failed to delete the bank';
            $data['errors'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }
}
