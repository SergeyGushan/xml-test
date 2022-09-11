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
        Schema::create('mark_model_generations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->bigInteger('mark_model_id')->unsigned()->nullable();
            $table->bigInteger('mark_id')->unsigned()->nullable();
            $table->foreign('mark_id')->references('id')->on('marks')->onDelete('cascade');
            $table->foreign('mark_model_id')->references('id')->on('mark_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mark_model_generations');
    }
};
