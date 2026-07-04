<div class="card-body">

    <div class="form-group row">
        <label for="house" class="col-sm-2 col-form-label">Bank Name <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <input type="text" required name="house" value="{{$house->house ?? ''}}"  placeholder="House" class="form-control" id="house">
            <small class="text-danger error house_error"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="house_bn" class="col-sm-2 col-form-label">Bank Name (Bangla) <span class="text-danger" title="Required" data-toggle="tooltip">*</span></label>
        <div class="col-sm-9">
            <input type="text" required name="house_bn" value="{{$house->house_bn ?? ''}}" placeholder="House Bangla" class="form-control" id="house_bn">
            <small class="text-danger error house_bn_error"></small>
        </div>
    </div>
</div>