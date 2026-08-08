@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'FarmerCreate'])
@section('title', 'Farmer Edit')
@push('style')
    {{-- <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgb(251, 24, 24);
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 19px;
            width: 19px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #21d937;
        }




        input:focus+.slider {
            box-shadow: 0 0 1px #21d937;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style> --}}

    <style>

        .knobs,
        .layer {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .toggle-button {
            position: relative;
            top: 50%;
            width: 74px;
            height: 36px;
            overflow: hidden;
        }

        .toggle-button.r,
        .toggle-button.r .layer {
            border-radius: 100px;
        }

        .checkbox {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            opacity: 0;
            cursor: pointer;
            z-index: 3;
        }

        .knobs {
            z-index: 2;
        }

        .layer {
            width: 100%;
            background-color: #fcebeb;
            transition: 0.3s ease all;
            z-index: 1;
        }

        /* Button 1 */
        .toggle-button-1 .knobs:before {
            content: "NO";
            position: absolute;
            top: 4px;
            left: 4px;
            width: 30px;
            height: 30px;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            line-height: 1;
            padding: 9px 4px;
            background-color: #f44336;
            border-radius: 50%;
            transition: 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15) all;
        }

        .toggle-button-1 .checkbox:checked + .knobs:before {
            content: "YES";
            left: 42px;
            background-color: #03a9f4;
        }

        .toggle-button-1 .checkbox:checked ~ .layer {
            background-color: #ebf7fc;
        }

        .toggle-button-1 .knobs,
        .toggle-button-1 .knobs:before,
        .toggle-button-1 .layer {
            transition: 0.3s ease all;
        }

    </style>
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>People Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('farmer.index') }}">Farmer</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                            @include('backend.pages.farmer.tabs.tab_header', ['user' => $user, 'active_tab' => 'classification'])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="farmerClassificationForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Bank</th>
                                            <th>Branch</th>
                                            <th>Types</th>
                                            <th>Amount</th>
                                            <th>Financial Year</th>
                                            <th><button type="button" class="btn btn-sm btn-success add-new-loan"><i class="fa fa-plus-circle"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="loan-tbody">
                                        @forelse ($user->loanInfos as $loan)
                                            @include('backend.pages.farmer.tabs.loan_single', ['banks' => $banks, 'loan'=> $loan])
                                        @empty
                                            @include('backend.pages.farmer.tabs.loan_single', ['banks' => $banks, 'loan'=> null])
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="form-group row mt-2">
                                    <label for="comments" class="col-sm-2 col-form-label">Comments</label>
                                    <div class="col-sm-10 px-2">
                                        <textarea class="form-control" name="comments" id="comments" placeholder="Comments" rows="1">{{$user->classificationInfo->comments ?? ''}}</textarea>
                                    </div>
                                </div>


                            </div>



                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <a href="{{ route('farmer.land', $user->id) }}" class="btn btn-danger btn-block">Land Info</a>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success btn-block">Save</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('farmer.show', $user->id) }}"
                                            class="btn btn-primary btn-block ">View Profile</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </form>
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
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $("#farmerClassificationForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('farmer.classificationStore')}}",
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
                        $.each(responseText.errors, function(key, val) {
                            thisForm.find("." + key + "-error").text(val[0]);
                        });
                    }
                });
            })
        })

        $(document).on('click', '.remove-loan', function(e){
            e.preventDefault();
            $(this).closest('tr').remove();
        })

        $(document).on('click', '.add-new-loan', function(e){
            e.preventDefault();
            let _this = $(this);
            let _this_html = _this.html();
            $.ajax({
                type: "GET",
                url: "{{ route('farmer.classification.add-new') }}",
                beforeSend: function() {
                    _this.prop("disabled", true);
                    _this.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    _this.prop("disabled", false);
                    _this.html(_this_html);
                    $("#loan-tbody").append(response)
                }
            });
        })

        $(document).on('change', '.bank', function(e){
            e.preventDefault();
            let _this = $(this);
            let _this_html = _this.html();
            $.ajax({
                type: "GET",
                url: "{{ url('branch-options') }}/"+_this.val(),
                success: function(response) {
                    let branch_html = '<option value="">Select Branch</option>';
                    if (response.branches.length) {
                        response.branches.forEach(element => {
                            branch_html +='<option value="'+element.id+'">'+element.en_name+'</option>'
                        });
                    }
                    _this.closest('tr').find(".branch").html(branch_html)
                }
            });
        })




    </script>
@endpush
