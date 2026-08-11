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
        $user = Auth::user();

        if (is_bank_admin()) {
            $bankId = get_user_bank_id($user->id);
            if ($bankId) {
                $data['applications'] = LoanApplication::where('bank_id', $bankId)
                    ->with(['user', 'bank', 'branch'])
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            } else {
                $data['applications'] = LoanApplication::where('id', 0)->paginate(50);
            }
        } elseif ($user && in_array($user->role_id, [13, 5])) {
            $data['applications'] = LoanApplication::where('created_by', $user->id)
                ->with(['user', 'bank', 'branch'])
                ->orderBy('id', 'desc')
                ->paginate(50);
        } else {
            $data['applications'] = LoanApplication::with(['user', 'bank', 'branch'])
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        $data['mainMenu'] = 'Loan';
        $data['subMenu']  = 'LoanApply';

        return view('backend.pages.loan.allapply', $data);
    }

    // View a single application
    public function view($id)
    {
        $app = LoanApplication::with(['user', 'bank', 'branch'])->findOrFail($id);
        $user = Auth::user();

        if (is_bank_admin()) {
            $userBankId = get_user_bank_id($user->id);
            if ($app->bank_id && $app->bank_id != $userBankId) {
                abort(403, 'Unauthorized access: You cannot view loan applications for other banks.');
            }
            $data['bankinfo'] = $app->bank ?? ($userBankId ? Bank::find($userBankId) : null);
        } elseif ($user && in_array($user->role_id, [13, 5])) {
            if ($app->created_by != $user->id) {
                abort(403, 'Unauthorized access: You can only view your own loan applications.');
            }
            $data['bankinfo'] = $app->bank;
        } else {
            $data['bankinfo'] = $app->bank;
        }

        $data['banks']    = Bank::orderBy('en_name', 'asc')->get();
        $data['app']      = $app;
        $data['mainMenu'] = 'Loan';
        $data['subMenu']  = 'LoanApply';

        return view('backend.pages.loan.view', $data);
    }

    // Approve loan → move to loan_infos table
    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if ($user && in_array($user->role_id, [13, 5])) {
            return back()->with('error', 'Unauthorized access: Farmers cannot approve loan applications.');
        }

        $app = LoanApplication::findOrFail($id);

        if (is_bank_admin()) {
            $userBankId = get_user_bank_id($user->id);
            if ($app->bank_id && $app->bank_id != $userBankId) {
                return back()->with('error', 'Unauthorized: You cannot approve loan applications for other banks.');
            }
        }

        $applicantUser = User::where('system_id', $request->system_id)->first();
        if (!$applicantUser) {
            return back()->with('error', 'User not found.');
        }

        try {
            $loan = new LoanInfo();

            $loan->user_id              = $applicantUser->id;
            $loan->loan_type            = $request->loan_type;
            $loan->bank_id              = $request->bank_id ?? $app->bank_id;
            $loan->branch_id            = $request->branch_id ?? $app->branch_id;
            $loan->amount               = $request->returned_amount;
            $loan->financial_year       = $request->financial_year;
            $loan->interest_rate        = $request->interest_rate ?? 0;
            $loan->total_payable        = $request->total_payable;
            $loan->distribution_date    = $request->distribution_date;
            $loan->ontime_payable_date  = $request->ontime_payable_date;
            $loan->last_payable_date    = $request->last_payable_date;
            $loan->status               = 'approved';

            // Guarantor Information
            $loan->guarantor_name        = $app->g_name;
            $loan->guarantor_father_name = $app->g_father;
            $loan->guarantor_mother_name = $app->g_mother;
            $loan->guarantor_dob         = $app->g_dob;
            $loan->guarantor_nid         = $app->g_nid;
            $loan->guarantor_address     = $app->g_address;
            $loan->guarantor_mobile      = $app->g_mobile;

            $loan->save();

            $app->status = 'approved';
            $app->save();

            return redirect()
                ->route('loan-info.index')
                ->with('success', 'Loan Approved Successfully');
        } catch (\Throwable $e) {
            Log::error('Loan approval failed', [
                'error'   => $e->getMessage(),
                'payload' => $app,
            ]);
            return back()->with('error', 'Loan approval failed: ' . $e->getMessage());
        }
    }

    // Reject loan application
    public function reject($id)
    {
        $user = Auth::user();
        if ($user && in_array($user->role_id, [13, 5])) {
            return back()->with('error', 'Unauthorized access: Farmers cannot reject loan applications.');
        }

        $app = LoanApplication::findOrFail($id);

        if (is_bank_admin()) {
            $userBankId = get_user_bank_id($user->id);
            if ($app->bank_id && $app->bank_id != $userBankId) {
                return back()->with('error', 'Unauthorized: You cannot reject loan applications for other banks.');
            }
        }

        $app->status = 'rejected';
        $app->save();

        return redirect()->route('loan.apply.all')->with('success', 'Loan Application Rejected Successfully');
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
        $user = Auth::user();
        if ($user && in_array($user->role_id, [13, 5])) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $app = LoanApplication::findOrFail($id);
        $app->step = 1;
        $app->step_time = now();
        $app->save();

        return back()->with('success', 'Proceed Completed');
    }
}
