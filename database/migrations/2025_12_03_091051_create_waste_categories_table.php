<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <- ini penting

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Organik, Anorganik, Residu
            $table->integer('points_per_kg'); // point per kg
            $table->timestamps();
        });

        // Contoh insert kategori
        DB::table('waste_categories')->insert([
            ['name'=>'Organik','points_per_kg'=>30,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Anorganik','points_per_kg'=>45,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Residu','points_per_kg'=>60,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_categories');
    }
};
