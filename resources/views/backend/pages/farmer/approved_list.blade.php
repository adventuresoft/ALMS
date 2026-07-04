@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'ApprovedFarmer'])
@push('style')
    <style>
        #farmer_table_wrapper .dataTables_filter {
            float: right;
        }

        #farmer_table_wrapper .dataTables_paginate {
            float: right;
        }
    </style>
@endpush
@section('title', 'Farmer View')
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
                        <li class="breadcrumb-item active">View</li>
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
                        <div class="card-header ">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">Farmer List</h3>
                                </div>
                                <div class="text-right">
                                    <a href="{{route('farmer-show-all')}}?status=true" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
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
                                        <a  class="btn btn-danger" href="{{route('farmer.index')}}">Reset</a>
                                    @endif
                                </div>

                            </form>
                            <table id="farmer_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>ID & Name</th>
                                        <th>Mobile & Email</th>
                                        <th>Gender & DOB</th>
                                        <th>Address</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($farmers)
                                        @foreach ($farmers as $key => $farmer)
                                        
                                         @php 
                                        $loanstaus=1;
                                        foreach($farmer->user?->loanInfos as $loanInfo){
                                            $loanstaus=$loanInfo->status;
                                            if($loanstaus=='paid'){
                                                $loanstaus=1;
                                                break;
                                            }else{
                                             $loanstaus=0;   
                                            }
                                        }
                                        
                                        @endphp 
                                        
                                            <tr>
                                                <td>{{ $loop->iteration + ($farmers->currentPage() - 1) * $farmers->perPage() }}</td>
                                                <td>
                                                    {{ $farmer->user->name ?? '' }}
                                                    <br><a href="{{ route('farmer.edit', $farmer->user->id) }}">{{ $farmer->user->system_id ?? '' }}</a>  
                                                </td>
                                                <td>
                                                    @php
                                                        $mobile = $farmer->user->mobile ? (''.$farmer->user->mobile.'') : '';
                                                        $email =  $farmer->user->email ? ('<br>'.$farmer->user->email.'') : '';
                                                    @endphp
                                                    {!!$mobile!!}
                                                    {!!$email!!}
                                                </td>
                                                <td>
                                                    @php
                                                        $gender = people_constant_option('gender');
                                                    @endphp
                                                    {{ $gender[$farmer->gender] ?? ''  }}<br>
                                                    {{ $farmer->date_of_birth ?? '--' }}
                                                </td>
                                                <td>
                                                    {{$farmer->user->addressInfo->presentUnion->name ?? 'N/A'}},<br> {{ $farmer->user->addressInfo->presentThana->name ?? ''}}
                                                </td>
                                                <td>
                                                    @if(isset($farmer->user->image) && $farmer->user->image )
                                                        <img height="50px;" src="{{asset($farmer->user->image)}}" alt="img.png">
                                                    @endif
                                                </td>
                                                <td style="width: 10%">
                                                    <div class="table-action">

                                                        @if ( create_permission() )
                                                            <form class="deleteFarmer" action="{{route('farmer.destroy', $farmer->id)}}" method="post">
                                                                @csrf
                                                                @method('Delete')
                                                                    @if($loanstaus==1)
                                                                <a href="{{ route('loan.apply') }}" title="Apply" data-toggle="tooltip" class="btn btn-sm btn-primary"> <i class="fas fa-clipboard"></i> </a>
                                                                @endif
                                                                
                                                                <a href="{{ route('farmer.show', $farmer->user->id) }}" title="View" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>

                                                                <a href="{{ route('farmer.edit', $farmer->user->id) }}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                                <button type="submit" disabled class="btn btn-sm btn-danger mt-1" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                           <div class="mt-3 d-flex justify-content-between align-items-center">
                                Showing {{ $farmers->firstItem() }} to {{ $farmers->lastItem() }} of {{ $farmers->total() }}

                                {{$farmers->links()}}
                            </div>
                        </div>
                        <!-- /.card-body -->

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
        $(document).ready(function() {
            // $("#farmer_table").DataTable({
            //     "paging": false,
            //     "filter": false
            // })

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
    <script>
        // $(function() {
        //     $("#farmer_table").DataTable({
        //         "responsive": true,
        //         "lengthChange": false,
        //         "autoWidth": false,
        //         "buttons": ["csv", "excel", "pdf", "print"]
        //     }).buttons().container().appendTo('#farmer_table_wrapper .col-md-6:eq(0)');
        // });
    </script>
@endpush
