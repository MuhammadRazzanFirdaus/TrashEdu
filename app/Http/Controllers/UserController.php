<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UsersExport;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $users->load(['quizProgresses.quiz']);

        foreach ($users as $user) {
            $user->total_points = $user->quizProgresses
                ->where('score', '>=', 60)
                ->filter(fn($p) => $p->quiz !== null)
                ->sum(fn($p) => $p->quiz->point_reward ?? 0);
        }

        return view('admin.user.index', compact('users'));
    }


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $createUser = User::create([
                'name' => $request->first_name . " " . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'points' => 0,
            ]);

            DB::commit();

            if ($createUser) {
                return redirect()->route('login')->with('ok', 'Berhasil membuat akun! silakan login');
            } else {
                return redirect()->back()->with('error', 'Gagal silakan coba lagi');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'JK' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        try {
            DB::beginTransaction();

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password),
                'JK' => $request->JK,
                'role' => 'staff',
                'points' => 0,
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Akun staff berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $data = $request->only(['email', 'password']);
        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil dilakukan!');
            } elseif (Auth::user()->role == 'staff') {
                return redirect()->route('staff.index')->with('login', 'Berhasil Login!');
            } else {
                return redirect()->route('home')->with('success', 'Login berhasil dilakukan!');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal Login! coba lagi');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Berhasil logout! Silakan login kembali untuk akses lengkap');
    }

    // EDIT
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'alamat' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'JK' => 'nullable|in:Laki-laki,Perempuan',
            'role' => 'required|in:admin,staff,user',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'JK' => $request->JK,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Akun berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // SOFT DELETE
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Akun berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.user.trash', compact('users'));
    }

    // RESTORE
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        try {
            $user->restore();

            return redirect()->route('admin.users.trash')
                ->with('success', 'Akun berhasil dipulihkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        try {
            $user->forceDelete();

            return redirect()->route('admin.users.trash')
                ->with('success', 'Akun berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'all');
        $filename = 'data_users_' . date('Y_m_d_His') . '.xlsx';

        return Excel::download(new UsersExport($type), $filename);
    }

    public function exportPDF(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = User::query();

        if ($type === 'admin') {
            $query->where('role', 'admin');
        } elseif ($type === 'staff') {
            $query->where('role', 'staff');
        } elseif ($type === 'user') {
            $query->where('role', 'user');
        }
        $users = $query->get();

        $pdf = Pdf::loadView('admin.user.print-pdf', compact('users'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data_users_' . date('Y_m_d_His') . '.pdf');
    }
}
