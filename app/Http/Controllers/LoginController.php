<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Country;
use App\Models\BasicSettings\FamilyCategory;
use App\Models\BasicSettings\FamilyType;
use App\Models\BasicSettings\Village;
use App\Models\District;
use App\Models\Division;
use App\Models\House;
use App\Models\Institute;
use App\Models\InstituteType;
use App\Models\People;
use App\Models\People\FamilyInfo;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Religion;
use App\Models\Road;
use App\Models\UnionWard;
use App\Models\User;
use App\Models\VillageArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
   
    public function register()
    {
        $data['divisions'] = Division::where('status', true)->get();
        $data['institute_types'] = InstituteType::where('status', true)->get();
        return view('authenticate.pages.register', $data);
    }

    public function registerStore(Request $request)
    {
        $project_type = $request->institute_type;
        $union_id = $request->union ? $request->union : null ;
        $pourashava_id = $request->pourashava ?  $request->pourashava : null ;
        $city_corporation_id = $request->city_corporation ? $request->city_corporation : null;

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        if($user) {
            $data['status'] = false;
            $data['message'] = "This email already registered!";
            return response()->json($data, 404);
        }

      $result =   DB::transaction(function() use($project_type, $union_id, $pourashava_id, $city_corporation_id, $email,  $password   ) {
            try {
                $project = Institute::where('institute_type_id', $project_type )
                ->where('union_id', $union_id)
                ->where('pourashava_id', $pourashava_id)
                ->where('city_corporation_id', $city_corporation_id)
                ->first();

                if (!$project) {
                    $project = new Project();
                    $project->project_type_id = $project_type;
                    $project->union_id = $union_id;
                    $project->pourashava_id = $pourashava_id;
                    $project->city_corporation_id = $city_corporation_id;
                    $project->save();
                }

                $user = new User();
                $user->role_id = 5;
                $user->institute_id = $project->id;
                $user->email = $email;
                $user->username = $email;
                $user->name = "Stranger";
                $user->password = Hash::make($password);
                $user->created_by = 1;
                $user->save();
                $data['status'] = true;
                $data['code'] = 200;
                $data['message'] = "Registration successful!";
                return $data;
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['code'] = 500;
                $data['message'] = "Registration failed";
                $data['errors'] = $th;
                return $data;
            }
        });


        return response()->json($result, $result['code']);

    

    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function loginCheck(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|max:190',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Invalid input! Please check your entries...";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $loginInput = trim($request->email);
        $remember = $request->remember ? true : false;

        $user = User::where(function($q) use ($loginInput) {
            $q->where('email', $loginInput)
              ->orWhere('system_id', $loginInput)
              ->orWhere('approved_id', $loginInput)
              ->orWhere('mobile', $loginInput)
              ->orWhere('nid', $loginInput);
        })->where('status', 1)->first();

        if ($user) {
            // Check if user is a Farmer and not yet approved
            if (in_array($user->role_id, [13, 5]) || $user->farmer) {
                if (!$user->is_verified) {
                    $data['status'] = false;
                    $data['message'] = "আপনার কৃষক প্রোফাইলটি এখনো অনুমোদিত নয়। প্রশাসনিক অনুমোদনের পর অনুমোদিত আইডি ও ডিফল্ট পাসওয়ার্ড (123456) দিয়ে লগইন করতে পারবেন।";
                    return response()->json($data, 403);
                }
            }

            $credential = ['password' => $request->password];
            if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                $credential['email'] = $loginInput;
            } elseif ($user->approved_id === $loginInput) {
                $credential['approved_id'] = $loginInput;
            } elseif ($user->system_id === $loginInput) {
                $credential['system_id'] = $loginInput;
            } elseif ($user->mobile === $loginInput) {
                $credential['mobile'] = $loginInput;
            } else {
                $credential['id'] = $user->id;
            }

            try {
                if (Auth::attempt($credential, $remember)) {
                    $data['status'] = true;
                    $data['user'] = $user;
                    $data['message'] = "Login Successfully! Redirecting...";
                    return response()->json($data, 200);
                } else {
                    $data['status'] = false;
                    $data['message'] = "User ID or password does not match!";
                    return response()->json($data, 403);
                }
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Something went wrong! Please try again...";
                $data['errors'] = $th->getMessage();
                return response()->json($data, 500);
            }
        } else {
            $data['status'] = false;
            $data['message'] = "User not found or account is inactive!";
            return response()->json($data, 404);
        }
    }

    /**
     * Password Reset Request specifically for Farmers
     */
    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'user_identity' => 'required|string',
        ]);

        $identity = trim($request->user_identity);

        $user = User::where(function($q) use ($identity) {
            $q->where('approved_id', $identity)
              ->orWhere('system_id', $identity)
              ->orWhere('mobile', $identity)
              ->orWhere('nid', $identity)
              ->orWhere('email', $identity);
        })->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'প্রদত্ত আইডি বা নম্বরের কোন একাউন্ট পাওয়া যায়নি!'
            ], 404);
        }

        // Only Farmer reset is allowed directly
        if (!in_array($user->role_id, [13, 5]) && !$user->farmer) {
            return response()->json([
                'status' => false,
                'message' => 'সরাসরি পাসওয়ার্ড রিসেট অপশনটি শুধুমাত্র কৃষকদের জন্য প্রযোজ্য।'
            ], 403);
        }

        $user->password = Hash::make('123456');
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'পাসওয়ার্ড সফলভাবে রিসেট করা হয়েছে! আপনার ডিফল্ট পাসওয়ার্ড "123456" সেট করা হয়েছে।'
        ], 200);
    }

    /**
     * Change Password View for Logged-In User
     */
    public function changePasswordView()
    {
        $user = Auth::user();
        return view('backend.pages.user.change_password', compact('user'));
    }

    /**
     * Update Password Store for Logged-In User
     */
    public function updatePasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড প্রদান করুন।',
            'password.required'         => 'নতুন পাসওয়ার্ড প্রদান করুন।',
            'password.min'              => 'নতুন পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে।',
            'password.confirmed'        => 'নতুন পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে না।',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'বর্তমান পাসওয়ার্ডটি সঠিক নয়!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }

    public function profile()
    {
        if(Auth::check()){
            $data['districts'] = District::get();
            $data['countries'] = Country::get();
            $data['religions'] = Religion::get();
            $data['familyTypes'] = FamilyType::get();
            $data['familyCategories'] = FamilyCategory::get();
            $data['villages'] = Village::get();
            $data['permanentVillageAreas'] = VillageArea::get();
            $data['wards'] = UnionWard::get();
            $data['roads'] = Road::get();
            $data['houses'] = $data['permanent_houses'] = House::get();
            $data['user'] = User::with('people', 'familyInfo', 'addressInfo')->find(Auth::id());
            return view('frontend.pages.user.profile', $data);
        } else{
            return "Unauthenticated";
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
