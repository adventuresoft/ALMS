<tr>
    <td>
        <select class="form-control" name="crop[]">
            <option value="">Select Cultivation</option>
            @if (count($crops))
                @foreach ($crops as $crop)
                    <option {{isset($cultivation->crop) && ($cultivation->crop == $crop->name) ? 'selected' : '' }} value="{{ $crop->name }}">{{ $crop->name }}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td>
        <select class="form-control" name="land_owner[]">
            <option {{isset($cultivation->land_owner) && ($cultivation->land_owner == "own") ? 'selected' : '' }} value="own">Owner</option>
            <option {{isset($cultivation->land_owner) && ($cultivation->land_owner == "lease") ? 'selected' : '' }} value="lease">Lease</option>
            <option {{isset($cultivation->land_owner) && ($cultivation->land_owner == "rental") ? 'selected' : '' }} value="rental">Rental</option>
        </select>
    </td>
    <td><input type="text" class="form-control" value="{{$cultivation->quantity ?? ''}}" name="quantity[]"></td>
    <td>
        <textarea name="address[]" class="form-control" rows="1"  placeholder="Address">{{$cultivation->address ?? ''}}</textarea>
    </td>
    <td>
        <textarea name="description[]" class="form-control" rows="1" placeholder="Description">{{$cultivation->description ?? ''}}</textarea>
    </td>
    <td><button type="button" class="btn btn-sm btn-danger remove-cultivation-item"><i class="fa fa-minus-circle"></i></button></td>
</tr>
