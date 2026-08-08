@push('style')
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('public/plugins')}}/fontawesome-free/css/all.min.css">
@endpush
<div class="panel-body">
    <div class="form-group row">
        <div class="col-md-3">
            <label for="father_name">Father Name</label>
            <input type="text" value="" class="form-control" name="father_name" id="father_name"
                placeholder="Father Name">
            <small class="error father_name-error text-danger"></small>
        </div>

        <div class="col-md-3">
            <label for="father_name_bn">Father Name In Bengali</label>
            <input type="text" value="" class="form-control" name="father_name_bn" id="father_name_bn"
                placeholder="Father Name In Bengali">
            <small class="error father_name_bn-error text-danger"></small>
        </div>

        <div class="col-md-3">
            <label for="father_live_status">Father's Live Status</label>
            <select name="father_live_status" class="form-control" id="father_live_status">
                @foreach (family_constant_option('live_status') as $key => $status)
                    <option value="{{$key}}" {{$key == 1 ? 'selected' : ''}}>{{$status}}</option>
                @endforeach
            </select>
            <small class="error father_live_status-error text-danger"></small>
        </div>

        <div class="col-md-3">
            <label for="father_nid">Father's NID</label>
            <input type="text" value="" class="form-control" name="father_nid" id="father_nid" placeholder="Father's NID">
            <small class="error father_nid-error text-danger"></small>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <label for="mother_name">Mother Name</label>
            <input type="text" value="" class="form-control"
                name="mother_name" id="mother_name" placeholder="Mother Name">
            <small class="error mother_name-error text-danger"></small>
        </div>

        <div class="col-md-3">
            <label for="mother_name_bn">Mother Name In Bangla</label>
            <input type="text" value="" class="form-control"
                name="mother_name_bn" id="mother_name_bn"
                placeholder="Mother Name In Bangla">
            <small class="error mother_name_bn-error text-danger"></small>
        </div>

        <div class="col-md-3">
            <label for="mother_live_status">Mother's Live Status</label>
            <select name="mother_live_status" class="form-control" id="mother_live_status">
                @foreach (family_constant_option('live_status') as $key => $status)
                    <option value="{{$key}}" {{$key == 1 ? 'selected' : ''}}>{{$status}}</option>
                @endforeach
            </select>
            <small class="error mother_live_status-error text-danger"></small>
        </div>

        <div class="col-md-3">
            <label for="mother_nid">Mother's NID</label>
            <input type="text" value="" class="form-control" name="mother_nid" id="mother_nid" placeholder="Mother's NID">
            <small class="error mother_nid-error text-danger"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="maritalStatus" class="col-sm-2 col-form-label">Marital Status</label>
        <div class="col-sm-2">
            <select name="marital_status" class="form-control" id="maritalStatus">
                @foreach (family_constant_option('marital_status') as $key => $marital_status)
                    <option value="{{$key}}">{{$marital_status}}</option>
                @endforeach
            </select>
            <small class="text-danger error marital_status_error"></small>
        </div>
    </div>

    <div class="table-responsive marital_status_content d-none">
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
                    <td><input type="text" name="spouse[name]" class="form-control"  value=""> </td>
                    <td><input type="text" name="spouse[profession]" class="form-control"  value=""></td>
                    <td><input type="date" name="spouse[date]" class="form-control"  value=""></td>
                    <td><input type="text" name="spouse[id]" class="form-control"  value=""></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="form-check row marital_status_content d-none">
        <label for="haveChildren"><input type="checkbox" value="1" name="have_children" class="form-check-input" id="haveChildren">&nbsp;&nbsp;&nbsp;&nbsp;Have any children?</label>

        <div class="table-responsive have_children_content d-none">
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
                    <tr>
                        <td class="sl-child">1</td>
                        <td><input type="text" class="form-control" name="children[{{ $unique_id }}][name]"></td>
                        <td><input type="text" class="form-control" name="children[{{ $unique_id }}][profession]" value="{{ $info['profession'] ?? '' }}"></td>
                        <td><input type="date" class="form-control" name="children[{{ $unique_id }}][date]"></td>
                        <td><input type="text" class="form-control" name="children[{{ $unique_id }}][id]"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeChildren"><i class="fa fa-times"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@push('script')
<script>
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
                                    <td class="sl-child">1</td>
                                    <td><input type="text" class="form-control" name="children[${uniqueId}][name]"></td>
                                    <td><input type="text" class="form-control" name="children[${uniqueId}][profession]"></td>
                                    <td><input type="date" class="form-control" name="children[${uniqueId}][date]"></td>
                                    <td><input type="text" class="form-control" name="children[${uniqueId}][id]"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeChildren"><i class="fa fa-times"></i></button></td>
                                </tr>`;
            $("#childrenBody").append(newChildren);
            updateChildrenSerial();
        })

        $(document).on('click', '.removeChildren', function(e){
            e.preventDefault();
            $(this).closest('tr').remove();
            updateChildrenSerial();
        })

        function updateChildrenSerial() {
            $(".sl-child").each(function(index) {
                $(this).text(index + 1);
            });
        }
</script>
@endpush
