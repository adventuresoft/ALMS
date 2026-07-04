<div class="card-body">
    <div class="form-group row">
        <label for="en_name" class="col-sm-3 col-form-label">Bank Name <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <input type="text" required name="en_name" value="{{$bank->en_name ?? ''}}"  placeholder="Bank" class="form-control" id="en_name">
            <small class="text-danger error en_name_error"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="bn_name" class="col-sm-3 col-form-label">Bank Name (Bangla) <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <input type="text" required name="bn_name" value="{{$bank->bn_name ?? ''}}" placeholder="Bank Bangla" class="form-control" id="bn_name">
            <small class="text-danger error bn_name_error"></small>
        </div>
    </div>
</div>
