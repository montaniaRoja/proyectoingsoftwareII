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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('no_cuenta')->unique();
            $table->unsignedInteger('id_cliente');
            $table->string('moneda');
            $table->unsignedInteger('creado_por');
            $table->timestamps();
            $table->foreign('id_cliente')->references('id')->on('customers');
            $table->foreign('creado_por')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
