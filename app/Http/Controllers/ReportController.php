<?php

namespace App\Http\Controllers;
use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use App\Models\Farmer;
use App\Models\LoanInfo;
use App\Models\Subsidy;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generalReport()
    {
        $data['total_farmers'] = Farmer::count();
        $data['male_farmers'] = Farmer::where('gender',1)->count();
        $data['female_farmers'] = Farmer::where('gender',2)->count();

        $data['total_loan_received_users'] = LoanInfo::whereIn('status', ['approved', 'paid'])->count();

        $data['total_loan_received_male_users'] = LoanInfo::leftJoin('users', 'loan_infos.user_id', '=', 'users.id')
        ->rightJoin('farmers','farmers.user_id','=','users.id')
        ->whereIn('loan_infos.status', ['approved', 'paid'])
        ->where('farmers.gender', 1)
        ->count();

        $data['total_loan_received_female_users'] = LoanInfo::leftJoin('users', 'loan_infos.user_id', '=', 'users.id')
        ->rightJoin('farmers','farmers.user_id','=','users.id')
        ->whereIn('loan_infos.status', ['approved', 'paid'])
        ->where('farmers.gender', 2)
        ->count();

        $data['total_banks'] = Bank::where('status',1)->count();
        $data['total_branches'] = BankBranch::where('status',1)->count();

        $data['total_loan_amount'] = LoanInfo::whereIn('status', ['approved', 'paid'])
        ->sum('amount');

        $data['total_subsidy_amount'] = Subsidy::whereIn('status', ['approved', 'paid'])
        ->sum('amount');

        $data['total_subsidy_received_male_users'] = Subsidy::leftJoin('users', 'subsidies.user_id', '=', 'users.id')
        ->rightJoin('farmers','farmers.user_id','=','users.id')
        ->whereIn('subsidies.status', ['approved', 'paid'])
        ->where('farmers.gender', 1)
        ->sum('subsidies.amount');

        $data['total_subsidy_received_female_users'] = Subsidy::leftJoin('users', 'subsidies.user_id', '=', 'users.id')
        ->rightJoin('farmers','farmers.user_id','=','users.id')
        ->whereIn('subsidies.status', ['approved', 'paid'])
        ->where('farmers.gender', 2)
        ->sum('subsidies.amount');

        return view("backend.pages.report.general", $data);
    }

    public function loanReport(Request $request)
    {
        return view("backend.pages.report.loan");
    }

    public function paymentReport(Request $request)
    {
        return view("backend.pages.report.payment");
    }

    public function dueReport(Request $request)
    {
        return view("backend.pages.report.due");
    }

    public function subsidyReport(Request $request)
    {
        return view("backend.pages.report.subsidy");
    }
}
