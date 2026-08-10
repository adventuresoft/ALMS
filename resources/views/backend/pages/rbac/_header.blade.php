@php
    $currentRoute = Route::currentRouteName();
    $tabs = [
        ['name' => 'Users Directory', 'route' => 'user.index', 'icon' => 'fas fa-users'],
        ['name' => 'User Roles', 'route' => 'roleuser.index', 'icon' => 'fas fa-user-shield'],
    ];

    if (is_superadmin() || view_permission('roles') || (Auth::check() && Auth::user()->role_id == 6)) {
        $tabs[] = ['name' => 'Bank Admins', 'route' => 'bank-admin.index', 'icon' => 'fas fa-university'];
        $tabs[] = ['name' => 'Role Definitions', 'route' => 'role.index', 'icon' => 'fas fa-user-tag'];
        $tabs[] = ['name' => 'Permission Pool', 'route' => 'permission.index', 'icon' => 'fas fa-key'];
        $tabs[] = ['name' => 'Modules', 'route' => 'module.index', 'icon' => 'fas fa-cubes'];
    }
    if (view_permission('people') || is_superadmin() || (Auth::check() && Auth::user()->role_id == 6)) {
        $tabs[] = ['name' => 'People Directory', 'route' => 'people.index', 'icon' => 'fas fa-id-card'];
    }
@endphp

<style>
    :root {
        --rbac-primary: #2563eb; /* Modern Blue */
        --rbac-secondary: #1e40af;
        --rbac-bg: #f1f5f9;
        --rbac-border: #e2e8f0;
        --rbac-text: #1e293b;
        --rbac-text-light: #64748b;
    }

    .rbac-header-nav {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid var(--rbac-border);
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .rbac-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .rbac-nav-link {
        color: var(--rbac-text-light) !important;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none !important;
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        border: 1px solid transparent;
    }

    .rbac-nav-link i {
        font-size: 1rem;
        opacity: 0.7;
    }

    .rbac-nav-link:hover {
        background: var(--rbac-bg);
        color: var(--rbac-primary) !important;
    }

    .rbac-nav-link.active {
        background: #eff6ff;
        color: var(--rbac-primary) !important;
        border-color: #bfdbfe;
        font-weight: 600;
    }

    .rbac-nav-link.active i {
        opacity: 1;
    }

    /* Main Card Overrides */
    .rbac-main-card {
        border: 1px solid var(--rbac-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        background: white !important;
        backdrop-filter: none !important;
    }

    .rbac-card-header {
        background: #f8fafc !important;
        padding: 1.25rem 1.5rem !important;
        border-bottom: 1px solid var(--rbac-border) !important;
    }

    .rbac-card-title {
        color: var(--rbac-text) !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
    }

    .rbac-card-body {
        padding: 1.5rem !important;
    }

    /* Table Overrides */
    .premium-table thead th {
        background: #f8fafc !important;
        color: var(--rbac-text-light) !important;
        border-bottom: 2px solid var(--rbac-border) !important;
    }

    .premium-table tbody tr:hover {
        background: #f1f5f9 !important;
        transform: none !important;
    }

    .btn-premium-save {
        background: var(--rbac-primary) !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 10px 24px !important;
        font-size: 0.875rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        border: none !important;
        font-weight: 500 !important;
    }

    .btn-premium-save i {
        color: white !important;
    }

    .btn-premium-save:hover {
        background: var(--rbac-secondary) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2) !important;
    }

    .btn-premium-reset {
        background: #f8fafc !important;
        color: var(--rbac-text-light) !important;
        border: 1px solid var(--rbac-border) !important;
        border-radius: 8px !important;
        padding: 10px 20px !important;
        font-size: 0.875rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }

    .btn-premium-reset:hover {
        background: white !important;
        color: var(--rbac-text) !important;
        border-color: var(--rbac-text-light) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
    }

    .form-control-premium {
        border-radius: 8px !important;
        border: 1px solid var(--rbac-border) !important;
        font-size: 0.95rem !important;
    }

    .form-control-premium:focus {
        border-color: var(--rbac-primary) !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    }

    /* Hide redundant elements */
    .content-header { display: none !important; }
</style>

<div class="rbac-header-nav">
    <div class="rbac-nav">
        @foreach($tabs as $tab)
            @if(Route::has($tab['route']))
            <a href="{{ route($tab['route']) }}" class="rbac-nav-link {{ $currentRoute == $tab['route'] ? 'active' : '' }}">
                <i class="{{ $tab['icon'] }}"></i>
                {{ $tab['name'] }}
            </a>
            @endif
        @endforeach
    </div>
</div>
