<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardRedemption;
use Illuminate\Support\Facades\Mail;
use App\Mail\RewardApprovedMail;

class StaffRewardController extends Controller
{
    public function index()
    {
        $redemptions = RewardRedemption::with('user','reward')
            ->where('status','pending')
            ->latest()->get();
        return view('staff.rewards.index', compact('redemptions'));
    }

    public function approve($id)
    {
        $redemption = RewardRedemption::findOrFail($id);
        $redemption->status = 'approved';
        $redemption->save();

        // Kurangi poin user
        $user = $redemption->user;
        $user->points -= $redemption->points_used;
        $user->save();

        // Kirim email
        Mail::to($user->email)->send(new RewardApprovedMail($redemption));

        return redirect()->back()->with('success', 'Reward berhasil dikonfirmasi dan email dikirim.');
    }

    public function reject($id)
    {
        $redemption = RewardRedemption::findOrFail($id);
        $redemption->status = 'rejected';
        $redemption->save();

        return redirect()->back()->with('success', 'Reward berhasil ditolak.');
    }
}
