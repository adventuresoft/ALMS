<?php

namespace App\Http\Controllers;
use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use App\Models\BankSelling;
use App\Models\Farmer;
use App\Models\LoanInfo;
use App\Models\LoanPayment;
use App\Models\Subsidy;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generalReport()
    {
        $data['total_farmers'] = Farmer::count();
        $data['male_farmers'] = Farmer::where('gender', 1)->count();
        $data['female_farmers'] = Farmer::where('gender', 2)->count();

        $data['total_loan_received_users'] = LoanInfo::whereNotNull('user_id')->distinct('user_id')->count('user_id');

        $data['total_loan_received_male_users'] = LoanInfo::join('farmers', 'farmers.user_id', '=', 'loan_infos.user_id')
            ->where('farmers.gender', 1)
            ->distinct('loan_infos.user_id')
            ->count('loan_infos.user_id');

        $data['total_loan_received_female_users'] = LoanInfo::join('farmers', 'farmers.user_id', '=', 'loan_infos.user_id')
            ->where('farmers.gender', 2)
            ->distinct('loan_infos.user_id')
            ->count('loan_infos.user_id');

        $data['total_banks'] = Bank::count();
        $data['total_distributable_loan_amount'] = BankSelling::sum('amount');
        $data['total_distributed_loan_amount'] = LoanInfo::sum('amount');
        $data['remaining_distributable_loan_amount'] = max(0, $data['total_distributable_loan_amount'] - $data['total_distributed_loan_amount']);

        $data['total_subsidy_amount'] = Subsidy::sum('amount');

        $data['total_subsidy_received_male_users'] = Subsidy::join('farmers', 'farmers.user_id', '=', 'subsidies.user_id')
            ->where('farmers.gender', 1)
            ->sum('subsidies.amount');

        $data['total_subsidy_received_female_users'] = Subsidy::join('farmers', 'farmers.user_id', '=', 'subsidies.user_id')
            ->where('farmers.gender', 2)
            ->sum('subsidies.amount');

        return view("backend.pages.report.general", $data);
    }

    public function loanReport(Request $request)
    {
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();

        $query = LoanInfo::with(['user.addressInfo', 'user.farmer', 'bank', 'branch'])
            ->latest();

        if ($request->filled('financial_year')) {
            $query->where('financial_year', $request->financial_year);
        }

        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $data['loans'] = $query->paginate(50)->withQueryString();

        return view("backend.pages.report.loan", $data);
    }

    public function paymentReport(Request $request)
    {
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();

        $query = LoanPayment::with(['loanInfo.user.addressInfo', 'loanInfo.user.farmer', 'loanInfo.bank', 'loanInfo.branch'])
            ->latest();

        if ($request->filled('financial_year') || $request->filled('bank_id') || $request->filled('branch_id')) {
            $query->whereHas('loanInfo', function($q) use ($request) {
                if ($request->filled('financial_year')) {
                    $q->where('financial_year', $request->financial_year);
                }
                if ($request->filled('bank_id')) {
                    $q->where('bank_id', $request->bank_id);
                }
                if ($request->filled('branch_id')) {
                    $q->where('branch_id', $request->branch_id);
                }
            });
        }

        $data['payments'] = $query->paginate(50)->withQueryString();

        return view("backend.pages.report.payment", $data);
    }

    public function dueReport(Request $request)
    {
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();

        $query = LoanInfo::with(['user.addressInfo', 'user.farmer', 'bank', 'branch', 'payments'])
            ->latest();

        if ($request->filled('financial_year')) {
            $query->where('financial_year', $request->financial_year);
        }

        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $data['loans'] = $query->paginate(50)->withQueryString();

        return view("backend.pages.report.due", $data);
    }

    public function subsidyReport(Request $request)
    {
        return view("backend.pages.report.subsidy");
    }
}
