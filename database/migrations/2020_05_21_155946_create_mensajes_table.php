<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('emisor');
            $table->unsignedBigInteger('receptor');

            $table->unsignedBigInteger('bibliografia_id');
            $table->foreign('bibliografia_id')->references('id')->on('bibliografias')->onDelete('CASCADE');
 

            $table->text('contenido');

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
        Schema::dropIfExists('mensajes');
    }
}
