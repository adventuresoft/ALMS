@extends('backend.master', ['mainMenu' => 'BankBranch', 'subMenu' => 'BankBranchList'])
@push('style')
    <style>
        #datatable_wrapper .dataTables_filter {
            float: right;
        }

        #datatable_wrapper .dataTables_paginate {
            float: right;
        }
    </style>
@endpush
@section('title', 'Bank Branch List')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bank Branch Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('bank-branch.index') }}">Bank Branch</a></li>
                        <li class="breadcrumb-item active">List</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Bank Branch List</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#SL</th>
                                         <th>Bank</th>
                                        <th>Name</th>
                                        <th>Bengali Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($bank_branches))
                                        @foreach ($bank_branches as $key => $branch)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $branch->bank->bn_name ?? '' }}</td>
                                                <td>{{ $branch->en_name }}</td>
                                                <td>{{ $branch->bn_name }}</td>
                                                <td style="width: 10%">
                                                    <div class="table-action">
                                                        @can('bank-branch-update')
<a href="{{ route('bank-branch.edit', $branch->id) }}" title="Edit"
                                                            data-toggle="tooltip" class="btn btn-sm btn-primary"><i
                                                                class="fa fa-edit"></i></a>
@endcan
                                                        

                                                        @can('bank-branch-delete')
@can('bank-branch-delete')
<form class="deleteBank"
                                                            action="{{ route('bank-branch.destroy', $branch->id) }}" method="post">
                                                            @csrf
                                                            @method('Delete')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-toggle="tooltip" title="Delete"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
@endcan
@endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
            $("#datatable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "buttons": ["csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');

            $(".deleteBank").submit(function(e) {
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
@endpush
