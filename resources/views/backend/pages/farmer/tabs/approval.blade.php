@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'FarmerCreate'])
@section('title', 'Farmer Create')
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
                        <li class="breadcrumb-item active">Create</li>
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
                            @include('backend.pages.farmer.tabs.tab_header', [
                                'user' => $user,
                                'active_tab' => 'approval',
                            ])
                        </div>
                        <!-- /.card-header -->
                        @if(Auth::check() && in_array(Auth::user()->role_id, [13, 5]))
                            <div class="card-body text-center p-4">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-1"></i> কৃষক অনুমোদন সম্পর্কিত কার্যক্রম শুধুমাত্র প্রশাসকদের জন্য সংরক্ষিত।
                                </div>
                            </div>
                        @else
                        <!-- form start -->
                        <form class="form-horizontal" id="farmerApprovalForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="card-body">
                                <div class="form-group row align-items-center">
                                    <div class="col-sm-9 px-2">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{$user->is_verified ? 'checked' : ''}} id="is_verified" name="is_verified" value="1">
                                            <label class="form-check-label" for="is_verified">
                                                I have reviewed the user as a farmer and approve this profile.
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <a href="{{ route('farmer.classification', $user->id) }}"
                                            class="btn btn-danger btn-block">Initial Loan</a>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success btn-block">Save</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('script')
    <script>
        $(document).ready(function() {
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
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000)
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
    </script>
@endpush
