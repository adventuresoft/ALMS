<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankSellingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bank_sellings')) {
        Schema::create('bank_sellings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('financial_year')->nullable();
            $table->foreignId('bank_id')->constrained('banks');
            $table->decimal('amount', 16,2)->default(0.00);
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
        Schema::dropIfExists('bank_sellings');
    }
}
