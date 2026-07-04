<?php

namespace App\Http\Controllers;

use App\Models\BankSelling;
use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankSellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['banks'] = Bank::where('status', true)->orderBy('en_name', 'asc')->get();
        $bank_sellings = BankSelling::with('bank')->where('financial_year', $request->year)->get();
        $data['year'] = $request->year;
        $bank_sells = [];
        if(count($bank_sellings)){
            foreach ($bank_sellings as $selling) {
                $bank_sells[$selling->bank_id] =  $selling->amount;
            }
        }
        $data['bank_sells'] = $bank_sells;
        return view('backend.pages.bank.selling', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['banks'] = Bank::latest('en_name', 'asc')->get();
        return view('backend.pages.bank.selling.create', $data);
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
            'financial_year' => 'required|integer',
            'amounts' => 'nullable'
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        DB::beginTransaction();
        try {
            BankSelling::where('financial_year', $request->financial_year)->delete();
            $amounts = $request->amounts;
            if (!empty($amounts)) {
                foreach ($amounts as $key => $value) {
                    $bank_selling = new BankSelling();
                    $bank_selling->financial_year = $request->financial_year;
                    $bank_selling->bank_id = $key;
                    $bank_selling->amount = $value ? $value : 0;
                    $bank_selling->created_by = Auth::id();
                    $bank_selling->save();
                }
            }


            $data['status'] = true;
            $data['message'] = "Bank selling information saved successfully!";
            $data['redirect_url'] = route('bank-selling.index').'?year='.$request->financial_year;
            DB::commit();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th->getMessage();
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankSelling  $bankSelling
     * @return \Illuminate\Http\Response
     */
    public function show(BankSelling $bankSelling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankSelling  $bankSelling
     * @return \Illuminate\Http\Response
     */
    public function edit(BankSelling $bankSelling)
    {
        $data['banks'] = Bank::latest('en_name', 'asc')->get();
        $data['branches'] = BankBranch::where('bank_id', $bankSelling->bank_id)->get();
        $data['bank_selling'] = $bankSelling;
        return view('backend.pages.bank.selling.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankSelling  $bankSelling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankSelling $bankSelling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankSelling  $bankSelling
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankSelling $bankSelling)
    {
        try {
            $bankSelling->delete();
            $data['status'] = true;
            $data['message'] = "Deleted successfully!";
            return response()->json($data);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Failed to delete the record!";
            $data['errors'] = $th->getMessage();
            return response()->json($data, 500);
        }

    }
}
