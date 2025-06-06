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
        Schema::create('transaccions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cuenta_id');
            $table->string('tipo_movimiento');
            $table->double('monto');
            $table->unsignedInteger('cajero');
            $table->timestamps();

            $table->foreign('cajero')->references('id')->on('users');
            $table->foreign('cuenta_id')->references('id')->on('accounts');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccions');
    }
};
