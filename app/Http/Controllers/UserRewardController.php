<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reward;
use App\Models\RewardRedemption;

class UserRewardController extends Controller
{
    public function redeemForm()
    {
        $rewards = Reward::all();
        return view('user.rewards.redeem', compact('rewards'));
    }

    public function requestRedeem(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|exists:rewards,id',
        ]);

        $reward = Reward::findOrFail($request->reward_id);
        $user = Auth::user();
        $totalPoints = $user->points ?? 0; // ambil poin user

        if ($totalPoints < $reward->points_required) {
            return back()->with('error', 'Poin tidak cukup untuk menukarkan hadiah ini.');
        }

        RewardRedemption::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'points_used' => $reward->points_required,
            'status' => 'pending'
        ]);

        return redirect()->route('user.rewards.history')
                         ->with('success', 'Request penukaran berhasil dikirim, menunggu konfirmasi staff.');
    }

    public function history()
    {
        $redemptions = RewardRedemption::with('reward')->where('user_id', Auth::id())->latest()->get();
        return view('user.rewards.history', compact('redemptions'));
    }
}
