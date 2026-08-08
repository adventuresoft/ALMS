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
                            @include('backend.pages.farmer.tabs.tab_header', [
                                'user' => $user,
                                'active_tab' => 'cultivation',
                            ])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="farmerCultivationForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            {{-- <div class="card-header">
                                <h6 class="card-title">Cultivation</h6>
                            </div> --}}

                            <div class="card-body">
                                <div class="form-group row align-items-center">
                                    <label for="is_property" class="col-sm-3 col-form-label">Is Available Agricultural Card?</label>
                                    <div class="col-sm-9 px-2">
                                        <label class="mb-0">
                                            <input type="radio" value="0"
                                                {{ isset($user->classificationInfo->is_agriculture_card)
                                                        ? ($user->classificationInfo->is_agriculture_card == 0 ? 'checked' : '')
                                                        : 'checked' }}
                                                name="is_agriculture_card" class="agri-radio">
                                            No
                                        </label>

                                        <label class="mb-0">
                                            <input type="radio" value="1"
                                                {{ isset($user->classificationInfo->is_agriculture_card)
                                                        ? ($user->classificationInfo->is_agriculture_card == 1 ? 'checked' : '')
                                                        : '' }}
                                                name="is_agriculture_card" class="agri-radio">
                                            Yes
                                        </label>

                                        <input type="text"
                                            id="agriculture_card_number"
                                            placeholder="Agriculture Card Number"
                                            name="agriculture_card_number"
                                            value="{{ $user->farmer->agriculture_card_number ?? '' }}"
                                            class="form-control"
                                            style="width: 250px; margin-left: 10px; display: none;">
                                    </div>
                                </div>
                                 <div id="cultivation-section">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 200px;">Cultivation Type</th>
                                            <th style="min-width: 180px;">Ownership Type</th>
                                            <th>Quantity</th>
                                            <th>Description</th>
                                            <th><button type="button" class="btn btn-sm btn-success add-new-cultivation"><i class="fa fa-plus-circle"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cultivation-tbody">
                                        @forelse ($user->cultivations as $cultivate)
                                            @include('backend.pages.farmer.tabs.cultivation_single', ['crops' => $crops, 'cultivation'=> $cultivate])
                                        @empty
                                            @include('backend.pages.farmer.tabs.cultivation_single', ['crops' => $crops, 'cultivation'=> null])
                                        @endforelse
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success btn-block">Save</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('farmer.land', $user->id) }}" class="btn btn-primary btn-block">Land Info</a>
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
            $("#farmerCultivationForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('farmer.cultivationStore') }}",
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

            $(document).on('click', '.add-new-cultivation', function(e){
                e.preventDefault();
                let _this = $(this);
                let _this_html = _this.html();
                $.ajax({
                    type: "GET",
                    url: "{{ route('farmer.cultivation.add-new') }}",
                    beforeSend: function() {
                        _this.prop("disabled", true);
                        _this.html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        _this.prop("disabled", false);
                        _this.html(_this_html);
                        $("#cultivation-tbody").append(response)
                    }
                });
            })

            $(document).on('click', '.remove-cultivation-item', function(e){
                e.preventDefault();
                $(this).closest('tr').remove();
            })

        })
        
        $(document).ready(function () {

    function toggleAgriCard(clearValue) {
        let value = $('input[name="is_agriculture_card"]:checked').val();
        if (value == "1") {
            $('#cultivation-section').show();
            $('#agriculture_card_number').show();
        } else {
            $('#cultivation-section').hide();
            $('#agriculture_card_number').hide();
            if (clearValue) {
                $('#agriculture_card_number').val('');
            }
        }
    }

    // On load — run immediately to set correct initial state
    toggleAgriCard(false);

    // On user change
    $(document).on('change', 'input[name="is_agriculture_card"]', function () {
        toggleAgriCard(true);
    });

});


    </script>



@endpush
