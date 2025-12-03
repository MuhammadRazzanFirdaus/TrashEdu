<?php
// app/Models/UserQuizProgress.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizProgress extends Model
{
    use HasFactory;

    // pastikan nama tabel sesuai migration: user_quiz_progresses
    protected $table = 'user_quiz_progresses';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'correct_answers',
        'total_questions',
        'time_spent',
        'answers',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'time_spent' => 'integer',
        'answers' => 'array'
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // persentase benar
    public function getPercentageAttribute()
    {
        if ($this->total_questions > 0) {
            return round(($this->correct_answers / $this->total_questions) * 100, 1);
        }
        return 0;
    }

    // format waktu mm:ss
    public function getFormattedTimeAttribute()
    {
        $minutes = floor($this->time_spent / 60);
        $seconds = $this->time_spent % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    // status convenience
    public function getStatusAttribute()
    {
        return $this->completed_at ? 'completed' : 'in_progress';
    }

    // scope completed
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    // scope in progress
    public function scopeInProgress($query)
    {
        return $query->whereNull('completed_at');
    }

    // scope by user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
