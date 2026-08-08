@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'FarmerCreate'])
@section('title', 'Farmer Create')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Farmer Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('farmer.index') }}">Farmer</a></li>
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
                            @include('backend.pages.farmer.tabs.tab_header', ['user' => $user, 'active_tab' => 'family'])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="farmerFamilyForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="fatherName" class="col-sm-2 col-form-label">Father's Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="father_name" value="{{$user->familyInfo->father_name ?? ''}}" class="form-control" id="fatherName" placeholder="Father's Name">
                                        <small class="text-danger error father_name_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fatherNameBn" class="col-sm-2 col-form-label">Father's Name (Bangla)</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="father_name_bn" value="{{$user->familyInfo->father_name_bn ?? ''}}" class="form-control" id="fatherNameBn" placeholder="Father's Name (Bangla)">
                                        <small class="text-danger error father_name_bn_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fatherNID" class="col-sm-2 col-form-label">Father's NID</label>
                                    <div class="col-sm-10">
                                        <input type="text" maxlength="17" name="father_nid" class="form-control" id="fatherNID"  value="{{$user->familyInfo->father_nid ?? ''}}"  placeholder="Father's NID">
                                        <small class="text-danger error father_nid_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fatherLiveStatus" class="col-sm-2 col-form-label">Father's Live Status</label>
                                    <div class="col-sm-10">
                                        <select name="father_live_status" class="form-control" id="fatherLiveStatus">
                                            @foreach (family_constant_option('live_status') as $key => $status)
                                                <option value="{{$key}}" {{$user->familyInfo ? (($user->familyInfo->father_live_status == $key) ? 'selected' : '') : (($key == 1) ? 'selected' : '')}}>{{$status}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error father_live_status_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="motherName" class="col-sm-2 col-form-label">Mother's Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mother_name" id="motherName"  value="{{$user->familyInfo->mother_name ??''}}"  placeholder="Mother's Name">
                                        <small class="text-danger error mother_name_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="motherNameBn" class="col-sm-2 col-form-label">Mother's Name (Bangla)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mother_name_bn" id="motherNameBn"  value="{{$user->familyInfo->mother_name_bn ?? ''}}"  placeholder="Mother's Name (Bangla)">
                                        <small class="text-danger error mother_name_bn_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="motherNID" class="col-sm-2 col-form-label">Mother's NID</label>
                                    <div class="col-sm-10">
                                        <input type="text" maxlength="17" name="mother_nid" class="form-control" id="motherNID"  value="{{$user->familyInfo->mother_nid ?? ''}}" placeholder="Mother's NID">
                                        <small class="text-danger error mother_nid_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="motherLiveStatus" class="col-sm-2 col-form-label">Mother's Live Status</label>
                                    <div class="col-sm-10">
                                        <select name="mother_live_status" class="form-control" id="motherLiveStatus">
                                            @foreach (family_constant_option('live_status') as $key => $status)
                                                <option value="{{$key}}" {{$user->familyInfo ? (($user->familyInfo->mother_live_status == $key) ? 'selected' : '') : (($key == 1) ? 'selected' : '')}}>{{$status}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error mother_live_status_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="maritalStatus" class="col-sm-2 col-form-label">Marital Status</label>
                                    <div class="col-sm-10">
                                        <select name="marital_status" class="form-control" id="maritalStatus">
                                            @foreach (family_constant_option('marital_status') as $key => $marital_status)
                                                <option value="{{$key}}" {{$user->familyInfo ? (($user->familyInfo->marital_status == $key) ? 'selected' : '') : ''}}>{{$marital_status}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error marital_status_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row marital_status_content {{(isset($user->familyInfo->marital_status) && $user->familyInfo->marital_status == 2) ? : 'd-none'}}">
                                    @php
                                        $spouse = isset($user->familyInfo->spouse) && !is_null($user->familyInfo->spouse) ? json_decode($user->familyInfo->spouse, true) : [];
                                    @endphp
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Spouse Name</th>
                                                <th>Profession</th>
                                                <th>Date of Birth</th>
                                                <th>Birth Certificate/NID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" name="spouse[name]" class="form-control"  value="{{$spouse['name'] ?? ''}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="spouse[profession]" class="form-control"  value="{{$spouse['profession'] ?? ''}}">
                                                </td>
                                                <td>
                                                    <input type="date" name="spouse[date]" class="form-control"  value="{{$spouse['date'] ?? ''}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="spouse[id]" class="form-control"  value="{{$spouse['id'] ?? ''}}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-check row marital_status_content {{$user->familyInfo ? ( ($user->familyInfo->marital_status == 1) ? 'd-none' : 'block') : 'd-none'}}">
                                    <input type="checkbox" value="1" {{$user->familyInfo ? ($user->familyInfo->have_children ? "checked" : "") : ""}} name="have_children" class="form-check-input" id="haveChildren">
                                    <label for="haveChildren" class=" form-check-label"> Have any children?</label>


                                    <div class="form-group row have_children_content {{$user->familyInfo ? ($user->familyInfo->have_children ? 'block' : 'd-none') : 'd-none'}}">
                                        @php
                                            $unique_id = round(microtime(true) * 1000);
                                        @endphp
                                        <table class="table table-bordered have_children_content">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Name</th>
                                                    <th>Profession</th>
                                                    <th>Date of Birth</th>
                                                    <th>Birth Certificate/NID</th>
                                                    <th><button type="button" id="addChildren" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody id="childrenBody">
                                                @if (isset($user->familyInfo->children) && !is_null($user->familyInfo->have_children))

                                                    @php
                                                        $children_infos = json_decode($user->familyInfo->children, true);
                                                    @endphp

                                                    @if (!empty($children_infos))
                                                        @foreach ($children_infos as $c_key => $info)
                                                            <tr>
                                                                <td class="sl">{{ $loop->iteration }}</td>
                                                                <td><input type="text" class="form-control" name="children[{{ $c_key }}][name]" value="{{ $info['name'] ?? '' }}"></td>
                                                                <td><input type="text" class="form-control" name="children[{{ $c_key }}][profession]" value="{{ $info['profession'] ?? '' }}"></td>
                                                                <td><input type="date" class="form-control" name="children[{{ $c_key }}][date]" value="{{ $info['date'] ?? '' }}"></td>
                                                                <td><input type="text" class="form-control" name="children[{{ $c_key }}][id]" value="{{ $info['id'] ?? '' }}"></td>
                                                                <td><button type="button" class="btn btn-danger btn-sm removeChildren"><i class="fa fa-times"></i></button></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif


                                                @else
                                                    <tr>
                                                        <td class="sl">1</td>
                                                        <td><input type="text" class="form-control" name="children[{{ $unique_id }}][name]"></td>
                                                        <td><input type="text" class="form-control" name="children[{{ $unique_id }}][profession]" value="{{ $info['profession'] ?? '' }}"></td>
                                                        <td><input type="date" class="form-control" name="children[{{ $unique_id }}][date]"></td>
                                                        <td><input type="text" class="form-control" name="children[{{ $unique_id }}][id]"></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm removeChildren"><i class="fa fa-times"></i></button></td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                {{-- <div class="form-group row have_children_content {{$user->familyInfo ? ($user->familyInfo->have_children ? 'block' : 'd-none') : 'd-none'}}">
                                    <label for="girls" class="col-sm-2 col-form-label">
                                        Number of Girls
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="girls" id="girls" value="{{$user->familyInfo->girls ?? ''}}"  placeholder="Number of Girls" />
                                        <small class="text-danger error girls_error"></small>

                                    </div>
                                </div> --}}
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <a href="{{route('farmer.edit', $user->id)}}" class="btn btn-danger btn-block"> Personal</a>

                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success btn-block">Save & Next</button>
                                    </div>

                                    <div class="col-sm-3">
                                        <a href="{{route('farmer.address',$user->id)}}" class="btn btn-primary btn-block ">Address </a>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-footer -->
                        </form>
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
        // Convert Bangla digits to English digits
        function convertBanglaToEnglishNumber(str) {
            const banglaDigits = {'০':'0','১':'1','২':'2','৩':'3','৪':'4','৫':'5','৬':'6','৭':'7','৮':'8','৯':'9'};
            return str.replace(/[০-৯]/g, function(w) {
                return banglaDigits[w];
            });
        }

        $(document).ready(function() {
            // English-only input constraint for Father's / Mother's Name
            $('#fatherName, #motherName').on('input', function() {
                this.value = this.value.replace(/[^a-zA-Z\s\.\-\(\)]/g, '');
            });

            // Bangla-only input constraint for Father's / Mother's Name (Bangla)
            $('#fatherNameBn, #motherNameBn').on('keypress', function(e) {
                const char = String.fromCharCode(e.which);
                const isBangla = /^[\u0980-\u09FF\s\.\-\(\)]+$/.test(char);
                if (!isBangla) {
                    e.preventDefault();
                }
            });

            $('#fatherNameBn, #motherNameBn').on('input', function() {
                this.value = this.value.replace(/[^\u0980-\u09FF\s\.\-\(\)]/g, '');
            });

            // English numbers only, automatic conversion, and max 17 digits for Father's / Mother's NID
            $('#fatherNID, #motherNID').on('input', function() {
                let val = convertBanglaToEnglishNumber(this.value);
                val = val.replace(/[^0-9]/g, '');
                if (val.length > 17) {
                    val = val.slice(0, 17);
                }
                this.value = val;
            });

            $("#farmerFamilyForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);

                // Client-side validations
                let fatherName = $('#fatherName').val().trim();
                let motherName = $('#motherName').val().trim();
                let fatherNameBn = $('#fatherNameBn').val().trim();
                let motherNameBn = $('#motherNameBn').val().trim();
                let fatherNid = $('#fatherNID').val().trim();
                let motherNid = $('#motherNID').val().trim();

                thisForm.find('.error').html(''); // Clear previous errors
                let hasError = false;

                if (fatherName && !/^[a-zA-Z\s\.\-\(\)]+$/.test(fatherName)) {
                    thisForm.find('.father_name_error').text("Father's Name must contain only English characters.");
                    hasError = true;
                }

                if (fatherNameBn && !/^[\u0980-\u09FF\s\.\-\(\)]+$/.test(fatherNameBn)) {
                    thisForm.find('.father_name_bn_error').text("Father's Name (Bangla) must contain only Bangla characters.");
                    hasError = true;
                }

                if (motherName && !/^[a-zA-Z\s\.\-\(\)]+$/.test(motherName)) {
                    thisForm.find('.mother_name_error').text("Mother's Name must contain only English characters.");
                    hasError = true;
                }

                if (motherNameBn && !/^[\u0980-\u09FF\s\.\-\(\)]+$/.test(motherNameBn)) {
                    thisForm.find('.mother_name_bn_error').text("Mother's Name (Bangla) must contain only Bangla characters.");
                    hasError = true;
                }

                if (fatherNid && (fatherNid.length < 10 || fatherNid.length > 17)) {
                    thisForm.find('.father_nid_error').text("Father's NID must be between 10 and 17 digits.");
                    hasError = true;
                }

                if (motherNid && (motherNid.length < 10 || motherNid.length > 17)) {
                    thisForm.find('.mother_nid_error').text("Mother's NID must be between 10 and 17 digits.");
                    hasError = true;
                }

                if (hasError) {
                    toastr.error('Please correct the validation errors before submitting.');
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('farmer.familyStore') }}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        thisForm.find('button[type="submit"]').prop("disabled", true);
                        $('.error').text('');
                    },
                    success: function(response) {
                        thisForm.find('button[type="submit"]').prop("disabled", false);
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000)
                    },
                    error: function(xhr, status, error) {
                        thisForm.find('button[type="submit"]').prop("disabled", false);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                        $.each(responseText.errors, function(key, val) {
                            thisForm.find("." + key + "_error").text(val[0]);
                        });
                    }
                });
            })
        })

        $(document).on('change', '#maritalStatus', function(e){
            let maritalStaus = $(this).val();
            if (maritalStaus == 2) {
                $('.marital_status_content').removeClass('d-none');
            } else{
                $('.marital_status_content').addClass('d-none');
            }
        })

        $(document).on('change', '#haveChildren', function(e){
            e.preventDefault();
            if (this.checked) {
                $('.have_children_content').removeClass('d-none');
            } else {
                $('.have_children_content').addClass('d-none');
            }
        })

        $(document).on('click', '#addChildren', function(e){

            e.preventDefault();
            const uniqueId =  Date.now();
            let newChildren = `<tr>
                                    <td class="sl">1</td>
                                    <td><input type="text" class="form-control" name="children[${uniqueId}][name]"></td>
                                    <td><input type="text" class="form-control" name="children[${uniqueId}][profession]"></td>
                                    <td><input type="date" class="form-control" name="children[${uniqueId}][date]"></td>
                                    <td><input type="text" class="form-control" name="children[${uniqueId}][id]"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeChildren"><i class="fa fa-times"></i></button></td>
                                </tr>`;
            $("#childrenBody").append(newChildren);
            updateSerial();
        })

        $(document).on('click', '.removeChildren', function(e){
            e.preventDefault();
            $(this).closest('tr').remove();
            updateSerial();
        })

        function updateSerial() {
            $(".sl").each(function(index) {
                $(this).text(index + 1);
            });
        }



    </script>
@endpush
