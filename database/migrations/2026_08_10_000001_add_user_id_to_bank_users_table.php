<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bank_users')) {
            Schema::table('bank_users', function (Blueprint $table) {
                if (!Schema::hasColumn('bank_users', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('people_id');
                }
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
        if (Schema::hasTable('bank_users')) {
            Schema::table('bank_users', function (Blueprint $table) {
                if (Schema::hasColumn('bank_users', 'user_id')) {
                    $table->dropColumn('user_id');
                }
            });
        }
    }
};
