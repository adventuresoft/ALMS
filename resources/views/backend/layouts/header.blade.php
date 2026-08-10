<nav class="main-header navbar navbar-expand navbar-upms">
<!--<nav class="main-header navbar navbar-expand navbar-white navbar-light">-->
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-md-inline-flex align-items-center">
        <a href="{{route('home')}}" class="nav-link text-white font-weight-bold p-0 d-flex align-items-center ml-2" style="font-size: 16px; letter-spacing: 0.3px; line-height: 1;">
          Agriculture Loan Management & Monitoring System (ALMS)
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @php
        $authUser = Auth::user();
        $userRoleName = 'User';
        $userBankName = null;

        if ($authUser) {
            if ($authUser->role_id == 1) {
                $userRoleName = 'Super Admin';
            } elseif (in_array($authUser->role_id, [4, 14, 15])) {
                $userRoleName = 'Super Admin';
            } elseif ($authUser->role_id == 17 || $authUser->role_id == 18 || is_bank_admin()) {
                $userRoleName = ($authUser->role_id == 18) ? 'Bank Branch Admin' : 'Bank Admin';
                $bankId = get_user_bank_id($authUser->id);
                if ($bankId) {
                    $bank = \App\Models\BasicSettings\Bank::find($bankId);
                    $userBankName = $bank?->en_name ?? $bank?->bn_name;
                }
            } elseif ($authUser->role_id == 6) {
                $userRoleName = 'Union Admin';
            } elseif ($authUser->role_id == 8) {
                $userRoleName = 'Pourashava Admin';
            } elseif ($authUser->role_id == 10) {
                $userRoleName = 'City Corp Admin';
            } elseif ($authUser->role_id == 13 || $authUser->role_id == 5) {
                $userRoleName = 'Farmer';
            } elseif ($authUser->role) {
                $userRoleName = $authUser->role->name;
            } elseif ($authUser->roles && $authUser->roles->count() > 0) {
                $userRoleName = $authUser->roles->pluck('name')->first();
            }
        }
      @endphp

      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center py-1 px-2" data-toggle="dropdown" href="#" style="gap: 8px;">
          <div class="text-right d-none d-sm-block" style="line-height: 1.2;">
            <span class="d-block text-white font-weight-bold" style="font-size: 13px;">{{ $authUser?->name }}</span>
            @if($userBankName)
              <span class="d-block text-warning font-weight-bold" style="font-size: 11px; letter-spacing: 0.2px;">
                <i class="fas fa-university mr-1" style="font-size: 10px;"></i>{{ $userBankName }}
              </span>
            @endif
            <span class="badge badge-light text-dark font-weight-normal px-2 mt-1" style="font-size: 10px; border-radius: 10px; opacity: 0.95;">
              {{ $userRoleName }}
            </span>
          </div>
          <i class="far fa-user text-white ml-1" style="font-size: 18px;"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
          <div class="dropdown-item bg-light text-center py-2 border-bottom">
            <h6 class="mb-0 font-weight-bold text-dark">{{ $authUser?->name }}</h6>
            @if($userBankName)
              <div class="text-success font-weight-bold small my-1">
                <i class="fas fa-university mr-1"></i>{{ $userBankName }}
              </div>
            @endif
            <span class="badge badge-primary font-weight-normal mt-1">{{ $userRoleName }}</span>
            @if($authUser?->system_id)
              <small class="d-block text-muted mt-1">System ID: {{ $authUser->system_id }}</small>
            @endif
          </div>
          <a href="{{ route('farmer.show', $authUser->id) }}" class="dropdown-item mt-1">
            <i class="fas fa-id-badge mr-2 text-primary"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <button type="button" onclick="event.preventDefault();document.getElementById('logoutForm').submit();" class="dropdown-item text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </button>
        </div>
      </li>
    </ul>
  </nav>
