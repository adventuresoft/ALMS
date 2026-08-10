<style>
  .nav-sidebar .nav-item {
    margin: 0px !important;
    padding: 0px !important;
  }
  .nav-sidebar .nav-link {
    padding-top: 2px !important;
    padding-bottom: 2px !important;
    line-height: 1.2 !important;
  }
  .nav-sidebar .nav-treeview > .nav-item > .nav-link {
    padding-top: 1px !important;
    padding-bottom: 1px !important;
  }
  .nav-sidebar .nav-treeview > .nav-item > .nav-link > .nav-icon {
    font-size: 10px !important;
  }
  .nav-sidebar p {
    margin-bottom: 0 !important;
  }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('frontend/img/company-logo.png') }}" alt="Adventure Soft Logo"
            class="brand-image img-circle elevation-3" style="opacity: .9; background: white; padding: 2px; width: 33px; height: 33px; object-fit: contain;">
        <span class="brand-text font-weight-light"><b>ALMS</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                {{-- Dashboard --}}
                @can('dashboard-read')
                <li class="nav-item menu-open">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link  @if ($subMenu == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @endcan


            @can('basic-settings-read')
                {{-- Basic Settings --}}
                <li class="nav-item
                    @if (
                        $subMenu == 'CityCorporation' ||
                        $subMenu == 'CityCorporationWard' ||
                        $subMenu == 'FamilyCategory' ||
                        $subMenu == 'FamilySubcategory' ||
                        $subMenu == 'FamilyType' ||
                        $subMenu == 'Financialyear' ||
                        $subMenu == 'HouseType' ||
                        $subMenu == 'HouseCategory' ||
                        $subMenu == 'HouseOwnershipType' ||
                        $subMenu == 'LandType' ||
                        $subMenu == 'LandClass' ||
                        $subMenu == 'LandOwnershipType' ||
                        $subMenu == 'MarketType' ||
                        $subMenu == 'MarketCategory' ||
                        $subMenu == 'MarketOwnershipType' ||
                        $subMenu == 'OrganizationCategory' ||
                        $subMenu == 'OrganizationSubcategory' ||
                        $subMenu == 'OrganizationWorkArea' ||
                        $subMenu == 'OrganizationOwnershipType' ||
                        $subMenu == 'OrganizationType' ||
                        $subMenu == 'OrganizationSubtype' ||
                        $subMenu == 'Profession' ||
                        $subMenu == 'ProfessionCategory' ||
                        $subMenu == 'ProfessionSubcategory' ||
                        $subMenu == 'ProfessionType' ||
                        $subMenu == 'RoadCategory' ||
                        $subMenu == 'RoadType' ||
                        $subMenu == 'RoadOwner' ||
                        $subMenu == 'ResarvWard' ||
                        $subMenu == 'VehicleCategory' ||
                        $subMenu == 'VehicleSubcategory' ||
                        $subMenu == 'VehicleType' ||
                        $subMenu == 'UnionWard' ||
                        $subMenu == 'ReserveWard' ||
                        $subMenu == 'Village' ||
                        $subMenu == 'VillageArea' ||
                        $subMenu == 'Union' ||
                        $subMenu == 'Year') menu-open
                    @endif
                ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Basic') active @endif">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Basic Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.city-corporation.index') }}"
                                class="nav-link @if ($subMenu == 'CityCorporation') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>City Corporation</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.city-corporation-ward.index') }}"
                                class="nav-link @if ($subMenu == 'CityCorporationWard') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>City Corporation Ward</p>
                            </a>
                        </li>
                        {{-- Hide Family, House, and Land settings options as requested
                        <li class="nav-item">
                            <a href="{{ route('basic-settings.family-category.index') }}"
                                class="nav-link @if ($subMenu == 'FamilyCategory') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Family Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('basic-settings.family-subcategory.index') }}"
                                class="nav-link @if ($subMenu == 'FamilySubcategory') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Family Subcategory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('basic-settings.family-type.index') }}"
                                class="nav-link @if ($subMenu == 'FamilyType') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Family Type</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.house-ownership-type.index') }}"
                                class="nav-link @if ($subMenu == 'HouseOwnershipType') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>House Ownership Type</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.house-type.index') }}"
                                class="nav-link @if ($subMenu == 'HouseType') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>House Type</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.house-category.index') }}"
                                class="nav-link @if ($subMenu == 'HouseCategory') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>House Category</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.land-type.index') }}"
                                class="nav-link @if ($subMenu == 'LandType') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Land Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('basic-settings.land-class.index') }}"
                                class="nav-link @if ($subMenu == 'LandClass') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Land Class</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('basic-settings.land-ownership-type.index') }}"
                                class="nav-link @if ($subMenu == 'LandOwnershipType') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Land Ownership Type</p>
                            </a>
                        </li>
                        --}}

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.financial-year.index') }}"
                                class="nav-link @if ($subMenu == 'Financialyear') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Financial Year</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.profession.index') }}"
                                class="nav-link @if ($subMenu == 'Profession') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profession</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.profession-type.index') }}"
                                class="nav-link @if ($subMenu == 'ProfessionType') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profession Type</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.profession-category.index') }}"
                                class="nav-link @if ($subMenu == 'ProfessionCategory') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profession Category</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.profession-subcategory.index') }}"
                                class="nav-link @if ($subMenu == 'ProfessionSubcategory') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profession Subcategory</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.union.index') }}"
                                class="nav-link @if ($subMenu == 'Union') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Union</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.union-ward.index') }}"
                                class="nav-link @if ($subMenu == 'UnionWard') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Union Ward</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.village.index') }}"
                                class="nav-link @if ($subMenu == 'Village') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Village</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('basic-settings.village-area.index') }}"
                                class="nav-link @if ($subMenu == 'VillageArea') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Village Area</p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan


            @can('access-management-read')
                <li class="nav-item">
                    <a href="{{ route('user.index') }}"
                        class="nav-link {{ (isset($mainMenu) && in_array($mainMenu, ['AccessManagment', 'User', 'People'])) || in_array(Route::currentRouteName(), ['user.index', 'roleuser.index', 'role.index', 'permission.index', 'module.index', 'people.index']) ? 'active' : '' }}">
                        <!-- <i class="nav-icon fa-solid fa-unlock-keyhole"></i> -->
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Access Management
                        </p>
                    </a>
                </li>
            @endcan
                




                {{-- Farmer Info --}}
                @can('farmer-info-read')
                <li class="nav-item @if ($subMenu == 'FarmerCreate' || $subMenu == 'FarmerView' || $subMenu == 'FarmerShow' || $subMenu == 'ApprovedFarmer' || $subMenu == 'FarmerEdit') menu-open @endif">
                    <a href="#" class="nav-link @if ($mainMenu == 'Farmer') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Farmer Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                            @if(Auth::check() && in_array(Auth::user()->role_id, [13, 5]))
                            <li class="nav-item">
                                <a href="{{ route('farmer.show', Auth::user()->id) }}"
                                    class="nav-link @if ($subMenu == 'FarmerShow' || $subMenu == 'MyProfile') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>My Profile</p>
                                </a>
                            </li>
                            @endif

                            @if(!Auth::check() || !in_array(Auth::user()->role_id, [13, 5]))
                            @can('farmer-create-read')
                            <li class="nav-item">
                                <a href="{{ route('farmer.create') }}"
                                    class="nav-link @if ($subMenu == 'FarmerCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                            @endcan
                            @endif
                       
                            @can('farmer-general-list-read')
                            <li class="nav-item">
                                <a href="{{ route('farmer.index') }}"
                                    class="nav-link @if ($subMenu == 'FarmerView') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General Farmer List</p>
                                </a>
                            </li>
                            @endcan
                       
                            @can('farmer-approve-list-read')
                            <li class="nav-item">
                                <a href="{{ route('approved-farmer.index') }}"
                                    class="nav-link @if ($subMenu == 'ApprovedFarmer') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Approve Farmer List</p>
                                </a>
                            </li>
                            @endcan
                    </ul>
                </li>
                @endcan

                @can('loan-info-read')
                <li class="nav-item
                    @if (
                        $subMenu == 'LoanGenerate' ||
                            $subMenu == 'LoanReceived' ||
                            $subMenu == 'LoanRateList' ||
                            $subMenu == 'LoanList' ||
                            $subMenu == 'AllLoanApply' ||
                            $subMenu == 'LoanApply' ||
                            $subMenu == 'LoanApplyForm' ||
                            $subMenu == 'LoanPayment') menu-open @endif ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Loan') active @endif">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Loan Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                            @if(Auth::check() && in_array(Auth::user()->role_id, [13, 5]))
                            <li class="nav-item">
                                <a href="{{ route('loan.apply') }}"
                                    class="nav-link @if ($subMenu == 'LoanApplyForm') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Apply for Loan</p>
                                </a>
                            </li>
                            @endif

                            @can('loan-all-loans-read')
                            <li class="nav-item">
                                <a href="{{ route('loan-info.index') }}"
                                    class="nav-link @if ($subMenu == 'LoanList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Loans</p>
                                </a>
                            </li>
                            @endcan
                            
                            @can('loan-all-loan-apply-read')
                             <li class="nav-item">
                                <a href="{{ route('loan.apply.all') }}"
                                    class="nav-link @if ($subMenu == 'LoanApply') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ Auth::check() && in_array(Auth::user()->role_id, [13, 5]) ? 'My Loan Applications' : 'All Loan Apply' }}</p>
                                </a>
                            </li>
                            @endcan
                    </ul>
                </li>
                @endcan

                {{-- Subsidy --}}
                @can('subsidy-info-read')
                <li class="nav-item
                    @if ($subMenu == 'SubsidyCreate' || $subMenu == 'SubsidyList') menu-open @endif ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Subsidy') active @endif">
                        <i class="nav-icon fas fa-donate"></i>
                        <p>
                            Subsidy
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                            @can('subsidy-create-read')
                            <li class="nav-item">
                                <a href="{{ route('subsidy.create') }}"
                                    class="nav-link  @if ($subMenu == 'SubsidyCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subsidy Create</p>
                                </a>
                            </li>
                            @endcan
                       
                            @can('subsidy-view-read')
                            <li class="nav-item">
                                <a href="{{ route('subsidy.index') }}"
                                    class="nav-link @if ($subMenu == 'SubsidyList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View</p>
                                </a>
                            </li>
                            @endcan
                      
                    </ul>
                </li>
                @endcan

                @can('bank-info-read')
                {{-- Bank Info --}}
                <li class="nav-item @if ($subMenu == 'BankCreate' || $subMenu == 'BankList' || $subMenu == 'BankSelling') menu-open @endif">
                    <a href="#" class="nav-link  @if ($mainMenu == 'Bank') active @endif ">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Bank Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                       
                            @can('bank-create-read')
                            <li class="nav-item">
                                <a href="{{ route('bank.create') }}"
                                    class="nav-link @if ($subMenu == 'BankCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                            @endcan
                      
                            @can('bank-list-read')
                            <li class="nav-item">
                                <a href="{{ route('bank.index') }}"
                                    class="nav-link @if ($subMenu == 'BankList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                            @endcan
                       
                            @can('bank-selling-read')
                            <li class="nav-item">
                                <a href="{{ route('bank-selling.index') }}"
                                    class="nav-link @if ($subMenu == 'BankSelling') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Selling</p>
                                </a>
                            </li>
                            @endcan
                        
                            @can('bank-employee-read')
                            <li class="nav-item">
                                <a href="{{ route('bankuser.index') }}"
                                    class="nav-link @if ($subMenu == 'bankuser') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Bank Employee</p>
                                </a>
                            </li>
                            @endcan
                        
                    </ul>
                </li>
                @endcan

                {{-- Bank Branches removed --}}



                {{-- Land Info removed --}}

                @can('reports-read')
                <li class="nav-item
                    @if (
                        $subMenu == 'GeneralReport' ||
                        $subMenu == 'LoanReport' ||
                        $subMenu == 'PaymentReport' ||
                        $subMenu == 'DueReport' ||
                        $subMenu == 'SubsidyReport') menu-open @endif
                    ">
                    <a href="#" class="nav-link @if ($mainMenu == 'report') active @endif ">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                            @can('reports-general-read')
                            <li class="nav-item">
                                <a href="{{ route('report.general-report') }}"
                                    class="nav-link @if ($subMenu == 'GeneralReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General</p>
                                </a>
                            </li>
                            @endcan
                            @can('reports-loan-read')
                            <li class="nav-item">
                                <a href="{{ route('report.loan-report') }}"
                                    class="nav-link @if ($subMenu == 'LoanReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Loan</p>
                                </a>
                            </li>
                            @endcan
                            @can('reports-payment-read')
                            <li class="nav-item">
                                <a href="{{ route('report.payment-report') }}"
                                    class="nav-link @if ($subMenu == 'PaymentReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment</p>
                                </a>
                            </li>
                            @endcan
                            @can('reports-due-read')
                            <li class="nav-item">
                                <a href="{{ route('report.due-report') }}"
                                    class="nav-link @if ($subMenu == 'DueReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Due</p>
                                </a>
                            </li>
                            @endcan
                            @can('reports-subsidy-read')
                            <li class="nav-item">
                                <a href="{{ route('report.subsidy-report') }}"
                                    class="nav-link @if ($subMenu == 'SubsidyReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subsidy</p>
                                </a>
                            </li>
                            @endcan
                        
                    </ul>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ url('cc') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Clear Cache</p>
                    </a>
                </li>





            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
