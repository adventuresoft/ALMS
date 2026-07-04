@extends('backend.master', ['mainMenu' => 'People', 'subMenu' =>'View'])
@push('style')
<style>
    @media print {
        #printPageButton {
            display: none;
        }
        .bg-success{
            background: #28a745!important;
            color: #fff;
        }
        footer{
            display: none;
        }
        .content-wrapper, .container, .card, .card-footer{
            background: #ffffff
        }
        .border-dark{
            border: 1px solid #343a40!important;
        }
    }
</style>
@endpush
@section('title', 'People View')
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h1>People Information</h1>
        </div>
        <div class="col-sm-4 text-center">
            <button id="printPageButton" class="btn btn-outline-primary btn-sm text-center" onClick="window.print();"> <i class="fa fa-print"></i> Print</button>
        </div>
        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('people.index')}}">People</a></li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h1>People Information</h1>
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="image" class="col-sm-2 col-form-label">Photo </label>
                                <div class="col-sm-9">
                                    <img class="img-fluid img-thumbnail" src="{{ $user->image ? asset($user->image) : asset('public/no-image-found.jpeg') }}" id="preview" alt="Preview" width="100" height="100">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger" title="disabled" data-toggle="tooltip" >*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" disabled value="{{ $user->name ?? '' }}" class="form-control"
                                        name="name" id="name" placeholder="Name English">
                                    <small class="error name-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bn_name" class="col-sm-2 col-form-label">Name Bangla <span class="text-danger" title="disabled" data-toggle="tooltip" >*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" disabled value="{{ $user->people->bn_name ?? '' }}" class="form-control"
                                        name="bn_name" id="bn_name" placeholder="Name Bangla">
                                    <small class="error bn_name-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email <span class="text-danger" title="disabled" data-toggle="tooltip" >*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" disabled value="{{ $user->email ?? '' }}" name="email"
                                        placeholder="Email" class="form-control" id="email">
                                    <small class="error email-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-sm-2 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input type="date" disabled value="{{ $user->people->date_of_birth ?? '' }}" name="date_of_birth"
                                        class="form-control" id="date_of_birth">
                                    <small class="error date_of_birth-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birth_place" class="col-sm-2 col-form-label">Birth Place</label>
                                <div class="col-sm-9">
                                    <select name="birth_place" disabled  class="form-control" id="birth_place">
                                            <option value="">Select Birth Place</option>
                                        @if (count(people_constant_option('birth_place')))
                                            @foreach (people_constant_option('birth_place') as $key => $item)
                                                <option value="{{ $key }}" {{isset($user->people->birth_place) ? (($user->people->birth_place == $key) ? 'selected' : '') : ''}}>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="error birth_place-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row districts {{isset($user->people->birth_place) ? (($user->people->birth_place == 1) ? '' : 'd-none') : 'd-none'}} ">
                                <label for="district_id" class="col-sm-2 col-form-label">District</label>
                                <div class="col-sm-9">
                                    <select name="district_id" disabled class="form-control" id="district_id">
                                        @if (count($districts))
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}" {{isset($user->people->district_id) ? (($user->people->district_id == $district->id) ? 'selected' : '') : ''}}>{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="error district_id-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row countries {{isset($user->people->birth_place) ? (($user->people->birth_place == 2) ? '' : 'd-none') : 'd-none'}} ">
                                <label for="country_id" class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-9">
                                    <select name="country_id" disabled class="form-control" id="country_id">
                                        @if (count($countries))
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{isset($user->people->country_id) ? (($user->people->country_id == $country->id) ? 'selected' : '') : ''}}>{{ $country->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="error country_id-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select name="gender" disabled class="form-control" id="gender">
                                        <option value="">Select Gender</option>
                                        @if (count(people_constant_option('gender')))
                                            @foreach (people_constant_option('gender') as $key => $item)
                                                <option value="{{ $key }}" {{isset($user->people->gender) ? (($user->people->gender == $key) ? 'selected' : '') : ''}}>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="error gender-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="religion" class="col-sm-2 col-form-label">Religion</label>
                                <div class="col-sm-9">
                                    <select name="religion" disabled class="form-control" id="religion">
                                        <option value="">Select Religion</option>
                                        @if (count($religions))
                                            @foreach ($religions as $religion)
                                                <option value="{{ $religion->id }}" {{isset($user->people->religion_id) ? (($user->people->religion_id == $religion->id) ? 'selected' : '') : ''}} >{{ $religion->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="error religion-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blood_group" class="col-sm-2 col-form-label">Blood Group</label>
                                <div class="col-sm-9">
                                    <select name="blood_group" disabled class="form-control" id="blood_group">
                                        <option value="">Select Blood Group</option>
                                        @if (count(people_constant_option('blood_group')))
                                            @foreach (people_constant_option('blood_group') as $key => $item)
                                                <option value="{{ $key }}" {{isset($user->people->blood_group) ? (($user->people->blood_group == $key) ? 'selected' : '') : ''}} >{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="error blood_group-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label">Mobile No.</label>
                                <div class="col-sm-9">
                                    <input type="tel" disabled value="{{ $user->mobile ?? '' }}" name="mobile"
                                        placeholder="Mobile" class="form-control" id="mobile">
                                    <small class="error mobile-error text-danger"></small>
                                </div>
                            </div>

                           

                            <div class="form-group row">
                                <label for="birth_certificate" class="col-sm-2 col-form-label">Birth Reg. No.</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled value="{{ $user->birth_certificate ?? '' }}"
                                        name="birth_certificate" placeholder="Birth Reg. No." class="form-control"
                                        id="birth_certificate">
                                    <small class="error birth_certificate-error text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nid" class="col-sm-2 col-form-label">NID No. </label>
                                <div class="col-sm-9">
                                    <input type="text" disabled value="{{ $user->nid ?? '' }}" name="nid"
                                        placeholder="NID No." class="form-control" id="nid">
                                    <span class="error nid-error text-danger"></span>
                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="card-title">Family Information </h6>
                            </div>

                            <div class="form-group row">
                                <label for="family_type_id" class="col-sm-2 col-form-label">
                                    Family Member Type
                                </label>
                                <div class="col-sm-9">
                                    <select name="family_type_id" disabled class="form-control" id="family_type_id">
                                        <option value="">Select Member Type</option>
                                        @if (count($familyTypes))
                                            @foreach ($familyTypes as $familyType)
                                                <option value="{{$familyType->id}}" {{$user->familyInfo ? ($user->familyInfo->family_type_id == $familyType->id ? 'selected' : '') : ''}}>{{$familyType->en_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger error family_type_id_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="family_category_id" class="col-sm-2 col-form-label">
                                    Family Category
                                </label>
                                <div class="col-sm-9">
                                    <select disabled name="family_category_id" class="form-control" id="family_category_id">
                                        <option value="">Select Family Category</option>
                                        @if (count($familyCategories))
                                            @foreach ($familyCategories as $familyCategory)
                                                <option value="{{$familyCategory->id}}" {{$user->familyInfo ? ($user->familyInfo->family_type_id == $familyCategory->id ? 'selected' : '') : ''}}>{{$familyCategory->en_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    <small class="text-danger error family_category_id_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fatherName" class="col-sm-2 col-form-label">Father's Name</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="father_name" value="{{$user->familyInfo->father_name ?? ''}}" class="form-control" id="fatherName" placeholder="Father's Name">
                                    <small class="text-danger error father_name_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="father_name_bn" class="col-sm-2 col-form-label">Father's Name in Bangla</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="father_name_bn" value="{{$user->familyInfo->father_name_bn ?? ''}}" class="form-control" id="father_name_bn" placeholder="Father's Name in Bangla">
                                    <small class="text-danger error father_name_bn_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fathersLiveStatus" class="col-sm-2 col-form-label">Father's Live Statu</label>
                                <div class="col-sm-9">
                                    <select name="father_live_status" disabled class="form-control" id="fathersLiveStatus">
                                        @foreach (family_constant_option('live_status') as $key => $live_status)
                                            <option value="{{$key}}" {{$user->familyInfo ? ($user->familyInfo->father_live_status == $key ? 'selected' : '') : ''}}>{{$live_status}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger error father_live_status_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fatherNID" class="col-sm-2 col-form-label">Father's ID</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="father_nid" class="form-control" id="fatherNID"  value="{{$user->familyInfo->father_nid ?? ''}}"  placeholder="Fatherss NID">
                                    <small class="text-danger error father_nid_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="motherName" class="col-sm-2 col-form-label">
                                    Mother's Name
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" disabled class="form-control" name="mother_name" id="motherName"  value="{{$user->familyInfo->mother_name ??''}}"  placeholder="Mother's Name">
                                    <small class="text-danger error mother_name_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mother_name_bn" class="col-sm-2 col-form-label">
                                    Mother's Name in Bangla
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" disabled class="form-control" name="mother_name_bn" id="mother_name_bn"  value="{{$user->familyInfo->mother_name_bn ??''}}"  placeholder="Mother's Name in Bangla">
                                    <small class="text-danger error mother_name_bn_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="motherLiveStatus" class="col-sm-2 col-form-label">
                                    Mother's Live Status
                                </label>
                                <div class="col-sm-9">
                                    <select name="mother_live_status" disabled class="form-control" id="motherLiveStatus">
                                        @foreach (family_constant_option('live_status') as $key => $live_status)
                                            <option value="{{$key}}" {{$user->familyInfo ? ($user->familyInfo->mother_live_status == $key ? 'selected' : '') : ''}}>{{$live_status}}</option>
                                        @endforeach
                                    </select>

                                    <small class="text-danger error mother_live_status_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="motherNID" class="col-sm-2 col-form-label">
                                    Mother's ID
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="mother_nid" class="form-control" id="motherNID"  value="{{$user->familyInfo->mother_nid ?? ''}}" placeholder="Mother's NID">
                                    <small class="text-danger error mother_nid_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="maritalStatus" class="col-sm-2 col-form-label">Marital Status</label>
                                <div class="col-sm-9">
                                    <select name="marital_status" disabled class="form-control" id="maritalStatus">

                                        @foreach (family_constant_option('marital_status') as $key => $marital_status)
                                            <option value="{{$key}}" {{$user->familyInfo ? (($user->familyInfo->marital_status == $key) ? 'selected' : '') : ''}}>{{$marital_status}}</option>
                                        @endforeach

                                    </select>

                                    <small class="text-danger error marital_status_error"></small>

                                </div>
                            </div>

                            <div class="form-group row marital_status_content {{$user->familyInfo ? ( ($user->familyInfo->marital_status == 1) ? 'd-none' : 'block') : 'd-none'}}">
                                <label for="spouseName" class="col-sm-2 col-form-label">Spouse Name</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="spouse_name" class="form-control" id="spouseName" value="{{$user->familyInfo->spouse_name ?? ''}}" placeholder="Spouse Name" />
                                    <small class="text-danger error spouse_name_error"></small>
                                </div>
                            </div>

                            <div class="form-group row marital_status_content {{$user->familyInfo ? (($user->familyInfo->marital_status == 1) ? 'd-none' : 'block') : 'd-none'}}">
                                <label for="spouseNID" class="col-sm-2 col-form-label">
                                    Spouse's ID
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="spouse_nid" class="form-control"  value="{{$user->familyInfo->spouse_nid ?? ''}}" id="spouseNID" placeholder="Spouse's NID" />
                                    <small class="text-danger error spouse_nid_error"></small>

                                </div>
                            </div>

                            <div class="form-group row marital_status_content {{$user->familyInfo ? (($user->familyInfo->marital_status == 1) ? 'd-none' : 'block') : 'd-none'}}">
                                <label for="married_date" class="col-sm-2 col-form-label">
                                    Married Date
                                </label>
                                <div class="col-sm-9">
                                    <input type="date" disabled name="married_date"   value="{{$user->familyInfo->married_date ?? ''}}" class="form-control" id="married_date" />
                                    <small class="text-danger error married_date_error"></small>

                                </div>
                            </div>

                            <div class="form-check row marital_status_content {{$user->familyInfo ? ( ($user->familyInfo->marital_status == 1) ? 'd-none' : 'block') : 'd-none'}}">
                                <input type="checkbox" disabled value="1" {{$user->familyInfo ? ($user->familyInfo->have_children ? "checked" : "") : ""}} name="have_children" class="form-check-input" id="haveChildren">
                                <label for="haveChildren" class=" form-check-label"> Have any children?</label>
                            </div>

                            <div class="form-group row have_children_content {{$user->familyInfo ? ($user->familyInfo->have_children ? 'block' : 'd-none') : 'd-none'}}">
                                <label for="boys" class="col-sm-2 col-form-label">
                                    Number of boys
                                </label>
                                <div class="col-sm-9">
                                    <input type="number" disabled name="boys" class="form-control" id="boys"  value="{{$user->familyInfo->boys ?? ''}}"  placeholder="Number of Boys" />
                                    <small class="text-danger error boys_error"></small>

                                </div>
                            </div>

                            <div class="form-group row have_children_content {{$user->familyInfo ? ($user->familyInfo->have_children ? 'block' : 'd-none') : 'd-none'}}">
                                <label for="girls" class="col-sm-2 col-form-label">
                                    Number of Girls
                                </label>
                                <div class="col-sm-9">
                                    <input type="number" disabled class="form-control" name="girls" id="girls" value="{{$user->familyInfo->girls ?? ''}}"  placeholder="Number of Girls" />
                                    <small class="text-danger error girls_error"></small>

                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="card-title">Address Information </h6>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_village_id" class="col-sm-2 col-form-label">Village</label>
                                <div class="col-sm-9">
                                    <select name="permanent_village_id" disabled class="form-control select2 select2bs4" id="permanent_village_id">
                                        <option value="">Select Village</option>
                                        @if (count($villages))
                                            @foreach ($villages as $village)
                                                <option value="{{$village->id}}" {{$user->addressInfo ? ($user->addressInfo->permanent_village_id == $village->id ? 'selected' : '' ) : ''}}>{{$village->en_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger error permanent_village_id_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_ward_id" class="col-sm-2 col-form-label">Permanent Ward</label>
                                <div class="col-sm-9">
                                    <select name="permanent_ward_id" disabled class="form-control select2 select2bs4" id="permanent_ward_id">
                                        <option value="">Select Ward</option>
                                        @if ($wards)
                                            @foreach ($wards as $ward)
                                                <option value="{{$ward->id}}" {{$user->addressInfo ? (($user->addressInfo->permanent_ward_id == $ward->id) ? 'selected' : '' ) : ''}}>{{$ward->en_ward_no}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger error permanent_ward_id_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_area" class="col-sm-2 col-form-label">Area</label>
                                <div class="col-sm-9">
                                    <input name="permanent_area" disabled placeholder="Permanent Area" value="{{$user->addressInfo->permanent_area ?? ''}}" class="form-control">
                                    <small class="text-danger error permanent_area_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_area_bn" class="col-sm-2 col-form-label">Area (Bangla)</label>
                                <div class="col-sm-9">
                                    <input name="permanent_area_bn" disabled placeholder="Permanent Area in Bangla" value="{{$user->addressInfo->permanent_area_bn ?? ''}}" class="form-control">
                                    <small class="text-danger error permanent_area_bn_error"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_road" class="col-sm-2 col-form-label">Road</label>
                                <div class="col-sm-9">
                                        <select class="form-control select2" disabled name="permanent_road" >
                                            <option value="">Select Road</option>
                                            @if (count($roads))
                                                @foreach($roads as $road)
                                                    <option value="{{$road->id}}" {{isset($user->addressInfo->permanentRoad->id) ? (($user->addressInfo->permanentRoad->id == $road->id) ? 'selected' : '' ) : '' }} >{{$road->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger error permanent_road_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_house" class="col-sm-2 col-form-label">House</label>
                                <div class="col-sm-9">

                                    <select name="permanent_house" disabled class="form-control select2 select2bs4" id="permanent_house">
                                        @if (count($permanent_houses))
                                            @foreach ($permanent_houses as $house)
                                                <option value="{{$house->id}}" {{isset($user->addressInfo->permanentHouse->id) ? ($user->addressInfo->permanentHouse->id == $house->id ? 'selected' : '') : ''}} >{{$house->house}}</option>
                                            @endforeach

                                        @else 
                                            <option value="{{$user->addressInfo->permanentHouse->id ?? ''}}">{{$user->addressInfo->permanentHouse->house ?? 'No House Found' }}</option>
                                        @endif
                                    </select>
                                    <small class="text-danger error permanent_house_error"></small>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_flat" class="col-sm-2 col-form-label">Flat</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="permanent_flat" class="form-control" id="permanent_flat"
                                        value="{{ $user->addressInfo->permanent_flat ?? '' }}" placeholder="Permanent Flat">

                                        <small class="text-danger error permanent_flat_error"></small>
                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="card-title">Present Address </h6>
                            </div>

                            <div class="form-group row">
                                <label for="present_division_id" class="col-sm-2 col-form-label">Division</label>
                                <div class="col-sm-9">
                                    <select name="present_division_id" disabled class="form-control select2 select2bs4"
                                        id="present_division_id">
                                        <option value="">Select Division</option>
                                        @if ($divisions)
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}" {{$user->addressInfo ? ($user->addressInfo->present_division_id == $division->id ? 'selected' : '') : ''}}>{{ $division->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger error present_division_id_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_district_id" class="col-sm-2 col-form-label">District</label>
                                <div class="col-sm-9">
                                    <select name="present_district_id" disabled class="form-control select2 select2bs4"
                                        id="present_district_id">
                                        <option value="{{$user->addressInfo->present_district_id ?? ''}}">{{$user->addressInfo->presentDistrict->name ?? 'Select District'}}</option>
                                    </select>
                                    <small class="text-danger error present_district_id_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_thana_id" class="col-sm-2 col-form-label">Thana</label>
                                <div class="col-sm-9">
                                    <select name="present_thana_id" disabled class="form-control select2 select2bs4"
                                        id="present_thana_id">
                                        <option value="{{$user->addressInfo->present_thana_id ?? ''}}">{{$user->addressInfo->presentThana->name ?? 'Select Thana'}}</option>
                                    </select>
                                    <small class="text-danger error present_thana_id_error"></small>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_union_id" class="col-sm-2 col-form-label">UP</label>
                                <div class="col-sm-9">
                                    <select name="present_union_id" disabled  class="form-control select2 select2bs4"
                                        id="present_union_id">
                                        <option value="{{$user->addressInfo->present_union_id ?? ''}}"> {{$user->addressInfo->presentUnion->name ?? 'Select Union'}} </option>
                                    </select>
                                    <small class="text-danger error present_union_id_error"></small>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_village_id" class="col-sm-2 col-form-label">Village</label>
                                <div class="col-sm-9">
                                    <select name="present_village_id" disabled  class="form-control select2 select2bs4" id="present_village_id">
                                        <option value="{{$user->addressInfo->present_village_id ?? ''}}">{{$user->addressInfo->presentVillage->en_name ?? 'Select Village'}}</option>
                                    </select>
                                    <small class="text-danger error present_village_id_error"></small>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_ward_id" class="col-sm-2 col-form-label">Ward</label>
                                <div class="col-sm-9">
                                    <select name="present_ward_id" disabled class="form-control select2 select2bs4"
                                        id="present_ward_id">
                                        <option value="">Select Ward</option>
                                        @if ($wards)
                                            @foreach ($wards as $ward)
                                                <option value="{{$ward->id}}" {{$user->addressInfo ? (($user->addressInfo->present_ward_id == $ward->id) ? 'selected' : '' ) : ''}}>{{$ward->en_ward_no}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger error present_ward_id_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_area" class="col-sm-2 col-form-label">Area</label>
                                <div class="col-sm-9">
                                    <input name="present_area" disabled placeholder="Present Area" value="{{$user->addressInfo->present_area ?? ''}}" class="form-control">
                                    <small class="text-danger error present_area_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_area_bn" class="col-sm-2 col-form-label">Area (Bangla)</label>
                                <div class="col-sm-9">
                                    <input name="present_area_bn" disabled placeholder="Present Area in Bangla" value="{{$user->addressInfo->present_area_bn ?? ''}}" class="form-control">
                                    <small class="text-danger error present_area_bn_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_road" class="col-sm-2 col-form-label">Road</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" disabled id="present_road" name="present_road" >
                                        <option value="{{$user->addressInfo->presentRoad->id ?? ''}}">{{$user->addressInfo->presentRoad->name ?? 'Select Road'}}</option>
                                    </select>
                                    <small class="text-danger error present_road_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_house" class="col-sm-2 col-form-label">House</label>
                                <div class="col-sm-9">
                                    <select name="present_house" disabled class="form-control select2 select2bs4" id="present_house">
                                        <option value="{{$user->addressInfo->presentHouse->id ?? ''}}">{{$user->addressInfo->presentHouse->house ?? '' }} </option>
                                    </select>
                                    <small class="text-danger error present_house_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_flat" class="col-sm-2 col-form-label">Flat</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled name="present_flat" class="form-control"
                                        value="{{ $user->addressInfo->present_flat ?? '' }}" id="present_flat"
                                        placeholder="Present Flat">
                                        <small class="text-danger error present_flat_error"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="present_start_date" class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-9">
                                    <input type="date" disabled name="present_start_date"
                                        value="{{ $user->addressInfo->present_start_date ?? '' }}" class="form-control"
                                        id="present_start_date">
                                        <small class="text-danger error present_start_date_error"></small>
                                </div>
                            </div>

                            

                            @if (count($user->educationInfos))
                                <div class="card-header">
                                    <h6 class="card-title">Education </h6>
                                </div>
                                @foreach ($user->educationInfos as $education)
                                        <div class="form-group row">
                                            <label for="degree_id" class="col-sm-2 col-form-label">Degree</label>
                                            <div class="col-sm-9">
                                                <select name="degree_idU[{{$education->id}}]" disabled class="form-control" id="degree_id">
                                                    <option value="1" @if($education->degree_id == 1) selected @endif >HSC</option>
                                                    <option value="2"  @if($education->degree_id == 2) selected @endif >SSC</option>
                                                    <option value="3"  @if($education->degree_id == 3) selected @endif >JSC</option>
                                                </select>
                                                <small class="text-danger error degree_id_error"></small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="group_id" class="col-sm-2 col-form-label">Group</label>
                                            <div class="col-sm-9">
                                                <select name="group_idU[{{$education->id}}]" disabled class="form-control" id="group_id">
                                                    <option value="1"  @if($education->group_id == 1) selected @endif >Science</option>
                                                    <option value="2"  @if($education->group_id == 2) selected @endif >Business</option>
                                                    <option value="3"  @if($education->group_id == 3) selected @endif >Humanties</option>
                                                </select>
                                                <small class="text-danger error group_id_error"></small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="grade_id" class="col-sm-2 col-form-label">Grade</label>
                                            <div class="col-sm-9">
                                                <select name="grade_idU[{{$education->id}}]" disabled class="form-control" id="grade_id">
                                                    <option value="1"  @if($education->grade_id == 1) selected @endif >A+</option>
                                                    <option value="2"  @if($education->grade_id == 2) selected @endif>A</option>
                                                    <option value="3"  @if($education->grade_id == 3) selected @endif>A-</option>
                                                    <option value="4"  @if($education->grade_id == 4) selected @endif>B+</option>
                                                    <option value="5"  @if($education->grade_id == 5) selected @endif>B</option>
                                                    <option value="6"  @if($education->grade_id == 6) selected @endif>B-</option>
                                                    <option value="7"  @if($education->grade_id == 7) selected @endif>C+</option>
                                                    <option value="8"  @if($education->grade_id == 8) selected @endif>C</option>
                                                    <option value="9"  @if($education->grade_id == 9) selected @endif>D</option>
                                                    <option value="10"  @if($education->grade_id == 10) selected @endif>F</option>
                                                </select>
                                                <small class="text-danger error grade_id_error"></small>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="board_id" class="col-sm-2 col-form-label">Board</label>
                                            <div class="col-sm-9">
                                                <select name="board_idU[{{$education->id}}]" disabled class="form-control" id="board_id">
                                                    <option value="1" @if($education->board_id == 1) selected @endif >Dhaka</option>
                                                    <option value="2" @if($education->board_id == 2) selected @endif>Rajshashi</option>
                                                    <option value="3" @if($education->board_id == 3) selected @endif>Rangpur</option>
                                                    <option value="4" @if($education->board_id == 4) selected @endif>Jessore</option>
                                                    <option value="5" @if($education->board_id == 5) selected @endif>Comilla</option>
                                                    <option value="6" @if($education->board_id == 6) selected @endif>Sylhet</option>
                                                    <option value="7" @if($education->board_id == 7) selected @endif>Chittagong</option>
                                                </select>

                                                <small class="text-danger error board_id_error"></small>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="institute" class="col-sm-2 col-form-label">Educational Institute</label>
                                            <div class="col-sm-9">
                                                <input type="text" disabled name="instituteU[{{$education->id}}]" value="{{$education->institute}}" placeholder="Educational Institute" class="form-control" id="institute">
                                            </div>
                                        </div>
                                @endforeach
                            @endif

                            

                            @if (count($user->professionalInfos))
                                <div class="card-header">
                                    <h6 class="card-title">Profession </h6>
                                </div>
                                @foreach ($user->professionalInfos as $professionalInfo)
                                    <div class="single-profession">

                                        <div class="form-group row">
                                            <label for="profession" class="col-sm-2 col-form-label">Profession</label>
                                            <div class="col-sm-9">
                                                <select disabled name="professionU[{{ $professionalInfo->id }}]"
                                                    class="form-control select2 profession">
                                                    <option value="">Select Profession</option>
                                                    @if (count($professions))
                                                        @foreach ($professions as $profession)
                                                            <option value="{{ $profession->id }}"
                                                                {{ isset($professionalInfo->subcategory->category->type->profession_id) ? ($professionalInfo->subcategory->category->type->profession_id == $profession->id ? 'selected' : '') : '' }}>
                                                                {{ $profession->en_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="profession_type" class="col-sm-2 col-form-label">Type</label>
                                            <div class="col-sm-9">
                                                <select disabled name="profession_typeU[{{ $professionalInfo->id }}]"
                                                    class="form-control select2 profession_type">
                                                    <option
                                                        value="{{ $professionalInfo->subcategory->category->type->id ?? '' }}">
                                                        {{ $professionalInfo->subcategory->category->type->en_name ?? 'Select Profession Type' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="profession_category"
                                                class="col-sm-2  col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <select disabled name="profession_categoryU[{{ $professionalInfo->id }}]"
                                                    class="form-control select2 profession_category">
                                                    <option
                                                        value="{{ $professionalInfo->subcategory->category->id ?? '' }}">
                                                        {{ $professionalInfo->subcategory->category->en_name ?? 'Select Profession Category' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="profession_subcategory"
                                                class="col-sm-2 col-form-label">Subcategory</label>
                                            <div class="col-sm-9">
                                                <select disabled
                                                    name="profession_subcategoryU[{{ $professionalInfo->id }}]"
                                                    class="form-control select2 profession_subcategory">
                                                    <option value="{{ $professionalInfo->subcategory->id ?? '' }}">
                                                        {{ $professionalInfo->subcategory->en_name ?? 'Select Profession Subcategory' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="profession_start" class="col-sm-2 col-form-label">Start
                                                Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" disabled
                                                    name="profession_startU[{{ $professionalInfo->id }}]"
                                                    value="{{ $professionalInfo->profession_start ?? '' }}"
                                                    placeholder="Profession Start Date" class="form-control"
                                                    id="profession_start">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="profession_end" class="col-sm-2 col-form-label">End Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" disabled
                                                    name="profession_endU[{{ $professionalInfo->id }}]"
                                                    value="{{ $professionalInfo->profession_end ?? '' }}"
                                                    placeholder="Profession End Date" class="form-control"
                                                    id="profession_end">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="organization"
                                                class="col-sm-2 col-form-label">Organization</label>
                                            <div class="col-sm-9">
                                                <input type="text" disabled name="organizationU[{{ $professionalInfo->id }}]"
                                                    placeholder="Enter name of professional organization"
                                                    value="{{ $professionalInfo->organization ?? '' }}"
                                                    class="form-control organization">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="designation" class="col-sm-2 col-form-label">Designation</label>
                                            <div class="col-sm-9">
                                                <input type="text" disabled name="designationU[{{ $professionalInfo->id }}]"
                                                    placeholder="Enter name of professional designation"
                                                    value="{{ $professionalInfo->designation ?? '' }}"
                                                    class="form-control designation">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <textarea disabled name="addressU[{{ $professionalInfo->id }}]" class="form-control address"
                                                    placeholder="Enter name of professional address" cols="30" rows="3">{{ $professionalInfo->address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif



                            @if (count($user->financialInfos))

                                <div class="card-header">
                                    <h6 class="card-title">Financial </h6>
                                </div>

                                @foreach ($user->financialInfos as $financial)
                                    <div class="single-financial-{{$financial->id}}">
                                        <div class="form-group row">
                                            <label for="account_no" class="col-sm-2 col-form-label">A/C No</label>
                                            <div class="col-sm-9">
                                                <input type="text" disabled class="form-control" value="{{$financial->account_no}}" name="account_noU[{{$financial->id}}]" id="account_no" placeholder="A/C No">
                                                <small class="text-danger error account_noU_error"></small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="account_type_id" class="col-sm-2 col-form-label">A/C Type</label>
                                            <div class="col-sm-9">
                                                <select disabled name="account_typeU[{{$financial->id}}]" class="form-control account_type_id">
                                                    @if (count($account_types))
                                                        @foreach($account_types as $type)
                                                            <option value="{{$type->id}}" @if ($type->id == $financial->account_type_id) selected @endif >{{$type->en_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <small class="text-danger error account_typeU_error"></small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="bank_id" class="col-sm-2 col-form-label">Bank</label>
                                            <div class="col-sm-9">
                                                <select disabled name="bank_idU[{{$financial->id}}]" class="form-control" id="bank_id">
                                                    @if (count($banks))
                                                        @foreach ($banks as $bank)
                                                            <option value="{{$bank->id}}" @if ($bank->id == $financial->bank_id) selected @endif >{{$bank->en_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <small class="text-danger error bank_idU_error"></small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="account_balance" class="col-sm-2 col-form-label">Balance</label>
                                            <div class="col-sm-9">
                                                <input type="text" disabled value="{{$financial->account_balance}}" name="account_balanceU[{{$financial->id}}]" class="form-control" id="account_balance">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                            <div class="card-header">
                                <h6 class="card-title">Property </h6>
                            </div>

                            <div class="property-content {{(isset($user->propertyInfos->is_property) ?  (($user->propertyInfos->is_property == 1) ? '' : 'd-none')  : 'd-none')}}">
                                <div class="form-group row">
                                    <label for="cash_amount" class="col-sm-2 col-form-label">Cash Amount</label>
                                    <div class="col-sm-9">
                                        <input type="number" disabled  class="form-control"
                                            value="{{ $user->propertyInfos->cash_amount ?? '' }}" name="cash_amount"
                                            id="cash_amount" placeholder="Cash Amount">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tin_number" class="col-sm-2 col-form-label">E-TIN</label>
                                    <div class="col-sm-9">
                                        <input type="text" disabled name="tin_number"
                                            value="{{ $user->propertyInfos->tin_number ?? '' }}" class="form-control"
                                            id="tin_number">
                                    </div>
                                </div>

                                <br><br>
                                {{-- House --}}
                                <div class="form-check d-flex mr-2">
                                    <label for="house"> 
                                        <i class="fa fa-home"></i> 
                                        Have any house? 
                                    </label>
                                    <div class="toggle-button r toggle-button-1">
                                        <input disabled type="checkbox" class="checkbox" name="house" id="house" value="1"  {{ $user->propertyInfos ? ($user->propertyInfos->house ? 'checked' : '') : '' }} />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            
                                
                                
                                <hr>

                                <div
                                    class="house-property  {{ $user->propertyInfos ? ($user->propertyInfos->house ? '' : 'd-none') : 'd-none' }}">
                                    <div class="form-group row">
                                        <label for="house_type" class="col-sm-2 col-form-label">House Type</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="house_type"
                                                value="{{ $user->propertyInfos->house_type ?? '' }}"
                                                placeholder="Building/Tien Shed" class="form-control" id="house_type">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="house_area" class="col-sm-2 col-form-label">House Area</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="house_area"
                                                value="{{ $user->propertyInfos->house_area ?? '' }}"
                                                placeholder="House Area" class="form-control" id="house_area">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="house_land_quantity" class="col-sm-2 col-form-label">Land
                                            Quantity</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="house_land_quantity"
                                                value="{{ $user->propertyInfos->house_land_quantity ?? '' }}"
                                                placeholder="Land Quantity" class="form-control" id="house_land_quantity">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="house_price" class="col-sm-2 col-form-label">House Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="house_price"
                                                value="{{ $user->propertyInfos->house_price ?? '' }}"
                                                placeholder="House Price" class="form-control" id="house_price">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="house_ownership_status" class="col-sm-2 col-form-label">Ownership
                                            Status</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="house_ownership_status"
                                                value="{{ $user->propertyInfos->house_ownership_status ?? '' }}"
                                                placeholder="Ownership Status" class="form-control"
                                                id="house_ownership_status">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="house_address" class="col-sm-2 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" disabled rows="3" name="house_address" placeholder="Address" id="house_address">{{ $user->propertyInfos->house_address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>




                                <br><br>
                                {{-- Land --}}
                                <div class="form-check d-flex mr-2">
                                    <label for="land">
                                        <i class="fa fa-mountain"></i>
                                        Have any land?
                                    </label>


                                    <div class="toggle-button r toggle-button-1">
                                        <input type="checkbox" disabled class="checkbox" name="land" id="land" value="1"  {{ $user->propertyInfos ? ($user->propertyInfos->land ? 'checked' : '') : '' }} />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>

                                </div>
                                <hr>

                                <div
                                    class="land-property {{ $user->propertyInfos ? ($user->propertyInfos->land ? '' : 'd-none') : 'd-none' }}">

                                    <div class="form-group row">
                                        <label for="land_district_id" class="col-sm-2 col-form-label">District</label>
                                        <div class="col-sm-9">
                                            <select name="land_district_id" disabled class="form-control select2" id="land_district_id">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}"
                                                        {{ $user->propertyInfos ? ($user->propertyInfos->land_district_id == $district->id ? 'selected' : '') : '' }}>
                                                        {{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_thana_id" class="col-sm-2 col-form-label">Thana</label>
                                        <div class="col-sm-9">
                                            <select name="land_thana_id" disabled class="form-control select2" id="land_thana_id">
                                                <option value="">Select Thana</option>
                                                @if (count($landThanas))
                                                    @foreach($landThanas as $landThana)
                                                        <option value="{{$landThana->id}}" {{ $user->propertyInfos ? ($user->propertyInfos->land_thana_id == $landThana->id ? 'selected' : '') : '' }}  >{{$landThana->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_mouza_id" class="col-sm-2 col-form-label">Mouza</label>
                                        <div class="col-sm-9">
                                            <select name="land_mouza_id" disabled class="form-control select2" id="land_mouza_id">
                                                <option value="">Select Mouza</option>
                                                @if (count($landMouzas))
                                                    @foreach($landMouzas as $landMouza)
                                                        <option value="{{$landMouza->id}}" {{ $user->propertyInfos ? ($user->propertyInfos->land_mouza_id == $landMouza->id ? 'selected' : '') : '' }}  >{{$landMouza->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_khatian_id" class="col-sm-2 col-form-label">Khatian</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_khatian_id"
                                                value="{{ $user->propertyInfos->land_khatian_id ?? '' }}"
                                                placeholder="Khatian No." class="form-control" id="land_khatian_id">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_dag_no" class="col-sm-2 col-form-label">Dag No.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_dag_no"
                                                value="{{ $user->propertyInfos->land_dag_no ?? '' }}"
                                                placeholder="Dag No." class="form-control" id="land_dag_no">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_bs" class="col-sm-2 col-form-label">BS</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_bs"
                                                value="{{ $user->propertyInfos->land_bs ?? '' }}" placeholder="BS"
                                                class="form-control" id="land_bs">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_rs" class="col-sm-2 col-form-label">RS</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_rs"
                                                value="{{ $user->propertyInfos->land_rs ?? '' }}" placeholder="RS"
                                                class="form-control" id="land_rs">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_sa" class="col-sm-2 col-form-label">SA</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_sa"
                                                value="{{ $user->propertyInfos->land_sa ?? '' }}" placeholder="SA"
                                                class="form-control" id="land_sa">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_cs" class="col-sm-2 col-form-label">CS</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_cs"
                                                value="{{ $user->propertyInfos->land_cs ?? '' }}" placeholder="CS"
                                                class="form-control" id="land_cs">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_quantity" class="col-sm-2 col-form-label">Quantity</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_quantity"
                                                value="{{ $user->propertyInfos->land_quantity ?? '' }}"
                                                placeholder="Quantity" class="form-control" id="land_quantity">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_type" class="col-sm-2 col-form-label">Land Type</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_type"
                                                value="{{ $user->propertyInfos->land_type ?? '' }}"
                                                placeholder="Land Type" class="form-control" id="land_type">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="land_ownership_status" class="col-sm-2 col-form-label">Ownership
                                            Status</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="land_ownership_status"
                                                value="{{ $user->propertyInfos->land_ownership_status ?? '' }}"
                                                placeholder="Land Ownership Status" class="form-control"
                                                id="land_ownership_status">
                                        </div>
                                    </div>

                                </div>


                                <br><br>
                                {{-- Flat --}}
                                <div class="form-check d-flex mr-2">

                                    <label for="flat">
                                        <i class="fa fa-building"></i>
                                        Have any flat?
                                    </label>
                                    

                                    <div class="toggle-button r toggle-button-1">
                                        <input type="checkbox" disabled class="checkbox" name="flat" id="flat" value="1"  {{ $user->propertyInfos ? ($user->propertyInfos->flat ? 'checked' : '') : '' }} />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>

                                </div>
                                <hr>

                                <div
                                    class="flat-property {{ $user->propertyInfos ? ($user->propertyInfos->flat ? '' : 'd-none') : 'd-none' }}">

                                    <div class="form-group row">
                                        <label for="flat_district_id" class="col-sm-2 col-form-label">District</label>
                                        <div class="col-sm-9">
                                            <select disabled name="flat_district_id" class="form-control select2" id="flat_district_id">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}"
                                                        {{ $user->propertyInfos ? ($user->propertyInfos->flat_district_id == $district->id ? 'selected' : '') : '' }}>
                                                        {{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_thana_id" class="col-sm-2 col-form-label">Thana</label>
                                        <div class="col-sm-9">
                                            <select disabled name="flat_thana_id" class="form-control select2" id="flat_thana_id">
                                                <option value="">Select Thana</option>
                                                @if (count($flatThanas))
                                                    @foreach($flatThanas as $landThana)
                                                        <option value="{{$landThana->id}}" {{ $user->propertyInfos ? ($user->propertyInfos->flat_thana_id == $landThana->id ? 'selected' : '') : '' }}  >{{$landThana->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_mouza_id" class="col-sm-2 col-form-label">Mouza</label>
                                        <div class="col-sm-9">
                                            <select disabled name="flat_mouza_id" class="form-control select2" id="flat_mouza_id">
                                                <option value="">Select Mouza</option>
                                                @if (count($flatMouzas))
                                                    @foreach($flatMouzas as $flatMouza)
                                                        <option value="{{$flatMouza->id}}" {{ $user->propertyInfos ? ($user->propertyInfos->flat_mouza_id == $flatMouza->id ? 'selected' : '') : '' }}  >{{$flatMouza->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_area" class="col-sm-2 col-form-label">Flat Area</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled value="{{ $user->propertyInfos->flat_area ?? '' }}"
                                                name="flat_area" placeholder="Flat Area" class="form-control"
                                                id="flat_area">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_road" class="col-sm-2 col-form-label">Flat Road</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="flat_road"
                                                value="{{ $user->propertyInfos->flat_road ?? '' }}"
                                                placeholder="Flat Road" class="form-control" id="flat_road">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_house_no" class="col-sm-2 col-form-label">Flat House No.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="flat_house_no"
                                                value="{{ $user->propertyInfos->flat_house_no ?? '' }}"
                                                placeholder="Flat House No." class="form-control" id="flat_house_no">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_quantity" class="col-sm-2 col-form-label">Flat Quantity</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="flat_quantity"
                                                value="{{ $user->propertyInfos->flat_quantity ?? '' }}"
                                                placeholder="Flat Quantity" class="form-control" id="flat_quantity">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_price" class="col-sm-2 col-form-label">Flat Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="flat_price" placeholder="Flat Price"
                                                value="{{ $user->propertyInfos->flat_price ?? '' }}" class="form-control"
                                                id="flat_price">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="flat_ownership_status" class="col-sm-2 col-form-label">Ownership
                                            Status</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="flat_ownership_status"
                                                value="{{ $user->propertyInfos->flat_ownership_status ?? '' }}"
                                                placeholder="Flat Ownership Status" class="form-control"
                                                id="flat_ownership_status">
                                        </div>
                                    </div>
                                </div>


                                <br><br>
                                {{-- Diamond --}}
                                <div class="form-check d-flex mr-2">
                                    <label for="diamond">
                                        <i class="fa fa-gem"></i>
                                        Have any diamond?
                                    </label>
                                   

                                    <div class="toggle-button r toggle-button-1">
                                        <input type="checkbox" disabled class="checkbox" name="diamond" id="diamond" value="1"  {{ $user->propertyInfos ? ($user->propertyInfos->diamond ? 'checked' : '') : '' }} />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>

                                </div>
                                <hr>

                                <div
                                    class="diamond-property {{ $user->propertyInfos ? ($user->propertyInfos->diamond ? '' : 'd-none') : 'd-none' }}">

                                    <div class="form-group row">
                                        <label for="diamond_type" class="col-sm-2 col-form-label">Diamond Type</label>
                                        <div class="col-sm-9">
                                            <select name="diamond_type" disabled class="form-control" id="diamond_type">
                                                @foreach (property_constant_option('diamondType') as $key => $text)
                                                    <option value="{{$key}}" {{ $user->propertyInfos ? ($user->propertyInfos->diamond_type ==  $key ? 'selected' : '') : '' }}>{{$text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="diamond_quantity" class="col-sm-2 col-form-label">Diamond Qty.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="diamond_quantity"
                                                value="{{ $user->propertyInfos->diamond_quantity ?? '' }}"
                                                placeholder="Diamond  Qty." class="form-control" id="diamond_quantity">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="diamond_price" class="col-sm-2 col-form-label">Diamond Price.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="diamond_price"
                                                value="{{ $user->propertyInfos->diamond_price ?? '' }}"
                                                placeholder="Diamond  Price." class="form-control" id="diamond_price">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="diamond_ownership_status" class="col-sm-2 col-form-label">Ownership
                                            Status</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="diamond_ownership_status"
                                                value="{{ $user->propertyInfos->diamond_ownership_status ?? '' }}"
                                                placeholder="Diamond Ownership Status" class="form-control"
                                                id="diamond_ownership_status">
                                        </div>
                                    </div>

                                </div>


                                <br><br>
                                {{-- Gold --}}
                                <div class="form-check d-flex mr-2">

                                    <label for="gold">
                                        <i class="fa fa-coins"></i>
                                        Have any gold?
                                    </label>
                                  
                                    <div class="toggle-button r toggle-button-1">
                                        <input type="checkbox" disabled class="checkbox" name="gold" id="gold" value="1"  {{ $user->propertyInfos ? ($user->propertyInfos->gold ? 'checked' : '') : '' }} />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                                <hr>

                                <div
                                    class="gold-property {{ $user->propertyInfos ? ($user->propertyInfos->gold ? '' : 'd-none') : 'd-none' }} ">
                                    <div class="form-group row">
                                        <label for="gold_type" class="col-sm-2 col-form-label">Gold Type</label>
                                        <div class="col-sm-9">
                                            <select name="gold_type" disabled class="form-control" id="gold_type">
                                                @foreach (property_constant_option('goldType') as $key => $text)
                                                    <option value="{{$key}}" {{ $user->propertyInfos ? ($user->propertyInfos->gold_type ==  $key ? 'selected' : '') : '' }}>{{$text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gold_quantity" class="col-sm-2 col-form-label">Gold Qty.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="gold_quantity"
                                                value="{{ $user->propertyInfos->gold_quantity ?? '' }}"
                                                placeholder="Gold  Qty." class="form-control" id="gold_quantity">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gold_price" class="col-sm-2 col-form-label">Gold Price.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="gold_price"
                                                value="{{ $user->propertyInfos->gold_price ?? '' }}"
                                                placeholder="Gold Price." class="form-control" id="gold_price">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gold_ownership_status" class="col-sm-2 col-form-label">Ownership
                                            Status</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="gold_ownership_status"
                                                value="{{ $user->propertyInfos->gold_ownership_status ?? '' }}"
                                                placeholder="Gold Ownership Status" class="form-control"
                                                id="gold_ownership_status">
                                        </div>
                                    </div>
                                </div>

                                <br><br>
                                {{-- Silver --}}
                                <div class="form-check d-flex mr-2">
                                    <label for="silver">
                                        <i class="fa fa-utensil-spoon"></i>
                                        Have any silver?
                                    </label>
                                   
                                    <div class="toggle-button r toggle-button-1">
                                        <input type="checkbox" disabled class="checkbox" name="silver" id="silver" value="1"  {{ $user->propertyInfos ? ($user->propertyInfos->silver ? 'checked' : '') : '' }} />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                                <hr>

                                <div
                                    class="silver-property {{ $user->propertyInfos ? ($user->propertyInfos->silver ? '' : 'd-none') : 'd-none' }}">

                                    <div class="form-group row">
                                        <label for="silver_type" class="col-sm-2 col-form-label">Silver Type</label>
                                        <div class="col-sm-9">
                                            <select name="silver_type" disabled class="form-control" id="silver_type">
                                                @foreach (property_constant_option('silverType') as $key => $text)
                                                    <option value="{{$key}}" {{ $user->propertyInfos ? ($user->propertyInfos->silver_type ==  $key ? 'selected' : '') : '' }}>{{$text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="silver_quantity" class="col-sm-2 col-form-label">Silver Qty.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="silver_quantity"
                                                value="{{ $user->propertyInfos->silver_quantity ?? '' }}"
                                                placeholder="Silver  Qty." class="form-control" id="silver_quantity">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="silver_price" class="col-sm-2 col-form-label">Silver Price.</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="silver_price"
                                                value="{{ $user->propertyInfos->silver_price ?? '' }}"
                                                placeholder="Silver Price." class="form-control" id="silver_price">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="silver_ownership_status" class="col-sm-2 col-form-label">Ownership
                                            Status</label>
                                        <div class="col-sm-9">
                                            <input type="text" disabled name="silver_ownership_status"
                                                value="{{ $user->propertyInfos->silver_ownership_status ?? '' }}"
                                                placeholder="Silver Ownership Status" class="form-control"
                                                id="silver_ownership_status">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="card-header">
                                <h6 class="card-title">Disability </h6>
                            </div>

                            <div class="disability-content {{(isset($user->disabilityInfo->is_disability) ?  (($user->disabilityInfo->is_disability == 1) ? '' : 'd-none')  : 'd-none')}}">


                                <div class="form-group row">
                                    <label for="disability_name_id" class="col-sm-2 col-form-label">Disability Name</label>
                                    <div class="col-sm-9">
                                        <select name="disability_name_id" disabled class="form-control" id="disability_name_id">
                                            <option value="">Select Disability Name</option>
                                            @foreach (disability_constant_option('disability_name') as $key=>$item)
                                                <option value="{{$key}}" {{isset($user->disabilityInfo->disability_name_id) ? (($user->disabilityInfo->disability_name_id == $key) ? 'selected' : '' ) : ''  }}>{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error disability_name_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="disability_category_id" class="col-sm-2 col-form-label">Disability
                                        Category</label>
                                    <div class="col-sm-9">
                                        <select name="disability_category_id" disabled class="form-control"
                                            id="disability_category_id">
                                            <option value="">Select Disability Category</option>
                                            @foreach (disability_constant_option('disability_category') as $key=>$item)
                                                <option value="{{$key}}" {{isset($user->disabilityInfo->disability_category_id) ? (($user->disabilityInfo->disability_category_id == $key) ? 'selected' : '' ) : ''  }} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error disability_category_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="disability_type_id" class="col-sm-2 col-form-label">Disability type</label>
                                    <div class="col-sm-9">
                                        <select name="disability_type_id" disabled class="form-control" id="disability_type_id">
                                            @foreach (disability_constant_option('disability_type') as $key=>$item)
                                                <option value="{{$key}}" {{isset($user->disabilityInfo->disability_type_id) ? (($user->disabilityInfo->disability_type_id == $key) ? 'selected' : '' ) : ''  }} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error disability_type_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group disability-date-content {{isset($user->disabilityInfo->disability_type_id) ? (($user->disabilityInfo->disability_type_id != 1 ) ? '' : 'd-none' ) : 'd-none'  }} row" id="disability-date-content">
                                    <label for="start_date" class="col-sm-2 col-form-label">Disability Start
                                        Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" disabled name="start_date" value="{{$user->disabilityInfo->start_date ?? ''}}" class="form-control"
                                            id="start_date">
                                            <small class="text-danger error start_date_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="treatment_status_id" class="col-sm-2 col-form-label">Treatment
                                        Status</label>
                                    <div class="col-sm-9">
                                        <select name="treatment_status_id" disabled class="form-control" id="treatment_status_id">
                                            @foreach (disability_constant_option('treatment_status') as $key => $item)
                                                <option value="{{$key}}"  {{isset($user->disabilityInfo->treatment_status_id) ? (($user->disabilityInfo->treatment_status_id == $key) ? 'selected' : '' ) : ''  }} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error treatment_status_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group treatment-doctor-content {{isset($user->disabilityInfo->treatment_status_id) ? (($user->disabilityInfo->treatment_status_id != 1 ) ? '' : 'd-none' ) : 'd-none'  }} row">
                                    <label for="disability_doctor" class="col-sm-2 col-form-label">Dr.Name/ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" disabled name="disability_doctor" value="{{$user->disabilityInfo->disability_doctor ?? ''}}"
                                            placeholder="Dr. Name/ID" class="form-control" id="disability_doctor">

                                            <small class="text-danger error disability_doctor_error"></small>

                                    </div>
                                </div>

                            </div>


                            <div class="card-header">
                                <h6 class="card-title">Freedom Fighter </h6>
                            </div>

                            <div class="fighter-content {{(isset($user->freedomFighterInfo->is_freedom_fighter) ?  (($user->freedomFighterInfo->is_freedom_fighter == 1) ? '' : 'd-none')  : 'd-none')}}">

                                
                                <div class="form-group row">
                                    <label for="type_id" class="col-sm-2 col-form-label">Freedom Fighter Type</label>
                                    <div class="col-sm-9">
                                        <select name="type_id" disabled class="form-control" id="type_id">
                                            <option value="">Select Type</option>
                                            @foreach (freedom_fighter_constant_option('type') as $key => $item)
                                                <option value="{{$key}}" {{isset($user->freedomFighterInfo->type_id) ? (($user->freedomFighterInfo->type_id == $key) ? 'selected' : '' ) : ''  }} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error type_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="area_id" class="col-sm-2 col-form-label">Freedom Fight Area</label>
                                    <div class="col-sm-9">
                                        <select name="area_id" disabled class="form-control" id="area_id">
                                            <option value="">Select Area</option>
                                            @foreach (freedom_fighter_constant_option('area') as $key => $item)
                                                <option value="{{$key}}" {{isset($user->freedomFighterInfo->area_id) ? (($user->freedomFighterInfo->area_id == $key) ? 'selected' : '' ) : ''  }} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error area_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="designation_id" class="col-sm-2 col-form-label">Designation</label>
                                    <div class="col-sm-9">
                                        <select name="designation_id" disabled class="form-control" id="designation_id">
                                            <option value="">Select Designation</option>
                                            @foreach (freedom_fighter_constant_option('designation') as $key => $item)
                                                <option value="{{$key}}" {{isset($user->freedomFighterInfo->designation_id) ? (($user->freedomFighterInfo->designation_id == $key) ? 'selected' : '' ) : ''  }} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error designation_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="freedom_fighter_id" class="col-sm-2 col-form-label"> Freedom Fighter ID </label>
                                    <div class="col-sm-9">
                                        <input type="text" disabled name="freedom_fighter_id" value="{{$user->freedomFighterInfo->freedom_fighter_id ?? ''}}" class="form-control" id="freedom_fighter_id">
                                        <small class="text-danger error freedom_fighter_id_error"></small>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="commander_name" class="col-sm-2 col-form-label">Commander Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" disabled name="commander_name" value="{{$user->freedomFighterInfo->commander_name ?? ''}}" class="form-control" id="commander_name">
                                        <small class="text-danger error commander_name_error"></small>

                                    </div>
                                </div>

                            </div>



                            

                        </div>
                       
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
@push('script')
    <script>
      
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function() {
            readURL(this);
        });
    </script>
@endpush
