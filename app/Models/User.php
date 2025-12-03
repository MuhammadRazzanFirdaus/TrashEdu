<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'JK',
        'points',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'points' => 'integer', // <-- wajib agar bisa increment()
    ];

    protected $dates = ['deleted_at'];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function quizProgresses()
    {
        return $this->hasMany(UserQuizProgress::class, 'user_id');
    }


    public function completedQuizzes()
    {
        return $this->quizProgresses()->completed();
    }

    public function totalPointsEarned()
    {
        return $this->completedQuizzes()->get()->sum(function ($progress) {
            return $progress->quiz->point_reward;
        });
    }
}
