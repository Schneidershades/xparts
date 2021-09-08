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
            $table->text('title')->index()->nullable();
            $table->text('image')->nullable();
            $table->foreignId('category_two_id')->index()->nullable()->constrained();
            $table->text('category_two_name')->nullable();
            $table->text('slug')->index()->nullable();
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
