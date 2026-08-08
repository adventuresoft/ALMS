<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsidiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subsidies')) {
        Schema::create('subsidies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('subsidy_types')->onDelete('cascade');
            $table->decimal('amount', 8,2)->default(0.00);
            $table->bigInteger('financial_year')->nullable();
            $table->enum('status', ['pending', 'approved', 'declined', 'paid', 'unpaid'])->default('pending');
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
        Schema::dropIfExists('subsidies');
    }
}
