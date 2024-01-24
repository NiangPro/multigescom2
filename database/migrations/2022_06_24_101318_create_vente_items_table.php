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
        Schema::create('vente_items', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("nom");
            $table->text("description")->nullable();
            $table->double("montant");
            $table->double("quantite");
            $table->double("taxe");
            $table->unsignedBigInteger("vente_id");
            $table->foreign("vente_id")->references("id")->on("ventes")->onDelete("cascade");
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
        Schema::dropIfExists('vente_items');
    }
};
