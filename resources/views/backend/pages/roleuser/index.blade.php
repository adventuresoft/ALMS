@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' =>'role'])
@section('content')

<div class="" style="min-height: 1203.6px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Role</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('backend.pages.rbac._header')

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{isset($singleRoleUser)? 'Edit Role':'Add User Role '}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if(isset($singleRoleUser))
                        <form role="form" method="POST" action="{{route('roleuser.update',$singleRoleUser->role_id)}}" >
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="old_model_id" value="{{$singleRoleUser->model_id}}">
                            <div class="card-body">

                               <div class="form-group">
                                <label for="user_id">Users</label>
                                
                                
                                 <select class="form-control select2-ajax2" id="user_id" name="user_id" required
        data-url="{{ route('autocomplete.users') }}">
        @if(isset($singleRoleUser))
            <option value="{{ $singleRoleUser->User->id }}" selected>{{ $singleRoleUser->User->name }}</option>
        @endif
    </select>

                            </div>  

                            <div class="form-group">
                                <label for="role_id">Role</label>
                               <select class="form-control select2-ajax" id="role_id" name="role_id" required
        data-url="{{ route('autocomplete.roles') }}">
        @if(isset($singleRoleUser))
            <option value="{{ $singleRoleUser->Role->id }}" selected>{{ $singleRoleUser->Role->name }}</option>
        @endif
    </select>
                            </div>             
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>  Update</button>
                            <button type="reset" class="btn btn-warning ml-2"><i class="fa fa-undo-alt"></i> Reset</button>
                            <a href="{{route('roleuser.index')}}" class="btn btn-dark ml-2" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </form>
                    @else
                    <form role="form" method="POST" action="{{route('roleuser.store')}}" >
                        {{csrf_field()}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="user_id">Users</label>
                          
                                 <select class="form-control select2-ajax2" id="user_id" name="user_id" required
        data-url="{{ route('autocomplete.users') }}">
       
    </select>
                            </div>  

                            <div class="form-group">
                                <label for="role_id">Role</label>
                              
                                 <select class="form-control select2-ajax" id="role_id" name="role_id" required
        data-url="{{ route('autocomplete.roles') }}">
      
    </select>
                            </div>    
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            <button type="reset" class="btn btn-warning ml-2"><i class="fa fa-undo-alt"></i> Reset</button>
                        </div>
                    </form>
                    @endif
                </div>     
            </div>  
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">User Role List</h3>                
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($roleUser->count()==0)
                        <div class="text-center btn-warning font-weight-bold pt-3 pb-3 h2">No Data Found</div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                            <thead class="text-center thead-dark">                  
                                <tr>
                                    <th style="width: 15px">#</th>
                                    <th>Role</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roleUser as $key => $value)
                                @php
                                $unique='_'.$value->role_id.'_'.$value->model_id;
                                @endphp
                                <tr class="text-center">
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->Role->name}}</td>
                                    <td>{{$value->User->name}} ({{$value->User->system_id}})</td>
                                    <td>
                                        <a href="{{route('roleuser.edit',['role_id'=>$value->role_id,'user_id'=>$value->model_id])}}" class="badge badge-primary"> <i class="fa fa-edit"></i> Edit</a>

                                        <a href="#" class="badge badge-danger" 
                                        onclick="if (confirm('You are sure to Delete This User Role?')){event.preventDefault();document.getElementById('delete-form{{$unique}}').submit();}else{event.stopPropagation(); event.preventDefault();};">
                                        <i class="fa fa-trash"></i> Delete </a>
                                        <form id="delete-form{{$unique}}" action="{{ route('roleuser.roleusersoft') }}" method="POST" style="display: none;">
                                            <input type="hidden" name="model_id" value="{{$value->model_id}}">
                                            <input type="hidden" name="role_id" value="{{$value->role_id}}">
                                            {{ method_field('POST') }}                                                
                                            @csrf
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">            
                        {{$roleUser->links()}}                  
                    </div>  
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- jQuery (should already be included with AdminLTE) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-ajax').each(function () {
        let $this = $(this);
        let url = $this.data('url');

        $this.select2({
            theme: 'bootstrap4', // optional for AdminLTE style
            placeholder: 'Search...',
            minimumInputLength: 1,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });

    $('.select2-ajax2').each(function () {
        let $this = $(this);
        let url = $this.data('url');

        $this.select2({
            theme: 'bootstrap4', // optional for AdminLTE style
            placeholder: 'Search...',
            minimumInputLength: 1,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name+' ( '+item.system_id +')'
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
});
</script>
@endsection