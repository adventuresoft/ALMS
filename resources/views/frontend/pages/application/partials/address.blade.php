<div class="panel-body">
    <div class="form-gorup row" style="background:azure !important">
        <div class="col-md-12">
            <p>Permanent Address:</p>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="permanent_division">Permanent Division</label>
            <select name="permanent_division" class="form-control" id="permanent_division">
                <option value="">Select Permanent Division</option>
                @if (count($divisions))
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-4">
            <label for="permanent_district">Permanent District</label>
            <select name="permanent_district" class="form-control" id="permanent_district">
                <option value="">Select Permanent District</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="permanent_thana">Permanent Thana</label>
            <select name="permanent_thana" class="form-control" id="permanent_thana">
                <option value="">Select Permanent Thana</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <label for="permanent_union">Permanent Union</label>
            <select name="permanent_union" class="form-control" id="permanent_union">
                <option value="">Select Permanent Union</option>
            </select>
        </div>
        <div class="col-sm-8">
            <label for="permanent_area">Address</label>
            <textarea id="permanent_area" rows="1" class="form-control" name="permanent_area" placeholder="Full Address"></textarea>
            <small class="text-danger error permanent_area_error"></small>
        </div>
    </div>

    <div class="form-group row " style="background-color:azure !important">
        <div class="col-md-6" style="background-color:azure !important">
            <p>Present Address: </p>
        </div>
        <div class="col-md-6" style="background-color:azure !important">
            <label>Same as permanent address? <input type="checkbox" name="same_present_addres"
                    id="same_as_present_address" /></label>
        </div>
    </div>

    <div id="same-as-permanent-address-section">
        <div class="form-group row">
            <div class="col-md-4">
                <label for="present_division">Present Division</label>
                <select name="present_division" class="form-control" id="present_division">
                    <option value="">Select Present Division</option>
                    @if (count($divisions))
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">
                                {{ $division->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="present_district">Present District</label>
                <select name="present_district" class="form-control" id="present_district">
                    <option value="">Select Present District</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="present_thana">Present Thana</label>
                <select name="present_thana" class="form-control" id="present_thana">
                    <option value="">Select Present Thana</option>
                </select>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-4">
                <label for="present_union">Present Union</label>
                <select name="present_union" class="form-control" id="present_union">
                    <option value="">Select Present Union</option>
                </select>
            </div>
            <div class="col-md-8">
                <label for="present_area">Address</label>
                <textarea id="present_area" rows="1" class="form-control" name="present_area" placeholder="Full Address"></textarea>
                <small class="text-danger error present_area_error"></small>
            </div>
        </div>
    </div>
</div>
