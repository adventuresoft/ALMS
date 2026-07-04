@extends('frontend.master')
@section('title', 'SUKTAIL UNION PARISHAD - Profile')
@push('style')
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('application.create')}}">Application</a></li>
                            <li class="breadcrumb-item active">Verify</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card text-center">
                            <div class="card-body">
                                @if ($verify_id && $user)
                                <button id="printPageButton" class="btn btn-outline-primary btn-sm text-center" onClick="window.print();">
                                    <i class="fa fa-print"></i> Print
                                </button>
                                    @include('backend.pages.farmer.partials.profile')
                                @else
                                    <form action="" method="GET">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="verify-id">Application ID</label>
                                                    <input type="text" id="verify-id" name="id" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-left" style="padding-top: 25px;">
                                                <label for="">&nbsp;</label>
                                                <button type="submit" class="btn btn-success mt-2"><i class="fa fa-search"></i> Search</button>
                                            </div>

                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
@push('script')
    <script>
    </script>
@endpush
