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
        Schema::create('properties', function (Blueprint $table) {  
            $table->id();  
            $table->string('title'); 
            $table->text('description')->nullable();  
            $table->string('property_type');  
            $table->string('transaction_type'); 
            $table->decimal('price', 10, 2)->index();  
            $table->decimal('area', 10, 2);  
            $table->string('city')->index();  
            $table->string('neighborhood')->index();   
            $table->decimal('latitude', 9, 6)->nullable();  
            $table->decimal('longitude', 9, 6)->nullable(); 
            $table->integer('bedrooms')->nullable();  
            $table->integer('bathrooms')->nullable();  
            $table->integer('floor_number')->nullable(); 
            $table->foreignId('owner')->constrained('users')->onDelete('cascade');  
            $table->string('image')->nullable();  
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
