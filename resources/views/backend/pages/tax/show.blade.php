@extends('backend.master', ['mainMenu' => 'Tax', 'subMenu' =>'TaxList'])
@push('style')
<style>
    @media print {
        
            #printPageButton {
                display: none;
            }
            .bg-success{
                background: #28a745!important;
                color: #fff;
            }
           

            footer{
                display: none;
            }
            .content-wrapper, .container, .card, .card-footer{
                background: #ffffff
            }

            .border-dark{
                border: 1px solid #343a40!important;
            }
            
        }
</style>
@endpush
@section('title', 'Tax Show')
@section('content')
 <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Loan Generate</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('tax.index')}}">Loan</a></li>
            <li class="breadcrumb-item active">Generate</li>
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
                            <h3 class="card-title">Loan Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                  
                            <div class="card-body">
                                <div class="tabl-responsive">

                                    

                                    <table class=" table my-2 user_info_table">
                                        <tr>
                                            <td><img class="user_img" height="60" width="60" src="{{  asset($tax->user->image ?? 'public/no-image-found.jpeg')}}"></td>
                                            <td> Name: <strong class="user_name">{{$tax->user->people->bn_name ?? ''}}</strong> </td>
                                            <td> Fathers' Name: <strong class="user_father_name">{{$tax->user->familyInfo->father_name_bn ?? ''}}</strong></td>
                                            <td> Farmer ID No.: <strong class="user_system_id">{{$tax->user_system_id}}</strong></td>
                                        </tr>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Financial Year</th>
                                                <th>
                                                    @if ($tax->year == 1)
                                                        2022-2023
                                                    @else
                                                        2021-2022
                                                    @endif
                                                </th>
                                                <th>Type</th>
                                                <th>{{$tax->house->house_bn ?? ''}}</th>
                                            </tr>
                                            <tr>
                                                <th>Upozila</th>
                                                <th>{{$tax->unionWard->bn_ward_no ?? ''}}</th>
                                                <th>Union</th>
                                                <th>{{$tax->village->bn_name ?? ''}}</th>
                                            </tr>
                                        </thead>
                                    </table>

                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Sl. No.</th>
                                                <th>Loan</th>
                                                <th style="width: 20%">Previous Loan</th>
                                                <th style="width: 30%">Loan</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr>
                                                <td>1.</td>
                                                <td class="text-left">Land</td>
                                                <td  class="text-right">{{$tax->previous_residence_tax ?? ''}}</td>
                                                <td  class="text-right">{{$tax->residence_tax ?? ''}}</td>
                                            </tr>

                                            <tr>
                                                <td>2.</td>
                                                <td  class="text-left">Agriculture</td>
                                                <td  class="text-right">{{$tax->previous_income_tax ?? ''}}</td>
                                                <td  class="text-right">{{$tax->income_tax ?? ''}}</td>
                                            </tr>

                                            <tr>
                                                <td>3.</td>
                                                <td  class="text-left">Fisheries</td>
                                                <td  class="text-right">{{$tax->previous_entertainment_institute_tax ?? ''}}</td>
                                                <td  class="text-right">{{$tax->entertainment_institute_tax ?? ''}}</td>
                                            </tr>

                                            <tr>
                                                <td>4.</td>
                                                <td  class="text-left">Firm</td>
                                                <td  class="text-right">{{$tax->previous_license_tax ?? ''}}</td>
                                                <td  class="text-right">{{$tax->license_tax ?? ''}}</td>
                                            </tr>

                                            <tr>
                                                <td>5.</td>
                                                <td  class="text-left">Others</td>
                                                <td  class="text-right">{{$tax->previous_bazar_tax ?? ''}}</td>
                                                <td  class="text-right">{{$tax->bazar_tax ?? ''}}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr >
                                                <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                                <td class="text-right">
                                                    @php
                                                        $total_previous = 0;
                                                        $total_previous = $total_previous + ($tax->previous_extra  ? $tax->previous_extra : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_others  ? $tax->previous_others : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_fine  ? $tax->previous_fine : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_auction_tax  ? $tax->previous_auction_tax : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_land_tax  ? $tax->previous_land_tax : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_bazar_tax  ? $tax->previous_bazar_tax : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_license_tax  ? $tax->previous_license_tax : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_entertainment_institute_tax  ? $tax->previous_entertainment_institute_tax : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_income_tax  ? $tax->previous_income_tax : 0) ;
                                                        $total_previous = $total_previous + ($tax->previous_residence_tax  ? $tax->previous_residence_tax : 0) ;
                                                    @endphp
                                                    <strong class="previous_total">{{$total_previous}}/=</strong>
                                                </td>
                                                <td class="text-right">

                                                    @php
                                                        $total_current = 0;
                                                        $total_current = $total_current + ($tax->extra  ? $tax->extra : 0) ;
                                                        $total_current = $total_current + ($tax->others  ? $tax->others : 0) ;
                                                        $total_current = $total_current + ($tax->fine  ? $tax->fine : 0) ;
                                                        $total_current = $total_current + ($tax->auction_tax  ? $tax->auction_tax : 0) ;
                                                        $total_current = $total_current + ($tax->land_tax  ? $tax->land_tax : 0) ;
                                                        $total_current = $total_current + ($tax->bazar_tax  ? $tax->bazar_tax : 0) ;
                                                        $total_current = $total_current + ($tax->license_tax  ? $tax->license_tax : 0) ;
                                                        $total_current = $total_current + ($tax->entertainment_institute_tax  ? $tax->entertainment_institute_tax : 0) ;
                                                        $total_current = $total_current + ($tax->income_tax  ? $tax->income_tax : 0) ;
                                                        $total_current = $total_current + ($tax->residence_tax  ? $tax->residence_tax : 0) ;
                                                    @endphp

                                                    <strong class="current_total">{{$total_current}}/=</strong>
                                                </td>
                                            </tr>

                                            <tr >
                                                <td colspan="3" class="text-right"><strong>Grand Total:</strong></td>
                                                <td class="text-right"><strong class="sum_of_total">{{$total_current + $total_previous}}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    {{-- {{route('death.index')}} --}}
                                    <a href="{{route('tax.index')}}" class="btn btn-default float-right">Cancel</a>
                                    <div class="col-sm-9">
                                        <button type="button" id="printPageButton" class="btn btn-secondary text-right" onClick="window.print();">Print</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
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
