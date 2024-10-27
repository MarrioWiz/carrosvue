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
        Schema::create('autos', function (Blueprint $table) {
            $table->id(); // ID de la tabla
            $table->string('modelo', 80); // Modelo del carro
            $table->string('color', 50); // Color del carro
            $table->decimal('precio', 10, 2); // Precio del carro
            $table->string('transmision', 50); // Transmisión del carro
            $table->string('submarca', 80); // Submarca del carro
            $table->foreignId('marca_id')->constrained('marcas') // Clave foránea a la tabla 'marcas'
                ->onUpdate('cascade')->onDelete('restrict');
            $table->string('imagen');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
