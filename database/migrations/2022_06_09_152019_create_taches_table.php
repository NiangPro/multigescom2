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
        Schema::create('taches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titre');
            $table->string('priorite');
            $table->string('statut');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('description');
            $table->unsignedBigInteger('assignation');
            $table->foreign('assignation')->references('id')->on('users')->onDelete("cascade");
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete("cascade");
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
        Schema::dropIfExists('taches');
    }
};
