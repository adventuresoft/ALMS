@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'organization_people'])
@section('content')

    <div class="" style="min-height: 1203.6px;">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$title??''}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{$title??''}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- Left Form -->
                    <div class="col-md-5">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($singleBankUser) ? 'Edit Bank User' : 'Add Bank User' }}
                                </h3>
                            </div>

                            @if (isset($singleBankUser))
                                <!-- Edit Form -->
                                <form role="form" method="POST"
                                    action="{{ route('bankuser.update', $singleBankUser->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="card-body">

                                        <!-- People -->
                                        <div class="form-group">
                                            <label for="people_id">People</label>
                                            <select class="form-control select2-ajax2" id="people_id" name="people_id"
                                                required data-url="{{ route('autocomplete.users') }}">
                                                <option value="{{ $singleBankUser->people->id }}" selected>
                                                    {{ $singleBankUser->people->name }}
                                                    ({{ $singleBankUser->people->system_id }})
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Bank -->
                                        <div class="form-group">
                                            <label for="bank_id">Bank</label>
                                            <select class="form-control select2-ajax" id="bank_id" name="bank_id" required
                                                data-url="{{ route('autocomplete.banks') }}">
                                                <option value="{{ $singleBankUser->bank->id }}" selected>
                                                    {{ $singleBankUser->bank->name }}
                                                </option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                            Update</button>
                                        <button type="reset" class="btn btn-warning ml-2"><i class="fa fa-undo-alt"></i>
                                            Reset</button>
                                        <a href="{{ route('organization-people.index') }}" class="btn btn-dark ml-2"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                </form>
                            @else
                                <!-- Create Form -->
                                <form role="form" method="POST" action="{{ route('organization-people.store') }}">
                                    @csrf

                                    <div class="card-body">

                                        <!-- People -->
                                        <div class="form-group">
                                            <label for="people_id">People</label>
                                            <select class="form-control select2-ajax2" id="people_id" name="people_id"
                                                required data-url="{{ route('autocomplete.people') }}">
                                            </select>
                                        </div>

                                        <!-- Organization -->
                                        <div class="form-group">
                                            <label for="organization_id">Organization</label>
                                            <select class="form-control select2-ajax" id="new_organization_id" name="organization_id" required
                                                data-url="{{ route('autocomplete.organizations') }}">
                                            </select>
                                        </div>

                                         <div class="form-group">
                                            <label for="new_branch_id">Branch</label>
                                            <select class="form-control " id="new_branch_id" name="branch_id" required
                                               >
                                            </select>
                                        </div>


                                    </div>

                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                            Save</button>
                                        <button type="reset" class="btn btn-warning ml-2"><i class="fa fa-undo-alt"></i>
                                            Reset</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Right Table -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Organization People List</h3>
                            </div>

                            <div class="card-body">
                                @if ($bankUsers->count() == 0)
                                    <div class="text-center btn-warning font-weight-bold pt-3 pb-3 h2">No Data Found</div>
                                @else
                                    <table class="table table-bordered table-striped">
                                        <thead class="text-center thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Organization</th>
                                                <th>Branch</th>
                                                <th>People</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bankUsers as $i => $item)
                                                <tr class="text-center">
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $item->organization?->name }}</td>                                                    
                                                    <td>{{ $item->branch?->bn_name }}</td>                                                    
                                                    <td>{{ $item->person?->bn_name }}
                                                       ({{ $item->person?->user->system_id }})
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('organization-people.edit',$item->id ) }}"
                                                            class="badge badge-primary">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="#" class="badge badge-danger"
                                                            onclick="if(confirm('Are you sure to delete?')){
                                                        event.preventDefault();
                                                        document.getElementById('delete{{ $item->id }}').submit();
                                                   }">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>

                                                        <form id="delete{{ $item->id }}"
                                                            action="{{ route('bankuser.soft') }}" method="POST"
                                                            style="display:none;">
                                                            @csrf
                                                            <input type="hidden" name="people_id"
                                                                value="{{ $item->people_id }}">
                                                            <input type="hidden" name="bank_id"
                                                                value="{{ $item->bank_id }}">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $bankUsers->links() }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {

            // Bank autocomplete (name only)
            $('.select2-ajax').each(function() {
                const $el = $(this);

                $el.select2({
                    theme: 'bootstrap4',
                    placeholder: 'Search...',
                    minimumInputLength: 1,
                    ajax: {
                        url: $el.data('url'),
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term
                        }),
                        processResults: data => ({
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name
                            }))
                        })
                    }
                });
            });

            // People autocomplete (name + system_id)
            $('.select2-ajax2').each(function() {
                const $el = $(this);

                $el.select2({
                    theme: 'bootstrap4',
                    placeholder: 'Search...',
                    minimumInputLength: 1,
                    ajax: {
                        url: $el.data('url'),
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term
                        }),
                        processResults: data => ({
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name + ' (' + item.system_id + ')'
                            }))
                        })
                    }
                });
            });

        });

        $(document).ready(function() {
            $('#new_organization_id').on('change',function(){
                var organization_id = $(this).val();
                console.log(organization_id);
                
                 $.ajax({
                    url: "{{ route('organization.getBranches', '') }}/" + organization_id,
                    type: "GET",
                    success: function(data) {
                        $('#new_branch_id').html('<option value="">-- Select Branch --</option>');
                        $.each(data, function(key, branch) {
                            $('#new_branch_id').append('<option value="' + branch.id + '">' + branch.bn_name + '</option>');
                        });
                    }
                });

            });    

            $('#bank_id').on('change',function(){
                var bank_id = $(this).val();
                console.log(bank_id);
                
                 $.ajax({
                    url: "{{ route('loan.getBranches', '') }}/" + bank_id,
                    type: "GET",
                    success: function(data) {
                        $('#branch_id').html('<option value="">-- Select Branch --</option>');
                        $.each(data, function(key, branch) {
                            $('#branch_id').append('<option value="' + branch.id + '">' + branch.bn_name + '</option>');
                        });
                    }
                });

            }); 
        });
    </script>

@endsection
