@extends('backend.master', ['mainMenu' => 'Basic', 'subMenu' => 'Union'])
@push('style')
@endpush
@section('title', 'Union')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Union</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Union</a></li>
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
                        <div class="card-header">
                            <h3 class="card-title">Union List</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Name</th>
                                            <th>Bengali Name</th>
                                            <th>Thana / Upazila</th>
                                            <th>URL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if ($unions && count($unions) > 0)
                                            @foreach ($unions as $key => $item)
                                                <tr>
                                                    <td>{{ $unions->firstItem() + $key }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->bn_name }}</td>
                                                    <td>{{ $item->thana->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($item->url)
                                                            <a href="http://{{ $item->url }}" target="_blank">{{ $item->url }}</a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No records found.</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 d-flex justify-content-end">
                                {{ $unions->links() }}
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
@endpush
