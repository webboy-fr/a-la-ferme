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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('farm_image');
            $table->foreignId('farm_details_id')->constrained('farm_details', 'id')->nullable(false); //Foreign key farm_details_id on the id column in farm_details tables
            $table->foreignId('user_id')->constrained('users', 'id')->nullable(false); //Foreign key user_id on the id column in users tables
            $table->foreignId('lang_id')->constrained('langs', 'id')->nullable(false)->default('1'); //Foreign key user_id on the id column in users tables
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
        Schema::dropIfExists('farms');
    }
};
