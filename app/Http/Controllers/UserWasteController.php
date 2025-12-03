<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteSubmission;
use App\Models\WasteCategory;
use Illuminate\Support\Facades\Auth;

class UserWasteController extends Controller
{
    public function create()
    {
        $categories = WasteCategory::all();
        return view('user.waste.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:waste_categories,id',
            'weight' => 'required|numeric|min:0.1'
        ]);

        WasteSubmission::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'weight' => $request->weight,
            'status' => 'pending'
        ]);

        return redirect()->route('user.waste.history')->with('success', 'Pengajuan sampah berhasil dikirim! Menunggu verifikasi petugas.');
    }

    public function history()
    {
        $submissions = WasteSubmission::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.waste.history', compact('submissions'));
    }
}
