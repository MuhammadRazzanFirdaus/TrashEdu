<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuizzesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'point_reward' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:a,b,c,d',
            'questions.*.point' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('quiz-thumbnails', 'public');
            }

            // Create quiz
            $quiz = Quiz::create([
                'title' => $request->title,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath,
                'point_reward' => $request->point_reward,
                'is_active' => $request->has('is_active'),
            ]);

            foreach ($request->questions as $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_answer' => $questionData['correct_answer'],
                    'point' => $questionData['point'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.quizzes.index')
                ->with('success', 'Quiz berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'point_reward' => 'required|integer|min:1',
            'remove_thumbnail' => 'sometimes|boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:a,b,c,d',
            'questions.*.point' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $thumbnailPath = $quiz->thumbnail;
            if ($request->has('remove_thumbnail') && $request->remove_thumbnail) {
                if ($quiz->thumbnail) {
                    Storage::disk('public')->delete($quiz->thumbnail);
                }
                $thumbnailPath = null;
            }

            if ($request->hasFile('thumbnail')) {
                if ($quiz->thumbnail) {
                    Storage::disk('public')->delete($quiz->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')->store('quiz-thumbnails', 'public');
            }

            $quiz->update([
                'title' => $request->title,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath,
                'point_reward' => $request->point_reward,
                'is_active' => $request->has('is_active'),
            ]);

            $quiz->questions()->delete();

            foreach ($request->questions as $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_answer' => $questionData['correct_answer'],
                    'point' => $questionData['point'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.quizzes.index')
                ->with('success', 'Quiz berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);

        try {
            $quiz->delete();

            return redirect()->route('admin.quizzes.index')
                ->with('success', 'Quiz berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $quizzes = Quiz::onlyTrashed()->withCount('questions')->latest()->get();
        return view('admin.quizzes.trash', compact('quizzes'));
    }

    public function restore($id)
    {
        $quiz = Quiz::onlyTrashed()->findOrFail($id);

        try {
            $quiz->restore();

            return redirect()->route('admin.quizzes.trash')
                ->with('success', 'Quiz berhasil dipulihkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        $quiz = Quiz::onlyTrashed()->findOrFail($id);

        try {
            if ($quiz->thumbnail) {
                Storage::disk('public')->delete($quiz->thumbnail);
            }

            $quiz->forceDelete();

            return redirect()->route('admin.quizzes.trash')
                ->with('success', 'Quiz berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'all');
        $filename = 'data_quizzes_' . date('Y_m_d_His') . '.xlsx';

        return Excel::download(new QuizzesExport($type), $filename);
    }

    public function exportPDF(Request $request)
    {
        $type = $request->get('type', 'all');

        $quizzes = Quiz::withCount('questions')
            ->when($type !== 'all', function ($query) use ($type) {
                $query->where('type', $type);
            })->latest()->get();

        $pdf = Pdf::loadView('admin.quizzes.pdf', [
            'quizzes' => $quizzes,
            'export_date' => now(),
            'total' => $quizzes->count()
        ])->setPaper('a4', 'portrait');

        $filename = 'data_quizzes_' . date('Y_m_d_His') . '.pdf';

        return $pdf->download($filename);
    }
}
