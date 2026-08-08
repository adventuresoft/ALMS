<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Bank;
use App\Models\ClassificationInfo;
use App\Models\LoanInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassificationInfoController extends Controller
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
    public function create($id)
    {
        $data['user'] = User::with( 'institute', 'classificationInfo', 'loanInfos.branch')->find($id);
        $data['banks'] = Bank::all();
        return view('backend.pages.farmer.tabs.classification', $data);
    }

    public function addNew()
    {
        $data['banks'] = Bank::all();
        return view('backend.pages.farmer.tabs.loan_single', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banks = $request->bank;
        $branches = $request->branch;
        $loan_types = $request->loan_type;
        $amounts = $request->amount;
        $financial_years = $request->financial_year;


        DB::beginTransaction();
        try {
            ClassificationInfo::updateOrCreate(['user_id' => $request->user_id],['comments' => $request->comments]);
            LoanInfo::where('user_id', $request->user_id)->delete();
            if (!empty($banks)) {
                foreach ($banks as $key => $bank) {
                    $loan_info = new LoanInfo();
                    $loan_info->user_id = $request->user_id;
                    $loan_info->bank_id = $bank;
                    $loan_info->branch_id = $branches[$key] ?? "" ;
                    $loan_info->loan_type = $loan_types[$key] ?? "";
                    $loan_info->amount = $amounts[$key] ?? 0;
                    $loan_info->financial_year = $financial_years[$key] ?? '';
                    $loan_info->save();
                }
            }
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'Saved Successfully';
            $data['redirect_url'] = route('farmer.show', $request->user_id);
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['message'] = $th->getMessage();
            return response()->json($data, 500);
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassificationInfo  $classificationInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ClassificationInfo $classificationInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassificationInfo  $classificationInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassificationInfo $classificationInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassificationInfo  $classificationInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassificationInfo $classificationInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassificationInfo  $classificationInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassificationInfo $classificationInfo)
    {
        //
    }
}
