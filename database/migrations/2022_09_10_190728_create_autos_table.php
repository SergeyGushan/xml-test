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
        Schema::create('autos', function (Blueprint $table) {
            $table->bigInteger('id')->unique()->primary();
            $table->timestamps();
            $table->year('year')->nullable();
            $table->float('run')->nullable();
            $table->bigInteger('mark_id')->unsigned()->nullable();
            $table->bigInteger('mark_model_id')->unsigned()->nullable();
            $table->bigInteger('mark_model_generation_id')->unsigned()->nullable();
            $table->bigInteger('color_id')->unsigned()->nullable();
            $table->bigInteger('body_type_id')->unsigned()->nullable();
            $table->bigInteger('engine_type_id')->unsigned()->nullable();
            $table->bigInteger('transmission_id')->unsigned()->nullable();
            $table->bigInteger('gear_type_id')->unsigned()->nullable();

            $table->foreign('mark_id')->references('id')->on('marks')->onDelete('cascade');
            $table->foreign('mark_model_id')->references('id')->on('mark_models')->onDelete('cascade');
            $table->foreign('mark_model_generation_id')->references('id')->on('mark_model_generations')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('cascade');
            $table->foreign('engine_type_id')->references('id')->on('engine_types')->onDelete('cascade');
            $table->foreign('transmission_id')->references('id')->on('transmissions')->onDelete('cascade');
            $table->foreign('gear_type_id')->references('id')->on('gear_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autos');
    }
};
