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
        Schema::create('ventes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('montant');
            $table->double('remise');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references("id")->on("clients")->onDelete("cascade");
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')->references("id")->on("entreprises")->onDelete("cascade");
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
        Schema::dropIfExists('ventes');
    }
};
