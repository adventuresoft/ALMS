<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;

use App\Models\BankUser;
use App\Models\LoanInfo;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Auth;

class LoanInfoController extends Controller
{
    public function __construct() {
        $this->middleware('permission:loan-all-loans-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:loan-all-loans-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:loan-all-loans-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:loan-all-loans-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Auth::user()->role_id;
        if($role==17 ){
            $bank=BankUser::where('user_id',Auth::user()->id)->first();

            $data['loans'] = LoanInfo::with('user.addressInfo', 'user.farmer', 'bank', 'branch')->where('bank_id',$bank->bank_id)->latest()->paginate(100);
        }
        elseif($role==18){
           $bank=BankUser::where('user_id',Auth::user()->id)->first();

            $data['loans'] = LoanInfo::with('user.addressInfo', 'user.farmer', 'bank', 'branch')->where('branch_id',$bank->branch_id)->latest()->paginate(100);  
        }
        else{
            if($role==13){
                $data['loans'] = LoanInfo::with('user.addressInfo', 'user.farmer', 'bank', 'branch')->where('user_id',Auth::user()->id)->latest()->paginate(100);
            }else{
            $data['loans'] = LoanInfo::with('user.addressInfo', 'user.farmer', 'bank', 'branch')->latest()->paginate(100);    
            }
            
        }
        return view('backend.pages.loan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();
        return view('backend.pages.loan.create', $data);
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
                $loan_info =  LoanInfo::find($request->id);
            } else {
                $loan_info = new LoanInfo();
                $loan_info->user_id = $request->user_id;
            }


            $loan_info->financial_year = $request->financial_year;
            $loan_info->bank_id = $request->bank;
            $loan_info->branch_id = $request->branch;
            $loan_info->loan_type = $request->loan_type;
            $loan_info->amount = $request->loan_amount;

            $loan_info->interest_rate = $request->interest_rate;
            $loan_info->total_payable = $request->total_payable;
            $loan_info->distribution_date = $request->distribution_date;
            $loan_info->ontime_payable_date = $request->ontime_payable_date;
            $loan_info->last_payable_date = $request->last_payable_date;


            $loan_info->status = $request->status;
            $loan_info->save();

            $data['loan_info'] = $loan_info;
            $data['status'] = true;
            $data['message'] = "Loan generated successfully!";
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $data['status'] = false;
            $data['message'] = "Failed to generate loan";
            $data['error'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanInfo  $loanInfo
     * @return \Illuminate\Http\Response
     */
    public function show(LoanInfo $loanInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanInfo  $loanInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanInfo $loanInfo)
    {
        $loanInfo->load('branch.bank', 'user.farmer', 'user.addressInfo');
        $data['loan'] = $loanInfo;
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();
        $data['branches'] = BankBranch::where('bank_id', $loanInfo->bank_id)->get();
        return view('backend.pages.loan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanInfo  $loanInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanInfo $loanInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanInfo  $loanInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanInfo $loanInfo)
    {
        try {
            $loanInfo->delete();
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
 /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanInfo  $loanInfo
     * @return \Illuminate\Http\Response
     */

  public function allapply()
    {
        
        $data['loan'] = '';
        $data['loanapplication']=LoanApplication::paginate(100);     
      
        return view('backend.pages.loan.allapply', $data);
        
    }

    public function apply()
    {
        
        $data['loan'] = '';
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();        
        return view('backend.pages.loan.apply', $data);
    }

    public function applystore(Request $request)
    {
    
        $infos=$request->validate([
            'bank_id'         => 'required|exists:banks,id',
            'branch_id'       => 'nullable|exists:bank_branches,id',
            'financial_year'  => 'required',
            'loan_amount'     => 'required|numeric',

            'g_name'          => 'required|string|max:191',
            'g_nid'           => 'required|string|max:100',
            'g_mobile'        => 'required|string|max:50',

            'g_father'        => 'nullable|string|max:191',
            'g_mother'        => 'nullable|string|max:191',
            'g_profession'    => 'nullable|string|max:191',

            'g_dob'           => 'nullable|date',
            'g_relation'      => 'nullable|string|max:191',
            'g_address'       => 'nullable|string|max:255',
        ]);
    try {

        $loan = LoanApplication::create([
            'bank_id'         => $request->bank_id,
            'branch_id'       => $request->branch_id,
            'financial_year'  => $request->financial_year,
            'loan_amount'     => $request->loan_amount,
            'g_name'          => $request->g_name,
            'g_nid'           => $request->g_nid,
            'g_mobile'        => $request->g_mobile,
            'g_father'        => $request->g_father,
            'g_mother'        => $request->g_mother,
            'g_profession'    => $request->g_profession,
            'g_dob'           => $request->g_dob,
            'g_relation'      => $request->g_relation,
            'g_address'       => $request->g_address,
            'created_by'      => Auth::user()->id,
            'status'          => 'pending',
        ]);

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Loan Application Submitted Successfully',
        //     'data' => $loan,
        // ]);
        return redirect()->route('loan.apply.all')
            ->with('success', 'Loan Requested Successfully');
        } catch (\Throwable $e) {
        Log::error('Admin note create failed', [
            'error'    => $e->getMessage(),
          
            'payload'  => $infos,
        ]);

        return back()->withInput()->with('error', 'Could not create the note. Please try again.');
    }
    }
    

}
