<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RewardsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::withTrashed()->get(); // tampil semua termasuk soft deleted
        return view('staff.rewards.index', compact('rewards'));
    }

    public function create()
    {
        return view('staff.rewards.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rewards', 'public');
        }

        Reward::create($data);

        return redirect()->route('staff.rewards.index')->with('success', 'Reward created successfully.');
    }

    public function edit(Reward $reward)
    {
        return view('staff.rewards.edit', compact('reward'));
    }

    public function update(Request $request, Reward $reward)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rewards', 'public');
        }

        $reward->update($data);

        return redirect()->route('staff.rewards.index')->with('success', 'Reward updated successfully.');
    }

    public function destroy(Reward $reward, $id)
    {
        $deleteData = Reward::where('id', $id)->delete();
        if($deleteData) {
            return redirect()->route('staff.rewards.trash')->with('success', 'Reward dipindahkan ke trash.');
        }else {
            return redirect()->back()->with('error', 'Gagal menghapus data!');
        }
    }


    public function trash()
    {
        $rewards = Reward::onlyTrashed()->get();
        return view('staff.rewards.trash', compact('rewards'));
    }


    public function restore($id)
    {
        $reward = Reward::onlyTrashed()->findOrFail($id);
        $reward->restore();
        return redirect()->route('staff.rewards.index')->with('success', 'Reward berhasil dikembalikan.');
    }


    public function forceDelete($id)
    {
        $reward = Reward::onlyTrashed()->findOrFail($id);
        if($reward->image && Storage::exists('public/'.$reward->image)){
        Storage::delete('public/'.$reward->image);
        }

        $reward->forceDelete();
        return redirect()->route('staff.rewards.trash')->with('success', 'Reward dihapus permanen.');
    }


    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new RewardsExport, 'staff.rewards.xlsx');
    }

    // Export PDF
    public function exportPDF()
    {
        $rewards = Reward::all();
        $pdf = PDF::loadView('staff.rewards.pdf', compact('rewards'));
        return $pdf->download('staff.rewards.pdf');
    }
}
