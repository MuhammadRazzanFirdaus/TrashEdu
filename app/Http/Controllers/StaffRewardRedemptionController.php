<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardRedemption;
use Illuminate\Support\Facades\Mail;

class StaffRewardRedemptionController extends Controller
{
    public function index()
    {
        $redemptions = RewardRedemption::with(['user', 'reward'])->where('status','pending')->latest()->get();
        return view('staff.reedemption.index', compact('redemptions'));
    }

    public function approve($id)
    {
        $redemption = RewardRedemption::with(['user','reward'])->findOrFail($id);
        $user = $redemption->user;
        $reward = $redemption->reward;

        if($user->points < $redemption->points_used){
            return back()->with('error','User tidak memiliki cukup point.');
        }

        // Kurangi point user
        $user->points -= $redemption->points_used;
        $user->save();

        // Kurangi stok reward
        $reward->stock -= 1;
        $reward->save();

        $redemption->status = 'approved';
        $redemption->save();

        // Kirim email ke user
        Mail::to($user->email)->send(new \App\Mail\RewardApprovedMail($redemption));

        return back()->with('success','Penukaran berhasil disetujui.');
    }

    public function reject($id)
    {
        $redemption = RewardRedemption::findOrFail($id);
        $redemption->status = 'rejected';
        $redemption->save();

        // Opsional kirim email rejected

        return back()->with('success','Penukaran telah ditolak.');
    }
}
