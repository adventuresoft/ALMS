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
                            <li class="breadcrumb-item active">Success</li>

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
                            <div class="card-header">
                              {{-- Featured --}}
                            </div>
                            <div class="card-body">
                                @if ($user)

                                <h5 class="text-success text-center">
                                    Success! <br>
                                    Application ID: {{$user->system_id}}
                                </h5>
                                <p class="card-text">Your application has been submitted. Please keep this application id for further uses.</p>
                                <a href="{{route('application.verify')}}/?id={{$user->system_id}}" class="btn btn-primary">View the application</a>
                                <div class="card-footer text-muted mt-2">
                                    Thanks for your application.
                                </div>
                                @else
                                    <h5>No Record Found!</h5>
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
