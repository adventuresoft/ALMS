<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationSuccessMail;
use App\Models\BasicSettings\Village;
use App\Models\Crop;
use App\Models\CultivationInfo;
use App\Models\Division;
use App\Models\Farmer;
use App\Models\Institute;
use App\Models\LandInfo;
use App\Models\People;
use App\Models\People\AddressInfo;
use App\Models\People\FamilyInfo;
use App\Models\Road;
use App\Models\UnionWard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{

    public function create()
    {
        $data['divisions'] = Division::orderBy('name', 'asc')->get();
        $data['permanent_villages'] = Village::latest()->get();
        $data['wards'] = UnionWard::get();
        $data['roads'] = Road::latest()->get();
        $data['crops'] = Crop::where('status', true)->latest()->get();
        return view('frontend.pages.application.create', $data);
    }

    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'bn_name' => 'required|max:190',

            'father_name' => 'nullable|max:190',
            'father_name_bn' => 'nullable|max:190',

            'mother_name' => 'nullable|max:190',
            'mother_name_bn' => 'nullable|max:190',

            'email' => 'nullable|email',
            'mobile' => 'required|max:11|min:11',

            'date_of_birth' => 'required',
            'gender' => 'required',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }


        DB::beginTransaction();

        try {
            $user = new User();
            $user->role_id = 5;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->birth_certificate = $request->birth_certificate;
            $user->nid = $request->nid;
            $user->password = Hash::make(date('dmY', strtotime($request->date_of_birth)));
            $user->created_by = 1;
            $user->status = 0;

            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(('upload/users/images'), $image);
                $user->image = 'upload/users/images/'. $image;
            }



            $user->save();


            $farmer = new Farmer();
            $farmer->user_id = $user->id;
            $farmer->bn_name = $request->bn_name;
            $farmer->date_of_birth = $request->date_of_birth;
            $farmer->district_id = $request->district_id;
            $farmer->gender = $request->gender;
            $farmer->is_agriculture_card = $request->is_agriculture_card;
            $farmer->agriculture_card_number = $request->agriculture_card_number;
            $farmer->save();

            $family = new FamilyInfo();
            $family->user_id = $user->id;
            $family->father_name = $request->father_name;
            $family->father_name_bn = $request->father_name_bn;
            $family->father_nid = $request->father_nid;
            $family->mother_name = $request->mother_name;
            $family->mother_name_bn = $request->mother_name_bn;
            $family->mother_nid = $request->mother_nid;
            $family->marital_status = $request->marital_status;
            $family->spouse = $request->spouse ? json_encode($request->spouse) : null;
            $family->have_children = $request->have_children;
            $family->children = $request->children ? json_encode($request->children) : null;
            $family->save();

            $address = new AddressInfo();
            $address->user_id = $user->id;
            $address->permanent_division_id = $request->permanent_division;
            $address->permanent_district_id = $request->permanent_district;
            $address->permanent_thana_id = $request->permanent_thana;
            $address->permanent_union_id = $request->permanent_union;
            $address->permanent_area = $request->permanent_area;

            if($request->same_as_present_address){
                $address->present_division_id = $request->permanent_division;
                $address->present_district_id = $request->permanent_district;
                $address->present_thana_id = $request->permanent_thana;
                $address->present_union_id = $request->permanent_union;
                $address->present_area = $request->permanent_area;

            }else{
                $address->present_division_id = $request->present_division;
                $address->present_district_id = $request->present_district;
                $address->present_thana_id = $request->present_thana;
                $address->present_union_id = $request->present_union;
                $address->present_area = $request->present_area;
            }
            $address->save();


            $crops = $request->crop;
            $land_owners = $request->land_owner;
            $quantities = $request->quantity;
            $addresses = $request->address;
            $descriptions = $request->description;


            if (!empty($crops)) {
                foreach ($crops as $key => $crop) {
                    $cultivation = new CultivationInfo();
                    $cultivation->user_id = $user->id;
                    $cultivation->crop = $crop;
                    $cultivation->land_owner = $land_owners[$key] ?? "own" ;
                    $cultivation->quantity = $quantities[$key] ?? '';
                    $cultivation->address = $addresses[$key] ?? '';
                    $cultivation->description = $descriptions[$key] ?? '';
                    $cultivation->save();
                }
            }


            $land_types = $request->land_type;
            $land_quantities = $request->land_quantity;
            $divisions = $request->division;
            $districts = $request->district;
            $thanas = $request->thana;
            $mouzas = $request->mouza;
            $dag_nos = $request->dag_no;
            $khatiyan_no = $request->khatiyan_no;

            if (!empty($land_types)) {
                foreach ($land_types as $landKey => $land_type) {
                    $land = new LandInfo();
                    $land->user_id = $user->id;
                    $land->land_type = $land_type;
                    $land->land_quantity = $land_quantities[$landKey] ?? "0.00" ;
                    $land->division = $divisions[$landKey] ?? '';
                    $land->district = $districts[$landKey] ?? '';
                    $land->thana = $thanas[$landKey] ?? '';
                    $land->mouza = $mouzas[$landKey] ?? '';
                    $land->dag_no = $dag_nos[$landKey] ?? '';
                    $land->khatiyan_no = $khatiyan_no[$landKey] ?? '';
                    $land->save();
                }
            }



            if ($request->email) {
                $details = [
                    'email' => $request->email,
                    'password' => date('dmY', strtotime($request->date_of_birth)),
                    'system_id' => $user->system_id
                ];
                // Mail::to($request->email)->send(new ApplicationSuccessMail($details));
            }

            // if($request->mobile){
            //     $message = "Application successful! Application ID: ".$user->system_id. " Password: " .date('dmY', strtotime($request->date_of_birth)). " Login: http://bit.ly/3YH8zRw";
            //     $response = Http::get('https://api.mobireach.com.bd/SendTextMessage', [
            //         'Username' => "advsoft",
            //         'Password' => 'Dhaka@0088',
            //         'From' => '8801847050122',
            //         'To' => $request->mobile,
            //         'Message' => $message,

            //     ]);
            //     if ($response->failed()) {
            //         $data['SMS'] = "failed";
            //        // return failure
            //     } else {
            //         $data['SMS'] = "success";
            //         // return success
            //     }
            // }




            $data['message'] ="Successfully submitted the application!";
            $data['status'] = true;
            $data['redirect_url'] = route('application.success', $user->system_id);
            DB::commit();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['message'] ="Sorry, Application Failed!";
            $data['status'] = false;
            $data['errors'] = $th;
            return response()->json($data, 500);
        }
    }

    public function success($system_id)
    {
        $data['user'] = User::where('system_id', $system_id)->first();
        return view('frontend.pages.application.success', $data);
    }

    public function verify(Request  $request)
    {
        $data['verify_id'] = $request->id;
        $data['user'] = null;
        if($data['verify_id']){
            $data['user'] = User::where('system_id', $data['verify_id'])->first();
        }
        return view('frontend.pages.application.verify', $data);
    }
}
