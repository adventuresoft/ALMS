<div class="panel-body">
    <div class="form-group row">
        <div class="col-md-4">
            <label for="name">Name <span class="text-danger" title="Required"
                    data-toggle="tooltip">*</span></label>
            <input type="text" required value="" class="form-control"
                name="name" id="name" placeholder="Name English">
            <small class="error name-error text-danger"></small>
        </div>

        <div class="col-md-4">
            <label for="bn_name">Name In Bangla <span class="text-danger"
                    title="Required" data-toggle="tooltip">*</span></label>
            <input type="text" required value="" class="form-control"
                name="bn_name" id="bn_name" placeholder="Name In Bangla">
            <small class="error bn_name-error text-danger"></small>
        </div>

        <div class="col-md-4">
            <label for="gender">Gender</label>
            <select name="gender" class="form-control" id="gender">
                <option value="">Select Gender</option>
                @if (count(people_constant_option('gender')))
                    @foreach (people_constant_option('gender') as $key => $item)
                        <option value="{{ $key }}">{{ $item }}
                        </option>
                    @endforeach
                @endif
            </select>
            <small class="error gender-error text-danger"></small>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="email">Email</label>
            <input type="email" value="" name="email"
                placeholder="Email" class="form-control" id="email">
            <small class="error email-error text-danger"></small>
        </div>
        <div class="col-md-4">
            <label for="mobile">Mobile <span class="text-danger"
                    title="Required" data-toggle="tooltip">*</span></label>
            <input type="tel" pattern="(01){1}[3-9]{1}\d{8}"
                    title="Mobile number with 01 and remaining 9 digit with 0-9"
                    placeholder="01........." required name="mobile"
                    class="form-control" id="mobile">
                <small class="error mobile-error text-danger"></small>
        </div>
        <div class="col-md-4">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" required value="" name="date_of_birth"
                class="form-control" id="date_of_birth">
            <small class="error date_of_birth-error text-danger"></small>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <label for="birth_certificate">Birth Reg. No.</label>
            <input type="text" value="" name="birth_certificate"
                placeholder="0000000000000" class="form-control"
                id="birth_certificate">
            <small class="error birth_certificate-error text-danger"></small>
        </div>
        <div class="col-md-4">
            <label for="nid" class="">NID No. </label>
            <input type="text" value="" name="nid"
                placeholder="000 000 0000" class="form-control" id="nid">
            <small class="error nid-error text-danger"></small>
        </div>
        <div class="col-md-4">
            <label for="image">Photo </label>
            <input type="file" name="image" style="padding: 3px 12px;" accept="image/*" class="form-control image" id="image">
            <small class="error image-error text-danger"></small>
        </div>
    </div>
</div>
