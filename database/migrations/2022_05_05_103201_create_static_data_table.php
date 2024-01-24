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
        Schema::create('static_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('entreprise_id');
            $table->string('type');
            $table->string('valeur');
            $table->unsignedInteger('statut')->default(1);
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
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
        Schema::dropIfExists('static_data');
    }
};
