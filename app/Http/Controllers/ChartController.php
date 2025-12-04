<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardRedemption;
use App\Models\WasteSubmission;
use Carbon\Carbon;

class ChartController extends Controller
{
    // Line Chart: Penukaran Hadiah Bulanan
    public function rewardLineChart()
    {
        // ambil semua penukaran approved
        $redemptions = RewardRedemption::where('status','approved')->get();

        // group berdasarkan bulan
        $grouped = $redemptions->groupBy(function($item){
            return Carbon::parse($item->created_at)->format('F'); // nama bulan
        });

        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $data = [];

        foreach($months as $m){
            $data[] = isset($grouped[$m]) ? count($grouped[$m]) : 0;
        }

        return response()->json([
            'labels' => $months,
            'data' => $data
        ]);
    }

    // Pie Chart: Total Poin Penukaran Sampah
    public function trashPieChart()
    {
        $points = WasteSubmission::where('status','approved')->sum('points');

        return response()->json([
            'data' => ['approved' => $points]
        ]);
    }
}
