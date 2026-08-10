<?php

use Illuminate\Support\Facades\Auth;

/**
 * Role ID Reference for ALMS & UPMS:
 * 1  = Admin (Superadmin)
 * 4  = Developer (Superadmin-equivalent)
 * 14, 15 = ALMS System Admins (Superadmin-equivalent)
 * 2  = DC
 * 3  = UNO
 * 6  = Union Admin       (Institutional Admin)
 * 8  = Pourashava Admin  (Institutional Admin)
 * 10 = City Corp Admin   (Institutional Admin)
 */

if (! function_exists('is_superadmin')) {
    function is_superadmin() {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return in_array($user->role_id, [1, 4, 14, 15]);
    }
}

if (! function_exists('is_bank_admin')) {
    function is_bank_admin() {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return in_array($user->role_id, [17, 18]) || ($user->roles && $user->roles->contains('name', 'Bank Admin'));
    }
}

if (! function_exists('get_user_bank_id')) {
    function get_user_bank_id($userId = null) {
        $userId = $userId ?? Auth::id();
        if (!$userId) return null;
        $bankUser = \App\Models\BankUser::where('user_id', $userId)
            ->orWhere('people_id', $userId)
            ->first();
        if (!$bankUser) {
            $people = \App\Models\People::where('user_id', $userId)->first();
            if ($people) {
                $bankUser = \App\Models\BankUser::where('people_id', $people->id)->first();
            }
        }
        return $bankUser ? $bankUser->bank_id : null;
    }
}

if (! function_exists('is_institutional_admin')) {
    function is_institutional_admin() {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return is_superadmin() || ($user->institute_id && !in_array($user->role_id, [4, 14, 15])) || in_array($user->role_id, [2, 3, 6, 8, 10]);
    }
}

if (! function_exists('access_management_permission')) {
    function access_management_permission() {
        return is_superadmin() || is_institutional_admin();
    }
}

if (! function_exists('basic_settings_permissions')) {
    function basic_settings_permissions() {
        return is_superadmin() || (Auth::check() && Auth::user()->can('basic-settings.read'));
    }
}

if (! function_exists('institute_permissions')) {
    function institute_permissions() {
        return is_superadmin();
    }
}

/**
 * create_permission($module = null)
 */
if (! function_exists('create_permission')) {
    function create_permission($module = null) {
        if (! Auth::check()) return false;
        if (is_superadmin() || Auth::user()->role_id == 6) return true;

        $user = Auth::user();
        if ($module) {
            try {
                return $user->hasPermissionTo($module . '.create') || $user->hasPermissionTo($module . '-create');
            } catch (\Exception $e) {
                return false;
            }
        }
        return is_institutional_admin()
            || $user->getAllPermissions()->contains(fn($p) => str_ends_with($p->name, '.create') || str_ends_with($p->name, '-create'));
    }
}

/**
 * edit_permission($module = null)
 */
if (! function_exists('edit_permission')) {
    function edit_permission($module = null) {
        if (! Auth::check()) return false;
        if (is_superadmin() || Auth::user()->role_id == 6) return true;

        $user = Auth::user();
        if ($module) {
            try {
                return $user->hasPermissionTo($module . '.update') || $user->hasPermissionTo($module . '-update');
            } catch (\Exception $e) {
                return false;
            }
        }
        return $user->getAllPermissions()->contains(fn($p) => str_ends_with($p->name, '.update') || str_ends_with($p->name, '-update'));
    }
}

/**
 * view_permission($module = null)
 */
if (! function_exists('view_permission')) {
    function view_permission($module = null) {
        if (! Auth::check()) return false;
        if (is_superadmin() || Auth::user()->role_id == 6) return true;

        $user = Auth::user();
        if ($module) {
            if (is_array($module)) {
                foreach ($module as $m) {
                    try {
                        if ($user->hasPermissionTo($m . '.read') || $user->hasPermissionTo($m . '-read')) return true;
                    } catch (\Exception $e) {}
                }
                return false;
            }
            try {
                return $user->hasPermissionTo($module . '.read') || $user->hasPermissionTo($module . '-read');
            } catch (\Exception $e) {
                return false;
            }
        }
        return $user->getAllPermissions()->contains(fn($p) => str_ends_with($p->name, '.read') || str_ends_with($p->name, '-read'));
    }
}

/**
 * delete_permission($module = null)
 */
if (! function_exists('delete_permission')) {
    function delete_permission($module = null) {
        if (! Auth::check()) return false;
        if (is_superadmin() || Auth::user()->role_id == 6) return true;

        $user = Auth::user();
        if ($module) {
            try {
                return $user->hasPermissionTo($module . '.delete') || $user->hasPermissionTo($module . '-delete');
            } catch (\Exception $e) {
                return false;
            }
        }
        return $user->getAllPermissions()->contains(fn($p) => str_ends_with($p->name, '.delete') || str_ends_with($p->name, '-delete'));
    }
}
