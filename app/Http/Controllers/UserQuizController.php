<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\UserQuizProgress;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::active()
            ->with(['questions', 'userProgresses' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->get()
            ->map(function ($quiz) {
                $quiz->userProgress = $quiz->userProgresses->first();
                $quiz->completion_count = $quiz->getCompletionCountAttribute();
                $quiz->average_score = $quiz->getAverageScoreAttribute();
                $quiz->total_questions = $quiz->getTotalQuestionsAttribute();
                return $quiz;
            });

        $userStats = [
            'completed_quizzes' => 0,
            'total_points' => 0,
            'average_score' => 0
        ];

        if (Auth::check()) {
            $userProgresses = UserQuizProgress::with('quiz')
                ->where('user_id', Auth::id())
                ->completed()
                ->get();

            $userStats = [
                'completed_quizzes' => $userProgresses->count(),
                'total_points' => Auth::user()->totalpoints ?? 0, // ⬅ ini ganti
                'average_score' => $userProgresses->avg('score') ?? 0
            ];
        }

        return view('user.quizzes.index', compact('quizzes', 'userStats'));
    }

    public function start($id)
    {
        $quiz = Quiz::active()->findOrFail($id);

        $existingProgress = UserQuizProgress::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existingProgress) {
            if ($existingProgress->completed_at) {
                return redirect()->route('user.quizzes.result', $quiz->id)
                    ->with('info', 'Anda sudah menyelesaikan quiz ini.');
            } else {
                return redirect()->route('user.quizzes.show', $quiz->id);
            }
        }

        UserQuizProgress::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'correct_answers' => 0,
            'total_questions' => $quiz->questions()->count(),
            'score' => 0,
            'time_spent' => 0,
            'answers' => [],
            'started_at' => now()
        ]);

        return redirect()->route('user.quizzes.show', $quiz->id)
            ->with('success', 'Quiz dimulai! Semoga berhasil!');
    }

    public function show($id)
    {
        $quiz = Quiz::active()->with('questions')->findOrFail($id);

        $progress = UserQuizProgress::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        if ($progress->completed_at) {
            return redirect()->route('user.quizzes.result', $quiz->id);
        }

        $answeredQuestionIds = array_keys($progress->answers ?? []);
        $currentQuestion = $quiz->questions()
            ->whereNotIn('id', $answeredQuestionIds)
            ->first();

        if (!$currentQuestion) {
            $this->completeQuiz($progress, $quiz);
            return redirect()->route('user.quizzes.result', $quiz->id);
        }

        return view('user.quizzes.show', compact('quiz', 'progress', 'currentQuestion'));
    }

    public function submitAnswer(Request $request, $id)
    {
        $quiz = Quiz::active()->findOrFail($id);
        $progress = UserQuizProgress::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
            'answer' => 'required|in:a,b,c,d'
        ]);

        $this->processAnswer($progress, $request->question_id, $request->answer);

        return redirect()->route('user.quizzes.show', $quiz->id);
    }

    public function result($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $progress = UserQuizProgress::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->completed()
            ->firstOrFail();

        return view('user.quizzes.result', compact('quiz', 'progress'));
    }

    public function leaderboard($id)
    {
        $quiz = Quiz::findOrFail($id);

        $leaderboard = UserQuizProgress::with('user')
            ->where('quiz_id', $quiz->id)
            ->completed()
            ->orderBy('score', 'desc')
            ->orderBy('time_spent', 'asc')
            ->orderBy('completed_at', 'asc')
            ->take(10)
            ->get();

        return view('user.quizzes.leaderboard', compact('quiz', 'leaderboard'));
    }

    public function myResults()
    {
        $completedQuizzes = UserQuizProgress::with('quiz')
            ->where('user_id', Auth::id())
            ->completed()
            ->latest('completed_at')
            ->paginate(10);

        return view('user.quizzes.my-result', compact('completedQuizzes'));
    }

    private function processAnswer(UserQuizProgress $progress, $questionId, $answer)
    {
        $question = QuizQuestion::findOrFail($questionId);
        $answers = $progress->answers ?? [];

        $answers[$questionId] = [
            'answer' => $answer,
            'is_correct' => $question->isCorrect($answer),
            'point' => $question->isCorrect($answer) ? $question->point : 0,
            'answered_at' => now()
        ];

        $correctAnswers = collect($answers)->where('is_correct', true)->count();

        $progress->update([
            'answers' => $answers,
            'correct_answers' => $correctAnswers,
            'score' => ($correctAnswers / $progress->total_questions) * 100,
        ]);

        if (count($answers) >= $progress->total_questions) {
            $this->completeQuiz($progress, $progress->quiz);
        }
    }

    private function completeQuiz(UserQuizProgress $progress, Quiz $quiz)
    {
        $finalScore = ($progress->correct_answers / $progress->total_questions) * 100;

        $timeSpent = now()->diffInSeconds($progress->started_at);

        $progress->update([
            'score' => $finalScore,
            'time_spent' => $timeSpent,
            'completed_at' => now(),
        ]);
        if ($finalScore >= 60) {
            \App\Models\User::where('id', Auth::id())
                ->increment('quiz_points', $quiz->point_reward ?? 0);
        }
    }
}
