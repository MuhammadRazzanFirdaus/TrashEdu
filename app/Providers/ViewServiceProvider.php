<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\UserQuizProgress;

class ViewServiceProvider extends ServiceProvider
{
    public function register() { }

    public function boot()
    {
        View::composer('*', function ($view) {

            $userStats = [
                'completed_quizzes' => 0,
                'total_points' => 0,
                'points_from_quiz' => 0,
                'points_from_trash' => 0,
                'average_score' => 0,
            ];

            if (Auth::check() && Auth::user()->role == 'user') {

                $user = Auth::user();

                // Poin dari sampah (langsung dari users.points, tidak ditambah lagi)
                $pointsFromTrash = $user->points ?? 0;

                // Poin dari quiz (hanya sum score di tabel quiz, tidak ditambah ke users.points)
                $userProgresses = UserQuizProgress::where('user_id', $user->id)->completed()->get();
                $pointsFromQuiz = $userProgresses->sum('score');

                $totalPoints = $pointsFromTrash + $pointsFromQuiz;

                $userStats = [
                    'completed_quizzes' => $userProgresses->count(),
                    'points_from_quiz' => $pointsFromQuiz,
                    'points_from_trash' => $pointsFromTrash,
                    'total_points' => $totalPoints,
                    'average_score' => $userProgresses->avg('score') ?? 0,
                ];
            }

            $view->with('userStats', $userStats);
        });
    }
}
