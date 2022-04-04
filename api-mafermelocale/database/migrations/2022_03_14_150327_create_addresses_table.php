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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('postcode');
            $table->string('city');
            $table->decimal('lon', 10, 6);
            $table->decimal('lat', 10, 6);
            $table->foreignId('country_id')->default(1)->constrained('countries', 'id')->cascadeOnUpdate(); //Foreign key country_id on the id column in countries tables
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
        Schema::dropIfExists('addresses');
    }
};
