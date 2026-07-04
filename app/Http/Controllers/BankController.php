<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['banks'] = Bank::latest()->get();
        return view("backend.pages.bank.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.pages.bank.create");
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
            $save_data['en_name'] = $request->en_name;
            $save_data['bn_name'] = $request->bn_name;

            if ($request->id) {
                $save_data['updated_by'] = Auth::user()->id;
                $bank = Bank::where('id', $request->id)->update( $save_data );
            } else {
                $save_data['created_by'] = Auth::user()->id;
                $bank = Bank::create($save_data);
            }

            $data['status'] = true;
            $data['message'] = "Bank information saved successfully!";
            $data['result'] = $bank;
            $data['code'] = 200;
            $data['redirect_url'] = route('bank.index');
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
     * @param  \App\Models\BasicSettings\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BasicSettings\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        $data['bank'] = $bank;
        return view('backend.pages.bank.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BasicSettings\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BasicSettings\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        try {
            $bank->delete();
            $data['status'] = true;
            $data['message'] = 'Bank deleted successfully';
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = 'Failed to delete the bank';
            $data['errors'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }
}
