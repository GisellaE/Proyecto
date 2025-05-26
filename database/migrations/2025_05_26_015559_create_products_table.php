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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // Nombre del reloj
            $table->string('slug')->unique();        // Slug para URL amigable
            $table->text('description');             // Descripción del producto
            $table->decimal('price', 8, 2);          // Precio (formato decimal)
            $table->string('brand');                 // Marca del reloj
            $table->integer('stock');                // Inventario disponible
            $table->string('image')->nullable();     // Nombre o ruta de la imagen
            $table->foreignId('category_id')         // Relación con categorías
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();                    // created_at, updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
