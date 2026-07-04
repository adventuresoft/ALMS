@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'module'])

@section('content')
    <div class="" style="min-height: 1203.6px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Module</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Module</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($module) ? 'Edit Module' : 'Add Module' }}</h3>
                        </div>

                        @if (isset($module))
                            <form method="POST" action="{{ route('module.update', $module->id) }}">
                                @csrf
                                @method('PUT')
                            @else
                                <form method="POST" action="{{ route('module.store') }}">
                                    @csrf
                        @endif

                        <div class="card-body">
                            <div class="form-group">
                                <label>Module Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $module->name ?? '' }}"
                                    placeholder="Module Name" required>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button class="btn btn-success"><i class="fa fa-save"></i>
                                {{ isset($module) ? 'Update' : 'Save' }}</button>
                            <a href="{{ route('module.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>
                                Back</a>
                        </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Module List</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead class="text-center bg-dark text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Module Name</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($modules as $key => $row)
                                        <tr class="text-center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->slug }}</td>
                                            <td>
                                                <a href="{{ route('module.edit', $row->id) }}"
                                                    class="badge badge-primary"><i class="fa fa-edit"></i> Edit</a>

                                                <form action="{{ route('module.destroy', $row->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="badge badge-danger border-0"
                                                        onclick="return confirm('Delete?')">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div class="mt-3 d-flex justify-content-center">
                                {{ $modules->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
