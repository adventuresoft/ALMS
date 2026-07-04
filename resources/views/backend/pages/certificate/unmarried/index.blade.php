@extends('backend.master', ['mainMenu' => 'Certificate', 'subMenu' =>'Unmarried'])
@push('style')
@endpush
@section('title', 'Unmarried Certificate')
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Unmarried Certificate</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('unmarried.index')}}">Unmarried</a></li>
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
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    <h3 class="card-title">Certificate List</h3>
                                </div>
                                <div class="col-md-6 text-right">
                                  @if (create_permission())
                                    <a href="{{route('unmarried.create')}}" class="btn btn-primary">Create</a>
                                  @endif
                                </div>

                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Name</th>
                                    <th>Eamil</th>
                                    <th>Quantity</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>


                                @if ($certificates)

                                    @foreach ($certificates as $key => $certificate)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$certificate->user->name}}</td>
                                            <td>{{$certificate->user->email}}</td>
                                            <td>{{$certificate->quantity}}</td>
                                            <td>{{$certificate->created_at}}</td>
                                            <td>
                                                <a target="_blank" href="{{route('unmarried.show', $certificate->id)}}" class="btn btn-primary"><i class="fa fa-file-pdf"></i> EN</a>
                                                <a target="_blank" href="{{route('unmarried.bn_certificate', $certificate->id)}}" class="btn btn-info"><i class="fa fa-file-pdf"></i> BN</a>
                                                {{-- <a href="{{route('people.edit', $people->user_id)}}" class="btn btn-primary">Edit</a> --}}
                                                {{-- <form action="{{route('people.destroy', $people->id)}}" method="post">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form> --}}
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
@endpush
