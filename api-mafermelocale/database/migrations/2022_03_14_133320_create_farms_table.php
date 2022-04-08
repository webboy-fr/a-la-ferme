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
            $table->string('name');
            $table->string('farm_image');
            $table->string('short_description');
            $table->foreignId('address_id')->constrained('addresses', 'id')->cascadeOnUpdate(); //Foreign key user_id on the id column in users tables
            $table->foreignId('farm_details_id')->constrained('farm_details', 'id')->cascadeOnUpdate()->cascadeOnDelete(); //Foreign key farm_details_id on the id column in farm_details tables
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnUpdate()->cascadeOnDelete(); //Foreign key user_id on the id column in users tables
            $table->foreignId('lang_id')->default(1)->constrained('langs', 'id')->cascadeOnUpdate()->cascadeOnDelete(); //Foreign key lang_id on the id column in langs tables
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
