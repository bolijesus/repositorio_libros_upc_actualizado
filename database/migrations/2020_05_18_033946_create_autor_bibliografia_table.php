<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorBibliografiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autor_bibliografia', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('autor_id');
            $table->foreign('autor_id')->references('id')->on('autors')->onDelete('CASCADE');
            
            $table->unsignedBigInteger('bibliografia_id');
            $table->foreign('bibliografia_id')->references('id')->on('bibliografias')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autor_bibliografia');
    }
}
