@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'View'])
@section('title', 'People View')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>Farmer Information</h1>
                </div>
                <div class="col-sm-4 text-center">
                    <button id="printPageButton" class="btn btn-outline-primary btn-sm text-center" onClick="window.print();">
                        <i class="fa fa-print"></i> Print</button>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('farmer.index') }}">Farmer</a></li>
                        <li class="breadcrumb-item active">Permission</li>
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
                        {{-- <div class="card-header no-print">
                            <h3>Farmer Information</h3>
                        </div> --}}
                        @include('backend.pages.farmer.partials.profile')

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-horizontal" id="farmerApprovalForm" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{$user->is_verified ? 'checked' : ''}} id="is_verified" name="is_verified" value="1">
                                            <label class="form-check-label" for="is_verified">
                                                আমি ব্যবহারকারীকে একজন কৃষক হিসেবে পর্যালোচনা করেছি এবং এই প্রোফাইলটি অনুমোদন করছি।                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
        $(document).ready(function(){
            $("#farmerApprovalForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('approval.store') }}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        thisForm.find('button[type="submit"]').prop("disabled", true);
                        $('.error').text('');
                    },
                    success: function(response) {
                        thisForm.find('button[type="submit"]').prop("disabled", false);
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        thisForm.find('button[type="submit"]').prop("disabled", false);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                        $.each(responseText.errors, function(key, val) {
                            thisForm.find("." + key + "_error").text(val[0]);
                        });
                    }
                });
            })
        })

        $(document).on('change', '#is_verified', function(){
            $(this).closest('form').submit();
        })

    </script>
@endpush
