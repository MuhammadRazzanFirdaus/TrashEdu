<?php
// app/Models/Quiz.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'thumbnail', 'point_reward', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    // tambahkan thumbnail_url otomatis
    protected $appends = ['thumbnail_url'];

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/default-quiz.jpg');
    }

    // relasi questions
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    // relasi semua progress user pada quiz ini
    public function userProgresses()
    {
        return $this->hasMany(UserQuizProgress::class);
    }

    /**
     * Ambil 1 progress untuk user tertentu.
     * Jika $userId null, gunakan user yg sedang login (jika ada).
     */
    public function userProgress($userId = null)
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            // tidak ada user login
            return $this->hasOne(UserQuizProgress::class, 'quiz_id')->whereRaw('1 = 0'); // empty relation
        }

        return $this->hasOne(UserQuizProgress::class, 'quiz_id')
            ->where('user_id', $userId);
    }

    // relasi untuk hanya yang telah completed
    public function completedProgresses()
    {
        return $this->userProgresses()->whereNotNull('completed_at');
    }

    // total soal, gunakan count yang sudah di-load jika ada (optimisasi)
    public function getTotalQuestionsAttribute()
    {
        return $this->questions_count ?? $this->questions()->count();
    }

    // rata-rata score dari progress yang completed
    public function getAverageScoreAttribute()
    {
        // completedProgresses() mengembalikan query builder
        $completed = $this->completedProgresses();

        // jika tidak ada completed, kembalikan 0
        if ($completed->count() === 0) {
            return 0;
        }

        return round($completed->avg('score'), 1);
    }

    // jumlah yang menyelesaikan quiz
    public function getCompletionCountAttribute()
    {
        return $this->completedProgresses()->count();
    }

    // difficulty berdasar point_reward (opsional)
    public function getDifficultyAttribute()
    {
        if (!$this->point_reward) return 'Tidak Diketahui';
        if ($this->point_reward <= 50) return 'Mudah';
        if ($this->point_reward <= 100) return 'Sedang';
        return 'Sulit';
    }

    // scope active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // helper dengan stats (withCount)
    public function scopeWithStats($query)
    {
        return $query->withCount(['questions', 'completedProgresses']);
    }

    // Helper: cek sudah completed oleh user
    public function isCompletedByUser($userId = null)
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return false;

        return $this->userProgresses()
            ->where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->exists();
    }

    // Helper: cek in progress oleh user
    public function isInProgressByUser($userId = null)
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return false;

        return $this->userProgresses()
            ->where('user_id', $userId)
            ->whereNull('completed_at')
            ->exists();
    }
}
