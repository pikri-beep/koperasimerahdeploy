<?php

namespace App\Http\Controllers;

use App\Models\Tbcicilan;
use App\Models\TbPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TbcicilanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER — Halaman cicilan milik sendiri
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = Auth::user();

        // Semua pinjaman user yang disetujui / sedang berjalan
        $pinjamans = TbPinjaman::where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'lunas'])
            ->with(['cicilans'])
            ->latest()
            ->get();

        // Statistik ringkas
        $totalCicilan    = Tbcicilan::where('user_id', $user->id)->count();
        $sudahBayar      = Tbcicilan::where('user_id', $user->id)
                            ->whereIn('status', ['sudah_bayar', 'dikonfirmasi'])->count();
        $belumBayar      = Tbcicilan::where('user_id', $user->id)
                            ->where('status', 'belum_bayar')->count();
        $terlambat       = Tbcicilan::where('user_id', $user->id)
                            ->where('status', 'terlambat')->count();

        return view('dashboard.cicilan', compact(
            'pinjamans', 'totalCicilan', 'sudahBayar', 'belumBayar', 'terlambat'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | USER — Upload bukti bayar
    |--------------------------------------------------------------------------
    */
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'foto_bukti' => 'required|image|max:2048',
        ]);

        $cicilan = Tbcicilan::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['belum_bayar', 'terlambat'])
            ->firstOrFail();

        // Hapus bukti lama jika ada
        if ($cicilan->foto_bukti && Storage::disk('public')->exists($cicilan->foto_bukti)) {
            Storage::disk('public')->delete($cicilan->foto_bukti);
        }

        $path = $request->file('foto_bukti')->store('cicilan/bukti', 'public');

        $cicilan->update([
            'foto_bukti'    => $path,
            'tanggal_bayar' => now(),
            'status'        => 'sudah_bayar',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Semua cicilan semua user
    |--------------------------------------------------------------------------
    */
    public function adminIndex()
    {
        $search = request('search');

        $cicilans = Tbcicilan::with(['pinjaman', 'user'])
            ->when($search, function ($q, $search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('pinjaman', fn($p) => $p->where('nama_lengkap', 'like', "%$search%"));
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        // Statistik admin
        $stats = [
            'total'        => Tbcicilan::count(),
            'dikonfirmasi' => Tbcicilan::where('status', 'dikonfirmasi')->count(),
            'sudah_bayar'  => Tbcicilan::where('status', 'sudah_bayar')->count(),
            'terlambat'    => Tbcicilan::where('status', 'terlambat')->count(),
            'belum_bayar'  => Tbcicilan::where('status', 'belum_bayar')->count(),
        ];

        return view('admin.cicilan', compact('cicilans', 'stats'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Konfirmasi pembayaran cicilan
    |--------------------------------------------------------------------------
    */
    public function konfirmasi($id)
    {
        $cicilan = Tbcicilan::with('pinjaman')->findOrFail($id);

        $cicilan->update([
            'status'  => 'dikonfirmasi',
            'catatan' => 'Dikonfirmasi oleh admin pada ' . now()->format('d/m/Y H:i'),
        ]);

        // Cek apakah semua cicilan pinjaman ini sudah dikonfirmasi → tandai lunas
        $pinjaman    = $cicilan->pinjaman;
        $totalCicilan = $pinjaman->cicilans()->count();
        $terkonfirmasi = $pinjaman->cicilans()->where('status', 'dikonfirmasi')->count();

        if ($totalCicilan > 0 && $totalCicilan === $terkonfirmasi) {
            $pinjaman->update(['status' => 'lunas']);
        }

        return back()->with('status', 'Pembayaran cicilan berhasil dikonfirmasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Tolak / minta ulang bukti
    |--------------------------------------------------------------------------
    */
    public function tolak(Request $request, $id)
    {
        $cicilan = Tbcicilan::findOrFail($id);

        $cicilan->update([
            'status'  => 'belum_bayar',
            'catatan' => $request->catatan ?? 'Bukti ditolak oleh admin, harap unggah ulang.',
        ]);

        return back()->with('status', 'Bukti ditolak. User diminta unggah ulang.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Tandai terlambat (bisa dipanggil via scheduler/manual)
    |--------------------------------------------------------------------------
    */
    public function tandaiTerlambat()
    {
        $jumlah = Tbcicilan::where('status', 'belum_bayar')
            ->where('tanggal_jatuh_tempo', '<', now()->startOfDay())
            ->update([
                'status' => 'terlambat',
                'denda'  => \DB::raw('jumlah_cicilan * 0.02'),  // denda 2% dari cicilan
            ]);

        return back()->with('status', "$jumlah cicilan ditandai terlambat.");
    }
}