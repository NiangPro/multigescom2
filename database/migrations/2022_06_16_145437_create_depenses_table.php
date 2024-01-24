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
        Schema::create('depenses', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("categorie");
            $table->string("mode_paiement");
            $table->text("description")->nullable();
            $table->date("date");
            $table->double("montant");
            $table->unsignedBigInteger("entreprise_id");
            $table->foreign("entreprise_id")->references("id")->on("entreprises")->onDelete("cascade");
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
        Schema::dropIfExists('depenses');
    }
};
