<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Module;
use Spatie\Permission\Models\Permission;

class CreateFinancialYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('financial_years')) {
        Schema::create('financial_years', function (Blueprint $table) {
            $table->id();
            $table->string('en_name');
            $table->string('bn_name');
            $table->string('slug')->nullable();
            $table->boolean('status')->default(1)->comment('0=>Inactive, 1=>Active');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // Insert default financial years matching the original helper IDs
        $defaultYears = [
            ['id' => 1, 'en_name' => '2020-2021', 'bn_name' => '২০২০-২০২১', 'slug' => '2020-2021', 'status' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'en_name' => '2021-2022', 'bn_name' => '২০২১-২০২২', 'slug' => '2021-2022', 'status' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'en_name' => '2022-2023', 'bn_name' => '২০২২-২০২৩', 'slug' => '2022-2023', 'status' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'en_name' => '2023-2024', 'bn_name' => '২০২৩-২০২৪', 'slug' => '2023-2024', 'status' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'en_name' => '2024-2025', 'bn_name' => '২০২৪-২০২৫', 'slug' => '2024-2025', 'status' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'en_name' => '2025-2026', 'bn_name' => '২০২৫-২০২৬', 'slug' => '2025-2026', 'status' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('financial_years')->insert($defaultYears);

        // Create the module entry
        $module = Module::firstOrCreate(
            ['slug' => 'financial-year'],
            ['name' => 'Financial Year', 'status' => 1]
        );

        // Auto generate Spatie permissions
        $actions = ['read', 'create', 'update', 'delete'];
        foreach ($actions as $action) {
            Permission::firstOrCreate([
                'name' => 'financial-year-' . $action,
                'guard_name' => 'web'
            ]);
        }

        // Give permissions to Admin (role_id = 1) and Developer (role_id = 4)
        $rolesToAssign = [1, 4];
        $adminPermissions = [
            'financial-year-read',
            'financial-year-create',
            'financial-year-update',
            'financial-year-delete',
        ];

        foreach ($rolesToAssign as $roleId) {
            foreach ($adminPermissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if ($permission) {
                    DB::table('role_has_permissions')->insertOrIgnore([
                        'permission_id' => $permission->id,
                        'role_id' => $roleId
                    ]);
                }
            }
        }
    }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_years');

        // Delete the module and permissions
        Module::where('slug', 'financial-year')->delete();
        $permissions = [
            'financial-year-read',
            'financial-year-create',
            'financial-year-update',
            'financial-year-delete',
        ];
        Permission::whereIn('name', $permissions)->delete();
    }
}
