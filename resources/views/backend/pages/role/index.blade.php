@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' =>'role'])
@section('title', 'Security Role Matrix')
@section('content')
<div class="rbac-container container-fluid">
    @include('backend.pages.rbac._header')

    <div class="row">
        <!-- Role Creation/Edit Column -->
        <div class="col-md-12 mb-3 text-right">
            <button type="button" class="btn btn-premium-save shadow-sm" data-toggle="modal" data-target="#createRoleModal">
                <i class="fas {{ isset($role) ? 'fa-edit' : 'fa-plus-circle' }} mr-2"></i> 
                {{ isset($role) ? 'Modify Security Role Architecture' : 'Initialize New Security Role' }}
            </button>
            @if(isset($role))
                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary shadow-sm ml-2">
                    <i class="fas fa-undo mr-1"></i> Reset
                </a>
            @endif
        </div>

        <div class="modal fade text-left" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light border-bottom">
                        <h4 class="modal-title font-weight-bold" id="createRoleModalLabel">
                            <i class="fas {{ isset($role) ? 'fa-edit text-warning' : 'fa-plus-circle text-primary' }} mr-2"></i>
                            {{ isset($role) ? 'Modify Security Role Architecture' : 'Initialize New Security Role' }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <form role="form" method="POST" action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}">
                        @csrf
                        @if(isset($role)) @method('PATCH') @endif
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="name" class="font-weight-bold text-uppercase small text-muted">Role Identity</label>
                                <input type="text" name="name" class="form-control form-control-premium" id="name" value="{{ $role->name ?? old('name') }}" placeholder="e.g. Finance Administrator" required>
                                <small class="text-muted">Unique name for this security profile.</small>
                            </div>
                        </div>

                        <div class="permission-matrix-container border rounded bg-white p-4 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                                <h5 class="font-weight-bold mb-0 text-dark">
                                    <i class="fas fa-cubes text-primary mr-2"></i> Role-Permission Capability Matrix
                                </h5>
                                <span class="badge badge-light border text-muted px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                    <i class="fas fa-shield-check mr-1 text-success"></i> Granular Access System
                                </span>
                            </div>

                            <!-- Premium Action Bar -->
                            <div class="action-bar-premium mb-4 p-3 bg-light rounded-lg border shadow-sm d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div class="input-group shadow-sm flex-grow-1" style="min-width: 280px; max-width: 600px; border-radius: 50px; overflow: hidden;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-0 text-primary px-4"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="matrix-search" class="form-control border-0 py-4 font-weight-500" placeholder="Search categories, modules, features..." style="font-size: 1rem; box-shadow: none;">
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm font-weight-bold d-flex align-items-center btn-hover-elevate" id="action-select-all">
                                        <i class="fas fa-check-circle mr-2"></i> Grant All
                                    </button>
                                    <button type="button" class="btn btn-danger rounded-pill px-4 py-2 shadow-sm font-weight-bold d-flex align-items-center btn-hover-elevate" id="action-deselect-all">
                                        <i class="fas fa-times-circle mr-2"></i> Revoke All
                                    </button>
                                </div>
                            </div>

                            <div class="permission-accordion-wrapper" id="permissionAccordion">
                                @foreach($sidebarGroups as $category => $modules)
                                    @php 
                                        $categoryId = 'cat_' . \Illuminate\Support\Str::slug($category, '_');
                                    @endphp
                                    <div class="card mb-4 border-0 shadow-sm rounded-lg accordion-item premium-card" data-category="{{ strtolower($category) }}" style="overflow: hidden;">
                                        <div class="card-header bg-white d-flex flex-wrap align-items-center p-3 category-header" id="heading_{{ $categoryId }}" data-toggle="collapse" data-target="#collapse_{{ $categoryId }}" aria-expanded="false" aria-controls="collapse_{{ $categoryId }}" style="cursor: pointer; transition: all 0.3s ease; border-bottom: 1px solid rgba(0,0,0,0.05);">
                                            <div class="d-flex align-items-center mb-2 mb-md-0 mr-3 flex-grow-1">
                                                <div class="icon-box bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-xs" style="min-width: 48px; height: 48px; font-size: 1.25rem;">
                                                    <i class="fas fa-layer-group"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0 font-weight-bold text-dark" style="font-size: 1.15rem; letter-spacing: -0.2px;">{{ $category }}</h5>
                                                    <div class="text-muted small mt-1 font-weight-500 d-flex align-items-center">
                                                        <i class="fas fa-cube text-primary mr-1 opacity-70"></i> 
                                                        <span class="mr-2">{{ count($modules) }} Modules</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="stats-pill bg-light rounded-pill px-3 py-1 mr-3 border d-flex align-items-center shadow-xs">
                                                    <i class="fas fa-chart-pie text-primary mr-2"></i>
                                                    <span class="font-weight-bold text-dark category-stats-{{ $categoryId }}" style="font-size: 0.9rem;">0 / 0</span>
                                                </div>
                                                <div class="toggle-icon-wrapper rounded-circle bg-light border d-flex align-items-center justify-content-center shadow-xs" style="min-width: 38px; height: 38px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                                                    <i class="fas fa-chevron-down text-primary accordion-icon transition-transform"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="collapse_{{ $categoryId }}" class="collapse collapse-body" aria-labelledby="heading_{{ $categoryId }}">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover bg-white mb-0 text-nowrap premium-matrix-table">
                                                        <thead class="bg-light sticky-top shadow-xs" style="z-index: 10;">
                                                            <tr>
                                                                <th style="min-width: 280px;" class="pl-4 py-3 text-uppercase small font-weight-bold text-dark border-0">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" id="select_all_{{ $categoryId }}" class="custom-control-input category-selector" data-category="{{ $categoryId }}">
                                                                        <label class="custom-control-label font-weight-bold" for="select_all_{{ $categoryId }}" style="font-size: 0.9rem;">Module / Feature</label>
                                                                    </div>
                                                                </th>
                                                                <th class="text-center py-3 text-uppercase small font-weight-bold border-0">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" id="select_all_create_{{ $categoryId }}" class="custom-control-input column-selector" data-column="create" data-category="{{ $categoryId }}">
                                                                        <label class="custom-control-label text-success font-weight-bold" for="select_all_create_{{ $categoryId }}">Create</label>
                                                                    </div>
                                                                </th>
                                                                <th class="text-center py-3 text-uppercase small font-weight-bold border-0">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" id="select_all_read_{{ $categoryId }}" class="custom-control-input column-selector" data-column="read" data-category="{{ $categoryId }}">
                                                                        <label class="custom-control-label text-primary font-weight-bold" for="select_all_read_{{ $categoryId }}">Read</label>
                                                                    </div>
                                                                </th>
                                                                <th class="text-center py-3 text-uppercase small font-weight-bold border-0">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" id="select_all_update_{{ $categoryId }}" class="custom-control-input column-selector" data-column="update" data-category="{{ $categoryId }}">
                                                                        <label class="custom-control-label text-warning font-weight-bold" for="select_all_update_{{ $categoryId }}">Update</label>
                                                                    </div>
                                                                </th>
                                                                <th class="text-center py-3 text-uppercase small font-weight-bold border-0">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" id="select_all_delete_{{ $categoryId }}" class="custom-control-input column-selector" data-column="delete" data-category="{{ $categoryId }}">
                                                                        <label class="custom-control-label text-danger font-weight-bold" for="select_all_delete_{{ $categoryId }}">Delete</label>
                                                                    </div>
                                                                </th>
                                                                <th class="text-center py-3 text-uppercase small font-weight-bold text-muted border-0">Other Capabilities</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($modules as $moduleName => $groupPermissions)
                                                                @php
                                                                    $rowId = $categoryId . '_' . \Illuminate\Support\Str::slug($moduleName, '_');
                                                                @endphp
                                                                <tr class="border-top matrix-row">
                                                                    <td class="pl-4 py-3 font-weight-bold text-dark d-flex align-items-center">
                                                                        <div class="custom-control custom-checkbox mr-3">
                                                                            <input type="checkbox" id="row_select_{{ $rowId }}" class="custom-control-input row-selector" data-row="{{ $rowId }}" data-category="{{ $categoryId }}">
                                                                            <label class="custom-control-label" for="row_select_{{ $rowId }}"></label>
                                                                        </div>
                                                                        <span class="module-title font-weight-600">
                                                                            {{ ucwords(str_replace(['_', '-'], ' ', $moduleName)) }}
                                                                        </span>
                                                                    </td>
                                                                    
                                                                    {{-- Dynamic columns for CRUD --}}
                                                                    @php
                                                                        $crudActions = ['create', 'read', 'update', 'delete'];
                                                                        $processedPermissions = [];
                                                                    @endphp
                                                                    
                                                                    @foreach($crudActions as $action)
                                                                        <td class="text-center py-3 align-middle">
                                                                            @php
                                                                                $perm = collect($groupPermissions)->first(function($p) use ($action) {
                                                                                    return str_ends_with($p->name, '.' . $action) || str_ends_with($p->name, '-' . $action);
                                                                                });
                                                                            @endphp
                                                                            
                                                                            @if($perm)
                                                                                @php $processedPermissions[] = $perm->id; @endphp
                                                                                <div class="custom-control custom-checkbox custom-control-inline mx-auto">
                                                                                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                                                                        id="perm_{{ $perm->id }}" class="custom-control-input perm-checkbox perm-{{ $action }} group-{{ $rowId }} cat-{{ $categoryId }}"
                                                                                        data-column="{{ $action }}" data-row="{{ $rowId }}" data-category="{{ $categoryId }}"
                                                                                        {{ (isset($role) && $role->permissions->contains('id', $perm->id)) ? 'checked' : '' }}>
                                                                                    <label class="custom-control-label" for="perm_{{ $perm->id }}"></label>
                                                                                </div>
                                                                            @else
                                                                                <span class="text-muted small align-middle" style="opacity: 0.5;">—</span>
                                                                            @endif
                                                                        </td>
                                                                    @endforeach

                                                                    {{-- Column for other permissions in this group --}}
                                                                    <td class="text-center py-3">
                                                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                                                        @foreach($groupPermissions as $p)
                                                                            @if(!in_array($p->id, $processedPermissions))
                                                                                <div class="custom-control custom-checkbox custom-control-inline align-items-center m-0 bg-light px-2 py-1 rounded border shadow-xs" title="{{ $p->name }}">
                                                                                    <input type="checkbox" name="permissions[]" value="{{ $p->name }}" 
                                                                                        id="perm_{{ $p->id }}" class="custom-control-input perm-checkbox perm-other group-{{ $rowId }} cat-{{ $categoryId }}"
                                                                                        data-column="other" data-row="{{ $rowId }}" data-category="{{ $categoryId }}"
                                                                                        {{ (isset($role) && $role->permissions->contains('id', $p->id)) ? 'checked' : '' }}>
                                                                                    <label class="custom-control-label mr-1" for="perm_{{ $p->id }}"></label>
                                                                                    <span class="small font-weight-500 text-dark">{{ preg_replace('/^.*?[\.-]/', '', $p->name) }}</span>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-premium-save px-5 shadow-sm">
                                <i class="fas fa-check-double mr-2"></i> {{ isset($role) ? 'Finalize Architecture Changes' : 'Initialize Role with Selected Matrix' }}
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Inventory Column -->
        <div class="col-md-12">
            <div class="card rbac-main-card">
                <div class="rbac-card-header d-flex justify-content-between align-items-center">
                    <h3 class="rbac-card-title mb-0">
                        <i class="fas fa-shield-alt text-primary mr-2"></i> Strategic Role Registry
                    </h3>
                    <div class="input-group" style="width: 300px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" id="role-table-search" class="form-control border-left-0" placeholder="Search roles...">
                    </div>
                </div>
                <div class="rbac-card-body p-0">
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px" class="text-center">#</th>
                                    <th style="width: 250px">Role Definition</th>
                                    <th>Embedded Matrix Summary</th>
                                    <th style="width: 120px" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="role-table-body">
                                @foreach($roles as $key => $r)
                                <tr class="role-table-row">
                                    <td class="text-center text-muted font-weight-bold">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $r->name }}</div>
                                        <div class="small text-muted text-uppercase">{{ count($r->permissions) }} capabilities assigned</div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            @php
                                                $roleGroups = $r->permissions->groupBy(function($p) {
                                                    if (str_contains($p->name, '.')) {
                                                        $parts = explode('.', $p->name);
                                                        return $parts[0];
                                                    } elseif (str_contains($p->name, '-')) {
                                                        $parts = explode('-', $p->name);
                                                        array_pop($parts);
                                                        return implode('-', $parts) ?: $p->name;
                                                    }
                                                    return 'Others';
                                                });
                                                $displayCount = 0;
                                                $maxDisplay = 3;
                                            @endphp
                                            
                                            @foreach($roleGroups as $gn => $gp)
                                                @if($displayCount < $maxDisplay)
                                                    <div class="mr-3 mb-2 p-2 bg-light border rounded shadow-xs" style="min-width: 140px;">
                                                        <div class="font-weight-bold small text-primary mb-1 border-bottom pb-1">{{ ucwords(str_replace(['_', '-'], ' ', $gn)) }}</div>
                                                        <div class="d-flex gap-1">
                                                            @foreach($gp as $p)
                                                                @php 
                                                                    if (str_contains($p->name, '.')) {
                                                                        $parts = explode('.', $p->name);
                                                                        $action = end($parts);
                                                                    } elseif (str_contains($p->name, '-')) {
                                                                        $parts = explode('-', $p->name);
                                                                        $action = end($parts);
                                                                    } else {
                                                                        $action = 'other';
                                                                    }
                                                                @endphp
                                                                <span class="badge badge-white border text-{{ 
                                                                    $action == 'create' ? 'success' : 
                                                                    ($action == 'read' ? 'primary' : 
                                                                    ($action == 'update' ? 'warning' : 
                                                                    ($action == 'delete' ? 'danger' : 'secondary'))) 
                                                                }} mr-1" style="font-size: 0.65rem;" title="{{ $p->name }}">
                                                                    {{ strtoupper(substr($action, 0, 1)) }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @php $displayCount++; @endphp
                                                @endif
                                            @endforeach

                                            @if($roleGroups->count() > $maxDisplay)
                                                <button type="button" class="btn btn-sm btn-outline-primary shadow-sm mb-2 ml-1" data-toggle="modal" data-target="#roleModal{{ $r->id }}">
                                                    +{{ $roleGroups->count() - $maxDisplay }} More
                                                </button>
                                            @elseif($roleGroups->count() > 0)
                                                <button type="button" class="btn btn-sm btn-outline-primary shadow-sm mb-2 ml-1" data-toggle="modal" data-target="#roleModal{{ $r->id }}">
                                                    View All
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="roleModal{{ $r->id }}" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel{{ $r->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title font-weight-bold" id="roleModalLabel{{ $r->id }}">
                                                            <i class="fas fa-shield-alt text-primary mr-2"></i> {{ $r->name }} - Full Permission Matrix
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body bg-white p-4">
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @foreach($roleGroups as $gn => $gp)
                                                                <div class="mr-3 mb-3 p-3 bg-light border rounded shadow-xs" style="min-width: 160px;">
                                                                    <div class="font-weight-bold text-primary mb-2 border-bottom pb-2">{{ ucwords(str_replace(['_', '-'], ' ', $gn)) }}</div>
                                                                    <div class="d-flex flex-wrap gap-1">
                                                                        @foreach($gp as $p)
                                                                            @php 
                                                                                if (str_contains($p->name, '.')) {
                                                                                    $parts = explode('.', $p->name);
                                                                                    $action = end($parts);
                                                                                } elseif (str_contains($p->name, '-')) {
                                                                                    $parts = explode('-', $p->name);
                                                                                    $action = end($parts);
                                                                                } else {
                                                                                    $action = 'other';
                                                                                }
                                                                            @endphp
                                                                            <span class="badge badge-white border text-{{ 
                                                                                $action == 'create' ? 'success' : 
                                                                                ($action == 'read' ? 'primary' : 
                                                                                ($action == 'update' ? 'warning' : 
                                                                                ($action == 'delete' ? 'danger' : 'secondary'))) 
                                                                            }} mr-1 mb-1" style="font-size: 0.75rem;" title="{{ $p->name }}">
                                                                                {{ strtoupper($action) }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            @if(edit_permission('roles') || is_superadmin() || (auth()->check() && auth()->user()->role_id == 6))
                                            <a href="{{ route('role.edit', $r->id) }}" class="btn btn-sm btn-light border" title="Modify Matrix Architecture">
                                                <i class="fas fa-edit text-primary"></i>
                                            </a>
                                            @endif
                                            @if(delete_permission('roles') || is_superadmin())
                                            <form action="{{ route('role.destroy', $r->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-light border btn-delete-confirm" title="Decommission Role">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
    /* Premium UI Enhancements */
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important; }
    .rounded-lg { border-radius: 0.75rem !important; }
    .font-weight-500 { font-weight: 500 !important; }
    .font-weight-600 { font-weight: 600 !important; }
    .opacity-70 { opacity: 0.7; }
    .gap-1 { gap: 0.25rem !important; }
    .gap-2 { gap: 0.5rem !important; }
    .gap-3 { gap: 1rem !important; }
    
    .bg-light-primary {
        background-color: #f0f7ff !important;
        color: #3b82f6 !important;
    }
    
    .btn-hover-elevate {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-hover-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
    }

    .action-bar-premium {
        background: linear-gradient(to right, #ffffff, #f8fafc);
    }
    
    .premium-card {
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .premium-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.025) !important;
        border-color: rgba(59, 130, 246, 0.2) !important;
    }

    .category-header:hover {
        background-color: #f8fafc !important;
    }
    .bg-primary-light {
        background-color: #f8fbff !important;
        border-left: 4px solid #3b82f6 !important;
    }
    .bg-primary-light .icon-box {
        background-color: #3b82f6 !important;
        color: white !important;
    }

    .premium-matrix-table td {
        vertical-align: middle;
    }
    .premium-matrix-table tbody tr {
        transition: background-color 0.2s ease;
    }
    .premium-matrix-table tbody tr:hover {
        background-color: #f8fbff !important;
    }

    /* Custom Checkbox Enhancements */
    .custom-control-label::before, .custom-control-label::after {
        top: 0.15rem !important;
        width: 1.35rem !important;
        height: 1.35rem !important;
        border-radius: 6px !important;
        transition: all 0.2s ease-in-out;
    }
    .custom-control-label::before {
        border: 2px solid #cbd5e1 !important;
        background-color: #fff !important;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3) !important;
    }
    
    /* Perm-other checkbox styling */
    .perm-other ~ .custom-control-label::before, .perm-other ~ .custom-control-label::after {
        width: 1.15rem !important;
        height: 1.15rem !important;
        top: 0.1rem !important;
    }

    .transition-transform {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush

@push('script')
<script>
(function($) {
    $(document).ready(function() {
        // 1. Live reactive search input
        $('#matrix-search').on('keyup', function() {
            let val = $(this).val().toLowerCase();
            
            if (val === '') {
                $('.accordion-item').show();
                $('.matrix-row').show();
                return;
            }

            $('.accordion-item').each(function() {
                let categoryCard = $(this);
                let categoryName = categoryCard.data('category');
                let categoryMatch = categoryName.includes(val);
                
                let hasVisibleRows = false;
                
                categoryCard.find('.matrix-row').each(function() {
                    let row = $(this);
                    let rowText = row.find('.module-title').text().toLowerCase();
                    
                    if (categoryMatch || rowText.includes(val)) {
                        row.show();
                        hasVisibleRows = true;
                    } else {
                        row.hide();
                    }
                });
                
                if (hasVisibleRows || categoryMatch) {
                    categoryCard.show();
                    if (val.length > 2 && !categoryMatch) {
                         categoryCard.find('.collapse').collapse('show');
                    }
                } else {
                    categoryCard.hide();
                }
            });
        });

        // Toggle icon rotation on collapse
        $('.collapse-body').on('show.bs.collapse', function () {
            $(this).parent().find('.accordion-icon').css('transform', 'rotate(180deg)');
        }).on('hide.bs.collapse', function () {
            $(this).parent().find('.accordion-icon').css('transform', 'rotate(0deg)');
        });

        // 3. Global selector (Category-level Select All)
        $('.category-selector').on('change', function() {
            let cat = $(this).data('category');
            let checked = $(this).prop('checked');
            $('.cat-' + cat).prop('checked', checked).trigger('change');
        });

        // 4. Column selectors in header
        $('.column-selector').on('change', function() {
            let column = $(this).data('column');
            let cat = $(this).data('category');
            let checked = $(this).prop('checked');
            $('.cat-' + cat + '.perm-' + column).prop('checked', checked).trigger('change');
        });

        // 5. Row-level selectors next to module name
        $('.row-selector').on('change', function() {
            let rowName = $(this).data('row');
            let checked = $(this).prop('checked');
            $('.group-' + rowName).prop('checked', checked).trigger('change');
        });

        // 6. Quick Action buttons
        $('#action-select-all').on('click', function() {
            $('.perm-checkbox').prop('checked', true).trigger('change');
            $('.collapse-body').collapse('show');
        });

        $('#action-deselect-all').on('click', function() {
            $('.perm-checkbox').prop('checked', false).trigger('change');
        });

        // 7. Individual Checkbox state synchronization and badge counting!
        $('.perm-checkbox').on('change', function() {
            let row = $(this).data('row');
            let col = $(this).data('column');
            let cat = $(this).data('category');
            
            // Sync row selector state
            let rowCheckboxes = $('.group-' + row);
            let rowChecked = $('.group-' + row + ':checked');
            $('#row_select_' + row).prop('checked', rowCheckboxes.length > 0 && rowCheckboxes.length === rowChecked.length);
            
            // Sync column selector state
            let colCheckboxes = $('.cat-' + cat + '.perm-' + col);
            let colChecked = $('.cat-' + cat + '.perm-' + col + ':checked');
            $('#select_all_' + col + '_' + cat).prop('checked', colCheckboxes.length > 0 && colCheckboxes.length === colChecked.length);
            
            // Sync category global selector
            let catCheckboxes = $('.cat-' + cat);
            let catChecked = $('.cat-' + cat + ':checked');
            $('#select_all_' + cat).prop('checked', catCheckboxes.length > 0 && catCheckboxes.length === catChecked.length);

            updateCounts();
        });

        function updateCounts() {
            // Update per category badge stats
            $('.accordion-item').each(function() {
                let catItem = $(this);
                let catId = catItem.find('.category-selector').data('category');
                let total = catItem.find('.perm-checkbox').length;
                let checked = catItem.find('.perm-checkbox:checked').length;
                
                catItem.find('.category-stats-' + catId).text(checked + ' / ' + total);
                
                if(checked > 0) {
                    catItem.find('.card-header').addClass('bg-primary-light');
                    catItem.find('.card-header').css('border-left', '4px solid #3b82f6');
                } else {
                    catItem.find('.card-header').removeClass('bg-primary-light');
                    catItem.find('.card-header').css('border-left', 'none');
                }
            });
        }

        // Table search functionality
        $('#role-table-search').on('keyup', function() {
            let val = $(this).val().toLowerCase();
            $('#role-table-body .role-table-row').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1)
            });
        });

        // Initialize counts and states on page load!
        updateCounts();

        // Auto open modal on edit or error
        @if(isset($role) || count($errors) > 0)
            $('#createRoleModal').modal('show');
        @endif
        
        // Sync all row selectors with checkboxes on page load
        $('.row-selector').each(function() {
            let row = $(this).data('row');
            let rowCheckboxes = $('.group-' + row);
            let rowChecked = $('.group-' + row + ':checked');
            $(this).prop('checked', rowCheckboxes.length > 0 && rowCheckboxes.length === rowChecked.length);
        });

        // Sync category and column selectors
        $('.category-selector').each(function() {
            let cat = $(this).data('category');
            let catCheckboxes = $('.cat-' + cat);
            let catChecked = $('.cat-' + cat + ':checked');
            $(this).prop('checked', catCheckboxes.length > 0 && catCheckboxes.length === catChecked.length);
        });

        $('.column-selector').each(function() {
            let col = $(this).data('column');
            let cat = $(this).data('category');
            let colCheckboxes = $('.cat-' + cat + '.perm-' + col);
            let colChecked = $('.cat-' + cat + '.perm-' + col + ':checked');
            $(this).prop('checked', colCheckboxes.length > 0 && colCheckboxes.length === colChecked.length);
        });
    });
})(jQuery);
</script>
@endpush
@endsection
