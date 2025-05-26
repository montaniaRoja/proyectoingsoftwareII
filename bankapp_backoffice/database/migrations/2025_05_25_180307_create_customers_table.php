<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_doc')->unique();
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono');
            $table->string('direccion');
            $table->unsignedInteger('creado_por');
            $table->string('keyword')->nullable();
            $table->timestamps();
            $table->foreign('creado_por')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
