<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use App\Models\LoanInfo;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanPaymentController extends Controller
{
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
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();
        return view('backend.pages.loan.payment', $data);
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
            $loan_payment = new LoanPayment();
            $loan_payment->loan_info_id = $request->loan_info_id;
            $loan_payment->date = $request->date;
            $loan_payment->amount = $request->amount;
            $loan_payment->created_by = Auth::id();
            $loan_payment->save();

            $data['status'] = true;
            $data['message'] = "Payment submitted successfully!";
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Failed to generate payment";
            $data['error'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $loanInfo = LoanInfo::with('branch.bank', 'user.farmer', 'user.addressInfo')->where('id', $id)->first();
        $data['loan'] = $loanInfo;
        $data['payments'] = LoanPayment::where('loan_info_id',$id)->get();
        $data['banks'] = Bank::orderBy('en_name', 'asc')->get();
        $data['branches'] = BankBranch::where('bank_id', $loanInfo->bank_id)->get();
        return view('backend.pages.loan.payment', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanPayment $loanPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanPayment $loanPayment)
    {
        //
    }
}
