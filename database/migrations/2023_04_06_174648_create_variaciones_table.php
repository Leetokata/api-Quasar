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
        Schema::create('variaciones', function (Blueprint $table) {
            $table->id();
            $table->string('referencia');
            $table->longText('descripcion');
            $table->unsignedDecimal('precio', $precision = 20, $scale = 2);
            $table->unsignedBigInteger('producto_id');
            $table->timestamps();


            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variaciones');
    }
};
