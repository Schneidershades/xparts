<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryThreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_threes', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('image')->nullable();
            $table->foreignId('category_two_id')->nullable()->constrained();
            $table->text('category_two_name')->nullable();
            $table->text('slug')->nullable();
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
        Schema::dropIfExists('category_threes');
    }
}
