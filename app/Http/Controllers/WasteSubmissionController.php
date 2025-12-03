<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteSubmission;
use App\Models\WasteCategory;
use App\Models\User;

class WasteSubmissionController extends Controller
{
    public function index()
    {
        // Ambil semua submission untuk staff
        $submissions = WasteSubmission::with(['user', 'category'])->latest()->get();

        // Ambil semua kategori sampah (mirip seperti di UserWasteController)
        $categories = WasteCategory::all();

        return view('staff.submissions.index', compact('submissions', 'categories'));
    }

    public function updateStatus(Request $request, $waste_id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $submission = WasteSubmission::with('category', 'user')->findOrFail($waste_id);

        if ($request->status === 'approved' && $submission->category) {
            $earnedPoints = $submission->category->points_per_kg * $submission->weight;

            // Simpan poin di submission
            $submission->points = $earnedPoints;

            // Tambahkan poin ke user
            $submission->user->points += $earnedPoints;
            $submission->user->save();
        }

        $submission->status = $request->status;
        $submission->save();

        return redirect()->route('staff.submissions.index')
            ->with('success', 'Status & poin berhasil diperbarui!');
    }
}
