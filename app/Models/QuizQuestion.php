<?php
// app/Models/QuizQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'question',
        // gunakan nama kolom option_a,d... agar jelas
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'point'
    ];

    protected $casts = [
        'point' => 'integer'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // getter kumpulan option
    public function getOptionsAttribute()
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    }

    // text jawaban benar
    public function getCorrectOptionTextAttribute()
    {
        return $this->options[$this->correct_answer] ?? '';
    }

    // cek benar tidak (bandingkan huruf: 'a'|'b'|'c'|'d')
    public function isCorrect($answer)
    {
        return strtolower($this->correct_answer) === strtolower($answer);
    }
}
