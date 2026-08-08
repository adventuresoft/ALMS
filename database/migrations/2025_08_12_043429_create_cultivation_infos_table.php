<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCultivationInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cultivation_infos')) {
        Schema::create('cultivation_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string("crop")->nullable();
            $table->enum("land_owner", ['own', 'borrow'])->default("own");
            $table->string("quantity")->nullable();
            $table->text("address")->nullable();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('cultivation_infos');
    }
}
