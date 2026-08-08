<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('loan_infos')) {
        Schema::create('loan_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger("loan_type")->default(false);
            $table->bigInteger('bank_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->decimal('amount', 8,2)->default(0.00);
            $table->bigInteger('financial_year')->nullable();

            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_father_name')->nullable();
            $table->string('guarantor_mother_name')->nullable();
            $table->date('guarantor_dob')->nullable();
            $table->string('guarantor_nid')->nullable();
            $table->string('guarantor_address')->nullable();
            $table->string('guarantor_mobile')->nullable();


            $table->enum('status', ['pending', 'approved', 'declined', 'paid', 'unpaid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_infos');
    }
}
