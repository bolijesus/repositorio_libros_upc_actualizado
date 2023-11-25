<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBibliografiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bibliografias', function (Blueprint $table) {
            $table->id();
            
            //relacion polimorfica 
            $table->unsignedBigInteger('bibliografiable_id');
            $table->string('bibliografiable_type');
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->OnDelete('SET NULL');
            
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('idioma');
            $table->string('archivo');
            $table->string('portada')->default('public/portada.png');
            $table->unsignedTinyInteger('revisado')->default(1)->comment('1:en revision, 2:no aceptado, 3:revisado');

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
        Schema::dropIfExists('bibliografias');
    }
}
