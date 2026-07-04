<tr>
    <td class="sl land-sl">1</td>
    <td><input type="text" required class="form-control" placeholder="Usage purpose" value="{{$land->land_type ?? ''}}" name="land_type[]"></td>
    <td><input type="text" required class="form-control" value="{{$land->division ?? ''}}" name="division[]"></td>
    <td><input type="text" required class="form-control" value="{{$land->district ?? ''}}" name="district[]"></td>
    <td><input type="text" required class="form-control" value="{{$land->thana ?? ''}}" name="thana[]"></td>

    <td><input type="text" required class="form-control" placeholder="BRS Mouza" value="{{$land->mouza ?? ''}}" name="mouza[]"></td>
    <td><input type="text" required class="form-control" placeholder="BRS Dag" value="{{$land->dag_no ?? ''}}" name="dag_no[]"></td>
    <td><input type="text" required class="form-control" placeholder="BRS Khatian" value="{{$land->khatiyan_no ?? ''}}" name="khatiyan_no[]"></td>
    <td><input type="text" required class="form-control land-quantity text-right" value="{{$land->land_quantity ?? ''}}" name="land_quantity[]"></td>

    <td><button type="button" class="btn btn-sm btn-danger remove-land-item"><i class="fa fa-minus-circle"></i></button></td>
</tr>
