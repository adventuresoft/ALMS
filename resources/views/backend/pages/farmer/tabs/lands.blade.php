@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'FarmerCreate'])
@section('title', 'Farmer Create')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Farmer Information</h1>
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
                            @include('backend.pages.farmer.tabs.tab_header', ['user' => $user, 'active_tab' => 'land'])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="farmerLandForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Land Type</th>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>Thana</th>
                                            <th>Mouza</th>
                                            <th>Dag No.</th>
                                            <th>Khatiyan No</th>
                                            <th>Quantity</th>
                                            <th><button type="button" class="btn btn-sm btn-success add-new-land"><i class="fa fa-plus-circle"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="land-tbody">
                                        @forelse ($user->lands as $land)
                                            @include('backend.pages.farmer.tabs.land_single', ['land'=> $land])
                                        @empty
                                            @include('backend.pages.farmer.tabs.land_single', ['land'=> null])
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" class="text-right">Total Land Quantity:</td>
                                            <td class="total-land-quantity text-right"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <a href="{{ route('farmer.cultivation', $user->id) }}"
                                            class="btn btn-danger btn-block">Cultivation</a>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success btn-block">Save</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('farmer.classification', $user->id) }}" class="btn btn-primary btn-block ">Initial Loan</a>
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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            updateSerial()
            updateTotalLandQuantity();
            $("#farmerLandForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('farmer.landStore') }}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        thisForm.find('button[type="submit"]').prop("disabled", true);
                        $('.error').text('');
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
                            thisForm.find("." + key + "_error").text(val[0]);
                        });
                    }
                });
            })

            $(document).on('click', '.add-new-land', function(e){
                e.preventDefault();
                let _this = $(this);
                let _this_html = _this.html();
                $.ajax({
                    type: "GET",
                    url: "{{ route('farmer.land.add-new') }}",
                    beforeSend: function() {
                        _this.prop("disabled", true);
                        _this.html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        _this.prop("disabled", false);
                        _this.html(_this_html);
                        $("#land-tbody").append(response)
                        updateSerial()
                    }
                });
            })

            $(document).on('click', '.remove-land-item', function(e){
                e.preventDefault();
                $(this).closest('tr').remove();
                updateSerial()
                updateTotalLandQuantity();
            })

        })

        $(document).on('change', '.land-quantity', function(e){
            e.preventDefault();
            updateTotalLandQuantity();
        })

        function updateSerial() {
            $(".sl").each((index, elem) => {
                $(elem).text(index + 1);
            });
        }

        function updateTotalLandQuantity() {
            let total_land_quantity = 0.00;
            $(".land-quantity").each((index, elem) => {
                let _this_quantity = $(elem).val();
                let quantity = parseFloat(_this_quantity)
                if(_this_quantity && quantity && !isNaN(quantity) ){
                    total_land_quantity = total_land_quantity + quantity;
                }
            });

            $(".total-land-quantity").text(total_land_quantity.toFixed(2));
        }

    </script>
@endpush
