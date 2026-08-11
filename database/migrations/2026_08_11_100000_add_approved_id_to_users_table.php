<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'approved_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('approved_id', 20)->nullable()->unique()->after('system_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'approved_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('approved_id');
            });
        }
    }
}
