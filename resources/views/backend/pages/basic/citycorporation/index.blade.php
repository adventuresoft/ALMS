@extends('backend.master', ['mainMenu' => 'Basic', 'subMenu' => 'CityCorporation'])
@push('style')
@endpush
@section('title', 'City Corporation')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>City Corporation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">City Corporation</a></li>
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
                            <h3 class="card-title">City Corporation List</h3>
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
                                            <th>District</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if ($cityCorporations && count($cityCorporations) > 0)
                                            @foreach ($cityCorporations as $key => $item)
                                                <tr>
                                                    <td>{{ $cityCorporations->firstItem() + $key }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->bn_name }}</td>
                                                    <td>{{ $item->District->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->category }}</td>
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
                                {{ $cityCorporations->links() }}
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
