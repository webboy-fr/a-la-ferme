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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('price', 9, 3);
            $table->string('product_image');
            $table->boolean('is_bio')->default(0);
            $table->boolean('is_aop')->default(0);
            $table->boolean('is_aoc')->default(0);
            $table->boolean('is_igp')->default(0);
            $table->boolean('is_stg')->default(0);
            $table->boolean('is_labelrouge');
            $table->foreignId('category_id')->constrained('categories', 'id')->nullable(false); //Foreign key category_id on the id column in categories tables
            $table->foreignId('farm_id')->constrained('farms', 'id')->nullable(false); //Foreign key farm_id on the id column in farms tables
            $table->foreignId('currency_id')->constrained('currencies', 'id')->nullable(false)->default(1); //Foreign key farm_id on the id column in farms tables
            $table->foreignId('lang_id')->constrained('langs', 'id')->nullable(false)->default(1); //Foreign key farm_id on the id column in farms tables
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
        Schema::dropIfExists('products');
    }
};
