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
        Schema::create('users', function (Blueprint $table) {  
            $table->id(); 
            $table->string('username');  
            $table->string('email')->unique();  
            $table->string('verification_code')->nullable();  
            $table->boolean('is_verified')->default(false);  
            $table->string('phone')->nullable();  
            $table->string('password');  
            $table->string('user_type');  
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
