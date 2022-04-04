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
        Schema::create('farm_details', function (Blueprint $table) {
            $table->id();
            $table->string('farm_image');
            $table->string('name');
            $table->string('description');
            $table->string('about');
            $table->foreignId('lang_id')->default(1)->constrained('langs', 'id')->cascadeOnUpdate(); //Foreign key farm_id on the id column in farms tables
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
        Schema::dropIfExists('farm_details');
    }
};
