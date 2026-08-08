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
                    </div>
                    <!-- /.card -->

                    @if(!$user->is_verified)
                        <div class="card card-outline card-success mt-4 no-print shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 4px solid #10b981;">
                            <div class="card-body p-4" style="background-color: #f8fafc;">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="text-success font-weight-bold mb-1" style="font-size: 18px;">
                                            <i class="fas fa-check-circle mr-2"></i> কৃষক তথ্য বিবরণী অনুমোদন করুন / Farmer Profile Approval
                                        </h5>
                                        <p class="text-muted mb-0" style="font-size: 14px;">
                                            কৃষকের সকল তথ্য সঠিক থাকলে নিচের অনুমোদন বাটনে ক্লিক করে প্রোফাইলটি অনুমোদন করুন।
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                        <form id="farmerApprovalForm" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="is_verified" value="1">
                                            <button type="submit" class="btn btn-success btn-lg px-4 font-weight-bold shadow-sm" style="border-radius: 8px; font-size: 16px; transition: all 0.2s ease;">
                                                <i class="fas fa-check mr-2"></i> অনুমোদন করুন / Approve
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card card-outline card-success mt-4 no-print shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 4px solid #10b981;">
                            <div class="card-body p-4 text-center" style="background-color: #f0fdf4;">
                                <h5 class="text-success font-weight-bold mb-1" style="font-size: 18px;">
                                    <i class="fas fa-check-circle mr-2"></i> এই প্রোফাইলটি অনুমোদিত / This Profile is Approved
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 14px;">
                                    কৃষক প্রোফাইলটি ইতিমধ্যে যাচাই এবং অনুমোদন করা হয়েছে।
                                </p>
                            </div>
                        </div>
                    @endif
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
                    }
                });
            })
        })
    </script>
@endpush
