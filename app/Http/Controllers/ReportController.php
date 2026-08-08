<?php

namespace App\Http\Controllers;
use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use App\Models\BankSelling;
use App\Models\Farmer;
use App\Models\LoanInfo;
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
