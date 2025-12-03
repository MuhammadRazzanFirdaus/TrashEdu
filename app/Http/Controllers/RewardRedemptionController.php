<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardRedemption;
use Illuminate\Support\Facades\Auth;

class RewardRedemptionController extends Controller
{
    public function create()
    {
        $rewards = Reward::where('stock', '>', 0)->get();
        return view('user.rewards.reedem', compact('rewards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|exists:rewards,id',
        ]);

        $reward = Reward::findOrFail($request->reward_id);
        $user = Auth::user();

        if ($user->points < $reward->points_required) {
            return back()->with('error', 'Point Anda tidak cukup untuk menukarkan hadiah ini.');
        }

        // Kurangi point sementara? atau tunggu staff approve
        // Simpan request
        RewardRedemption::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'points_used' => $reward->points_required,
            'status' => 'pending'
        ]);

        return redirect()->route('user.rewards.history')->with('success', 'Request penukaran berhasil dibuat. Tunggu konfirmasi staff.');
    }

    public function history()
    {
        $redemptions = RewardRedemption::with('reward')->where('user_id', Auth::id())->latest()->get();
        return view('user.rewards.history', compact('redemptions'));
    }
}
