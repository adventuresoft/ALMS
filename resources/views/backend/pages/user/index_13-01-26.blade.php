@extends('backend.master', ['mainMenu' => 'User', 'subMenu' => 'User'])
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
@section('title', 'User View')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
    @if(count($errors) > 0)
    @foreach($errors->all() as $error)
      <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
    @endif
    @if(session()->has('success'))
    <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    @if(session()->has('error'))
    <p class="alert alert-danger">{{ session('error') }}</p>
    @endif
    @if(session()->has('warning'))
    <p class="alert alert-warning">{{ session('warning') }}</p>
    @endif

            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header ">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">User List</h3>
                                </div>
                                <div class="text-right">
                                     <a href="{{route('user.create')}}" class="btn btn-dark"><i class="fas fa-plus"></i> Add New User</a> 
                                    <a href="{{route('farmer-show-all')}}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="farmer_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>User ID & Name</th>
                                        <th>Mobile & Email</th>
                                        <th>User Type</th>
                                        <th>Photo</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($farmers)
                                        @foreach ($farmers as $key => $farmer)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    {{ $farmer->user->system_id ?? '' }}
                                                    <br>{{ $farmer->user->name ?? '' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $mobile = $farmer->user->mobile ? ('<a href="tel:'.$farmer->user->mobile.'">'.$farmer->user->mobile.'</a>') : '';
                                                        $email =  $farmer->user->email ? ('<br><a href="mailto:'.$farmer->user->email.'">'.$farmer->user->email.'</a>') : '';
                                                    @endphp
                                                    {!!$mobile!!}
                                                    {!!$email!!}
                                                </td>
                                                <td>
                                                    @php
                                                        $gender = people_constant_option('gender');
                                                    @endphp
                                                    {{ $farmer->date_of_birth ?? '--' }}<br>
                                                    {{ $gender[$farmer->gender] ?? ''  }}
                                                </td>
                                                <td>
                                                    <img height="50px;" src="{{asset($farmer->user->image)}}" alt="avatar.png">
                                                </td>
                                                <th>{{$farmer->user->status==1?'Active':'Inactive'}}</th>
                                                <td style="width: 10%">
                                                    <div class="table-action">
                                                        <!--<a href="{{ route('farmer.show', $farmer->user->id) }}" title="View" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>-->
                                                        @can('credentials-update')
<a href="{{ route('user.credentials.edit', $farmer->user->id) }}" title="Reset Email & Password"
               data-toggle="tooltip" class="btn btn-sm btn-secondary">
                <i class="fa fa-key"></i>
            </a>
@endcan
            
            <a href="{{ route('farmers.changeStatus', $farmer->user->id) }}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-success"><i class="fa fa-circle"></i></a>
                                                        @if ( create_permission() )
                                                            <!--<a href="{{ route('farmer.permission', $farmer->user->id) }}" title="Permission" data-toggle="tooltip" class="btn btn-sm btn-warning"><i class="fa fa-certificate"></i></a>-->
                                                            <!--@can('farmer-update')
<a href="{{ route('farmer.edit', $farmer->user->id) }}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
@endcan-->
                                                            <!--@can('farmer-delete')
@can('farmer-delete')
<form class="deleteFarmer" action="{{route('farmer.destroy', $farmer->id)}}" method="post">-->
                                                            <!--    @csrf-->
                                                            <!--    @method('Delete')-->
                                                            <!--    <button type="submit" disabled class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>-->
                                                            <!--</form>
@endcan
@endcan-->
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                            {{$farmers->links()}}
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
            $("#farmer_table").DataTable({
                "paging": false,
                "filter": false
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
