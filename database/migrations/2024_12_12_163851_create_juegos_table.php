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
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->string('palabra');
            $table->string('intentos');
            $table->string('letras_usadas')->nullable();
            $table->string('letras_correctas')->nullable();
            $table->unsignedBigInteger('jugador_id')->nullable();
            $table->timestamps();
            $table->foreign('jugador_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juegos');
    }
};
