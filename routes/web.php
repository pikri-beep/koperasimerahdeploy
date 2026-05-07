<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TbpinjamanController;
use App\Http\Controllers\TbmodalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TbModal;
use App\Models\Tbpinjaman;

/*
|--------------------------------------------------------------------------
| 1. LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('dashboard.indexumum');
});


/*
|--------------------------------------------------------------------------
| 2. DASHBOARD USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard utama user
    Route::get('/dashboard', function () {
        return view('dashboard.index', [
            'totalPinjamanAktif' => Tbpinjaman::where('user_id', auth()->id())->count(),
            'totalModal' => TbModal::sum('simpanan_pokok')
                          + TbModal::sum('simpanan_wajib')
                          + TbModal::sum('simpanan_sementara'),
            'totalSimpananSementara' => TbModal::sum('simpanan_sementara'),
        ]);
    })->name('dashboard');


    Route::prefix('dashboard')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */
        Route::get('/penarikan', function () {
            return view('dashboard.penarikan');
        })->name('penarikan');

        Route::get('/cicilan', function () {
            return view('dashboard.cicilan');
        })->name('cicilan');


        /*
        |--------------------------------------------------------------------------
        | PINJAMAN
        |--------------------------------------------------------------------------
        */
        Route::get('/pinjaman', [TbpinjamanController::class, 'dashboard'])->name('pinjaman');

        Route::get('/pinjaman/riwayat', [TbpinjamanController::class, 'index'])->name('pinjaman.riwayat');

        Route::get('/pinjaman/pengajuan', [TbpinjamanController::class, 'create'])->name('pinjaman.pengajuan');

        Route::post('/pinjaman', [TbpinjamanController::class, 'store'])->name('pinjaman.store');

        Route::get('/pinjaman/{id}/edit', [TbpinjamanController::class, 'edit'])->name('pinjaman.edit');

        Route::put('/pinjaman/{id}', [TbpinjamanController::class, 'update'])->name('pinjaman.update');

        Route::delete('/pinjaman/{id}', [TbpinjamanController::class, 'destroy'])->name('pinjaman.destroy');


        /*
        |--------------------------------------------------------------------------
        | MODAL (SIMPANAN)
        |--------------------------------------------------------------------------
        */
        Route::get('/modal', function () {
            $requests = TbModal::where('user_id', auth()->id())
                ->latest()
                ->get();

            return view('dashboard.modal', [
                'data' => $requests,
            ]);
        })->name('modal');

        Route::post('/modal', [TbmodalController::class, 'storeRequest'])->name('modal.store');
    });
});


/*
|--------------------------------------------------------------------------
| 3. DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/dashboard', function (Request $request) {

        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', [
            'users' => $users,
            'totalAnggota' => User::where('role', 'user')->count(),
            'totalAdmin' => User::where('role', 'admin')->count(),
        ]);

    })->name('admin.dashboard');

    /*
|--------------------------------------------------------------------------
| PINJAMAN (ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // HALAMAN PINJAMAN
    Route::get('/pinjaman', [TbpinjamanController::class, 'index'])
        ->name('admin.pinjaman');

    // APPROVE
    Route::post('/pinjaman/{id}/approve', [TbpinjamanController::class, 'approve'])
        ->name('admin.pinjaman.approve');

    // DENY
    Route::post('/pinjaman/{id}/deny', [TbpinjamanController::class, 'deny'])
        ->name('admin.pinjaman.deny');

        Route::get('/cicilan', function () {
        return view('admin.cicilan');
    })->name('admin.cicilan');

    Route::get('/penarikan', function () {
        return view('admin.penarikan');
    })->name('admin.penarikan');
});


    /*
    |--------------------------------------------------------------------------
    | MODAL (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        Route::get('/modal', [TbmodalController::class, 'index'])->name('admin.modal');

        Route::post('/modal', [TbmodalController::class, 'store'])->name('admin.modal.store');

        Route::put('/modal/{id}', [TbmodalController::class, 'update'])->name('admin.modal.update');

        Route::delete('/modal/{id}', [TbmodalController::class, 'destroy'])->name('admin.modal.destroy');

        Route::put('/modal/{id}/approve', [TbmodalController::class, 'approve'])->name('admin.modal.approve');

        Route::put('/modal/{id}/reject', [TbmodalController::class, 'reject'])->name('admin.modal.reject');
    });


    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::patch('/admin/users/{user}/role', function (Request $request, User $user) {

        if ($user->id == 1) {
            return back()->with('error', 'Super Admin tidak bisa diubah!');
        }

        $user->update([
            'role' => trim($request->role)
        ]);

        return back()->with('status', 'Role berhasil diperbarui!');
    })->name('admin.users.updateRole');


    Route::delete('/admin/users/{user}', function (User $user) {

        if ($user->id == auth()->id() || $user->id == 1) {
            return back()->with('error', 'Tidak bisa menghapus akun utama atau diri sendiri!');
        }

        $user->delete();

        return back()->with('status', 'Anggota berhasil dihapus!');
    })->name('admin.users.destroy');
});


/*
|--------------------------------------------------------------------------
| 4. PROFILE (BREEZE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])
        ->name('profile.uploadFoto');
});


/*
|--------------------------------------------------------------------------
| AUTH (WAJIB ADA)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
