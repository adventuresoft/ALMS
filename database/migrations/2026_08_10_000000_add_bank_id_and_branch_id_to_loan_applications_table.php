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
        if (Schema::hasTable('loan_applications')) {
            Schema::table('loan_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('loan_applications', 'bank_id')) {
                    $table->unsignedBigInteger('bank_id')->nullable()->after('loan_amount');
                }
                if (!Schema::hasColumn('loan_applications', 'branch_id')) {
                    $table->unsignedBigInteger('branch_id')->nullable()->after('bank_id');
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
        if (Schema::hasTable('loan_applications')) {
            Schema::table('loan_applications', function (Blueprint $table) {
                if (Schema::hasColumn('loan_applications', 'branch_id')) {
                    $table->dropColumn('branch_id');
                }
                if (Schema::hasColumn('loan_applications', 'bank_id')) {
                    $table->dropColumn('bank_id');
                }
            });
        }
    }
};
