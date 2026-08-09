<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\LoanInfo;
use App\Models\User;
use App\Models\BasicSettings\Bank;
use App\Models\BankUser;
use App\Models\BasicSettings\BankBranch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class LoanApplyController extends Controller
{
    // Show list of all loan applications
    public function allapply()
    {
          $role_id=Auth::user()->role_id;
          if($role_id==13){
              
        $data['applications'] = LoanApplication::where('created_by',Auth::user()->id)->orderBy('id','desc')->paginate(50);
          }else{
              $data['applications'] = LoanApplication::orderBy('id','desc')->paginate(50);
          }
        return view('backend.pages.loan.allapply', $data);
    }

    // View a single application
    public function view($id)
    {
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();  
        $role_id=Auth::user()->role_id;
        $user_id=Auth::user()->id;
    //    dd($role_id);
        // $user_id=6;
        // $role_id=6;
        if ($role_id == 6) {
            $people = \App\Models\People::where('user_id', $user_id)->first();
            $bankEmployee = BankUser::where('people_id', $user_id)
                ->when($people, function ($q) use ($people) {
                    return $q->orWhere('people_id', $people->id);
                })
                ->first();

            $data['bankinfo'] = ($bankEmployee && $bankEmployee->bank_id) ? Bank::find($bankEmployee->bank_id) : null;
        }
        $data['app'] = LoanApplication::findOrFail($id);
        return view('backend.pages.loan.view', $data);
    }

    // Approve loan → move to loan_infos table
    public function approve(Request $request, $id)
    {
        $app = LoanApplication::findOrFail($id);

        // Find user by system_id or dropdown
        $user = User::where('system_id', $request->system_id)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
try {

        // Create loan_info record
       $loan = new LoanInfo();

        $loan->user_id              = $user->id;
        $loan->loan_type            = $request->loan_type;
        $loan->bank_id              = $request->bank_id;
        $loan->branch_id            = $request->branch_id??null;
        $loan->amount               = $request->returned_amount;
        $loan->financial_year       = $request->financial_year;
        $loan->interest_rate        = $request->interest_rate??0;
        $loan->total_payable        = $request->total_payable;
        $loan->distribution_date    = $request->distribution_date;
        $loan->ontime_payable_date  = $request->ontime_payable_date;
        $loan->last_payable_date    = $request->last_payable_date;
        $loan->status               = 'approved';

        // Guarantor Information
        $loan->granter_name         = $app->g_name;
        $loan->granter_father_name  = $app->g_father;
        $loan->granter_mother_name  = $app->g_mother;
        $loan->granter_dob          = $app->g_dob;
        $loan->granter_nid          = $app->g_nid;
        $loan->granter_address      = $app->g_address;
        $loan->granter_mobile       = $app->g_mobile;

        $loan->save();


        // Optionally update application status
        $app->status = 'approved';
        $app->save();

        return redirect()
            ->route('loan-info.index')
            ->with('success', 'Loan Approved Successfully');

    }
             catch (\Throwable $e) {
        Log::error('Admin note create failed', [
            'error'    => $e->getMessage(),
          
            'payload'  => $app,
        ]);
    }
}

    public function getBranches($bank_id)
{
    $branches = BankBranch::where('bank_id', $bank_id)
        ->where('status', 1)
        ->select('id', 'bn_name')
        ->orderBy('bn_name', 'asc')
        ->get();

    return response()->json($branches);
}


public function proceed($id)
{
    $app = LoanApplication::findOrFail($id);
    $app->step = 1;   // <-- Update step column
    $app->step_time = now();
    $app->save();

    return back()->with('success', 'Proceed Completed');
}


}
