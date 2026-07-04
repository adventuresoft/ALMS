<div class="card-body">
    <div class="form-group row">
        <label for="bank_id" class="col-sm-3 col-form-label">Bank <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <select name="bank_id" class="form-control" id="bank_id">
                <option value="">Select Bank</option>
                @foreach ($banks as $bank)
                    <option {{ (isset($branch->bank_id) && $bank->id == $branch->bank_id) ? 'selected' : '' }} value="{{$bank->id}}">{{$bank->en_name}}</option>
                @endforeach
            </select>
            <small class="text-danger error bank_id_error"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="district_id" class="col-sm-3 col-form-label">District <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <select name="district_id" class="form-control" id="district_id">
                <option value="">Select District</option>
                @foreach ($districts as $district)
                    <option {{ (isset($branch->district_id) && $district->id == $branch->district_id) ? 'selected' : '' }} value="{{$district->id}}">{{$district->name}}</option>
                @endforeach
            </select>
            <small class="text-danger error district_id_error"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="en_name" class="col-sm-3 col-form-label">Branch Name <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <input type="text" required name="en_name" value="{{$branch->en_name ?? ''}}"  placeholder="Branch" class="form-control" id="en_name">
            <small class="text-danger error en_name_error"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="bn_name" class="col-sm-3 col-form-label">Branch Name (Bangla) <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <input type="text" required name="bn_name" value="{{$branch->bn_name ?? ''}}" placeholder="Branch Bangla" class="form-control" id="bn_name">
            <small class="text-danger error bn_name_error"></small>
        </div>
    </div>
</div>
