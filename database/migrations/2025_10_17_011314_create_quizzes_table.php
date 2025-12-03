<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul quiz
            $table->text('description')->nullable(); // Deskripsi quiz
            $table->integer('point_reward'); // Point reward untuk quiz
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question'); // Pertanyaan
            $table->string('option_a'); // Opsi A
            $table->string('option_b'); // Opsi B
            $table->string('option_c'); // Opsi C
            $table->string('option_d'); // Opsi D
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']); // Jawaban benar
            $table->integer('point'); // Point untuk soal ini
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
