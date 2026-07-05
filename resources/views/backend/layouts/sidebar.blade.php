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
        <img src="{{ asset('public/backend') }}/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ALMS</span>
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
                <li class="nav-item menu-open">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link  @if ($subMenu == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


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
                
                        
                        @can('institute-settings-read')
                        <li
                            class="nav-item
                        @if (
                            $subMenu == 'InstituteCreate' ||
                                $subMenu == 'InstituteType' ||
                                $subMenu == 'InstituteCategory' ||
                                $subMenu == 'InstituteList') menu-open @endif">
                            <a href="#" class="nav-link @if ($mainMenu == 'Institute') active @endif ">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    Institute Settings
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('institute.create') }}"
                                        class="nav-link @if ($subMenu == 'InstituteCreate') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('institute.index') }}"
                                        class="nav-link @if ($subMenu == 'InstituteList') active @endif ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>View</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                   

                        @can('institutional-admins-read')
                        <li class="nav-item @if ($subMenu == 'AdminCreate' || $subMenu == 'AdminList' || $subMenu == 'AdminShow') menu-open @endif">
                            <a href="#" class="nav-link @if ($mainMenu == 'Admin') active @endif">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Institutional Admins
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('institutional-admin.create') }}"
                                        class="nav-link  @if ($subMenu == 'AdminCreate') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('institutional-admin.index') }}"
                                        class="nav-link  @if ($subMenu == 'AdminList') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endcan
                 

                {{-- Farmer Info --}}
                @can('farmer-info-read')
                <li class="nav-item @if ($subMenu == 'FarmerCreate' || $subMenu == 'FarmerView' || $subMenu == 'FarmerShow' || $subMenu == 'ApprovedFarmer') menu-open @endif">
                    <a href="#" class="nav-link @if ($mainMenu == 'Farmer') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Farmer Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                            <li class="nav-item">
                                <a href="{{ route('farmer.create') }}"
                                    class="nav-link @if ($subMenu == 'FarmerCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                       
                            <li class="nav-item">
                                <a href="{{ route('farmer.index') }}"
                                    class="nav-link @if ($subMenu == 'FarmerView') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General Farmer List</p>
                                </a>
                            </li>
                      
                            <li class="nav-item">
                                <a href="{{ route('approved-farmer.index') }}"
                                    class="nav-link @if ($subMenu == 'ApprovedFarmer') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Approve Farmer List</p>
                                </a>
                            </li>
                      
                    </ul>
                </li>
                @endcan

                {{-- Certificate --}}
               
                @can('certificate-read')
                    <li class="nav-item  @if ($mainMenu == 'Certificate') menu-open @endif ">
                        <a href="#" class="nav-link @if ($mainMenu == 'Certificate') active @endif">
                            <i class="nav-icon fas fa-certificate"></i>
                            <p>
                                Certificate
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('citizen-read')
                            <li class="nav-item">
                                <a href="{{ route('citizen.index') }}"
                                    class="nav-link @if ($subMenu == 'Citizen') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Citizen</p>
                                </a>
                            </li>
                            @endcan

                            @can('character-read')
                            <li class="nav-item">
                                <a href="{{ route('character.index') }}"
                                    class="nav-link  @if ($subMenu == 'Character') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Character</p>
                                </a>
                            </li>
                            @endcan


                        </ul>
                    </li>
                @endcan

               
                @can('department-settings-read')
                <li
                    class="nav-item
                    @if (
                        $subMenu == 'OrganizationCreate' ||
                            $subMenu == 'OrganizationList' ||
                            $subMenu == 'OrganizationBranchList' ||
                            $subMenu == 'organization_people' ||
                            $subMenu == 'OrganizationShow' ||
                            $subMenu == 'RegistrationFees' ||
                            $subMenu == 'RenewFees' ||
                            $subMenu == 'TradeLicense' ||
                            $subMenu == 'GetTradeLicense') menu-open @endif
                    ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Organization') active @endif ">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Organization Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                                <a href="{{ route('organization.index') }}"
                                    class="nav-link @if ($subMenu == 'OrganizationList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organization List</p>
                                </a>
                            </li>
                      
                             <li class="nav-item">
                                <a href="{{ route('organization-branch.index') }}"
                                    class="nav-link @if ($subMenu == 'OrganizationBranchList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organization Branch</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('organization-people.index') }}"
                                    class="nav-link @if ($subMenu == 'organization_people') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organization People</p>
                                </a>
                            </li>
                            @can('fees-read')
                            <li class="nav-item">
                                <a href="{{ route('organizationA.registration-fees.index') }}"
                                    class="nav-link @if ($subMenu == 'RegistrationFees') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fees</p>
                                </a>
                            </li>
                            @endcan
                            @can('generate-license-read')
                       
                            <li class="nav-item">
                                <a href="{{ route('organizationA.trade-license.index') }}"
                                    class="nav-link @if ($subMenu == 'TradeLicense') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate License </p>
                                </a>
                            </li>
                            @endcan
                            @can('trade-license-read')
                      
                            <li class="nav-item">
                                <a href="{{ route('organizationA.trade-license.getTradeLicense') }}"
                                    class="nav-link @if ($subMenu == 'GetTradeLicense') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Trade License</p>
                                </a>
                            </li>
                            @endcan
                       

                    </ul>
                </li>
                @endcan

              @php 
          //var_dump (auth()->user()->roles->pluck('name'));
              @endphp
                @can('loan-info-read')
                <li class="nav-item
                    @if (
                        $subMenu == 'LoanGenerate' ||
                            $subMenu == 'LoanReceived' ||
                            $subMenu == 'LoanRateList' ||
                            $subMenu == 'LoanList' ||
                            $subMenu == 'AllLoanApply' ||
                            $subMenu == 'LoanPayment') menu-open @endif ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Loan') active @endif">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Loan Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                            @can('loan-generate-create')
                            <li class="nav-item">
                                <a href="{{ route('loan-info.create') }}"
                                    class="nav-link  @if ($subMenu == 'LoanGenerate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Loan Generate</p>
                                </a>
                            </li>
                            @endcan
                       
                            <li class="nav-item">
                                <a href="{{ route('loan-info.index') }}"
                                    class="nav-link @if ($subMenu == 'LoanList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Loans</p>
                                </a>
                            </li>
                            @can('loan-payment-create')
                            <li class="nav-item">
                                <a href="{{ route('loan-payment.create') }}"
                                    class="nav-link  @if ($subMenu == 'LoanPayment') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Loan Payment</p>
                                </a>
                            </li>
                            @endcan
                            
                             <li class="nav-item">
                                <a href="{{ route('loan.apply.all') }}"
                                    class="nav-link  @if ($subMenu == 'LoanApply') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Loan Apply</p>
                                </a>
                            </li>

                    </ul>
                </li>
                @endcan

                {{-- Subsidy --}}
                @can('subsidy-read')
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
                       
                            <li class="nav-item">
                                <a href="{{ route('subsidy.create') }}"
                                    class="nav-link  @if ($subMenu == 'SubsidyCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subsidy Create</p>
                                </a>
                            </li>
                       
                            <li class="nav-item">
                                <a href="{{ route('subsidy.index') }}"
                                    class="nav-link @if ($subMenu == 'SubsidyList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View</p>
                                </a>
                            </li>
                      
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

                       
                            <li class="nav-item">
                                <a href="{{ route('bank.create') }}"
                                    class="nav-link @if ($subMenu == 'BankCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                      
                            <li class="nav-item">
                                <a href="{{ route('bank.index') }}"
                                    class="nav-link @if ($subMenu == 'BankList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                       
                            <li class="nav-item">
                                <a href="{{ route('bank-selling.index') }}"
                                    class="nav-link @if ($subMenu == 'BankSelling') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Selling</p>
                                </a>
                            </li>
                        
                        <li class="nav-item">
                                <a href="{{ route('bankuser.index') }}"
                                    class="nav-link @if ($subMenu == 'bankuser') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Bank Employee</p>
                                </a>
                            </li>
                        
                    </ul>
                </li>
                @endcan

                @can('bank-branchs-read')
                <li class="nav-item @if ($subMenu == 'BankBranchCreate' || $subMenu == 'BankBranchList') menu-open @endif">
                    <a href="#" class="nav-link  @if ($mainMenu == 'BankBranch') active @endif ">
                        <i class="nav-icon fas fa-code-branch"></i>
                        <p>
                            Bank Branches
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('bank-branch.create') }}"
                                    class="nav-link @if ($subMenu == 'BankBranchCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                   


                       
                            <li class="nav-item">
                                <a href="{{ route('bank-branch.index') }}"
                                    class="nav-link @if ($subMenu == 'BankBranchList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        
                    </ul>
                </li>
                @endcan



                @can('land-info-read')
                    {{-- Land Info --}}
                    <li
                        class="nav-item
                        @if ($subMenu == 'LandCreate' || $subMenu == 'LandList') menu-open @endif
                        ">
                        <a href="#" class="nav-link @if ($mainMenu == 'Land') active @endif">
                            <i class="nav-icon fas fa-bacon"></i>
                            <p>
                                Land Info
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                          
                                <li class="nav-item">
                                    <a href="{{ route('land.create') }}"
                                        class="nav-link @if ($subMenu == 'LandCreate') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                         
                                <li class="nav-item">
                                    <a href="{{ route('land.index') }}"
                                        class="nav-link @if ($subMenu == 'LandList') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>View</p>
                                    </a>
                                </li>
                          

                        </ul>
                    </li>
                @endcan

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
                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('report.general-report') }}"
                                    class="nav-link @if ($subMenu == 'GeneralReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.loan-report') }}"
                                    class="nav-link @if ($subMenu == 'LoanReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Loan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.payment-report') }}"
                                    class="nav-link @if ($subMenu == 'PaymentReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.due-report') }}"
                                    class="nav-link @if ($subMenu == 'DueReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Due</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.subsidy-report') }}"
                                    class="nav-link @if ($subMenu == 'SubsidyReport') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subsidy</p>
                                </a>
                            </li>
                        @endif
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
