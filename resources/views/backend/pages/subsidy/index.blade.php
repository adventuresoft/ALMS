@extends('backend.master', ['mainMenu' => 'Subsidy', 'subMenu' =>'SubsidyList'])
@section('content')
<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Subsidy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Subsidy</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Subsidy List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            
                            <form method="GET" class="mb-3 row">
                                
                                <div class="col-md-2">
                                    <select name="division_id" id="division_id" class="form-control">
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="">Select District</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="thana_id" id="thana_id" class="form-control thana_id">
                                        <option value="">Select Thana</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                    @if(request('search') || request('district_id'))
                                        <a  class="btn btn-danger" href="{{route('subsidy.index')}}">Reset</a>
                                    @endif
                                </div>

                            </form>
                            
                            
                            <table id="farmer_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>ID & Name</th>
                                        <th>Mobile & Email</th>
                                        <th>Location</th>
                                        <th>Amount</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th style="width: 100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($subsidies))
                                        @foreach ($subsidies as $key => $subside)
                                            @if($subside and isset($subside->user->system_id) )
                                                <tr>
                                                    <td> {{$loop->iteration}}</td>
                                                    <td>{{ $subside->user->name ?? '' }}<br>@can('subsidy-view-update')
<a href="{{ route('subsidy.edit', $subside->id) }}">{{ $subside->user->system_id ?? '' }}</a>
@endcan</td>
                                                    <td>
                                                        @php
                                                            $mobile = $subside->user->mobile ? (''.$subside->user->mobile.'') : '';
                                                            $email =  $subside->user->email ? ('<br>'.$subside->user->email.'') : '';
                                                        @endphp
                                                        {!!$mobile!!}
                                                        {!!$email!!}
                                                    </td>
                                                    <td>{{$subside?->user?->addressInfo->permanent_area ? $subside?->user?->addressInfo->permanent_area : $subside?->user?->addressInfo->present_area}}</td>
                                                    <td>{{$subside->amount}}</td>
                                                    <td>{{$subside->financial_year ? financialYears($subside->financial_year) : '' }}</td>
                                                    <td>{{$subside->status ? loanStatuses($subside->status) : ''}}</td>
                                                    <td >
                                                        <div class="">
                                                            {{-- <a href="{{ route('loan-info.show', $subside->id) }}" title="View" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                            {{-- <a href="{{ route('loan-payment.show', $subside->id) }}" title="Payment" data-toggle="tooltip" class="btn btn-sm btn-success"><i class="fa fa-money-bill"></i></a> --}}
                                                            @can('subsidy-view-update')
                                                            <a href="{{ route('subsidy.edit', $subside->id) }}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></a>
                                                            @endcan
                                                            @if ($subside->status == 'pending')
                                                                @can('subsidy-view-delete')
                                                                <form class="deleteFarmer" action="{{route('subsidy.destroy', $subside->id)}}" method="post" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('Delete')
                                                                    <button type="submit" class="btn btn-sm btn-danger mt-1" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                                @endcan
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                            
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                Showing {{ $subsidies->firstItem() }} to {{ $subsidies->lastItem() }} of {{ $subsidies->total() }}
    
                                {{$subsidies->links()}}
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
        </div>
    </section>
</div><!-- /.container-fluid -->

@endsection

@push('js')
    <script>
        let division_id_search = "{{request('division_id')}}";
        let district_id_search = "{{request('district_id')}}";
        let thana_id_search = "{{request('thana_id')}}";
        
         $(document).ready(function() {
            // $("#farmer_table").DataTable({
            //     "paging": false,
            //     "filter": false
            // })
            
            if (division_id_search) {
                $("#division_id").val(division_id_search).trigger('change');
            }
        })
        
        $(".deleteFarmer").submit(function(e) {
                e.preventDefault();
                var thisForm = $(this);
                var formData = thisForm.serialize();
                var deleteUrl = thisForm.attr('action');
                $("#toast-container").show();
                toastr.success(
                    "<br /><button type='button' id='confirmationRevertNo' class='btn clear'>No</button><br /><button type='button' id='confirmationRevertYes' class='btn clear'>Yes</button>",
                    'Are you sure, you want to delete it?', {
                        closeButton: false,
                        allowHtml: true,
                        onShown: function(toast) {
                            $("#confirmationRevertYes").click(function() {
                                $.ajax({
                                    type: "POST",
                                    url: deleteUrl,
                                    data: formData,
                                    beforeSend: function() {
                                        thisForm.find('button[type="submit"]').prop("disabled", true);
                                    },
                                    success: function(response) {
                                        thisForm.find('button[type="submit"]').prop("disabled", false);
                                        toastr.success(response.message);
                                        setTimeout(function() {location.reload();},2000);
                                    },
                                    error: function(xhr, status, error) {
                                        thisForm.find('button[type="submit"]').prop("disabled", false);
                                        var responseText = jQuery.parseJSON(xhr.responseText);
                                        toastr.error(responseText.message);
                                    }
                                });
                            });
                            $("#confirmationRevertNo").click(function() {
                                $("#toast-container").hide();
                            })
                        }
                    });
            })
    </script>
    
    <script>
        $(document).on('change', '#division_id', function(e) {
            e.preventDefault();
            let district_id = $('#district_id')
            let division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-districts-by-division') }}/" + division_id,
                    beforeSend: function() {
                        district_id.prop("disabled", true);
                        console.log("Searching Districts");
                    },
                    success: function(response) {
                        district_id.html(response)
                        district_id.prop("disabled", false);
                         if (district_id_search) {
                            $("#district_id").val(district_id_search).trigger('change');
                        }
                        
                        
                    },
                    error: function(xhr, status, error) {
                        district_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                district_id.prop("disabled", true);
            }
        })

        $(document).on('change', '#district_id', function(e) {
            e.preventDefault();
            let district_id = $(this).val();
            let present_thana_id = $("#thana_id");

            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-thanas-by-district') }}/" + district_id,
                    beforeSend: function() {
                        present_thana_id.prop("disabled", true);
                        console.log("Searching Thana");
                    },
                    success: function(response) {
                        present_thana_id.html(response)
                        present_thana_id.prop("disabled", false);
                        
                        if (thana_id_search) {
                            $("#thana_id").val(thana_id_search);
                        }
                    },
                    error: function(xhr, status, error) {
                        present_thana_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                present_thana_id.prop("disabled", true);
            }

        })
    </script>
    
@endpush
