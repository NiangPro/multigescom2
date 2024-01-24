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
        Schema::create('produits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('image_produit');
            $table->double('tarif');
            $table->float('taxe');
            $table->unsignedBigInteger('entreprise_id');
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
        Schema::dropIfExists('produits');
    }
};
