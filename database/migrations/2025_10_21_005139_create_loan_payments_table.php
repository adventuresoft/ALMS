<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('loan_payments')) {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_info_id')->constrained('loan_infos')->onDelete('cascade');
            $table->decimal('amount', 16,2)->default(0.00);
            $table->dateTime('date');
            $table->foreignId('created_by')->constrained('users');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('loan_payments');
    }
}
