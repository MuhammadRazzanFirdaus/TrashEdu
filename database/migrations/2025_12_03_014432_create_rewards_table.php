<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Nama hadiah
            $table->text('description')->nullable(); // Deskripsi
            $table->integer('points_required'); // Point untuk menukar
            $table->integer('stock')->default(0); // Stok hadiah
            $table->string('image')->nullable(); // Foto hadiah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
