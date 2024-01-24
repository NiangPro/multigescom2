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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('adresse');
            $table->string('tel');
            $table->string('email');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on("countries")->onDelete("cascade");
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')->references('id')->on("entreprises")->onDelete("cascade");
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
        Schema::dropIfExists('fournisseurs');
    }
};
