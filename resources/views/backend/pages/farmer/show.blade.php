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
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
