<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\UserQuizProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProgressController extends Controller
{
   public function index()
{
    $users = User::where('role', 'user')->get();
    $quizzes = Quiz::where('is_active', true)->get();

    $progresses = UserQuizProgress::with(['user', 'quiz'])
        ->when(request('user_id'), function($query, $userId) {
            return $query->where('user_id', $userId);
        })
        ->when(request('quiz_id'), function($query, $quizId) {
            return $query->where('quiz_id', $quizId);
        })
        ->when(request('status') == 'completed', function($query) {
            return $query->whereNotNull('completed_at');
        })
        ->when(request('status') == 'incomplete', function($query) {
            return $query->whereNull('completed_at');
        })
        ->latest()
        ->paginate(10);

    return view('admin.progress.index', compact('users', 'quizzes', 'progresses'));
}

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $quizzes = Quiz::where('is_active', true)->get();

        return view('admin.progress.create', compact('users', 'quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'required|integer|min:0',
            'correct_answers' => 'required|integer|min:0',
            'total_questions' => 'required|integer|min:1',
            'time_spent' => 'required|integer|min:1',
            'completed_at' => 'required|date'
        ]);

        $existingProgress = UserQuizProgress::where('user_id', $request->user_id)
            ->where('quiz_id', $request->quiz_id)
            ->first();

        if ($existingProgress) {
            return redirect()->back()
                ->with('error', 'User sudah mengerjakan quiz ini!')
                ->withInput();
        }

        try {
            DB::beginTransaction();

            UserQuizProgress::create([
                'user_id' => $request->user_id,
                'quiz_id' => $request->quiz_id,
                'score' => $request->score,
                'correct_answers' => $request->correct_answers,
                'total_questions' => $request->total_questions,
                'time_spent' => $request->time_spent,
                'completed_at' => $request->completed_at,
            ]);

            DB::commit();

            return redirect()->route('admin.progress.index')
                ->with('success', 'Progress berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $progress = UserQuizProgress::with(['user', 'quiz.questions'])
            ->findOrFail($id);

        return view('admin.progress.show', compact('progress'));
    }

    public function edit($id)
    {
        $progress = UserQuizProgress::findOrFail($id);
        $users = User::where('role', 'user')->get();
        $quizzes = Quiz::where('is_active', true)->get();

        return view('admin.progress.edit', compact('progress', 'users', 'quizzes'));
    }

    public function update(Request $request, $id)
    {
        $progress = UserQuizProgress::findOrFail($id);

        $request->validate([
            'score' => 'required|integer|min:0',
            'correct_answers' => 'required|integer|min:0',
            'total_questions' => 'required|integer|min:1',
            'time_spent' => 'required|integer|min:1',
            'completed_at' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $progress->update([
                'score' => $request->score,
                'correct_answers' => $request->correct_answers,
                'total_questions' => $request->total_questions,
                'time_spent' => $request->time_spent,
                'completed_at' => $request->completed_at,
            ]);

            DB::commit();

            return redirect()->route('admin.progress.index')
                ->with('success', 'Progress berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $progress = UserQuizProgress::findOrFail($id);

        try {
            $progress->delete();

            return redirect()->route('admin.progress.index')
                ->with('success', 'Progress berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function userHistory($userId)
    {
        $user = User::findOrFail($userId);
        $progresses = UserQuizProgress::with('quiz')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $stats = [
            'total_quizzes' => $progresses->count(),
            'average_score' => round($progresses->avg('score') ?? 0, 2),
            'total_points' => $progresses->sum(function($progress) {
                return $progress->quiz->point_reward;
            }),
        ];

        return view('admin.progress.user-history', compact('user', 'progresses', 'stats'));
    }

    public function quizLeaderboard($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $leaderboard = UserQuizProgress::with('user')
            ->where('quiz_id', $quizId)
            ->whereNotNull('completed_at')
            ->orderBy('score', 'DESC')
            ->orderBy('time_spent', 'ASC')
            ->paginate(10);

        return view('admin.progress.leaderboard', compact('quiz', 'leaderboard'));
    }

    public function statistics()
    {
        try {
            $totalUsers = User::where('role', 'user')->count();
            $totalQuizzes = Quiz::where('is_active', true)->count();
            $totalAttempts = UserQuizProgress::count();
            $completedAttempts = UserQuizProgress::whereNotNull('completed_at')->count();

            $topPerformers = UserQuizProgress::with(['user'])
                ->whereNotNull('completed_at')
                ->select('user_id', DB::raw('AVG(score) as avg_score'), DB::raw('COUNT(*) as quiz_count'))
                ->groupBy('user_id')
                ->orderBy('avg_score', 'DESC')
                ->limit(5)
                ->get();

            $popularQuizzes = Quiz::withCount(['userProgresses as attempts_count' => function($query) {
                $query->whereNotNull('completed_at');
            }])->orderBy('attempts_count', 'DESC')
               ->limit(5)
               ->get();

            return view('admin.progress.statistics', compact(
                'totalUsers',
                'totalQuizzes',
                'totalAttempts',
                'completedAttempts',
                'topPerformers',
                'popularQuizzes'
            ));

        } catch (\Exception $e) {
            return redirect()->route('admin.progress.index')
                ->with('error', 'Gagal memuat statistik: ' . $e->getMessage());
        }
    }
}
