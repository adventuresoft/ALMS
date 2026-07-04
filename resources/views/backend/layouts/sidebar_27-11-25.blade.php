<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('public/backend') }}/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
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
                        <a href="#" class="nav-link {{ $mainMenu == 'Basic' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Basic Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.city-corporation.index') }}"
                                    class="nav-link {{ $subMenu == 'CityCorporation' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>City Corporation</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.city-corporation-ward.index') }}"
                                    class="nav-link {{ $subMenu == 'CityCorporationWard' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>City Corporation Ward</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('basic-settings.family-category.index') }}"
                                    class="nav-link {{ $subMenu == 'FamilyCategory' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Family Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('basic-settings.family-subcategory.index') }}"
                                    class="nav-link {{ $subMenu == 'FamilySubcategory' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Family Subcategory</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('basic-settings.family-type.index') }}"
                                    class="nav-link {{ $subMenu == 'FamilyType' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Family Type</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
          <a href="#" class="nav-link {{$subMenu == 'FinancialYear'?'active':''}} ">
            <i class="far fa-circle nav-icon"></i>
            <p>Financial Year</p>
          </a>
        </li> --}}

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.house-ownership-type.index') }}"
                                    class="nav-link {{ $subMenu == 'HouseOwnershipType' ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>House Ownership Type</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.house-type.index') }}"
                                    class="nav-link {{ $subMenu == 'HouseType' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>House Type</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.house-category.index') }}"
                                    class="nav-link {{ $subMenu == 'HouseType' ? 'active' : '' }} @if ($subMenu == 'HouseCategory') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>House Category</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.land-type.index') }}"
                                    class="nav-link  {{ $subMenu == 'HouseType' ? 'active' : '' }} @if ($subMenu == 'LandType') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Land Type</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('basic-settings.land-class.index') }}"
                                    class="nav-link {{ $subMenu == 'HouseType' ? 'active' : '' }} @if ($subMenu == 'LandClass') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Land Class</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('basic-settings.land-ownership-type.index') }}"
                                    class="nav-link {{ $subMenu == 'HouseType' ? 'active' : '' }} @if ($subMenu == 'LandOwnershipType') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Land Ownership Type</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.profession.index') }}"
                                    class="nav-link {{ $subMenu == 'CityCorporationWard' ? 'active' : '' }} @if ($subMenu == 'Profession') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profession</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.profession-type.index') }}"
                                    class="nav-link {{ $subMenu == 'ProfessionType' ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profession Type</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.profession-category.index') }}"
                                    class="nav-link {{ $subMenu == 'ProfessionCategory' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profession Category</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.profession-subcategory.index') }}"
                                    class="nav-link {{ $subMenu == 'ProfessionSubcategory' ? 'active' : '' }} @">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profession Subcategory</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.union.index') }}"
                                    class="nav-link {{ $subMenu == 'CityCorporationWard' ? 'active' : '' }} {{ $subMenu == 'Union' ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Union</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('basic-settings.union-ward.index') }}"
                                    class="nav-link {{ $subMenu == 'UnionWard' ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Union Ward</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.village.index') }}"
                                    class="nav-link {{ $subMenu == 'Village' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Village</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('basic-settings.village-area.index') }}"
                                    class="nav-link {{ $subMenu == 'VillageArea' ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Village Area</p>
                                </a>
                            </li>



                        </ul>
                    </li>
               @endcan

            @can('access-management-read')
                <li
                    class="nav-item has-treeview {{ isset($page) && ($page == 'role' || $page == 'permission' || $page == 'rolepermission' || $page == 'userper' || $page == 'roleuser' || $page == 'user') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ isset($page) && ($page == 'role' || $page == 'permission' || $page == 'rolepermission' || $page == 'userper' || $page == 'roleuser' || $page == 'user') ? 'active' : '' }}">
                        <!-- <i class="nav-icon fa-solid fa-unlock-keyhole"></i> -->
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Access Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item ">
                            <a href="{{ route('role.index') }}"
                                class="nav-link {{ isset($page) && $page == 'role' ? 'active' : '' }}">
                                <!-- <i class="nav-icon fa-solid fa-scroll-torah"></i> -->
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                         <li class="nav-item ">
                            <a href="{{ route('module.index') }}"
                                class="nav-link {{ isset($subMenu) && $subMenu == 'module' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Module</p>
                            </a>
                        </li>
                        
                        <li class="nav-item ">
                            <a href="{{ route('permission.index') }}"
                                class="nav-link {{ isset($page) && $page == 'permission' ? 'active' : '' }}">
                                <!-- <i class="nav-icon fa-solid fa-fingerprint"></i> -->
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{ route('roleuser.index') }}"
                                class="nav-link {{ isset($page) && $page == 'roleuser' ? 'active' : '' }}">
                                <!-- <i class="fa fa-person-rays"></i> -->
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Roles</p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ route('rolepermission.index') }}"
                                class="nav-link {{ isset($page) && $page == 'rolepermission' ? 'active' : '' }}">
                                <!-- <i class="nav-icon fa-solid fa-rectangle-xmark"></i> -->
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{ route('user.index') }}"
                                class="nav-link {{ isset($page) && $page == 'user' ? 'active' : '' }}">
                                <!-- <i class="nav-icon fa-solid fa-users"></i> -->
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                         <li class="nav-item ">
                            <a href="{{ route('people.index') }}"
                                class="nav-link {{ isset($page) && $page == 'people' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>People</p>
                            </a>
                        </li>
                        
                        <li class="nav-item ">
                            <a href="{{ route('userper.index') }}"
                                class="nav-link {{ isset($page) && $page == 'userper' ? 'active' : '' }}">
                                <!-- <i class="nav-icon fa-solid fa-users-viewfinder"></i> -->
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Permission</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endcan
                @if (false)
                @if (institute_permissions())
                    {{-- Institute Settings --}}
                    <li class="nav-item
                        @if (
                            $subMenu == 'InstituteCreate' ||
                            $subMenu == 'InstituteType' ||
                            $subMenu == 'InstituteCategory' ||
                            $subMenu == 'InstituteList'
                        )
                            menu-open
                        @endif"
                    >
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
                @endif

                @if (create_permission())
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
                @endif
                @endif

                {{-- Farmer Info --}}
                <li class="nav-item @if ($subMenu == 'FarmerCreate' || $subMenu == 'FarmerView' || $subMenu == 'FarmerShow' || $subMenu == 'ApprovedFarmer') menu-open @endif">
                    <a href="#" class="nav-link @if ($mainMenu == 'Farmer') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Farmer Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('farmer.create') }}"
                                    class="nav-link @if ($subMenu == 'FarmerCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif
                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('farmer.index') }}"
                                    class="nav-link @if ($subMenu == 'FarmerView') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General Farmer List</p>
                                </a>
                            </li>
                        @endif
                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('approved-farmer.index') }}"
                                    class="nav-link @if ($subMenu == 'ApprovedFarmer') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Approval Farmer List</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                {{-- Certificate --}}
                @if (false)
                <li class="nav-item  @if ($mainMenu == 'Certificate') menu-open @endif ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Certificate') active @endif">
                        <i class="nav-icon fas fa-certificate"></i>
                        <p>
                            Certificate
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('citizen.index') }}"
                                class="nav-link @if ($subMenu == 'Citizen') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Citizen</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('character.index') }}"
                                class="nav-link  @if ($subMenu == 'Character') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Character</p>
                            </a>
                        </li>


                    </ul>
                </li>
                @endif

                {{-- Organization Info --}}
                <li class="nav-item
                    @if (
                        $subMenu == 'OrganizationCreate' ||
                            $subMenu == 'OrganizationList' ||
                            $subMenu == 'OrganizationShow' ||
                            $subMenu == 'RegistrationFees' ||
                            $subMenu == 'RenewFees' ||
                            $subMenu == 'TradeLicense' ||
                            $subMenu == 'GetTradeLicense') menu-open @endif
                    ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Organization') active @endif ">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Department Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('organization.create') }}"
                                    class="nav-link @if ($subMenu == 'OrganizationCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif

                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('organization.index') }}"
                                    class="nav-link @if ($subMenu == 'OrganizationList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        @endif

                        @if (basic_settings_permissions() && false)
                            <li class="nav-item">
                                <a href="{{ route('organizationA.registration-fees.index') }}"
                                    class="nav-link @if ($subMenu == 'RegistrationFees') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fees</p>
                                </a>
                            </li>
                        @endif

                        @if (view_permission() && false)
                            <li class="nav-item">
                                <a href="{{ route('organizationA.trade-license.index') }}"
                                    class="nav-link @if ($subMenu == 'TradeLicense') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate License </p>
                                </a>
                            </li>
                        @endif

                        @if (create_permission() && false)
                            <li class="nav-item">
                                <a href="{{ route('organizationA.trade-license.getTradeLicense') }}"
                                    class="nav-link @if ($subMenu == 'GetTradeLicense') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Trade License</p>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>


                {{-- Loan --}}
                <li class="nav-item
                    @if ($subMenu == 'LoanGenerate' || $subMenu == 'LoanReceived' || $subMenu == 'LoanRateList' || $subMenu == 'LoanList' || $subMenu == 'LoanPayment') menu-open @endif ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Loan') active @endif">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Loan Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('loan-info.create') }}"
                                    class="nav-link  @if ($subMenu == 'LoanGenerate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Loan Generate</p>
                                </a>
                            </li>
                        @endif
                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('loan-info.index') }}"
                                    class="nav-link @if ($subMenu == 'LoanList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View</p>
                                </a>
                            </li>
                        @endif

                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('loan-payment.create') }}"
                                    class="nav-link  @if ($subMenu == 'LoanPayment') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Loan Payment</p>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>

                {{-- Subsidy --}}
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
                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('subsidy.create') }}"
                                    class="nav-link  @if ($subMenu == 'SubsidyCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subsidy Create</p>
                                </a>
                            </li>
                        @endif
                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('subsidy.index') }}"
                                    class="nav-link @if ($subMenu == 'SubsidyList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

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

                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('bank.create') }}"
                                    class="nav-link @if ($subMenu == 'BankCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif


                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('bank.index') }}"
                                    class="nav-link @if ($subMenu == 'BankList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        @endif

                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('bank-selling.index') }}"
                                    class="nav-link @if ($subMenu == 'BankSelling') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Selling</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                {{-- Bank Branch --}}
                <li class="nav-item @if ($subMenu == 'BankBranchCreate' || $subMenu == 'BankBranchList') menu-open @endif">
                    <a href="#" class="nav-link  @if ($mainMenu == 'BankBranch') active @endif ">
                        <i class="nav-icon fas fa-code-branch"></i>
                        <p>
                            Bank Branches
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('bank-branch.create') }}"
                                    class="nav-link @if ($subMenu == 'BankBranchCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif


                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('bank-branch.index') }}"
                                    class="nav-link @if ($subMenu == 'BankBranchList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>




                @if (false)
                {{-- Land Info --}}
                <li class="nav-item
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

                        @if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('land.create') }}"
                                    class="nav-link @if ($subMenu == 'LandCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif
                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('land.index') }}"
                                    class="nav-link @if ($subMenu == 'LandList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View</p>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
                @endif

                 {{-- Reports Info --}}
                <li class="nav-item
                    @if (
                        $subMenu == 'OrganizationCreate' ||
                            $subMenu == 'OrganizationList' ||
                            $subMenu == 'OrganizationShow' ||
                            $subMenu == 'RegistrationFees' ||
                            $subMenu == 'RenewFees' ||
                            $subMenu == 'TradeLicense' ||
                            $subMenu == 'GetTradeLicense') menu-open @endif
                    ">
                    <a href="#" class="nav-link @if ($mainMenu == 'Organization') active @endif ">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <!--@if (create_permission())
                            <li class="nav-item">
                                <a href="{{ route('organization.create') }}"
                                    class="nav-link @if ($subMenu == 'OrganizationCreate') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif

                        @if (view_permission())
                            <li class="nav-item">
                                <a href="{{ route('organization.index') }}"
                                    class="nav-link @if ($subMenu == 'OrganizationList') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        @endif

                        @if (basic_settings_permissions() && false)
                            <li class="nav-item">
                                <a href="{{ route('organizationA.registration-fees.index') }}"
                                    class="nav-link @if ($subMenu == 'RegistrationFees') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fees</p>
                                </a>
                            </li>
                        @endif

                        @if (view_permission() && false)
                            <li class="nav-item">
                                <a href="{{ route('organizationA.trade-license.index') }}"
                                    class="nav-link @if ($subMenu == 'TradeLicense') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate License </p>
                                </a>
                            </li>
                        @endif

                        @if (create_permission() && false)
                            <li class="nav-item">
                                <a href="{{ route('organizationA.trade-license.getTradeLicense') }}"
                                    class="nav-link @if ($subMenu == 'GetTradeLicense') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Trade License</p>
                                </a>
                            </li>
                        @endif

                    </ul>-->
                </li>







            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
