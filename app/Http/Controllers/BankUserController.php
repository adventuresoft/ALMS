<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\BasicSettings\Bank;
use App\Models\BankUser;   // <-- your pivot model

class BankUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bank-employee-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:bank-employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:bank-employee-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bank-employee-delete', ['only' => ['destroy', 'soft']]);
        $this->middleware('admin');
    }

    /**
     * Display a listing of bank users
     */
    public function index()
    {
        $bankUsers = BankUser::orderBy('id', 'desc')->paginate(10);
        $banks     = Bank::all();
        $people    = People::all();

        return view('backend.pages.bankuser.index', compact('bankUsers', 'banks', 'people'))
            ->with(['title' => 'Bank User', 'page' => 'bankuser']);
    }

    /**
     * Store a new bank-user mapping
     */
    public function store(Request $request)
    {
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'bank_id'   => 'required|exists:banks,id',
        ]);

        BankUser::create([
            'people_id' => $request->people_id,
            'bank_id'   => $request->bank_id,
            'branch_id'   => $request->branch_id,
        ]);

        session()->flash("success", "Information saved successfully");
        return redirect()->route('bankuser.index');
    }

    /**
     * Edit mapping
     */
    public function edit($bank_id, $user_id)
    {
        $singleBankUser = BankUser::where('bank_id', $bank_id)
            ->where('people_id', $user_id)
            ->first();

        $bankUsers = BankUser::orderBy('id', 'desc')->paginate(10);
        $banks     = Bank::all();
        $people    = People::all();

        return view('backend.pages.bankuser.index', compact('bankUsers', 'banks', 'people', 'singleBankUser'))
            ->with(['title' => 'Bank User', 'page' => 'bankuser']);
    }

    /**
     * Update mapping
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'bank_id'   => 'required|exists:banks,id',
        ]);

        $bankUser = BankUser::findOrFail($id);

        $bankUser->update([
            'people_id' => $request->people_id,
            'bank_id'   => $request->bank_id,
            'branch_id'   => $request->branch_id,
        ]);

        session()->flash("success", "Information updated successfully");
        return redirect()->route('bankuser.index');
    }

    /**
     * Soft delete mapping
     */
    public function roleusersoft(Request $request)
    {
        BankUser::where('people_id', $request->people_id)
            ->where('bank_id', $request->bank_id)
            ->delete();

        session()->flash("success", "Information deleted successfully");
        return redirect()->route('bankuser.index');
    }

    /**
     * Autocomplete: People
     */
public function autocompleteUsers(Request $request)
{
    $search = $request->get('q', '');

    $users = People::query()
        ->leftJoin('users', 'users.id', '=', 'people.user_id')
        ->where(function ($q) use ($search) {
            $q->where('users.system_id', 'like', "%{$search}%")
              ->orWhere('users.name', 'like', "%{$search}%");
        })
        ->select(
            'people.id as id',
            'users.name as name',
            'users.system_id as system_id'
        )
        ->limit(20)
        ->get();

    return response()->json($users);
}

    /**
     * Autocomplete: Banks
     */
    public function autocompleteBanks(Request $request)
    {
        $search = $request->get('q', '');

        $banks = Bank::where('en_name', 'like', "%{$search}%")
            // ->orWhere('bank_code', 'like', "%{$search}%")
            ->select('id', 'en_name as name')
            ->limit(20)
            ->get();

        return response()->json($banks);
    }
}
