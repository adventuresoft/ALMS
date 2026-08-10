<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\People;
use App\Models\BankUser;
use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BankAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of Bank Admins
     */
    public function index(Request $request)
    {
        // Find or create 'Bank Admin' role
        $bankAdminRole = Role::firstOrCreate(['name' => 'Bank Admin', 'guard_name' => 'web']);
        $bankAdminRoleId = 17; // Default Bank Admin role ID

        $search = $request->get('q', '');

        $bankAdminsQuery = User::where(function ($q) use ($bankAdminRoleId) {
            $q->where('role_id', $bankAdminRoleId)
              ->orWhereHas('roles', function ($rq) {
                  $rq->where('name', 'Bank Admin');
              });
        })->with(['bankUser.bank', 'bankUser.branch']);

        if (!empty($search)) {
            $bankAdminsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('system_id', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $bankAdmins = $bankAdminsQuery->orderBy('id', 'desc')->paginate(15);
        $banks = Bank::orderBy('en_name', 'asc')->get();

        return view('backend.pages.bank_admin.index', compact('bankAdmins', 'banks', 'search'))
            ->with(['title' => 'Bank Admin Management', 'page' => 'bank_admin']);
    }

    /**
     * Store a new Bank Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:190',
            'email'     => 'required|email|max:190|unique:users,email',
            'mobile'    => 'required|string|max:50|unique:users,mobile',
            'bank_id'   => 'required|exists:banks,id',
            'branch_id' => 'nullable|exists:bank_branches,id',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Generate System ID
            $systemId = 'BA' . date('Ymd') . rand(1000, 9999);
            while (User::where('system_id', $systemId)->exists()) {
                $systemId = 'BA' . date('Ymd') . rand(1000, 9999);
            }

            $user = new User();
            $user->name        = $request->name;
            $user->email       = $request->email;
            $user->mobile      = $request->mobile;
            $user->system_id   = $systemId;
            $user->password    = Hash::make($request->password);
            $user->role_id     = 17; // Bank Admin role ID
            $user->status      = 1;
            $user->is_verified = 1;
            $user->created_by  = Auth::id();
            $user->save();

            // Assign Spatie Role
            $role = Role::firstOrCreate(['name' => 'Bank Admin', 'guard_name' => 'web']);
            $user->assignRole($role->name);

            // Create People record for compatibility
            $people = People::where('user_id', $user->id)->first();
            if (!$people) {
                $people = new People();
                $maxPeopleId = People::max('id') ?? 0;
                $people->id = $maxPeopleId + 1;
                $people->user_id = $user->id;
                $people->bn_name = $user->name;
                $people->name    = $user->name;
                $people->email   = $user->email;
                $people->mobile  = $user->mobile;
                $people->status  = 1;
                $people->created_by = Auth::id();
                $people->save();
            }

            // Create BankUser mapping
            $bankUser = BankUser::where('user_id', $user->id)->first();
            if (!$bankUser) {
                $bankUser = new BankUser();
                $maxBankUserId = BankUser::max('id') ?? 0;
                $bankUser->id = $maxBankUserId + 1;
                $bankUser->people_id = $people->id;
                $bankUser->user_id   = $user->id;
                $bankUser->bank_id   = $request->bank_id;
                $bankUser->branch_id = $request->branch_id;
                $bankUser->status    = 1;
                $bankUser->save();
            }

            DB::commit();
            session()->flash("success", "Bank Admin created successfully with System ID: {$systemId}");
            return redirect()->route('bank-admin.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create Bank Admin: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form for Bank Admin
     */
    public function edit($id)
    {
        $singleBankAdmin = User::with(['bankUser'])->findOrFail($id);
        $bankAdmins = User::where('role_id', 17)
            ->orWhereHas('roles', fn($q) => $q->where('name', 'Bank Admin'))
            ->with(['bankUser.bank', 'bankUser.branch'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        $banks = Bank::orderBy('en_name', 'asc')->get();
        $branches = $singleBankAdmin->bankUser?->bank_id 
            ? BankBranch::where('bank_id', $singleBankAdmin->bankUser->bank_id)->get() 
            : collect();

        return view('backend.pages.bank_admin.index', compact('bankAdmins', 'banks', 'branches', 'singleBankAdmin'))
            ->with(['title' => 'Edit Bank Admin', 'page' => 'bank_admin']);
    }

    /**
     * Update Bank Admin
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:190',
            'email'     => 'required|email|max:190|unique:users,email,' . $id,
            'mobile'    => 'required|string|max:50|unique:users,mobile,' . $id,
            'bank_id'   => 'required|exists:banks,id',
            'branch_id' => 'nullable|exists:bank_branches,id',
            'password'  => 'nullable|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user->name   = $request->name;
            $user->email  = $request->email;
            $user->mobile = $request->mobile;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update associated People record
            $people = People::where('user_id', $user->id)->first();
            if ($people) {
                $people->bn_name = $user->name;
                $people->name    = $user->name;
                $people->email   = $user->email;
                $people->mobile  = $user->mobile;
                $people->save();
            } else {
                $people = new People();
                $maxPeopleId = People::max('id') ?? 0;
                $people->id = $maxPeopleId + 1;
                $people->user_id = $user->id;
                $people->bn_name = $user->name;
                $people->name    = $user->name;
                $people->email   = $user->email;
                $people->mobile  = $user->mobile;
                $people->status  = 1;
                $people->created_by = Auth::id();
                $people->save();
            }

            // Update BankUser mapping
            $bankUser = BankUser::where('user_id', $user->id)
                ->orWhere('people_id', $people->id)
                ->first();

            if ($bankUser) {
                $bankUser->people_id = $people->id;
                $bankUser->user_id   = $user->id;
                $bankUser->bank_id   = $request->bank_id;
                $bankUser->branch_id = $request->branch_id;
                $bankUser->save();
            } else {
                $bankUser = new BankUser();
                $maxBankUserId = BankUser::max('id') ?? 0;
                $bankUser->id = $maxBankUserId + 1;
                $bankUser->people_id = $people->id;
                $bankUser->user_id   = $user->id;
                $bankUser->bank_id   = $request->bank_id;
                $bankUser->branch_id = $request->branch_id;
                $bankUser->status    = 1;
                $bankUser->save();
            }

            DB::commit();
            session()->flash("success", "Bank Admin updated successfully");
            return redirect()->route('bank-admin.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update Bank Admin: ' . $e->getMessage());
        }
    }

    /**
     * Delete Bank Admin
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Remove bank user mapping
            BankUser::where('user_id', $user->id)
                ->orWhere('people_id', function ($q) use ($user) {
                    $q->select('id')->from('people')->where('user_id', $user->id);
                })
                ->delete();

            // Delete user
            $user->delete();

            DB::commit();
            session()->flash("success", "Bank Admin deleted successfully");
            return redirect()->route('bank-admin.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete Bank Admin: ' . $e->getMessage());
        }
    }
}
